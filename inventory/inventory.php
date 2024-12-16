<?php
session_start();
include '../koneksi.php';

if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    // Hapus data inventory
    mysqli_query($conn, "DELETE FROM inventory WHERE id_inventory='$id'");
    echo "<script>
            alert('Data barang berhasil dihapus!');
            window.location='inventory.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Inventory - Sistem Inventory</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-utilities.min.css">
    <style>
        body {
            background-color: #f8f9fc;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, #224abe 100%);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem 1.5rem;
            margin-bottom: 0.5rem;
        }

        .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .search-input {
            max-width: 250px;
        }
        
        .stock-danger {
            background-color: #f8d7da !important; /* Warna merah lembut */
            color: #721c24 !important; /* Warna teks mencolok */
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">

            <?php include '../sidebar.php'; ?>

            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Kelola Inventory</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a type="button" class="btn btn-primary" href="add_inventory.php">
                            Tambah Barang
                        </a>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control search-input" placeholder="Cari barang...">
                    </div>
                </div>

                <div class="card table-container">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="inventoryTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jenis</th>
                                        <th>Kuantitas</th>
                                        <th>Gudang</th>
                                        <th>Vendor</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($conn, "SELECT i.*, v.nama_vendor, s.nama_gudang 
                                                                FROM inventory i 
                                                                JOIN vendor v ON i.id_vendor = v.id_vendor
                                                                JOIN storage_unit s ON i.id_gudang = s.id_gudang");
                                    $no = 1;
                                    while($data = mysqli_fetch_array($query)) {
                                        $low_stock_class = $data['kuantitas'] < 10 ? 'stock-danger' : '';
                                    ?>
                                    <tr>
                                        <td class="<?php echo $low_stock_class; ?>"><?php echo $no++; ?></td>
                                        <td class="<?php echo $low_stock_class; ?>"><?php echo $data['nama_barang']; ?></td>
                                        <td class="<?php echo $low_stock_class; ?>"><?php echo $data['jenis_barang']; ?></td>
                                        <td class="<?php echo $low_stock_class; ?>"><?php echo $data['kuantitas']; ?></td>
                                        <td class="<?php echo $low_stock_class; ?>"><?php echo $data['nama_gudang']; ?></td>
                                        <td class="<?php echo $low_stock_class; ?>"><?php echo $data['nama_vendor']; ?></td>
                                        <td class="<?php echo $low_stock_class; ?>">
                                            <a class="btn btn-warning btn-icon" href="edit_inventory.php?id=<?php echo $data['id_inventory']; ?>">
                                                Edit
                                            </a>
                                            <a href="?hapus=<?php echo $data['id_inventory']; ?>" 
                                            class="btn btn-danger btn-icon"
                                            onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.min.js"></script>
    
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchQuery = this.value.toLowerCase();
            let table = document.getElementById('inventoryTable');
            let rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let itemName = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
                let itemCategory = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();
                
                if (itemName.includes(searchQuery) || itemCategory.includes(searchQuery)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });

        // Add active class to current nav item
        const currentLocation = location.href;
        const menuItems = document.querySelectorAll('.nav-link');
        menuItems.forEach(item => {
            if(item.href === currentLocation){
                item.classList.add('active');
            }
        });
    </script>
</body>
</html>