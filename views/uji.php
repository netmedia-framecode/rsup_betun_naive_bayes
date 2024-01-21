<?php require_once("../controller/script.php");

// function bayes($penyakit_all, $gejala_all, $gejala_terpilih)
// {
//   global $conn;

//langkah 1

// menentukan penyakit yang muncul berdasarkan data latih			

// menyusun array penyakit
$penyakit_all = array();
$query_penyakit = mysqli_query($conn, "SELECT * FROM penyakit");
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
$gejala_checklist = $_SESSION['data-klasifikasi']['gejala'];

$gejala_terpilih = array();
foreach ($gejala_checklist as $rowChecklist) {
  $gejala_terpilih[] = $gejala_all[$rowChecklist];
}
// $gejala_terpilih[0] = $gejala_all[3];
// $gejala_terpilih[1] = $gejala_all[4];
// $gejala_terpilih[2] = $gejala_all[14];
// $gejala_terpilih[3] = $gejala_all[28];
print_r($gejala_terpilih);

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
    'p' => 1 / count($gejala_terpilih),
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

    $nilai_p_a_v_p[$key_penyakit_all]['probabilitas'][$key_gejala_terpilih]['nilai'] = ($nilai_n_class[$key_penyakit_all]['nc'][$key_gejala_terpilih] + $nilai_n_class[$key_penyakit_all]['m'] * $nilai_n_class[$key_penyakit_all]['p']) / ($nilai_n_class[$key_penyakit_all]['nc'][$key_gejala_terpilih] + $nilai_n_class[$key_penyakit_all]['m']);
  }
}

// Proses 3  :				
// Menghitung P(ai|vj) x P(vj) untuk tiap v	
$nilai_p_a_v_v = [];
foreach ($penyakit_all as $key_penyakit_all => $value_penyakit_all) {

  $total_nilai_p_a_v_p[$key_penyakit_all] = 0;
  foreach ($gejala_terpilih as $key_gejala_terpilih => $value_gejala_terpilih) {

    if ($key_gejala_terpilih == 0) {
      $total_nilai_p_a_v_p[$key_penyakit_all] = $nilai_p_a_v_p[$key_penyakit_all]['probabilitas'][$key_gejala_terpilih]['nilai'];
    }

    $total_nilai_p_a_v_p[$key_penyakit_all] = $total_nilai_p_a_v_p[$key_penyakit_all] * $nilai_p_a_v_p[$key_penyakit_all]['probabilitas'][$key_gejala_terpilih]['nilai'];
  }

  $nilai_p_a_v_v[$key_penyakit_all]['class'] = $value_penyakit_all['kode'];
  $nilai_p_a_v_v[$key_penyakit_all]['v_max'] = $nilai_n_class[$key_penyakit_all]['p'] * $total_nilai_p_a_v_p[$key_penyakit_all];
}

// Proses 4 : 						
// Menentukan hasil klasifikasi yaitu v yang memiliki hasil perkalian yang terbesar						

$nilai_p_a_v_v_rsort = bubble_sort($nilai_p_a_v_v, 'v_max');

print_r($nilai_p_a_v_v_rsort);
// }
