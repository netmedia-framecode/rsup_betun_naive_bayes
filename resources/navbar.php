<!-- ***** Preloader Start ***** -->
<div id="js-preloader" class="js-preloader">
  <div class="preloader-inner">
    <span class="dot"></span>
    <div class="dots">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
</div>
<!-- ***** Preloader End ***** -->

<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <nav class="main-nav">
          <!-- ***** Logo Start ***** -->
          <a href="index.html" class="logo">
            <img src="assets/images/logo.png" style="width: 50px;" alt="Chain App Dev">
          </a>
          <!-- ***** Logo End ***** -->
          <!-- ***** Menu Start ***** -->
          <ul class="nav">
            <li class="scroll-to-section"><a href="./">Beranda</a></li>
            <li class="scroll-to-section"><a href="konsultasi">Konsultasi</a></li>
            <li class="scroll-to-section"><a href="daftar-penyakit">Daftar Penyakit</a></li>
            <li class="scroll-to-section"><a href="informasi">Informasi</a></li>
            <?php if (!isset($_SESSION['data-user'])) { ?>
              <li>
                <div class="gradient-button"><a href="auth/"><i class="fa fa-sign-in-alt"></i> Masuk</a></div>
              </li>
            <?php } else if (isset($_SESSION['data-user'])) { ?>
              <li>
                <div class="gradient-button"><a href="auth/signout"><i class="fa fa-sign-out-alt"></i> Keluar</a></div>
              </li>
            <?php } ?>
          </ul>
          <a class='menu-trigger'>
            <span>Menu</span>
          </a>
          <!-- ***** Menu End ***** -->
        </nav>
      </div>
    </div>
  </div>
</header>
<!-- ***** Header Area End ***** -->