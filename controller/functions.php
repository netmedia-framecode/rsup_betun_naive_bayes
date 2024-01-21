<?php require_once("support_code.php");
function bayes($nama, $id_jenis_kelamin, $id_usia, $alamat, $gejala)
{
  global $conn;

  //langkah 1

  // menentukan penyakit yang muncul berdasarkan data latih			

  // menyusun array penyakit
  $penyakit_all = array();
  $gejalaList = implode("', '", $gejala);
  $query_penyakit = mysqli_query($conn, "SELECT * FROM penyakit JOIN akuisisi ON penyakit.id_penyakit=akuisisi.id_penyakit WHERE akuisisi.id_gejala IN ('$gejalaList')");
  foreach ($query_penyakit as $row) {
    $penyakit_all[$row['id_penyakit']] = array(
      'kode' => $row['kode_penyakit'],
      'nama' => $row['nama_penyakit']
    );
  }

  //menyusun array gejala
  $gejala_all = array();
  $query_gejala = mysqli_query($conn, "SELECT gejala.*, penyakit.kode_penyakit FROM gejala JOIN penyakit ON gejala.id_penyakit=penyakit.id_penyakit");
  foreach ($query_gejala as $row) {
    $gejala_all[$row['id_gejala']] = array(
      'kode' => $row['kode_gejala'],
      'nama' => $row['gejala'],
      'probabilitas' => $row['kode_penyakit']
    );
  }

  //menyusun array gejala terpilih
  if (!isset($_SESSION['data-user'])) {
    $gejala_checklist = $_SESSION['data-konsultasi']['gejala'];
  } else if (isset($_SESSION['data-user'])) {
    $gejala_checklist = $_SESSION['data-klasifikasi']['gejala'];
  }

  $gejala_terpilih = array();
  foreach ($gejala_checklist as $rowChecklist) {
    $gejala_terpilih[] = $gejala_all[$rowChecklist];
  }

  //langkah ke 2

  //Menghitung nilai Probabilitas penyakit dan gejala		

  $probabilitas_penyakit_gejala = [];

  foreach ($penyakit_all as $key_penyakit_all => $value_penyakit_all) {

    $prob_gejala[$key_penyakit_all] = 0;
    foreach ($gejala_all as $key_gejala_all => $value_gejala_all) {

      if ($value_gejala_all['probabilitas'] == $value_penyakit_all['kode']) {
        $prob_gejala[$key_penyakit_all]++;
      }
    }

    $probabilitas_penyakit_gejala[$key_penyakit_all] = $prob_gejala[$key_penyakit_all] / count($gejala_all);
  }

  //langkah ke 3 

  // Menghitung nilai bayes berdasarkan probabilitas penyakit dan gejala yang timbul 				

  $nilai_bayes_probabilitas_penyakit_gejala_timbul = [];
  $value_penyakit_all = [];
  foreach ($penyakit_all as $key_penyakit_all => $value_penyakit_all) {
    $nilai_bayes_probabilitas_penyakit_gejala_timbul[$key_penyakit_all] = $probabilitas_penyakit_gejala[$key_penyakit_all] / count($gejala_terpilih);
  }

  //langkah ke 4	

  // Proses  1 :					

  //Menentukan nilai nc untuk setiap class	

  $nilai_n_class = [];
  $n = [];
  foreach ($penyakit_all as $key_penyakit_all => $value_penyakit_all) {

    foreach ($gejala_terpilih as $key_gejala_terpilih => $value_gejala_terpilih) {

      $temp = false;

      foreach ($gejala_all as $key_gejala_all => $value_gejala_all) {

        if ($value_gejala_terpilih['probabilitas'] == $value_gejala_all['probabilitas'] && $value_gejala_all['probabilitas'] == $value_penyakit_all['kode']) {

          $temp = true;
        }
      }

      if ($temp == true) {

        $nc[$key_penyakit_all][$key_gejala_terpilih] = 1;
      } else {

        $nc[$key_penyakit_all][$key_gejala_terpilih] = 0;
      }
    }

    $cocok = false;
    // dd($nc);
    foreach ($nc[$key_penyakit_all] as $key_nc => $value_nc) {

      if ($value_nc == 1) {

        $cocok = true;
      }
    }

    if ($cocok == true) {

      $n[$key_penyakit_all] = 1;
    } else {

      $n[$key_penyakit_all] = 0;
    }

    $nilai_n_class[$key_penyakit_all] = [
      'class' => $value_penyakit_all['nama'],
      'n' => $n[$key_penyakit_all],
      'p' => 1 / count($penyakit_all),
      'm' => count($gejala_all),
    ];
    $nilai_n_class[$key_penyakit_all]['nc'] = $nc[$key_penyakit_all];
  }

  //Proses 2 : 	

  // menghitung nilai P(ai|vj) dengan menghitung nilai P(vj)					

  $nilai_p_a_v_p = [];
  foreach ($penyakit_all as $key_penyakit_all => $value_penyakit_all) {

    foreach ($gejala_terpilih as $key_gejala_terpilih => $value_gejala_terpilih) {

      $nilai_p_a_v_p[$key_penyakit_all]['class'] = $value_penyakit_all['kode'];

      $nilai_p_a_v_p[$key_penyakit_all]['probabilitas'][$key_gejala_terpilih]['kode_gejala'] = $value_gejala_terpilih['kode'];

      $nilai_p_a_v_p[$key_penyakit_all]['probabilitas'][$key_gejala_terpilih]['nilai'] = (($nilai_n_class[$key_penyakit_all]['nc'][$key_gejala_terpilih] + ($nilai_n_class[$key_penyakit_all]['m'] * $nilai_n_class[$key_penyakit_all]['p'])) / ($nilai_n_class[$key_penyakit_all]['n'] + $nilai_n_class[$key_penyakit_all]['m']));
    }
  }

  // Proses 3:
  // Menghitung P(ai|vj) x P(vj) untuk tiap v
  $nilai_p_a_v_v = [];

  foreach ($penyakit_all as $key_penyakit_all => $value_penyakit_all) {
    $total_nilai_p_a_v_p[$key_penyakit_all] = 1;

    foreach ($gejala_terpilih as $key_gejala_terpilih => $value_gejala_terpilih) {
      $total_nilai_p_a_v_p[$key_penyakit_all] *= $nilai_p_a_v_p[$key_penyakit_all]['probabilitas'][$key_gejala_terpilih]['nilai'];
    }

    $nilai_p_a_v_v[$key_penyakit_all]['class'] = $value_penyakit_all['kode'];

    // Menggunakan number_format() untuk mengontrol format angka
    $nilai_p_a_v_v[$key_penyakit_all]['v_max'] = number_format($nilai_n_class[$key_penyakit_all]['p'] * $total_nilai_p_a_v_p[$key_penyakit_all], 15, '.', '');
  }

  // Proses 4 : 						
  // Menentukan hasil klasifikasi yaitu v yang memiliki hasil perkalian yang terbesar						

  $nilai_p_a_v_v_rsort = bubble_sort($nilai_p_a_v_v, 'v_max');

  hasil_klasifikasi($nama, $id_jenis_kelamin, $id_usia, $alamat, $nilai_p_a_v_v_rsort);

  return $nilai_p_a_v_v_rsort;
}
function bubble_sort($arr, $key)
{
  $size = count($arr) - 1;

  for ($i = 0; $i < $size; $i++) {

    for ($j = 0; $j < $size - $i; $j++) {

      $k = $j + 1;

      // Periksa apakah indeks yang diakses ada dalam array
      if (isset($arr[$k][$key]) && isset($arr[$j][$key])) {

        if ($arr[$k][$key] > $arr[$j][$key]) {
          list($arr[$j], $arr[$k]) = array($arr[$k], $arr[$j]);
        }
      }
    }
  }

  return $arr;
}
function hasil_klasifikasi($nama, $id_jenis_kelamin, $id_usia, $alamat, $nilai_p_a_v_v_rsort)
{
  global $conn;
  $checkID = mysqli_query($conn, "SELECT * FROM data_uji ORDER BY id_uji DESC LIMIT 1");
  if (mysqli_num_rows($checkID) > 0) {
    $row = mysqli_fetch_assoc($checkID);
    $id_uji = $row['id_uji'] + 1;
  } else {
    $id_uji = 1;
  }

  $max_nilai = 0; // Inisialisasi nilai terbesar
  $id_penyakit = '';

  foreach ($nilai_p_a_v_v_rsort as $key_value_klasifikasi => $value_klasifikasi) {
    $kode_penyakit = $value_klasifikasi['class'];
    $klasifikasi_penyakit = mysqli_query($conn, "SELECT * FROM penyakit WHERE kode_penyakit='$kode_penyakit'");
    $data_kp = mysqli_fetch_assoc($klasifikasi_penyakit);

    // Periksa jika $value_klasifikasi['v_max'] bukan 0
    if ($value_klasifikasi['v_max'] != 0) {

      // Perbarui nilai terbesar dan nama penyakit terkait
      if ($value_klasifikasi['v_max'] > $max_nilai) {
        $id_penyakit = $data_kp['id_penyakit'];
      }
    }
  }

  $sql = "INSERT INTO data_uji(id_uji,nama,alamat,id_jenis_kelamin,id_usia,id_penyakit) VALUES('$id_uji','$nama','$alamat','$id_jenis_kelamin','$id_usia','$id_penyakit')";
  mysqli_query($conn, $sql);

  //menyusun array gejala terpilih
  if (!isset($_SESSION['data-user'])) {
    $gejala_checklist = $_SESSION['data-konsultasi']['gejala'];
  } else if (isset($_SESSION['data-user'])) {
    $gejala_checklist = $_SESSION['data-klasifikasi']['gejala'];
  }

  foreach ($gejala_checklist as $rowChecklist) {
    $sql = "INSERT INTO data_gejala(id_uji,id_gejala) VALUES('$id_uji','$rowChecklist')";
    mysqli_query($conn, $sql);
  }

  return true;
}

