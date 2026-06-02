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

    // Filter Mitra & Pencarian dari GET Method
    $id_mitra_filter = $_GET['mitra'] ?? '';
    $search = $_GET['search'] ?? '';

    // Ambil data dapur dan mitra sebagai MySQLi Result
    $queryDapur = $dapur->tampilDapur($search, $id_mitra_filter);
    $queryMitra = $mitra->getAll();

    $totalDapur = ($queryDapur) ? $queryDapur->num_rows : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAPUR MBG - Data Dapur</title>
    <link rel="icon" href="/CRUD-DAPUR-MBG/asset/MBG1.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fa; }
        .theme-green { color: #00a859 !important; }
        .nav-link.active-custom { background-color: #e6f6ec !important; color: #00a859 !important; border: 1px solid #bce2ca; }
        .nav-link.hover-custom:hover { background-color: #f0f4f8; }
        .btn-tambah { padding:8px 20px; border-radius:6px; font-weight:600; }
        .modal-content { border-radius:14px; padding:8px 20px; }
        .judul-modal { font-size:24px; font-weight: bold; margin-bottom:5px; }
        .subjudul-modal { color:#6c757d; font-size:14px; margin-bottom:0; }
        .custom-input { border-radius:6px; padding:8px 20px; }
        .custom-select { width:220px; border-radius:6px; padding:8px; font-size:14px; }
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
                    <a href="../templates/dashboard.php" class="nav-link text-secondary border border-light-subtle d-flex align-items-center gap-2 hover-custom rounded-3">
                        <i class='bx bx-grid-alt fs-5'></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="read.php" class="nav-link active-custom border d-flex align-items-center gap-2 rounded-3">
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

        <!-- MENU DATA DAPUR -->
        <main class="flex-grow-1 p-4 overflow-auto">    
            <div class="card mb-4 shadow-sm border-light rounded-4">
                <div class="card-body py-3">
                    <p class="mb-0 theme-green fw-bold fs-4">Selamat Datang <?= htmlspecialchars($_SESSION['nama'] ?? 'Nama'); ?> <?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?> </p>
                </div>
            </div> 

            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">Data Dapur</h4>
                        <p class="text-muted mb-0">Kelola seluruh data dapur mitra</p>
                    </div>
                    <button class="btn btn-success btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        + Tambah Data
                    </button>
                </div>

                <form method="GET" action="read.php" class="d-flex justify-content-between mb-3 gap-2">
                    <input type="text" name="search" class="form-control w-50" placeholder="Cari data dapur..." value="<?= htmlspecialchars($search); ?>">
                    <select name="mitra" class="form-select custom-select" onchange="this.form.submit()">
                        <option value="">Semua Mitra</option>
                        <?php 
                            if($queryMitra) {
                                while($m = mysqli_fetch_assoc($queryMitra)){
                                    $sel = ($id_mitra_filter == $m['id_mitra']) ? 'selected' : '';
                                    echo "<option value='{$m['id_mitra']}' {$sel}>{$m['nama_mitra']}</option>";
                                }
                                mysqli_data_seek($queryMitra, 0);
                            }
                        ?>
                    </select>
                </form>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-muted">
                                <th class="fw-semibold border-bottom py-3">Nama Dapur</th>
                                <th class="fw-semibold border-bottom py-3">Alamat</th>
                                <th class="fw-semibold border-bottom py-3">Penanggung Jawab</th>
                                <th class="fw-semibold border-bottom py-3">Kontak</th>
                                <th class="fw-semibold border-bottom py-3">Mitra</th>
                                <th class="fw-semibold border-bottom py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($totalDapur > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($queryDapur)): ?>
                                <tr>
                                    <td class="py-3 text-dark"><?= htmlspecialchars($row['nama_dapur']); ?></td>
                                    <td class="py-3 text-dark"><?= htmlspecialchars($row['alamat']); ?></td>
                                    <td class="py-3 text-dark"><?= htmlspecialchars($row['penanggung_jawab']); ?></td>
                                    <td class="py-3 text-dark"><?= htmlspecialchars($row['kontak']); ?></td>
                                    <td class="py-3">
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-semibold">
                                            <?= htmlspecialchars($row['nama_mitra'] ?? 'Tidak Ada'); ?>
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <a href="update.php?id=<?= $row['id_dapur']; ?>" class="btn btn-sm btn-link text-primary p-0 me-2">
                                            <i class='bx bxs-pencil fs-5'></i>
                                        </a>
                                        <button class="btn btn-sm btn-link text-danger p-0 btn-hapus" 
                                                data-id="<?= $row['id_dapur']; ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDelete">
                                            <i class='bx bxs-trash fs-5'></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Data dapur tidak ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <form action="create.php" method="POST">
                    <div class="modal-header border-0 px-4 pt-4">
                        <div>
                            <h2 class="judul-modal">Tambah Data Dapur</h2>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body px-4">
                        <label class="fw-semibold">Nama Dapur *</label>
                        <input type="text" name="nama_dapur" class="form-control custom-input mb-3" required>

                        <label class="fw-semibold">Alamat *</label>
                        <input type="text" name="alamat" class="form-control custom-input mb-3" required>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="fw-semibold">Penanggung Jawab *</label>
                                <input type="text" name="penanggung_jawab" class="form-control custom-input mb-3" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-semibold">Kontak *</label>
                                <input type="text" name="kontak" class="form-control custom-input mb-3" required>
                            </div>
                        </div>

                        <label class="fw-semibold">Mitra *</label>
                        <select name="id_mitra" class="form-select custom-input" required>
                            <option value="">Pilih Mitra</option>
                            <?php 
                                if($queryMitra) {
                                    while($m = mysqli_fetch_assoc($queryMitra)){
                                        echo "<option value='{$m['id_mitra']}'>{$m['nama_mitra']}</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelete" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0">
                    <h5 class="fw-bold text-danger mb-0">Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Apakah kamu yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="link-konfirmasi-hapus" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const tombolHapus = document.querySelectorAll('.btn-hapus');
        const linkKonfirmasiHapus = document.getElementById('link-konfirmasi-hapus');
        
        tombolHapus.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                linkKonfirmasiHapus.setAttribute('href', 'delete.php?id=' + id);
            });
        });
    </script>
</body>
</html>