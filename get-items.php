<?php
include 'koneksi.php';

$id_vendor = $_POST['id_vendor'];
$query = mysqli_query($conn, "SELECT DISTINCT nama_barang FROM vendor WHERE id_vendor = '$id_vendor'");

$output = '<option value="">Pilih Nama Barang</option>';
while($row = mysqli_fetch_array($query)) {
    $output .= '<option value="'.$row['nama_barang'].'">'.$row['nama_barang'].'</option>';
}
echo $output;
?>
