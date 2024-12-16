<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM vendor WHERE id_vendor='$id'");
    $row = mysqli_fetch_array($query);
} else {
    echo "<script>
            alert('ID tidak ditemukan!');
            window.location='vendor.php';
          </script>";
    exit;
}

// Handle form submission
if(isset($_POST['edit'])) {
    $id = $_POST['id_vendor'];
    $nama_vendor = $_POST['nama_vendor'];
    $nama_barang = $_POST['nama_barang'];
    $kontak = $_POST['kontak'];
    $nomor_invoice = $_POST['nomor_invoice'];
    
    $update = mysqli_query($conn, "UPDATE vendor SET 
                           nama_vendor='$nama_vendor',
                           nama_barang='$nama_barang',
                           kontak='$kontak',
                           nomor_invoice='$nomor_invoice'
                           WHERE id_vendor='$id'");
    
    if($update) {
        echo "<script>
                alert('Data vendor berhasil diupdate!');
                window.location='vendor.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengupdate data!');
              </script>";
    }
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vendor</title>
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
                        <a type="button" class="btn btn-secondary" href="vendor.php">
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <input type="hidden" name="id_vendor" value="<?php echo $row['id_vendor']; ?>">
                                <div class="mb-3">
                                    <label class="form-label">Nama Vendor</label>
                                    <input type="text" class="form-control" name="nama_vendor" required
                                        value="<?php echo $row['nama_vendor']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" name="nama_barang" required
                                        value="<?php echo $row['nama_barang']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kontak</label>
                                    <input type="text" class="form-control" name="kontak" 
                                        value="<?php echo $row['kontak']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nomor Invoice</label>
                                    <input type="text" class="form-control" name="nomor_invoice" 
                                        value="<?php echo $row['nomor_invoice']; ?>">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" name="edit" class="btn btn-primary">Update</button>
                                </div>
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