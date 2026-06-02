<?php
    session_start();

    if(!isset($_SESSION['username'])){
        header("Location: ../auth/login.php");
        exit;
    }

    require_once '../config/database.php';
    require_once '../models/dapur.php';
    require_once '../models/mitra.php';

    $db = (new Database())->connect();
    $dapur = new Dapur($db);
    $mitra = new Mitra($db);

    $id = $_GET['id'] ?? null;
    if(!$id) {
        header("Location: read.php");
        exit;
    }

    $dl = $dapur->getById($id);
    $queryMitra = $mitra->getAll();

    if(isset($_POST['update'])){
        // Perhatikan urutan argumen sesuai function update() di model dapur.php kamu:
        $dapur->update(
            $id, 
            $_POST['nama_dapur'], 
            $_POST['alamat'], 
            $_POST['penanggung_jawab'], 
            $_POST['kontak'], 
            $_POST['id_mitra']
        );
        header("Location: read.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAPUR MBG - Edit Data Dapur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fa; }
        .custom-input { border-radius:6px; padding:8px 20px; }
    </style>
</head>
<body>
    <div class="container mt-5" style="max-width: 700px;">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h3 class="fw-bold text-dark mb-4">Edit Data Dapur</h3>
            
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="fw-semibold form-label">Nama Dapur *</label>
                    <input type="text" name="nama_dapur" class="form-control custom-input" value="<?= htmlspecialchars($dl['nama_dapur'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold form-label">Alamat *</label>
                    <input type="text" name="alamat" class="form-control custom-input" value="<?= htmlspecialchars($dl['alamat'] ?? ''); ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold form-label">Penanggung Jawab *</label>
                        <input type="text" name="penanggung_jawab" class="form-control custom-input" value="<?= htmlspecialchars($dl['penanggung_jawab'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold form-label">Kontak *</label>
                        <input type="text" name="kontak" class="form-control custom-input" value="<?= htmlspecialchars($dl['kontak'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="fw-semibold form-label">Mitra *</label>
                    <select name="id_mitra" class="form-select custom-input" required>
                        <?php 
                        if($queryMitra) {
                            while($m = mysqli_fetch_assoc($queryMitra)){
                                $sel = ($m['id_mitra'] == $dl['id_mitra']) ? 'selected' : '';
                                echo "<option value='{$m['id_mitra']}' {$sel}>{$m['nama_mitra']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="read.php" class="btn btn-light px-4">Batal</a>
                    <button type="submit" name="update" class="btn btn-success px-4">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>