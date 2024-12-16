<?php
include '../koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT i.*, v.nama_vendor, s.nama_gudang 
                                 FROM inventory i 
                                 JOIN vendor v ON i.id_vendor = v.id_vendor
                                 JOIN storage_unit s ON i.id_gudang = s.id_gudang
                                 WHERE id_inventory='$id'");
    $row = mysqli_fetch_array($query);
} else {
    echo "<script>
            alert('ID tidak ditemukan!');
            window.location='inventory.php';
          </script>";
    exit;
}

// Handle form submission
if(isset($_POST['edit'])) {
    $id = $_POST['id_inventory'];
    $nama_barang = $_POST['nama_barang'];
    $jenis_barang = $_POST['jenis_barang'];
    $kuantitas = $_POST['kuantitas'];
    $id_gudang = $_POST['id_gudang'];
    $barcode = $_POST['barcode'];
    $id_vendor = $_POST['id_vendor'];
    
    $update = mysqli_query($conn, "UPDATE inventory SET 
                           nama_barang='$nama_barang',
                           jenis_barang='$jenis_barang',
                           kuantitas='$kuantitas',
                           id_gudang='$id_gudang',
                           barcode='$barcode',
                           id_vendor='$id_vendor'
                           WHERE id_inventory='$id'");
    
    if($update) {
        echo "<script>
                alert('Data barang berhasil diupdate!');
                window.location='inventory.php';
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
    <title>Edit Inventory</title>
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
                    <h1 class="h2">Edit Inventory</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a type="button" class="btn btn-secondary" href="./inventory.php">
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="id_inventory" value="<?php echo $row['id_inventory']; ?>">
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <select class="form-select" name="nama_barang" required>
                                    <?php
                                    $query_barang = mysqli_query($conn, "SELECT DISTINCT nama_barang FROM vendor");
                                    while($b = mysqli_fetch_array($query_barang)) {
                                        $selected = ($b['nama_barang'] == $row['nama_barang']) ? 'selected' : '';
                                        echo "<option value='".$b['nama_barang']."' ".$selected.">".$b['nama_barang']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Barang</label>
                                <input type="text" class="form-control" name="jenis_barang" required
                                    value="<?php echo $row['jenis_barang']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kuantitas</label>
                                <input type="number" class="form-control" name="kuantitas" required
                                    value="<?php echo $row['kuantitas']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gudang</label>
                                <select class="form-select" name="id_gudang" required>
                                    <?php
                                    $gudang = mysqli_query($conn, "SELECT * FROM storage_unit");
                                    while($g = mysqli_fetch_array($gudang)) {
                                        $selected = ($g['id_gudang'] == $row['id_gudang']) ? 'selected' : '';
                                        echo "<option value='".$g['id_gudang']."' ".$selected.">".$g['nama_gudang']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Vendor</label>
                                <select class="form-select" name="id_vendor" required>
                                    <?php
                                    $vendor = mysqli_query($conn, "SELECT * FROM vendor");
                                    while($v = mysqli_fetch_array($vendor)) {
                                        $selected = ($v['id_vendor'] == $row['id_vendor']) ? 'selected' : '';
                                        echo "<option value='".$v['id_vendor']."' ".$selected.">".$v['nama_vendor']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Barcode</label>
                                <input type="text" class="form-control" name="barcode" required
                                    value="<?php echo $row['barcode']; ?>">
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