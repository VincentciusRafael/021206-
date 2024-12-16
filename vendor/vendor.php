<?php
session_start();
include '../koneksi.php';

if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    // Cek apakah vendor masih digunakan di tabel inventory
    $cek = mysqli_query($conn, "SELECT * FROM inventory WHERE id_vendor='$id'");
    if(mysqli_num_rows($cek) > 0) {
        echo "<script>
                alert('Vendor tidak dapat dihapus karena masih digunakan dalam inventory!');
                window.location='vendor.php';
              </script>";
    } else {
        mysqli_query($conn, "DELETE FROM vendor WHERE id_vendor='$id'");
        echo "<script>
                alert('Data vendor berhasil dihapus!');
                window.location='vendor.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Vendor - Sistem Inventory</title>
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
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">

            <?php include '../sidebar.php'; ?>

            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Kelola Vendor</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a type="button" class="btn btn-primary" href="add_vendor.php">
                            Tambah Vendor
                        </a>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control search-input" placeholder="Cari vendor...">
                    </div>
                </div>

                <div class="card table-container">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="vendorTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Vendor</th>
                                        <th>Nama Barang</th>
                                        <th>Kontak</th>
                                        <th>Nomor Invoice</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($conn, "SELECT v.*, COUNT(i.id_inventory) as jumlah_item 
                                                                FROM vendor v 
                                                                LEFT JOIN inventory i ON v.id_vendor = i.id_vendor 
                                                                GROUP BY v.id_vendor");
                                    $no = 1;
                                    while($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['nama_vendor']; ?></td>
                                        <td><?php echo $row['nama_barang']; ?></td>
                                        <td><?php echo $row['kontak']; ?></td>
                                        <td><?php echo $row['nomor_invoice']; ?></td>
                                        <td>
                                            <a class="btn btn-warning btn-icon" href="edit_vendor.php?id=<?php echo $row['id_vendor']; ?>">
                                                    Edit                                           
                                            </a>
                                            <a href="?hapus=<?php echo $row['id_vendor']; ?>" 
                                            class="btn btn-danger btn-icon"
                                            onclick="return confirm('Yakin ingin menghapus vendor ini?')">
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
            let table = document.getElementById('vendorTable');
            let rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let vendorName = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
                let vendorContact = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();
                
                if (vendorName.includes(searchQuery) || vendorContact.includes(searchQuery)) {
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