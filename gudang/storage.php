<?php
session_start();
include '../koneksi.php';

if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM storage_unit WHERE id_gudang='$id'");
    echo "<script>
            alert('Data storage unit berhasil dihapus!');
            window.location='storage.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Storage Unit - Sistem Inventory</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-utilities.min.css">
    <style>
        body {
            background-color: #f8f9fc;
        }
        .table-container {
            background: #fff;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .search-input {
            max-width: 250px;
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

        .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../sidebar.php'; ?>

            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Kelola Storage Unit</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a type="button" class="btn btn-primary" href="add_barang.php">
                            Tambah Gudang
                        </a>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control search-input" placeholder="Cari gudang...">
                    </div>
                </div> 

                <div class="card table-container">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="storageTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Gudang</th>
                                            <th>Lokasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($conn, "SELECT s.*
                                                                    FROM storage_unit s 
                                                                    LEFT JOIN inventory i ON s.id_gudang = i.id_gudang 
                                                                    GROUP BY s.id_gudang");
                                        $no = 1;
                                        while($row = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['nama_gudang']; ?></td>
                                            <td><?php echo $row['lokasi']; ?></td>
                                            <td>
                                                <a class="btn btn-warning btn-icon" href="edit_barang.php?id=<?php echo $row['id_gudang']; ?>">
                                                        Edit
                                                </a>
                                                <a href="?hapus=<?php echo $row['id_gudang']; ?>" 
                                                class="btn btn-danger btn-icon"
                                                onclick="return confirm('Yakin ingin menghapus gudang ini?')">
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
            let table = document.getElementById('storageTable');
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