<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Klasifikasi";
$_SESSION["page-url"] = "klasifikasi";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once("../resources/dash-header.php") ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <?php if (isset($_SESSION["message-success"])) { ?>
    <div class="message-success" data-message-success="<?= $_SESSION["message-success"] ?>"></div>
  <?php }
  if (isset($_SESSION["message-info"])) { ?>
    <div class="message-info" data-message-info="<?= $_SESSION["message-info"] ?>"></div>
  <?php }
  if (isset($_SESSION["message-warning"])) { ?>
    <div class="message-warning" data-message-warning="<?= $_SESSION["message-warning"] ?>"></div>
  <?php }
  if (isset($_SESSION["message-danger"])) { ?>
    <div class="message-danger" data-message-danger="<?= $_SESSION["message-danger"] ?>"></div>
  <?php } ?>
  <div class="container-scroller">
    <?php require_once("../resources/dash-topbar.php") ?>
    <div class="container-fluid page-body-wrapper">
      <?php require_once("../resources/dash-sidebar.php") ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <h3>Klasifikasi</h3>
                    </li>
                  </ul>
                </div>
                <div class="data-main">
                  <div class="row mt-3">
                    <div class="col-lg-3">
                      <div class="card border-0 rounded-0 shadow">
                        <div class="card-body">
                          <nav class="sidebar sidebar-offcanvas bg-transparent" id="sidebar">
                            <ul class="nav">
                              <li class="nav-item">
                                <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='klasifikasi?to=data-uji'">
                                  <i class="mdi mdi-subdirectory-arrow-right menu-icon text-dark"></i>
                                  <span class="menu-title text-dark">Data Uji</span>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='klasifikasi?to=data-latih'">
                                  <i class="mdi mdi-subdirectory-arrow-right menu-icon text-dark"></i>
                                  <span class="menu-title text-dark">Data Latih</span>
                                </a>
                              </li>
                              <!-- <li class="nav-item">
                                <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='klasifikasi?to=probabilitas'" data-bs-toggle="tooltip" data-bs-placement="right" title="Pada tahap ini kita akan menghitung nilai probabilitas penyakit dan gejala juga nilai bayes berdasarkan probabilitas penyakit dan gejala yang timbul">
                                  <i class="mdi mdi-subdirectory-arrow-right menu-icon text-dark"></i>
                                  <span class="menu-title text-dark">Probabilitas</span>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='klasifikasi?to=nilai-klasifikasi'" data-bs-toggle="tooltip" data-bs-placement="right" title="Proses pertama adalah melakukan pencocokan setiap parameter gejala ke tiap gejala penyakit. jika terdapat gejala yang sama maka nc akan bernilai 1 jika tidak nc bernilai 0. Proses kedua adalah perhitungan dengan menghitung peluang dari tiap penyakit. Dan proses ketiga adalah menghitung seluruh peluang dari tiap penyakit.">
                                  <i class="mdi mdi-subdirectory-arrow-right menu-icon text-dark"></i>
                                  <span class="menu-title text-dark">Nilai Klasifikasi</span>
                                </a>
                              </li> -->
                              <li class="nav-item">
                                <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='klasifikasi?to=hasil-klasifikasi'" data-bs-toggle="tooltip" data-bs-placement="right" title="Menentukan hasil klasifikasi yaitu v yang memiliki hasil perkalian yang terbesar">
                                  <i class="mdi mdi-subdirectory-arrow-right menu-icon text-dark"></i>
                                  <span class="menu-title text-dark">Hasil Klasifikasi</span>
                                </a>
                              </li>
                              <li class="nav-item">
                                <form action="" method="post">
                                  <button type="submit" name="reset-diagnosa" class="nav-link border-0 bg-transparent">
                                    <i class="mdi mdi-refresh menu-icon text-dark"></i>
                                    <span class="menu-title text-dark">Reset</span>
                                  </button>
                                </form>
                              </li>
                            </ul>
                          </nav>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-9">
                      <?php if (!isset($_SESSION['data-klasifikasi'])) { ?>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="card border-0 rounded-0 shadow">
                              <div class="card-header">
                                <div class="card-titile">
                                  <h4>Masukan Data Uji</h4>
                                </div>
                              </div>
                              <div class="card-body">
                                <form action="" method="post">
                                  <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Pasien <small class="text-danger">*</small></label>
                                    <input type="text" name="nama" class="form-control text-center" id="nama" minlength="3" placeholder="Nama Pasien" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="id_jenis_kelamin" class="form-label">Jenis Kelamin <small class="text-danger">*</small></label>
                                    <select name="id_jenis_kelamin" class="form-control" aria-label="Default select example" required>
                                      <option selected value="">Pilih Jenis Kelamin</option>
                                      <?php foreach ($selectJenis_kelamin as $row_jk) : ?>
                                        <option value="<?= $row_jk['id_jenis_kelamin'] ?>"><?= $row_jk['jenis_kelamin'] ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="id_usia" class="form-label">Usia <small class="text-danger">*</small></label>
                                    <select name="id_usia" class="form-control" aria-label="Default select example" required>
                                      <option selected value="">Pilih Usia</option>
                                      <?php foreach ($selectUsia as $row_usia) : ?>
                                        <option value="<?= $row_usia['id_usia'] ?>"><?= $row_usia['usia'] ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat <small class="text-danger">*</small></label>
                                    <input type="text" name="alamat" class="form-control text-center" id="alamat" minlength="3" placeholder="Alamat" required>
                                  </div>
                                  <div class="mb-3 text-center">
                                    <button type="submit" name="data-uji" class="btn btn-primary text-white me-0 rounded-0 mt-3">Submit</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php } else if (isset($_SESSION['data-klasifikasi'])) {

                        // Inisialisasi Data Session
                        $nama = valid($_SESSION['data-klasifikasi']['nama']);

                        $id_jenis_kelamin = valid($_SESSION['data-klasifikasi']['id_jenis_kelamin']);
                        $takeJK = mysqli_query($conn, "SELECT * FROM jenis_kelamin WHERE id_jenis_kelamin='$id_jenis_kelamin'");
                        $rowTakeJK = mysqli_fetch_assoc($takeJK);
                        $jenis_kelamin = $rowTakeJK['jenis_kelamin'];

                        $id_usia = valid($_SESSION['data-klasifikasi']['id_usia']);
                        $takeUsia = mysqli_query($conn, "SELECT * FROM usia WHERE id_usia='$id_usia'");
                        $rowTakeUsia = mysqli_fetch_assoc($takeUsia);
                        $usia = $rowTakeUsia['usia'];

                        $alamat = valid($_SESSION['data-klasifikasi']['alamat']);

                        if (isset($_GET['to'])) {
                          if ($_GET['to'] == "data-uji") { ?>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="card border-0 rounded-0 shadow">
                                  <div class="card-header">
                                    <div class="card-titile">
                                      <h4>Data Uji</h4>
                                    </div>
                                  </div>
                                  <div class="card-body table-responsive">
                                    <table class="table table-striped table-hover table-sm">
                                      <tbody>
                                        <tr>
                                          <th scope="row" style="width: 200px;">Nama Pasien</th>
                                          <td style="width: 10px;">:</td>
                                          <td><?= $nama ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row" style="width: 200px;">Jenis Kelamin</th>
                                          <td style="width: 10px;">:</td>
                                          <td><?= $jenis_kelamin ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row" style="width: 200px;">Usia</th>
                                          <td style="width: 10px;">:</td>
                                          <td><?= $usia ?></td>
                                        </tr>
                                        <tr>
                                          <th scope="row" style="width: 200px;">Alamat</th>
                                          <td style="width: 10px;">:</td>
                                          <td><?= $alamat ?></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div class="card border-0 rounded-0 shadow mt-3">
                                  <div class="card-header">
                                    <div class="card-titile">
                                      <h4>Gejala Yang Dialami:</h4>
                                    </div>
                                  </div>
                                  <div class="card-body table-responsive">
                                    <?php if ($_SESSION['data-klasifikasi']['akses'] == 1) { ?>
                                      <form action="" method="post">
                                        <table class="table table-striped table-hover table-borderless table-sm display">
                                          <thead>
                                            <tr>
                                              <th scope="col">Pilih</th>
                                              <th scope="col" class="text-center">Kode</th>
                                              <th scope="col" class="text-center">Gejala</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php $gejala = mysqli_query($conn, "SELECT * FROM gejala ORDER BY id_gejala ASC");
                                            if (mysqli_num_rows($gejala) > 0) {
                                              $no = 1;
                                              while ($rowG = mysqli_fetch_assoc($gejala)) { ?>
                                                <tr>
                                                  <th scope="row">
                                                    <div class="form-check">
                                                      <input class="form-check-input" name="checklist[<?= $no++ ?>]" style="margin-left: 0;font-size: 20px;" type="checkbox" value="<?= $rowG['id_gejala'] ?>">
                                                    </div>
                                                  </th>
                                                  <td class="text-center"><?= $rowG["kode_gejala"] ?></td>
                                                  <td><?= $rowG["gejala"] ?></td>
                                                </tr>
                                            <?php }
                                            } ?>
                                          </tbody>
                                        </table>
                                        <input type="hidden" name="nama" value="<?= $nama ?>">
                                        <input type="hidden" name="id_jenis_kelamin" value="<?= $id_jenis_kelamin ?>">
                                        <input type="hidden" name="id_usia" value="<?= $id_usia ?>">
                                        <input type="hidden" name="alamat" value="<?= $alamat ?>">
                                        <button type="submit" name="klasifikasi" class="btn btn-primary btn-sm rounded-0 text-white border-0 mt-3" style="height: 30px;">Klasifikasi</button>
                                      </form>
                                    <?php }
                                    if ($_SESSION['data-klasifikasi']['akses'] == 2) {
                                      $gejala_checklist = $_SESSION['data-klasifikasi']['gejala'];

                                      $gejalaList = implode("', '", $gejala_checklist);
                                      $sqlChecklist = "SELECT * FROM gejala WHERE id_gejala IN ('$gejalaList')";
                                      $resultChecklist = mysqli_query($conn, $sqlChecklist); ?>
                                      <table class="table table-striped table-hover table-borderless table-sm display">
                                        <thead>
                                          <tr>
                                            <th scope="col"></th>
                                            <th scope="col" class="text-center">Kode</th>
                                            <th scope="col" class="text-center">Gejala</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php while ($rowChecklist = mysqli_fetch_assoc($resultChecklist)) { ?>
                                            <tr>
                                              <th scope="row">
                                                <div class="form-check">
                                                  <input class="form-check-input" style="margin-left: 0;font-size: 20px;" type="checkbox" checked>
                                                </div>
                                              </th>
                                              <td class="text-center"><?= $rowChecklist["kode_gejala"] ?></td>
                                              <td><?= $rowChecklist["gejala"] ?></td>
                                            </tr>
                                          <?php } ?>
                                        </tbody>
                                      </table>
                                    <?php } ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php }
                          if ($_GET['to'] == "data-latih") { ?>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="card border-0 rounded-0 shadow">
                                  <div class="card-header">
                                    <div class="card-titile">
                                      <h4>Data Latih</h4>
                                    </div>
                                  </div>
                                  <div class="card-body table-responsive">
                                    <table class="table table-striped table-hover table-borderless table-sm display">
                                      <thead>
                                        <tr>
                                          <th scope="col" class="text-center">#</th>
                                          <th scope="col" class="text-center">Nama</th>
                                          <th scope="col" class="text-center">Jenis Kelamin</th>
                                          <th scope="col" class="text-center">Usia</th>
                                          <th scope="col" class="text-center">Alamat</th>
                                          <th scope="col" class="text-center">Penyakit</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php if (mysqli_num_rows($data_latih) > 0) {
                                          $no = 1;
                                          while ($row = mysqli_fetch_assoc($data_latih)) { ?>
                                            <tr>
                                              <th scope="row"><?= $no; ?></th>
                                              <td><?= $row["nama"] ?></td>
                                              <td><?= $row["jenis_kelamin"] ?></td>
                                              <td><?= $row["usia"] ?></td>
                                              <td><?= $row["alamat"] ?></td>
                                              <td><?= $row["nama_penyakit"] ?></td>
                                            </tr>
                                        <?php $no++;
                                          }
                                        } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php }
                          if ($_GET['to'] == "hasil-klasifikasi") {
                            $nama = valid($_SESSION['data-klasifikasi']['nama']);
                            $id_jenis_kelamin = valid($_SESSION['data-klasifikasi']['id_jenis_kelamin']);
                            $id_usia = valid($_SESSION['data-klasifikasi']['id_usia']);
                            $alamat = valid($_SESSION['data-klasifikasi']['alamat']);
                            $gejala_checklist = $_SESSION['data-klasifikasi']['gejala'];

                            $data_klasifikasi = bayes($nama, $id_jenis_kelamin, $id_usia, $alamat, $gejala_checklist);
                          ?>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="card border-0 rounded-0 shadow">
                                  <div class="card-header">
                                    <div class="card-titile">
                                      <h4>Hasil Klasifikasi</h4>
                                    </div>
                                  </div>
                                  <div class="card-body">
                                    <div class="row p-0 m-0">
                                      <div class="col-lg-6">
                                        <h3 class='mt-4 text-dark' style="line-height: 30px;">Gejala yang dialami oleh <?= $_SESSION['data-klasifikasi']['nama'] ?></h3>
                                        <?php $gejala_checklist = $_SESSION['data-klasifikasi']['gejala'];

                                        $gejalaList = implode("', '", $gejala_checklist);
                                        $sqlChecklist = "SELECT * FROM gejala WHERE id_gejala IN ('$gejalaList')";
                                        $resultChecklist = mysqli_query($conn, $sqlChecklist); ?>
                                        <table class="table table-striped table-hover table-borderless table-sm">
                                          <thead>
                                            <tr>
                                              <th scope="col"></th>
                                              <th scope="col" class="text-center">Kode</th>
                                              <th scope="col" class="text-center">Gejala</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php while ($rowChecklist = mysqli_fetch_assoc($resultChecklist)) { ?>
                                              <tr>
                                                <th scope="row">
                                                  <div class="form-check">
                                                    <input class="form-check-input" style="margin-left: 0;font-size: 20px;" type="checkbox" disabled checked>
                                                  </div>
                                                </th>
                                                <td class="text-center"><?= $rowChecklist["kode_gejala"] ?></td>
                                                <td><?= $rowChecklist["gejala"] ?></td>
                                              </tr>
                                            <?php } ?>
                                          </tbody>
                                        </table>
                                      </div>
                                      <div class="col-lg-6">
                                        <h3 class='mt-4 text-dark'>Evaluasi</h3>
                                        <canvas id="myChart"></canvas>
                                        <script>
                                          // Fungsi untuk mengambil data dari database
                                          function fetchData() {
                                            // Lakukan request ke server untuk mengambil data dari database
                                            // Anda dapat menggunakan AJAX atau library HTTP request seperti axios atau fetch

                                            // Contoh data yang diambil dari database
                                            var dataFromDatabase = {
                                              labels: [<?php foreach ($data_klasifikasi as $key_value_klasifikasi => $value_klasifikasi) {
                                                          $kode_penyakit = $value_klasifikasi['class'];
                                                          $klasifikasi_penyakit = mysqli_query($conn, "SELECT * FROM penyakit WHERE kode_penyakit='$kode_penyakit'");
                                                          $data_kp = mysqli_fetch_assoc($klasifikasi_penyakit);

                                                          // Periksa jika $value_klasifikasi['v_max'] bukan 0
                                                          if ($value_klasifikasi['v_max'] != 0) {

                                                            // Ubah format angka menggunakan number_format()
                                                            $formatted_value = $value_klasifikasi['v_max'];

                                                            echo "'" . $data_kp['nama_penyakit'] . ": " . $formatted_value . "',";
                                                          }
                                                        } ?>],
                                              values: [<?php foreach ($data_klasifikasi as $value_klasifikasi) {
                                                          // Periksa jika $value_klasifikasi['v_max'] bukan 0
                                                          if ($value_klasifikasi['v_max'] != 0) {

                                                            // Ubah format angka menggunakan number_format()
                                                            $formatted_value = $value_klasifikasi['v_max'];

                                                            echo $formatted_value . ",";
                                                          }
                                                        } ?>]
                                            };

                                            // Panggil fungsi untuk membuat chart pie setelah data berhasil diambil
                                            createPieChart(dataFromDatabase.labels, dataFromDatabase.values);
                                          }

                                          // Fungsi untuk membuat chart pie menggunakan data dari database
                                          function createPieChart(labels, values) {
                                            var backgroundColors = generateRandomColors(values.length); // Generate random colors

                                            var data = {
                                              labels: labels,
                                              datasets: [{
                                                data: values,
                                                backgroundColor: backgroundColors
                                              }]
                                            };

                                            var options = {
                                              responsive: true
                                            };

                                            var ctx = document.getElementById('myChart').getContext('2d');
                                            var myPieChart = new Chart(ctx, {
                                              type: 'pie',
                                              data: data,
                                              options: options
                                            });
                                          }

                                          // Fungsi untuk menghasilkan daftar warna acak
                                          function generateRandomColors(numColors) {
                                            var colors = [];
                                            for (var i = 0; i < numColors; i++) {
                                              var color = getRandomColor();
                                              colors.push(color);
                                            }
                                            return colors;
                                          }

                                          // Fungsi untuk menghasilkan warna acak dalam format heksadesimal
                                          function getRandomColor() {
                                            var letters = '0123456789ABCDEF';
                                            var color = '#';
                                            for (var i = 0; i < 6; i++) {
                                              color += letters[Math.floor(Math.random() * 16)];
                                            }
                                            return color;
                                          }

                                          // Panggil fungsi fetchData untuk mengambil data dari database dan membuat chart
                                          fetchData();
                                        </script>
                                        <?php
                                        $max_nilai = 0; // Inisialisasi nilai terbesar
                                        $nama_penyakit = '';
                                        $nilai_terbesar = 0.0; // Inisialisasi nilai terbesar untuk ditampilkan

                                        foreach ($data_klasifikasi as $key_value_klasifikasi => $value_klasifikasi) {
                                          $kode_penyakit = $value_klasifikasi['class'];
                                          $klasifikasi_penyakit = mysqli_query($conn, "SELECT * FROM penyakit WHERE kode_penyakit='$kode_penyakit'");
                                          $data_kp = mysqli_fetch_assoc($klasifikasi_penyakit);

                                          // Periksa jika $value_klasifikasi['v_max'] bukan 0
                                          if ($value_klasifikasi['v_max'] != 0) {

                                            // Perbarui nilai terbesar dan nama penyakit terkait
                                            if ($value_klasifikasi['v_max'] > $max_nilai) {
                                              $max_nilai = $value_klasifikasi['v_max'];
                                              $nilai_terbesar = floatval($max_nilai); // Konversi ke float
                                              $nama_penyakit = $data_kp['nama_penyakit'];
                                            }
                                          }
                                        }
                                        ?>
                                        <h3 class='mt-4 text-dark' style="line-height: 30px;">Penyakit <?= $nama_penyakit ?> Dengan Evaluasi Nilai Tertinggi</h3>
                                        <p style="font-size: 16px;"><strong>Solusi</strong> dari penyakit ini yaitu <?php $solusi = mysqli_query($conn, "SELECT * FROM penyakit JOIN solusi ON penyakit.id_penyakit=solusi.id_penyakit WHERE penyakit.nama_penyakit='$nama_penyakit'");
                                                                                                                    $rowSolusi = mysqli_fetch_assoc($solusi);
                                                                                                                    echo $rowSolusi['solusi']; ?></p>
                                        <form action="" method="post">
                                          <button type="submit" name="reset-diagnosa" class="btn btn-primary border-0 rounded-0 text-white"><i class="fa fa-refresh" aria-hidden="true"></i> Reset</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                      <?php }
                        }
                      } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>