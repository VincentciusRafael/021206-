<?php
include '../koneksi.php';

if (isset($_POST['pilih_vendor'])) {
    $id_vendor = $_POST['id_vendor'];
    header("Location: add_inventory.php?id_vendor=" . $id_vendor);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Vendor - Tambah Inventory</title>
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
                    <h1 class="h2">Pilih Vendor - Tambah Inventory</h1>

                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a type="button" href="inventory.php" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Vendor</label>
                                <select name="id_vendor" class="form-select" required>
                                    <option value="">Pilih Nama Vendor</option>
                                    <?php 
                                        $vendor = mysqli_query($conn,  "SELECT * FROM vendor");
                                        while($v = mysqli_fetch_array($vendor)) {
                                            echo "<option value='".$v['id_vendor']."'>".$v['nama_vendor']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <button type="submit" name="pilih_vendor" class="btn btn-primary">Lanjutkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>