if (!isset($_SESSION["data-user"])) {
  function klasifikasi($data)
  {
    global $conn;
    $nama = valid($data['nama']);
    $id_jenis_kelamin = valid($data['id_jenis_kelamin']);
    $id_usia = valid($data['id_usia']);
    $alamat = valid($data['alamat']);
    $checklist = $data['checklist'];
    $akses = 2;
    $_SESSION['data-konsultasi'] = [
      'nama' => $nama,
      'id_jenis_kelamin' => $id_jenis_kelamin,
      'id_usia' => $id_usia,
      'alamat' => $alamat,
      'gejala' => $checklist,
      'akses' => $akses
    ];
    return mysqli_affected_rows($conn);
  }
  function masuk($data)
  {
    global $conn;
    $email = valid($data["email"]);
    $password = valid($data["password"]);

    // check account
    $checkAccount = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($checkAccount) == 0) {
      $_SESSION["message-danger"] = "Maaf, akun yang anda masukan belum terdaftar.";
      $_SESSION["time-message"] = time();
      return false;
    } else if (mysqli_num_rows($checkAccount) > 0) {
      $row = mysqli_fetch_assoc($checkAccount);
      if (password_verify($password, $row["password"])) {
        $_SESSION["data-user"] = [
          "id" => $row["id_user"],
          "role" => $row["id_role"],
          "email" => $row["email"],
          "username" => $row["username"],
        ];
      } else {
        $_SESSION["message-danger"] = "Maaf, kata sandi yang anda masukan salah.";
        $_SESSION["time-message"] = time();
        return false;
      }
    }
  }
}
if (isset($_SESSION["data-user"])) {
  function edit_profile($data)
  {
    global $conn, $idUser;
    $username = valid($data["username"]);
    $password = valid($data["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE users SET username='$username', password='$password' WHERE id_user='$idUser'");
    return mysqli_affected_rows($conn);
  }
  function add_user($data)
  {
    global $conn;
    $username = valid($data["username"]);
    $email = valid($data["email"]);
    $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($checkEmail) > 0) {
      $_SESSION["message-danger"] = "Maaf, email yang anda masukan sudah terdaftar.";
      $_SESSION["time-message"] = time();
      return false;
    }
    $password = valid($data["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $id_role = valid($data['id_role']);
    mysqli_query($conn, "INSERT INTO users(id_role,username,email,password) VALUES('$id_role','$username','$email','$password')");
    return mysqli_affected_rows($conn);
  }
  function edit_user($data)
  {
    global $conn, $time;
    $id_user = valid($data["id-user"]);
    $username = valid($data["username"]);
    $email = valid($data["email"]);
    $emailOld = valid($data["emailOld"]);
    if ($email != $emailOld) {
      $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
      if (mysqli_num_rows($checkEmail) > 0) {
        $_SESSION["message-danger"] = "Maaf, email yang anda masukan sudah terdaftar.";
        $_SESSION["time-message"] = time();
        return false;
      }
    }
    $id_role = valid($data['id_role']);
    mysqli_query($conn, "UPDATE users SET id_role='$id_role', username='$username', email='$email', updated_at=current_timestamp WHERE id_user='$id_user'");
    return mysqli_affected_rows($conn);
  }
  function delete_user($data)
  {
    global $conn;
    $id_user = valid($data["id-user"]);
    mysqli_query($conn, "DELETE FROM users WHERE id_user='$id_user'");
    return mysqli_affected_rows($conn);
  }
  function overview($data)
  {
    global $conn;
    $judul = valid($data['judul']);
    $konten = $data['konten'];
    mysqli_query($conn, "UPDATE overview SET judul='$judul', konten='$konten'");
    return mysqli_affected_rows($conn);
  }
  function add_data_latih($data)
  {
    global $conn;
    $nama = valid($data['nama']);
    $id_jenis_kelamin = valid($data['id_jenis_kelamin']);
    $id_usia = valid($data['id_usia']);
    $id_penyakit = valid($data['id_penyakit']);
    $alamat = valid($data['alamat']);
    mysqli_query($conn, "INSERT INTO data_latih(nama,alamat,id_jenis_kelamin,id_usia,id_penyakit) VALUES('$nama','$alamat','$id_jenis_kelamin','$id_usia','$id_penyakit')");
    return mysqli_affected_rows($conn);
  }
  function edit_data_latih($data)
  {
    global $conn;
    $id_latih = valid($data['id_latih']);
    $nama = valid($data['nama']);
    $id_jenis_kelamin = valid($data['id_jenis_kelamin']);
    $id_usia = valid($data['id_usia']);
    $id_penyakit = valid($data['id_penyakit']);
    $alamat = valid($data['alamat']);
    mysqli_query($conn, "UPDATE data_latih SET nama='$nama', alamat='$alamat', id_jenis_kelamin='$id_jenis_kelamin', id_usia='$id_usia', id_penyakit='$id_penyakit', updated_at=current_timestamp WHERE id_latih='$id_latih'");
    return mysqli_affected_rows($conn);
  }
  function delete_data_latih($data)
  {
    global $conn;
    $id_latih = valid($data['id_latih']);
    mysqli_query($conn, "DELETE FROM data_latih WHERE id_latih='$id_latih'");
    return mysqli_affected_rows($conn);
  }
  function add_penyakit($data)
  {
    global $conn;
    $checkKode = mysqli_query($conn, "SELECT * FROM penyakit ORDER BY id_penyakit DESC LIMIT 1");
    if (mysqli_num_rows($checkKode) > 0) {
      $row = mysqli_fetch_assoc($checkKode);
      $string = $row['kode_penyakit'];
      $result = separateAlphaNumeric($string);
      $numeric = $result['numeric'] + 1;
      $kode_penyakit = "P00" . $numeric;
    } else {
      $kode_penyakit = "P001";
    }
    $nama_penyakit = valid($data['nama_penyakit']);
    $checkPenyakit = mysqli_query($conn, "SELECT * FROM penyakit WHERE nama_penyakit='$nama_penyakit'");
    if (mysqli_num_rows($checkPenyakit) > 0) {
      $_SESSION["message-danger"] = "Maaf, penyakit " . $nama_penyakit . " sudah ada.";
      $_SESSION["time-message"] = time();
      return false;
    }
    mysqli_query($conn, "INSERT INTO penyakit(kode_penyakit,nama_penyakit) VALUES('$kode_penyakit','$nama_penyakit')");
    return mysqli_affected_rows($conn);
  }
  function edit_penyakit($data)
  {
    global $conn;
    $id_penyakit = valid($data['id_penyakit']);
    $nama_penyakit = valid($data['nama_penyakit']);
    $nama_penyakitOld = valid($data['nama_penyakitOld']);
    if ($nama_penyakit != $nama_penyakitOld) {
      $checkPenyakit = mysqli_query($conn, "SELECT * FROM penyakit WHERE nama_penyakit='$nama_penyakit'");
      if (mysqli_num_rows($checkPenyakit) > 0) {
        $_SESSION["message-danger"] = "Maaf, penyakit " . $nama_penyakit . " sudah ada.";
        $_SESSION["time-message"] = time();
        return false;
      }
    }
    mysqli_query($conn, "UPDATE penyakit SET nama_penyakit='$nama_penyakit' WHERE id_penyakit='$id_penyakit'");
    return mysqli_affected_rows($conn);
  }
  function delete_penyakit($data)
  {
    global $conn;
    $id_penyakit = valid($data['id_penyakit']);
    mysqli_query($conn, "DELETE FROM penyakit WHERE id_penyakit='$id_penyakit'");
    return mysqli_affected_rows($conn);
  }
  function add_gejala($data)
  {
    global $conn;
    $id_penyakit = valid($data['id_penyakit']);
    $checkKode = mysqli_query($conn, "SELECT * FROM gejala ORDER BY id_gejala DESC LIMIT 1");
    if (mysqli_num_rows($checkKode) > 0) {
      $row = mysqli_fetch_assoc($checkKode);
      $string = $row['kode_gejala'];
      $result = separateAlphaNumeric($string);
      $numeric = $result['numeric'] + 1;
      $kode_gejala = "G" . $numeric;
    } else {
      $kode_gejala = "G01";
    }
    $gejala = valid($data['gejala']);
    $checkGejala = mysqli_query($conn, "SELECT * FROM gejala WHERE id_penyakit='$id_penyakit' AND gejala='$gejala'");
    if (mysqli_num_rows($checkGejala) > 0) {
      $_SESSION["message-danger"] = "Maaf, gejala " . $gejala . " sudah ada.";
      $_SESSION["time-message"] = time();
      return false;
    }
    mysqli_query($conn, "INSERT INTO gejala(id_penyakit,kode_gejala,gejala) VALUES('$id_penyakit','$kode_gejala','$gejala')");
    return mysqli_affected_rows($conn);
  }
  function edit_gejala($data)
  {
    global $conn;
    $id_gejala = valid($data['id_gejala']);
    $id_penyakit = valid($data['id_penyakit']);
    $gejala = valid($data['gejala']);
    $gejalaOld = valid($data['gejalaOld']);
    if ($gejala != $gejalaOld) {
      $checkNama = mysqli_query($conn, "SELECT * FROM gejala WHERE id_penyakit='$id_penyakit' AND gejala='$gejala'");
      if (mysqli_num_rows($checkNama) > 0) {
        $_SESSION["message-danger"] = "Maaf, gejala " . $gejala . " sudah ada.";
        $_SESSION["time-message"] = time();
        return false;
      }
    }
    mysqli_query($conn, "UPDATE gejala SET id_penyakit='$id_penyakit', gejala='$gejala' WHERE id_gejala='$id_gejala'");
    return mysqli_affected_rows($conn);
  }
  function delete_gejala($data)
  {
    global $conn;
    $id_gejala = valid($data['id_gejala']);
    mysqli_query($conn, "DELETE FROM gejala WHERE id_gejala='$id_gejala'");
    return mysqli_affected_rows($conn);
  }
  function add_solusi($data)
  {
    global $conn;
    $id_penyakit = valid($data['id_penyakit']);
    $solusi = valid($data['solusi']);
    mysqli_query($conn, "INSERT INTO solusi(id_penyakit,solusi) VALUES('$id_penyakit','$solusi')");
    return mysqli_affected_rows($conn);
  }
  function edit_solusi($data)
  {
    global $conn;
    $id_solusi = valid($data['id_solusi']);
    $id_penyakit = valid($data['id_penyakit']);
    $solusi = valid($data['solusi']);
    mysqli_query($conn, "UPDATE solusi SET id_penyakit='$id_penyakit', solusi='$solusi' WHERE id_solusi='$id_solusi'");
    return mysqli_affected_rows($conn);
  }
  function delete_solusi($data)
  {
    global $conn;
    $id_solusi = valid($data['id_solusi']);
    mysqli_query($conn, "DELETE FROM solusi WHERE id_solusi='$id_solusi'");
    return mysqli_affected_rows($conn);
  }
  function add_obat($data)
  {
    global $conn;
    $id_penyakit = valid($data['id_penyakit']);
    $obat = valid($data['obat']);
    mysqli_query($conn, "INSERT INTO obat(id_penyakit,obat) VALUES('$id_penyakit','$obat')");
    return mysqli_affected_rows($conn);
  }
  function edit_obat($data)
  {
    global $conn;
    $id_obat = valid($data['id_obat']);
    $id_penyakit = valid($data['id_penyakit']);
    $obat = valid($data['obat']);
    mysqli_query($conn, "UPDATE obat SET id_penyakit='$id_penyakit', obat='$obat' WHERE id_obat='$id_obat'");
    return mysqli_affected_rows($conn);
  }
  function delete_obat($data)
  {
    global $conn;
    $id_obat = valid($data['id_obat']);
    mysqli_query($conn, "DELETE FROM obat WHERE id_obat='$id_obat'");
    return mysqli_affected_rows($conn);
  }
  function klasifikasi($data)
  {
    global $conn;
    $nama = valid($data['nama']);
    $id_jenis_kelamin = valid($data['id_jenis_kelamin']);
    $id_usia = valid($data['id_usia']);
    $alamat = valid($data['alamat']);
    $checklist = $data['checklist'];
    $akses = 2;
    $_SESSION['data-klasifikasi'] = [
      'nama' => $nama,
      'id_jenis_kelamin' => $id_jenis_kelamin,
      'id_usia' => $id_usia,
      'alamat' => $alamat,
      'gejala' => $checklist,
      'akses' => $akses
    ];
    return mysqli_affected_rows($conn);
  }
  function delete_data_uji($data)
  {
    global $conn;
    $id_uji = valid($data['id_uji']);
    mysqli_query($conn, "DELETE FROM data_uji WHERE id_uji='$id_uji'");
    return mysqli_affected_rows($conn);
  }
  function add_informasi($data)
  {
    global $conn;
    $judul = valid($data['judul']);
    $konten = $data['konten'];
    mysqli_query($conn, "INSERT INTO informasi(judul,konten) VALUES('$judul','$konten')");
    return mysqli_affected_rows($conn);
  }
  function edit_informasi($data)
  {
    global $conn;
    $id = valid($data['id']);
    $judul = valid($data['judul']);
    $konten = $data['konten'];
    mysqli_query($conn, "UPDATE informasi SET judul='$judul', konten='$konten', updated_at=current_timestamp WHERE id='$id'");
    return mysqli_affected_rows($conn);
  }
  function delete_informasi($data)
  {
    global $conn;
    $id = valid($data['id']);
    mysqli_query($conn, "DELETE FROM informasi WHERE id='$id'");
    return mysqli_affected_rows($conn);
  }
  function add_akuisisi($data)
  {
    global $conn;
    $id_gejala = valid($data['id_gejala']);
    $id_penyakit = $data['id_penyakit'];
    mysqli_query($conn, "INSERT INTO akuisisi(id_gejala,id_penyakit) VALUES('$id_gejala','$id_penyakit')");
    return mysqli_affected_rows($conn);
  }
  function delete_akuisisi($data)
  {
    global $conn;
    $id_akuisisi = valid($data['id_akuisisi']);
    mysqli_query($conn, "DELETE FROM akuisisi WHERE id_akuisisi='$id_akuisisi'");
    return mysqli_affected_rows($conn);
  }
}
