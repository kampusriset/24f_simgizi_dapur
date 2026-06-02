<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: ../auth/login.php");
    exit;
}

if($_SESSION['role'] !== 'petugas'){
    header("Location: ../auth/login.php"); 
    exit;
}

require_once '../config/database.php';
include '../models/user.php';
include '../models/dapur.php';
include '../models/mitra.php';

$db = (new Database())->connect();
$userModel = new User($db);
$dapur = new Dapur($db);
$mitra = new Mitra($db);

// Menangkap inputan pencarian jika ada
$search = $_GET['search'] ?? '';

// Menarik Semua Data
$queryUser = $userModel->getAll();
$totalUser = ($queryUser) ? $queryUser->num_rows : 0;

$queryDapur = $dapur->tampilDapur($search); 

$totalDapur = ($queryDapur) ? $queryDapur->num_rows : 0;

$queryMitra = $mitra->getAll(); 

$totalMitra = ($queryMitra) ? $queryMitra->num_rows : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAPUR MBG - Halaman Petugs</title>
    <link rel="icon" href="../asset/MBG1.png" type="image/png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fa; padding-bottom: 40px; }
        .theme-green { color: #00a859 !important; }
        .bg-theme-green { background-color: #00a859 !important; }
        
        .card-custom { border: none; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); background-color: #ffffff; }
        .icon-box { width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; border-radius: 10px; }

        .bg-green-light { background-color: #e6f6ec; color: #00a859; }
        .bg-blue-light { background-color: #e6f0ff; color: #0066ff; }
        .bg-purple-light { background-color: #f3e6ff; color: #9900ff; }

        .btn-logout-box { border: 1px solid #c3e6cb; color: #00a859; background: transparent; transition: all 0.2s; }
        .btn-logout-box:hover { background-color: #e6f6ec; color: #008f4c; }
        
        .search-pill { border-radius: 50px; padding: 10px 20px; border: 1px solid #dee2e6; box-shadow: none; }
        .search-pill:focus { border-color: #00a859; box-shadow: 0 0 0 0.2rem rgba(0, 168, 89, 0.15); }
    </style>
</head>
<body>

    <div class="container-fluid pt-4 px-md-5">
        
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-lg-2">
                <div class="card card-custom h-100 d-flex justify-content-center align-items-center py-3">
                    <h5 class="fw-bold mb-0 theme-green tracking-wide">DAPUR MBG</h5>
                </div>
            </div>
            <!-- Ucapan Selamat Datang Sesuai Role -->
            <div class="col-md-9 col-lg-10">
                <div class="card card-custom h-100 p-3">
                    <div class="d-flex justify-content-between align-items-center h-100">
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">Selamat datang <?= htmlspecialchars($_SESSION['nama'] ?? $_SESSION['username']); ?></h5>
                            <span class="text-muted small text-capitalize"><?= htmlspecialchars($_SESSION['role']); ?></span>
                        </div>
                        <a href="../auth/logout.php" class="btn btn-logout-box d-flex align-items-center justify-content-center rounded-3" style="width: 42px; height: 42px;" title="Logout">
                            <i class='bx bx-log-out fs-5'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statisik Total Data dari Data Dapur -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <div class="icon-box bg-green-light mb-3"><i class='bx bx-store-alt'></i></div>
                    <p class="text-secondary mb-1 small fw-medium">Total Dapur</p>
                    <h3 class="fw-bold mb-0 text-dark"><?= $totalDapur; ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <div class="icon-box bg-blue-light mb-3"><i class='bx bx-building-house'></i></div>
                    <p class="text-secondary mb-1 small fw-medium">Mitra</p>
                    <h3 class="fw-bold mb-0 text-dark"><?= $totalMitra; ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <div class="icon-box bg-purple-light mb-3"><i class='bx bx-user-circle'></i></div>
                    <p class="text-secondary mb-1 small fw-medium">Total Pengguna</p>
                    <h3 class="fw-bold mb-0 text-dark"><?= $totalUser; ?></h3>
                </div>
            </div>
        </div>

        <div class="card card-custom p-4 mb-4">
            <div class="mb-4">
                <h3 class="fw-bold text-dark mb-1">Data dapur</h3>
                <p class="text-secondary small mb-4">Informasi penyedia gizi dan dapur mitra yang terhubung.</p>
                
                <form action="" method="GET">
                    <input type="text" name="search" class="form-control search-pill w-100" placeholder="Cari nama dapur" value="<?= htmlspecialchars($search); ?>">
                </form>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-dark fw-bold border-bottom" style="font-size: 0.9rem;">
                            <th class="py-3 border-0">Nama Dapur</th>
                            <th class="py-3 border-0">Alamat</th>
                            <th class="py-3 border-0">Penanggung Jawab</th>
                            <th class="py-3 border-0">Kontak Dapur</th>
                            <th class="py-3 border-0">Mitra</th>
                        </tr>
                    </thead>
                    <!-- Table Untuk Menampilkan Data -->
                    <tbody class="border-top-0" style="font-size: 0.95rem;">
                        <?php if ($totalDapur > 0 && $queryDapur): ?>
                            <?php while($row = mysqli_fetch_assoc($queryDapur)): ?>
                            <tr class="border-bottom text-secondary">
                                <td class="py-3 text-dark fw-medium"><?= htmlspecialchars($row['nama_dapur']); ?></td>
                                <td class="py-3"><?= htmlspecialchars($row['alamat'] ?? '-'); ?></td>
                                <td class="py-3"><?= htmlspecialchars($row['penanggung_jawab'] ?? '-'); ?></td>
                                <td class="py-3"><?= htmlspecialchars($row['kontak'] ?? '-'); ?></td>
                                <td class="py-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-medium">
                                        <?= htmlspecialchars($row['nama_mitra'] ?? 'Tidak Ada'); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada data dapur yang tersedia untuk sekolah.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <small class="text-muted">Menampilkan <?= $totalDapur; ?> data</small>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>