<?php require_once("controller/script.php");
$_SESSION["page-name"] = "Daftar Penyakit";
$_SESSION["page-url"] = "daftar-penyakit";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('resources/header.php'); ?>
</head>

<body>
  <?php require_once('resources/navbar.php'); ?>

  <div id="services" class="services section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="section-heading  wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
            <h4>Daftar <em>Penyakit</em></h4>
            <img src="assets/images/heading-line-dec.png" alt="">
            <p class="text-dark">Beberapa penyakit beserta keterangannya</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <?php if (mysqli_num_rows($viewPenyakit) > 0) {
          while ($row = mysqli_fetch_assoc($viewPenyakit)) { ?>
            <div class="col-lg-3">
              <div class="service-item first-service">
                <div class="icon"></div>
                <h4><?= $row['nama_penyakit'] ?></h4>
                <div class="text-button">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#detail<?= $row['id_penyakit'] ?>">Detail <i class="fa fa-arrow-right"></i></a>
                </div>
              </div>
            </div>
            <div class="modal fade" id="detail<?= $row['id_penyakit'] ?>" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel"><?= $row['nama_penyakit'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <h6>Gejala yang sering muncul yaitu :</h6>
                    <ol type="1">
                      <?php $id_penyakit = $row['id_penyakit'];
                      $viewGejala = mysqli_query($conn, "SELECT * FROM gejala WHERE id_penyakit='$id_penyakit'");
                      if (mysqli_num_rows($viewGejala) > 0) {
                        while ($row_gejala = mysqli_fetch_assoc($viewGejala)) { ?>
                          <li>
                            <p class="text-dark" style="margin-left: 20px;"><?= $row_gejala['gejala'] ?></p>
                          </li>
                      <?php }
                      } ?>
                    </ol>
                    <h6>Solusi :</h6>
                    <ol type="1">
                      <?php $viewSolusi = mysqli_query($conn, "SELECT * FROM solusi WHERE id_penyakit='$id_penyakit'");
                      if (mysqli_num_rows($viewSolusi) > 0) {
                        while ($row_gejala = mysqli_fetch_assoc($viewSolusi)) { ?>
                          <li>
                            <p class="text-dark" style="margin-left: 20px;"><?= $row_gejala['solusi'] ?></p>
                          </li>
                      <?php }
                      } ?>
                    </ol>
                    <h6>Penyembuhan :</h6>
                    <ol type="1">
                      <?php $viewObat = mysqli_query($conn, "SELECT * FROM obat WHERE id_penyakit='$id_penyakit'");
                      if (mysqli_num_rows($viewObat) > 0) {
                        while ($row_gejala = mysqli_fetch_assoc($viewObat)) { ?>
                          <li>
                            <p class="text-dark" style="margin-left: 20px;"><?= $row_gejala['obat'] ?></p>
                          </li>
                      <?php }
                      } ?>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
        <?php }
        } ?>
      </div>
    </div>
  </div>

  <?php require_once('resources/footer.php'); ?>
</body>

</html>