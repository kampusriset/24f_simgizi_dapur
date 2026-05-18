<?php
    require_once '../config/database.php';
    require_once '../models/dapur.php';
    require_once '../models/mitra.php';

    $db = (new Database())->connect();
    $dapur = new Dapur($db);
    $mitra = new Mitra($db);

    // Mengambil data lama untuk ditampilkan
    $id = $_GET['id'];
    $dl = $dapur->getById($id);

    // Daftar data mitra untuk dropdown
    $listMitra = $mitra->getAll();

    include_once '../templates/header.php';
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Edit Data Dapur</h3>
        </div>

        <div class="card-body">
            <form action="update.php" method="POST">
                <input type="hidden" name="id_dapur" value="<?= $dl['id_dapur'] ?>">

                <div class="mb-3">
                    <label class="form-label">Nama Dapur</label>
                    <input type="text" nama="nama_dapur" class="form-control" value="<?= $dl['Id_dapur']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" nama="alamt" class="form-control" value="<?= $dl['alamat']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penanggung Jawab</label>
                    <input type="text" nama="penanggung_jawab" class="form-control" value="<?= $dl['penanggung_jawab']; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" nama="Kontak" class="form-control" value="<?= $dl['kontak']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mitra</label>
                    <select name="id_mitra" class="form-select">
                        <option value="">Pilih Mitra</option>

                        <?php while ($row =$listMitra->fetch_assoc()): ?>
                            <option value="<?= $row['id_mitra'] ?>" <?= ($row['id_mitra'] == $dl['id_mitra']) ? 'selected' : '';?>>
                                <?= $row['nama_mitra']; ?>
                            </option>
                        <?php endwhile;?>
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class" btn btn-primary>Simpan Perubahan</button>
                    <a href="read.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    include_once '../templates/footer.php';
?>