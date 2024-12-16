<?php 
include '../koneksi.php';

if (isset($_POST['tambah'])) {
    // Split the combined value into item name and vendor ID
    list($nama_barang, $id_vendor) = explode('|', $_POST['nama_barang_vendor']);
    
    $jenis_barang = $_POST['jenis_barang'];
    $kuantitas = $_POST['kuantitas'];
    $id_gudang = $_POST['id_gudang'];
    $barcode = $_POST['barcode'];

    mysqli_query($conn, "INSERT INTO inventory (nama_barang, jenis_barang, kuantitas, id_gudang, barcode, id_vendor) 
                        VALUES ('$nama_barang', '$jenis_barang', '$kuantitas', '$id_gudang', '$barcode', '$id_vendor')");

    echo "<script>
            alert('Data barang berhasil ditambahkan!')
            window.location = 'inventory.php';
         </script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Inventory</title>
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
                    <h1 class="h2">Tambah Inventory</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="inventory.php" type="button" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Nama Barang - Vendor</label>
                                <select name="nama_barang_vendor" class="form-select" required>
                                    <option value="">Pilih Nama Barang - Vendor</option>
                                    <?php 
                                        $query = mysqli_query($conn, "SELECT v.id_vendor, v.nama_vendor, v.nama_barang 
                                                                    FROM vendor v 
                                                                    ORDER BY v.nama_vendor, v.nama_barang");
                                        
                                        while($data = mysqli_fetch_array($query)){
                                            // Combine item name and vendor ID as the value
                                            $value = $data['nama_barang'] . '|' . $data['id_vendor'];
                                            // Show item name and vendor name in the dropdown
                                            $display = $data['nama_barang'] . ' - ' . $data['nama_vendor'];
                                            echo "<option value='".$value."'>".$display."</option>";
                                        }
                                    ?>
                                </select> 
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Barang</label>
                                <input type="text" class="form-control" name="jenis_barang" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kuantitas</label>
                                <input type="number" class="form-control" name="kuantitas" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gudang</label>
                                <select name="id_gudang" class="form-control" required>
                                    <option value="">Pilih Gudang</option>
                                    <?php 
                                        $gudang = mysqli_query($conn, "SELECT * FROM storage_unit");
                                        while ($g = mysqli_fetch_array($gudang)){
                                            echo "<option value='".$g['id_gudang']."'>".$g['nama_gudang']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Barcode</label>
                                <input type="text" class="form-control" name="barcode" required>
                            </div>
                            <div class="mb-3">
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