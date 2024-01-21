<nav class="sidebar sidebar-offcanvas shadow" style="background-color: rgb(3, 164, 237);" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='./'">
        <i class="mdi mdi-view-dashboard menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <?php if ($_SESSION['data-user']['role'] == 1) { ?>
      <li class="nav-item nav-category">Kelola Pengguna</li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='users'">
          <i class="mdi mdi-account-multiple-outline menu-icon"></i>
          <span class="menu-title">Users</span>
        </a>
      </li>
      <li class="nav-item nav-category">Data NBC</li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='data-latih'">
          <i class="mdi mdi-account-multiple-plus menu-icon"></i>
          <span class="menu-title">Data Latih</span>
        </a>
      </li>
      <?php }
    if ($_SESSION['data-user']['role'] <= 2) {
      if ($_SESSION['data-user']['role'] == 2) { ?>
        <li class="nav-item nav-category">Data Pakar</li>
        <li class="nav-item">
          <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='penyakit'">
            <i class="mdi mdi-heart-pulse menu-icon"></i>
            <span class="menu-title">Penyakit</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='gejala'">
            <i class="mdi mdi-loupe menu-icon"></i>
            <span class="menu-title">Gejala</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='solusi'">
            <i class="mdi mdi-stethoscope menu-icon"></i>
            <span class="menu-title">Solusi</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='akuisisi'">
            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            <span class="menu-title">Akuisisi</span>
          </a>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='klasifikasi'">
          <i class="mdi mdi-flask-outline menu-icon"></i>
          <span class="menu-title">Klasifikasi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='laporan'">
          <i class="mdi mdi-file menu-icon"></i>
          <span class="menu-title">Laporan</span>
        </a>
      </li>
    <?php }
    if ($_SESSION['data-user']['role'] == 1) { ?>
      <li class="nav-item nav-category">Data Lainnya</li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='informasi'">
          <i class="mdi mdi-format-list-bulleted menu-icon"></i>
          <span class="menu-title">Informasi</span>
        </a>
      </li>
    <?php } ?>
    <li class="nav-item nav-category"></li>
    <!-- <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='icons'">
        <i class="mdi mdi-face-profile menu-icon"></i>
        <span class="menu-title">Icons</span>
      </a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='../auth/signout'">
        <i class="mdi mdi-logout-variant menu-icon"></i>
        <span class="menu-title">Keluar</span>
      </a>
    </li>
  </ul>
</nav>