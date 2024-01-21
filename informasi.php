<?php require_once("controller/script.php");
$_SESSION["page-name"] = "Informasi";
$_SESSION["page-url"] = "informasi";
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
            <h4>Informasi</h4>
            <img src="assets/images/heading-line-dec.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="clients" class="the-clients" style="margin-top: 0;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="naccs">
            <div class="grid">
              <div class="row">
                <div class="col-lg-4">
                  <div class="menu">
                    <?php if (mysqli_num_rows($viewInformasi) > 0) {
                      while ($row = mysqli_fetch_assoc($viewInformasi)) { ?>
                        <div>
                          <div class="thumb">
                            <div class="row">
                              <div class="col-lg-12">
                                <h4><?= $row['judul'] ?></h4>
                                <span class="date">
                                  <?php $dateCreate = date_create($row["created_at"]);
                                  echo date_format($dateCreate, "l, d M Y h:i a"); ?>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                    <?php }
                    } ?>
                  </div>
                </div>
                <div class="col-lg-8">
                  <ul class="nacc">
                    <?php if (mysqli_num_rows($viewInformasiDetail) > 0) {
                      $no = 1;
                      while ($row = mysqli_fetch_assoc($viewInformasiDetail)) { ?>
                        <li <?php if ($no == 1) {
                              echo "class='active'";
                            } ?>>
                          <div>
                            <div class="thumb">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="client-content">
                                    <h4 class="text-white"><?= $row['judul'] ?></h4>
                                    <?= $row['konten'] ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                    <?php $no++;
                      }
                    } ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once('resources/footer.php'); ?>
</body>

</html>