<?php
if (!isset($_SESSION[""])) {
  session_start();
}
error_reporting(~E_NOTICE & ~E_DEPRECATED);
require_once("db_connect.php");
require_once("functions.php");
if (isset($_SESSION["time-message"])) {
  if ((time() - $_SESSION["time-message"]) > 2) {
    if (isset($_SESSION["message-success"])) {
      unset($_SESSION["message-success"]);
    }
    if (isset($_SESSION["message-info"])) {
      unset($_SESSION["message-info"]);
    }
    if (isset($_SESSION["message-warning"])) {
      unset($_SESSION["message-warning"]);
    }
    if (isset($_SESSION["message-danger"])) {
      unset($_SESSION["message-danger"]);
    }
    if (isset($_SESSION["message-dark"])) {
      unset($_SESSION["message-dark"]);
    }
    unset($_SESSION["time-alert"]);
  }
}

$baseURL = "http://$_SERVER[HTTP_HOST]/apps/tugas/rsup_betun_naive_bayes/";

if (!isset($_SESSION["data-user"])) {

  $selectRawat = mysqli_query($conn, "SELECT * FROM rawat");
  $selectJenis_kelamin = mysqli_query($conn, "SELECT * FROM jenis_kelamin");
  $selectUsia = mysqli_query($conn, "SELECT * FROM usia");
  $selectPenyakit = mysqli_query($conn, "SELECT * FROM penyakit");
  $selectLama_idap = mysqli_query($conn, "SELECT * FROM lama_idap");
  if (isset($_POST['konsultasi'])) {
    $nama = valid($_POST['nama']);
    $id_jenis_kelamin = valid($_POST['id_jenis_kelamin']);
    $id_usia = valid($_POST['id_usia']);
    $alamat = valid($_POST['alamat']);
    $akses = 1;
    $_SESSION['data-konsultasi'] = [
      'nama' => $nama,
      'id_jenis_kelamin' => $id_jenis_kelamin,
      'id_usia' => $id_usia,
      'alamat' => $alamat,
      'akses' => $akses
    ];
    header("Location: konsultasi");
    exit();
  }
  if (isset($_POST["klasifikasi"])) {
    if (klasifikasi($_POST) > 0) {
      $_SESSION["message-success"] = "Berhasil di klasifikasi silakan lihat hasilnya";
      $_SESSION["time-message"] = time();
      header("Location: konsultasi");
      exit();
    }
  }
  if (isset($_POST['reset-diagnosa'])) {
    unset($_SESSION['data-konsultasi']);
    header("Location: konsultasi");
    exit();
  }

  $viewPenyakit = mysqli_query($conn, "SELECT * FROM penyakit");
  $viewInformasi = mysqli_query($conn, "SELECT * FROM informasi ORDER BY id DESC");
  $viewInformasiDetail = mysqli_query($conn, "SELECT * FROM informasi ORDER BY id DESC");

  if (isset($_POST["masuk"])) {
    if (masuk($_POST) > 0) {
      header("Location: ../views/");
      exit();
    }
  }
}

