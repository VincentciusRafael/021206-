<?php
include '../koneksi.php';

if(isset($_POST['tambah'])) {
    $nama_vendor = $_POST['nama_vendor'];
    $nama_barang =  $_POST['nama_barang'];
    $kontak = $_POST['kontak'];
    $nomor_invoice = $_POST['nomor_invoice'];
    
    $query = mysqli_query($conn, "INSERT INTO vendor (nama_vendor, nama_barang, kontak, nomor_invoice) 
                           VALUES ('$nama_vendor', '$nama_barang', '$kontak', '$nomor_invoice')");
    
    echo "<script>
            alert('Data vendor berhasil ditambahkan!');
            window.location='vendor.php'; 
          </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Vendor</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-utilities.min.css">
    <style>
        body {
            background-color: #f8f9fc;
        }
        .card {
            background: #fff;
            border-radius: 0.35rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-lg-8 mx-auto">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-item-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Tambah Vendor</h1>

                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a type="button" class="btn btn-secondary" href="vendor.php">
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Vendor</label>
                                <input type="text" class="form-control" name="nama_vendor" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" name="nama_barang" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kontak</label>
                                <input type="text" class="form-control" name="kontak">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor Invoice</label>
                                <input type="text" class="form-control" name="nomor_invoice">
                            </div>
                            <div class="md-3">
                                <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>