<?php 
// 1. Panggil komponen header (berisi tag <head>, bootstrap, navbar, dll)
include_once 'header.php'; 
?>

<div class="container mt-5">

    <?php if ($aksi == 'read'): ?>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Data Management Dapur</h2>
            <a href="read.php?aksi=tambah" class="btn btn-primary px-4 py-2">
                <i class="fas fa-plus me-2"></i> Tambah Dapur
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Nama Dapur</th>
                                <th class="py-3">Alamat</th>
                                <th class="py-3">Penanggung Jawab</th>
                                <th class="py-3">Kontak</th>
                                <th class="py-3">Nama Mitra</th>
                                <th class="text-center py-3" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Melakukan looping data yang dikirim oleh dapur/read.php
                            if (mysqli_num_rows($dataDapur) > 0):
                                while($row = mysqli_fetch_assoc($dataDapur)): 
                            ?>
                                <tr>
                                    <td class="px-4 fw-semibold"><?= $row['nama_dapur']; ?></td>
                                    <td><?= $row['alamat']; ?></td>
                                    <td><?= $row['penanggung_jawab']; ?></td>
                                    <td><?= $row['kontak']; ?></td>
                                    <td>
                                        <span class="badge bg-secondary px-2.5 py-1.5"><?= $row['nama_mitra'] ?? 'Tanpa Mitra'; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="read.php?aksi=edit&id=<?= $row['id_dapur']; ?>" class="btn btn-sm btn-outline-warning me-1">
                                            Edit
                                        </a>
                                        <a href="delete.php?id=<?= $row['id_dapur']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data dapur ini?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                                endwhile; 
                            else:
                            ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data dapur tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    <?php elseif ($aksi == 'tambah'): ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Tambah Dapur Baru</h2>
                    <a href="read.php" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="create.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Nama Dapur</label>
                                <input type="text" name="nama_dapur" class="form-control" placeholder="Masukkan nama dapur" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Penanggung Jawab</label>
                                    <input type="text" name="penanggung_jawab" class="form-control" placeholder="Nama penanggung jawab" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Kontak / No. HP</label>
                                    <input type="text" name="kontak" class="form-control" placeholder="Contoh: 0812345678" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Pilih Mitra Berelasi</label>
                                <select name="id_mitra" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Mitra --</option>
                                    <?php while($m = mysqli_fetch_assoc($dataMitra)): ?>
                                        <option value="<?= $m['id_mitra']; ?>"><?= $m['nama_mitra']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="submit" class="btn btn-success py-2 fw-semibold">Simpan Data Dapur</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    <?php elseif ($aksi == 'edit'): ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Edit Data Dapur</h2>
                    <a href="read.php" class="btn btn-outline-secondary btn-sm">Batal</a>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="update.php" method="POST">
                            <input type="hidden" name="id_dapur" value="<?= $dataEdit['id_dapur']; ?>">

                            <div class="mb-3">
                                <label class="form-label fw-medium">Nama Dapur</label>
                                <input type="text" name="nama_dapur" class="form-control" value="<?= $dataEdit['nama_dapur']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-medium">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" required><?= $dataEdit['alamat']; ?></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Penanggung Jawab</label>
                                    <input type="text" name="penanggung_jawab" class="form-control" value="<?= $dataEdit['penanggung_jawab']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Kontak / No. HP</label>
                                    <input type="text" name="kontak" class="form-control" value="<?= $dataEdit['kontak']; ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Mitra Berelasi</label>
                                <select name="id_mitra" class="form-select" required>
                                    <?php while($m = mysqli_fetch_assoc($dataMitra)): ?>
                                        <option value="<?= $m['id_mitra']; ?>" <?= ($dataEdit['id_mitra'] == $m['id_mitra']) ? 'selected' : ''; ?>>
                                            <?= $m['nama_mitra']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="submit" class="btn btn-warning py-2 fw-semibold">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>

<?php 
// 2. Panggil komponen footer (penutup tag body, script JS, dll)
include_once 'footer.php'; 
?>