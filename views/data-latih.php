<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "Data Latih";
$_SESSION["page-url"] = "data-latih";
?>

<!DOCTYPE html>
<html lang="en">

<head><?php require_once("../resources/dash-header.php") ?></head>

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
                      <h3>Data Latih Pasien Rawat Jalan Dan Inap</h3>
                    </li>
                  </ul>
                  <div>
                    <div class="btn-wrapper">
                      <a href="#" class="btn btn-primary text-white me-0 btn-sm rounded-0" data-bs-toggle="modal" data-bs-target="#tambah">Tambah</a>
                    </div>
                  </div>
                </div>
                <div class="data-main">
                  <div class="card rounded-0 mt-3">
                    <div class="card-body table-responsive">
                      <table class="table table-striped table-hover table-borderless table-sm display" id="datatable">
                        <thead>
                          <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Nama</th>
                            <th scope="col" class="text-center">Jenis Kelamin</th>
                            <th scope="col" class="text-center">Usia</th>
                            <th scope="col" class="text-center">Alamat</th>
                            <th scope="col" class="text-center">Tgl Buat</th>
                            <th scope="col" class="text-center">Tgl Ubah</th>
                            <th scope="col" class="text-center">Aksi</th>
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
                                <td>
                                  <div class="badge badge-opacity-success">
                                    <?php $dateCreate = date_create($row["created_at"]);
                                    echo date_format($dateCreate, "l, d M Y h:i a"); ?>
                                  </div>
                                </td>
                                <td>
                                  <div class="badge badge-opacity-warning">
                                    <?php $dateUpdate = date_create($row["updated_at"]);
                                    echo date_format($dateUpdate, "l, d M Y h:i a"); ?>
                                  </div>
                                </td>
                                <td class="d-flex justify-content-center">
                                  <div class="col">
                                    <button type="button" class="btn btn-warning btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#ubah<?= $row["id_latih"] ?>">
                                      <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <div class="modal fade" id="ubah<?= $row["id_latih"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header border-bottom-0 shadow">
                                            <h5 class="modal-title" id="exampleModalLabel">Ubah data <?= $row["nama"] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <form action="" method="POST">
                                            <div class="modal-body text-center">
                                              <div class="mb-3">
                                                <label for="nama" class="form-label">Nama Pasien <small class="text-danger">*</small></label>
                                                <input type="text" name="nama" value="<?= $row["nama"] ?>" class="form-control text-center" id="nama" minlength="3" placeholder="Nama Pasien" required>
                                              </div>
                                              <div class="mb-3">
                                                <label for="id_jenis_kelamin" class="form-label">Jenis Kelamin <small class="text-danger">*</small></label>
                                                <select name="id_jenis_kelamin" class="form-select" aria-label="Default select example" required>
                                                  <option selected value="">Pilih Jenis Kelamin</option>
                                                  <?php $id_jenis_kelamin = $row['id_jenis_kelamin'];
                                                  foreach ($selectJenis_kelamin as $row_jk) {
                                                    $selected = ($row_jk['id_jenis_kelamin'] == $id_jenis_kelamin) ? 'selected' : ''; ?>
                                                    <option value="<?= $row_jk['id_jenis_kelamin'] ?>" <?= $selected ?>><?= $row_jk['jenis_kelamin'] ?></option>
                                                  <?php }  ?>
                                                </select>
                                              </div>
                                              <div class="mb-3">
                                                <label for="id_usia" class="form-label">Usia <small class="text-danger">*</small></label>
                                                <select name="id_usia" class="form-select" aria-label="Default select example" required>
                                                  <option selected value="">Pilih Usia</option>
                                                  <?php $id_usia = $row['id_usia'];
                                                  foreach ($selectUsia as $row_usia) {
                                                    $selected = ($row_usia['id_usia'] == $id_usia) ? 'selected' : ''; ?>
                                                    <option value="<?= $row_usia['id_usia'] ?>" <?= $selected ?>><?= $row_usia['usia'] ?></option>
                                                  <?php }  ?>
                                                </select>
                                              </div>
                                              <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat <small class="text-danger">*</small></label>
                                                <input type="text" name="alamat" class="form-control text-center" id="alamat" minlength="3" placeholder="Alamat" required>
                                              </div>
                                              <div class="mb-3">
                                                <label for="id_penyakit" class="form-label">Penyakit <small class="text-danger">*</small></label>
                                                <select name="id_penyakit" class="form-select" aria-label="Default select example" required>
                                                  <option selected value="">Pilih Penyakit</option>
                                                  <?php $id_penyakit = $row['id_penyakit'];
                                                  foreach ($selectPenyakit as $row_penyakit) {
                                                    $selected = ($row_penyakit['id_penyakit'] == $id_penyakit) ? 'selected' : ''; ?>
                                                    <option value="<?= $row_penyakit['id_penyakit'] ?>" <?= $selected ?>><?= $row_penyakit['nama_penyakit'] ?></option>
                                                  <?php }  ?>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="modal-footer justify-content-center border-top-0">
                                              <input type="hidden" name="id_latih" value="<?= $row["id_latih"] ?>">
                                              <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                              <button type="submit" name="ubah-data-latih" class="btn btn-warning btn-sm rounded-0 border-0" style="height: 30px;">Ubah</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col">
                                    <button type="button" class="btn btn-danger btn-sm text-white rounded-0 border-0" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#hapus<?= $row["id_latih"] ?>">
                                      <i class="bi bi-trash3"></i>
                                    </button>
                                    <div class="modal fade" id="hapus<?= $row["id_latih"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header border-bottom-0 shadow">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus data <?= $row["nama"] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body text-center">
                                            Anda yakin ingin menghapus data ini?
                                          </div>
                                          <div class="modal-footer justify-content-center border-top-0">
                                            <button type="button" class="btn btn-secondary btn-sm rounded-0 border-0" style="height: 30px;" data-bs-dismiss="modal">Batal</button>
                                            <form action="" method="POST">
                                              <input type="hidden" name="id_latih" value="<?= $row["id_latih"] ?>">
                                              <button type="submit" name="hapus-data-latih" class="btn btn-danger btn-sm rounded-0 text-white border-0" style="height: 30px;">Hapus</button>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </td>
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
            </div>
          </div>
        </div>

        <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header border-bottom-0 shadow">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Latih</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="" method="post" name="random_form">
                <div class="modal-body text-center">
                  <div class="mb-3">
                    <label for="nama" class="form-label">Nama Pasien <small class="text-danger">*</small></label>
                    <input type="text" name="nama" class="form-control text-center" id="nama" minlength="3" placeholder="Nama Pasien" required>
                  </div>
                  <div class="mb-3">
                    <label for="id_jenis_kelamin" class="form-label">Jenis Kelamin <small class="text-danger">*</small></label>
                    <select name="id_jenis_kelamin" class="form-select" aria-label="Default select example" required>
                      <option selected value="">Pilih Jenis Kelamin</option>
                      <?php foreach ($selectJenis_kelamin as $row_jk) : ?>
                        <option value="<?= $row_jk['id_jenis_kelamin'] ?>"><?= $row_jk['jenis_kelamin'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="id_usia" class="form-label">Usia <small class="text-danger">*</small></label>
                    <select name="id_usia" class="form-select" aria-label="Default select example" required>
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
                  <div class="mb-3">
                    <label for="id_penyakit" class="form-label">Penyakit <small class="text-danger">*</small></label>
                    <select name="id_penyakit" class="form-select" aria-label="Default select example" required>
                      <option selected value="">Pilih Penyakit</option>
                      <?php foreach ($selectPenyakit as $row_penyakit) : ?>
                        <option value="<?= $row_penyakit['id_penyakit'] ?>"><?= $row_penyakit['nama_penyakit'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                  <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" name="tambah-data-latih" class="btn btn-primary btn-sm rounded-0 border-0">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>