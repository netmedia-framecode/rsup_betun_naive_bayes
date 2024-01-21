<?php require_once("../controller/script.php");
require_once __DIR__ . '/../assets/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetTitle("Laporan Prediksi Lama Studi Mahasiswa Lulus Tepat Dan Tidak Tepat");
$mpdf->WriteHTML('<div style="border-bottom: 3px solid black;width: 100%;">
  <table border="0" style="width: 100%;">
    <tbody>
      <tr>
        <th style="text-align: center;">
          <img src="../assets/images/logo.png" alt="" style="width: 100px;">
        </th>
        <td style="text-align: center;">
          <h3>LAPORAN DATA UJI PASIEN RAWAT JALAN DAN RAWAT INAP<br>RS PENYANGGA PERBATASAN BETUN</h3>
          <p>Jl. Sukabihanawa Desa Kamanasa Kec.Malaka Tengah <br> email: rsppbetun@gmail.com | telp: 0389 - 2515074</p>
        </td>
      </tr>
    </tbody>
  </table>
</div>');
$mpdf->WriteHTML('<h4 style="text-align: center;"></h4>
<table border="0" style="width: 100%;margin-top: 10px;vertical-align: top;">
  <thead>
    <tr>
      <th scope="col" class="text-center" style="border: 1px solid black;">#</th>
      <th scope="col" class="text-center" style="border: 1px solid black;">Nama</th>
      <th scope="col" class="text-center" style="border: 1px solid black;">Jenis Kelamin</th>
      <th scope="col" class="text-center" style="border: 1px solid black;">Usia</th>
      <th scope="col" class="text-center" style="border: 1px solid black;">Alamat</th>
      <th scope="col" class="text-center" style="border: 1px solid black;">Penyakit</th>
      ');
$mpdf->WriteHTML('</tr>
  </thead>
  <tbody>');
if (mysqli_num_rows($data_uji) > 0) {
  $no = 1;
  while ($row = mysqli_fetch_assoc($data_uji)) {
    $id_testing = $row['id_testing'];
    $mpdf->WriteHTML('
          <tr>
            <th style="border: 1px solid black;">' . $no++ . '</th>
            <td style="border: 1px solid black;">' . $row['nama'] . '</td>
            <td style="border: 1px solid black;">' . $row['jenis_kelamin'] . '</td>
            <td style="border: 1px solid black;">' . $row['usia'] . '</td>
            <td style="border: 1px solid black;">' . $row['alamat'] . '</td>
            <td style="border: 1px solid black;">' . $row['nama_penyakit'] . '</td>
          </tr>');
  }
}
$mpdf->WriteHTML('
  </tbody>
</table>');

$mpdf->Output();
// $mpdf->OutputHttpDownload('Laporan-Permintaan-Darah-UTD-PMI-Pemprov-NTT' . date("Y-m-d") . '.pdf');
// header("Location: laporan");
// exit;
