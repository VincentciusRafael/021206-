<?php
include '../koneksi.php';

if (isset($_POST['tambah'])) {
    $nama_gudang = $_POST['nama_gudang'];
    $lokasi = $_POST['lokasi'];

    mysqli_query($conn,  "INSERT INTO storage_unit (nama_gudang, lokasi) VALUES ('$nama_gudang', '$lokasi')");

    echo "<script>
            alert('Data gudang unit berhasil ditambahkan!');
            window.location='storage.php';
         </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Storage Unit</title>
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
                    <h1 class="h2">Tambah Barang</h1>

                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a type="button" class="btn btn-secondary" href="storage.php">
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Gudang</label>
                                <input type="text" class="form-control" name="nama_gudang" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" required>
                            </div>
                            <div class="md-3">
                                <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>