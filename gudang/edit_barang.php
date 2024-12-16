<?php
include '../koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM storage_unit WHERE id_gudang='$id'");
$data = mysqli_fetch_array($query);

if(isset($_POST['edit'])) {
    $nama_gudang = $_POST['nama_gudang'];
    $lokasi = $_POST['lokasi'];
    
    mysqli_query($conn, "UPDATE storage_unit SET 
                        nama_gudang='$nama_gudang',
                        lokasi='$lokasi'
                        WHERE id_gudang='$id'");
    
    echo "<script>
            alert('Data storage unit berhasil diupdate!');
            window.location='storage.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Storage Unit</title>
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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Storage Unit</h1>

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
                                <input type="text" class="form-control" name="nama_gudang" value="<?php echo $data['nama_gudang']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" value="<?php echo $data['lokasi']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="edit" class="btn btn-primary">Update</button>
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