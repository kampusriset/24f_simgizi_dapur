<?php
    session_start();

    if(!isset($_SESSION['username'])){
        header("Location: ../auth/login.php");
        exit;
    }
    require_once '../config/database.php';
    include '../models/dapur.php';
    include '../models/mitra.php';

    $db = (new Database())->connect();
    $dapur = new Dapur($db);
    $mitra = new Mitra($db);

    // Mengambil object mysqli_result
    $queryDapur = $dapur->tampilDapur();
    $queryMitra = $mitra->getAll();

    // Menghitung jumlah baris data menggunakan num_rows bawaan MySQLi
    $totalDapur = ($queryDapur) ? $queryDapur->num_rows : 0;
    $totalMitra = ($queryMitra) ? $queryMitra->num_rows : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAPUR MBG - Dashboard</title>
    <link rel="icon" href="../asset/MBG1.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fa; }
        .theme-green { color: #00a859 !important; }
        .icon-box { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; border-radius: 10px; }
        .bg-green-light { background-color: #e6f6ec; color: #00a859; }
        .bg-blue-light { background-color: #e6f0ff; color: #0066ff; }
        .bg-purple-light { background-color: #f3e6ff; color: #9900ff; }
        .nav-link.active-custom { background-color: #e6f6ec !important; color: #00a859 !important; border: 1px solid #bce2ca; }
        .nav-link.hover-custom:hover { background-color: #f0f4f8; }
    </style>
</head>
<body>

    <div class="d-flex vh-100 overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="d-flex flex-column p-3 bg-white border-end" style="width: 280px;">
            <div class="card mb-3 shadow-sm border-light rounded-4">
                <div class="card-body py-3">
                    <h5 class="fw-bold mb-0 text-dark">Dapur MBG</h5>
                </div>
            </div>
            <ul class="nav nav-pills flex-column mb-auto gap-2">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link active-custom border d-flex align-items-center gap-2 rounded-3">
                        <i class='bx bx-grid-alt fs-5'></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../dapur/read.php" class="nav-link text-secondary border border-light-subtle d-flex align-items-center gap-2 hover-custom rounded-3">
                        <i class='bx bx-store-alt fs-5'></i> Data Dapur
                    </a>
                </li>
                </ul>
                <ul class="nav flex-column mt-auto pt-3">
                    <li class="nav-item">
                        <a href="../auth/logout.php" class="nav-link text-danger fw-semibold d-flex align-items-center gap-2" onmouseover="this.classList.add('bg-danger', 'bg-opacity-10', 'rounded-3')" onmouseout="this.classList.remove('bg-danger', 'bg-opacity-10', 'rounded-3')">
                            <i class='bx bx-log-out fs-5'></i> Logout
                        </a>
                    </li>
                </ul>
        </aside>      

        <!-- MENU DASHBOARD -->
        <main class="flex-grow-1 p-4 overflow-auto">    
            <div class="card mb-4 shadow-sm border-light rounded-4">
                <div class="card-body py-3">
                    <p class="mb-0 theme-green fw-bold fs-4">Selamat Datang <?= htmlspecialchars($_SESSION['nama'] ?? 'nama'); ?> <?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?> </p>
                </div>
            </div>          

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-2">
                        <div class="card-body">
                            <div class="icon-box bg-green-light mb-3"><i class='bx bx-store'></i></div>
                            <p class="text-muted mb-1 fs-6">Total Dapur</p>
                            <h3 class="fw-bold mb-0 text-dark"><?= $totalDapur; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-2">
                        <div class="card-body">
                            <div class="icon-box bg-blue-light mb-3"><i class='bx bx-buildings'></i></div>
                            <p class="text-muted mb-1 fs-6">Mitra</p>
                            <h3 class="fw-bold mb-0 text-dark"><?= $totalMitra; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-2">
                        <div class="card-body">
                            <div class="icon-box bg-purple-light mb-3"><i class='bx bx-user-circle'></i></div>
                            <p class="text-muted mb-1 fs-6">Penanggung Jawab</p>
                            <h3 class="fw-bold mb-0 text-dark"><?= $totalDapur; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="mb-4">
                    <h2 class="fw-bold text-dark mb-1">Ringkasan Dapur</h2>
                    <p class="text-muted mb-0">Pratinjau data dapur mitra yang aktif</p>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-muted">
                                <th class="fw-semibold border-bottom py-3">Nama Dapur</th>
                                <th class="fw-semibold border-bottom py-3">Alamat</th>
                                <th class="fw-semibold border-bottom py-3">Penanggung Jawab</th>
                                <th class="fw-semibold border-bottom py-3">Kontak</th>
                                <th class="fw-semibold border-bottom py-3">Mitra</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($totalDapur > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($queryDapur)): ?>
                                <tr>
                                    <td class="py-3 text-dark fw-medium"><?= htmlspecialchars($row['nama_dapur'] ?? '-'); ?></td>
                                    <td class="py-3 text-dark"><?= htmlspecialchars($row['alamat'] ?? '-'); ?></td>
                                    <td class="py-3 text-dark"><?= htmlspecialchars($row['penanggung_jawab'] ?? '-'); ?></td>
                                    <td class="py-3 text-dark"><?= htmlspecialchars($row['kontak'] ?? '-'); ?></td>
                                    <td class="py-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-semibold">
                                            <?= htmlspecialchars($row['nama_mitra'] ?? 'Tidak Ada'); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada data dapur.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <footer class="text-center mt-5 mb-2">
                <p class="text-muted small">© 2026 DAPUR MBG|1HZS.</p>
            </footer>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>