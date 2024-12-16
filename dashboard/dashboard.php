<?php
session_start();
if(!isset($_SESSION['id_admin'])) {
    header("Location: ../login.php");
    exit();
}
include '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Inventory</title>
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

        .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
        }

        .stats-card {
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .dropdown-menu {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
    
        <?php include '../sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
            <!-- Topbar -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card border-start border-primary border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Total Items</div>
                                    <div class="fs-4 fw-bold">
                                        <?php
                                        $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM inventory");
                                        $data = mysqli_fetch_array($query);
                                        echo number_format($data['total']);
                                        ?>
                                    </div>
                                </div>
                                <div class="text-primary">
                                    <i class="fas fa-box fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card border-start border-success border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Total Vendors</div>
                                    <div class="fs-4 fw-bold">
                                        <?php
                                        $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM vendor");
                                        $data = mysqli_fetch_array($query);
                                        echo number_format($data['total']);
                                        ?>
                                    </div>
                                </div>
                                <div class="text-success">
                                    <i class="fas fa-truck fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card border-start border-info border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Storage Units</div>
                                    <div class="fs-4 fw-bold">
                                        <?php
                                        $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM storage_unit");
                                        $data = mysqli_fetch_array($query);
                                        echo number_format($data['total']);
                                        ?>
                                    </div>
                                </div>
                                <div class="text-info">
                                    <i class="fas fa-warehouse fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card stats-card border-start border-warning border-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Low Stock Items</div>
                                    <div class="fs-4 fw-bold">
                                        <?php
                                        $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM inventory WHERE kuantitas < 10");
                                        $data = mysqli_fetch_array($query);
                                        echo number_format($data['total']);
                                        ?>
                                    </div>
                                </div>
                                <div class="text-warning">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Items Table -->
            <div class="card table-container mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary">Recent Items</h6>
                    <a href="../inventory/inventory.php" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jenis</th>
                                    <th>Stok</th>
                                    <th>Lokasi</th>
                                    <th>Vendor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($conn, "SELECT i.*, v.nama_vendor, s.nama_gudang 
                                                               FROM inventory i 
                                                               JOIN vendor v ON i.id_vendor = v.id_vendor
                                                               JOIN storage_unit s ON i.id_gudang = s.id_gudang
                                                               ORDER BY i.id_inventory DESC LIMIT 5");
                                while($row = mysqli_fetch_array($query)) {
                                    $status_class = $row['kuantitas'] < 10 ? 'text-danger' : 'text-success';
                                    $status_text = $row['kuantitas'] < 10 ? 'Low Stock' : 'In Stock';
                                ?>
                                <tr>
                                    <td><?php echo $row['nama_barang']; ?></td>
                                    <td><?php echo $row['jenis_barang']; ?></td>
                                    <td><?php echo $row['kuantitas']; ?></td>
                                    <td><?php echo $row['nama_gudang']; ?></td>
                                    <td><?php echo $row['nama_vendor']; ?></td>
                                    <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
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