if (isset($_SESSION["data-user"])) {
  $idUser = valid($_SESSION["data-user"]["id"]);

  $profile = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$idUser'");
  if (isset($_POST["ubah-profile"])) {
    if (edit_profile($_POST) > 0) {
      $_SESSION["message-success"] = "Profil akun anda berhasil di ubah.";
      $_SESSION["time-message"] = time();
      header("Location: profil");
      exit();
    }
  }

  $users = mysqli_query($conn, "SELECT users.*, users_role.role FROM users JOIN users_role ON users.id_role=users_role.id_role WHERE users.id_user!='$idUser'");
  $users_role = mysqli_query($conn, "SELECT * FROM users_role");
  if (isset($_POST["tambah-user"])) {
    if (add_user($_POST) > 0) {
      $_SESSION["message-success"] = "Data pengguna berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: users");
      exit();
    }
  }
  if (isset($_POST["ubah-user"])) {
    if (edit_user($_POST) > 0) {
      $_SESSION["message-success"] = "Data pengguna berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: users");
      exit();
    }
  }
  if (isset($_POST["hapus-user"])) {
    if (delete_user($_POST) > 0) {
      $_SESSION["message-success"] = "Data pengguna berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: users");
      exit();
    }
  }

  $overview = mysqli_query($conn, "SELECT * FROM overview");
  if (isset($_POST["overview"])) {
    if (overview($_POST) > 0) {
      $_SESSION["message-success"] = "Data overview berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }

  $data_latih = mysqli_query($conn, "SELECT data_latih.*, jenis_kelamin.jenis_kelamin, usia.usia, penyakit.nama_penyakit FROM data_latih
    JOIN jenis_kelamin ON data_latih.id_jenis_kelamin=jenis_kelamin.id_jenis_kelamin
    JOIN usia ON data_latih.id_usia=usia.id_usia
    JOIN penyakit ON data_latih.id_penyakit=penyakit.id_penyakit
  ");
  $selectRawat = mysqli_query($conn, "SELECT * FROM rawat");
  $selectJenis_kelamin = mysqli_query($conn, "SELECT * FROM jenis_kelamin");
  $selectUsia = mysqli_query($conn, "SELECT * FROM usia");
  $selectPenyakit = mysqli_query($conn, "SELECT * FROM penyakit");
  $selectLama_idap = mysqli_query($conn, "SELECT * FROM lama_idap");
  if (isset($_POST["tambah-data-latih"])) {
    if (add_data_latih($_POST) > 0) {
      $_SESSION["message-success"] = "Data pengguna berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: data-latih");
      exit();
    }
  }
  if (isset($_POST["ubah-data-latih"])) {
    if (edit_data_latih($_POST) > 0) {
      $_SESSION["message-success"] = "Data pengguna berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: data-latih");
      exit();
    }
  }
  if (isset($_POST["hapus-data-latih"])) {
    if (delete_data_latih($_POST) > 0) {
      $_SESSION["message-success"] = "Data pengguna berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: data-latih");
      exit();
    }
  }

  $penyakit = mysqli_query($conn, "SELECT * FROM penyakit");
  if (isset($_POST["tambah-penyakit"])) {
    if (add_penyakit($_POST) > 0) {
      $_SESSION["message-success"] = "Data penyakit berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: penyakit");
      exit();
    }
  }
  if (isset($_POST["ubah-penyakit"])) {
    if (edit_penyakit($_POST) > 0) {
      $_SESSION["message-success"] = "Data penyakit berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: penyakit");
      exit();
    }
  }
  if (isset($_POST["hapus-penyakit"])) {
    if (delete_penyakit($_POST) > 0) {
      $_SESSION["message-success"] = "Data penyakit berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: penyakit");
      exit();
    }
  }

  $gejala = mysqli_query($conn, "SELECT * FROM gejala JOIN penyakit ON gejala.id_penyakit=penyakit.id_penyakit");
  if (isset($_POST["tambah-gejala"])) {
    if (add_gejala($_POST) > 0) {
      $_SESSION["message-success"] = "Data gejala berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: gejala");
      exit();
    }
  }
  if (isset($_POST["ubah-gejala"])) {
    if (edit_gejala($_POST) > 0) {
      $_SESSION["message-success"] = "Data gejala berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: gejala");
      exit();
    }
  }
  if (isset($_POST["hapus-gejala"])) {
    if (delete_gejala($_POST) > 0) {
      $_SESSION["message-success"] = "Data gejala berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: gejala");
      exit();
    }
  }

  $solusi = mysqli_query($conn, "SELECT * FROM solusi JOIN penyakit ON solusi.id_penyakit=penyakit.id_penyakit");
  if (isset($_POST["tambah-solusi"])) {
    if (add_solusi($_POST) > 0) {
      $_SESSION["message-success"] = "Data solusi berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: solusi");
      exit();
    }
  }
  if (isset($_POST["ubah-solusi"])) {
    if (edit_solusi($_POST) > 0) {
      $_SESSION["message-success"] = "Data solusi berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: solusi");
      exit();
    }
  }
  if (isset($_POST["hapus-solusi"])) {
    if (delete_solusi($_POST) > 0) {
      $_SESSION["message-success"] = "Data solusi berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: solusi");
      exit();
    }
  }

  $obat = mysqli_query($conn, "SELECT * FROM obat JOIN penyakit ON obat.id_penyakit=penyakit.id_penyakit");
  if (isset($_POST["tambah-obat"])) {
    if (add_obat($_POST) > 0) {
      $_SESSION["message-success"] = "Data obat berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: obat");
      exit();
    }
  }
  if (isset($_POST["ubah-obat"])) {
    if (edit_obat($_POST) > 0) {
      $_SESSION["message-success"] = "Data obat berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: obat");
      exit();
    }
  }
  if (isset($_POST["hapus-obat"])) {
    if (delete_obat($_POST) > 0) {
      $_SESSION["message-success"] = "Data obat berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: obat");
      exit();
    }
  }

  if (isset($_POST['data-uji'])) {
    $nama = valid($_POST['nama']);
    $id_jenis_kelamin = valid($_POST['id_jenis_kelamin']);
    $id_usia = valid($_POST['id_usia']);
    $alamat = valid($_POST['alamat']);
    $akses = 1;
    $_SESSION['data-klasifikasi'] = [
      'nama' => $nama,
      'id_jenis_kelamin' => $id_jenis_kelamin,
      'id_usia' => $id_usia,
      'alamat' => $alamat,
      'akses' => $akses
    ];
    header("Location: klasifikasi?to=data-uji");
    exit();
  }
  if (isset($_POST["klasifikasi"])) {
    if (klasifikasi($_POST) > 0) {
      $_SESSION["message-success"] = "Berhasil di klasifikasi silakan lihat hasilnya";
      $_SESSION["time-message"] = time();
      header("Location: klasifikasi?to=data-uji");
      exit();
    }
  }
  if (isset($_POST['reset-diagnosa'])) {
    unset($_SESSION['data-klasifikasi']);
    header("Location: klasifikasi");
    exit();
  }

  $data_uji = mysqli_query($conn, "SELECT data_uji.*, jenis_kelamin.jenis_kelamin, usia.usia, penyakit.nama_penyakit FROM data_uji
    JOIN jenis_kelamin ON data_uji.id_jenis_kelamin=jenis_kelamin.id_jenis_kelamin
    JOIN usia ON data_uji.id_usia=usia.id_usia
    JOIN penyakit ON data_uji.id_penyakit=penyakit.id_penyakit
  ");
  if (isset($_POST["hapus-data-uji"])) {
    if (delete_data_uji($_POST) > 0) {
      $_SESSION["message-success"] = "Data uji berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: laporan");
      exit();
    }
  }

  $informasi = mysqli_query($conn, "SELECT * FROM informasi");
  if (isset($_POST["tambah-informasi"])) {
    if (add_informasi($_POST) > 0) {
      $_SESSION["message-success"] = "Data informasi berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: informasi");
      exit();
    }
  }
  if (isset($_POST["ubah-informasi"])) {
    if (edit_informasi($_POST) > 0) {
      $_SESSION["message-success"] = "Data informasi berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: informasi");
      exit();
    }
  }
  if (isset($_POST["hapus-informasi"])) {
    if (delete_informasi($_POST) > 0) {
      $_SESSION["message-success"] = "Data informasi berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: informasi");
      exit();
    }
  }

  $akuisisi = mysqli_query($conn, "SELECT * FROM akuisisi JOIN gejala ON akuisisi.id_gejala=gejala.id_gejala JOIN penyakit ON akuisisi.id_penyakit=penyakit.id_penyakit");
  if (isset($_POST["tambah-akuisisi"])) {
    if (add_akuisisi($_POST) > 0) {
      $_SESSION["message-success"] = "Data akuisisi berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: akuisisi");
      exit();
    }
  }
  if (isset($_POST["hapus-akuisisi"])) {
    if (delete_akuisisi($_POST) > 0) {
      $_SESSION["message-success"] = "Data akuisisi berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: akuisisi");
      exit();
    }
  }
}
