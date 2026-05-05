<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php
    require_once 'config/database.php';

    $errors   = [];
    $kode     = '';
    $nama     = '';
    $deskripsi = '';
    $status   = 'Aktif';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $kode      = trim(htmlspecialchars($_POST['kode_kategori'] ?? '', ENT_QUOTES, 'UTF-8'));
        $nama      = trim(htmlspecialchars($_POST['nama_kategori'] ?? '', ENT_QUOTES, 'UTF-8'));
        $deskripsi = trim(htmlspecialchars($_POST['deskripsi']     ?? '', ENT_QUOTES, 'UTF-8'));
        $status    = trim(htmlspecialchars($_POST['status']        ?? '', ENT_QUOTES, 'UTF-8'));

        if (empty($kode)) {
            $errors['kode'] = 'Kode Kategori wajib diisi.';
        } elseif (strlen($kode) < 4 || strlen($kode) > 10) {
            $errors['kode'] = 'Kode Kategori harus antara 4–10 karakter.';
        } elseif (!preg_match('/^KAT-/', $kode)) {
            $errors['kode'] = 'Kode Kategori harus diawali dengan "KAT-".';
        } else {
          
            $cek  = $conn->prepare("SELECT id_kategori FROM kategori WHERE kode_kategori = ?");
            $cek->bind_param('s', $kode);
            $cek->execute();
            $cek->store_result();
            if ($cek->num_rows > 0) {
                $errors['kode'] = 'Kode Kategori sudah digunakan. Gunakan kode lain.';
            }
            $cek->close();
        }

        if (empty($nama)) {
            $errors['nama'] = 'Nama Kategori wajib diisi.';
        } elseif (strlen($nama) < 3) {
            $errors['nama'] = 'Nama Kategori minimal 3 karakter.';
        } elseif (strlen($nama) > 50) {
            $errors['nama'] = 'Nama Kategori maksimal 50 karakter.';
        }

        if (!empty($deskripsi) && strlen($deskripsi) > 200) {
            $errors['deskripsi'] = 'Deskripsi maksimal 200 karakter.';
        }

        if (!in_array($status, ['Aktif', 'Nonaktif'])) {
            $errors['status'] = 'Status harus Aktif atau Nonaktif.';
        }

        if (empty($errors)) {
            $stmt = $conn->prepare(
                "INSERT INTO kategori (kode_kategori, nama_kategori, deskripsi, status)
             VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param('ssss', $kode, $nama, $deskripsi, $status);

            if ($stmt->execute()) {
                header('Location: index.php?pesan=tambah_berhasil');
                exit;
            } else {
                $errors['global'] = 'Gagal menyimpan data: ' . $conn->error;
            }
            $stmt->close();
        }
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Tambah Kategori Baru</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($errors['global'])): ?>
                            <div class="alert alert-danger"><?= $errors['global'] ?></div>
                        <?php endif; ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-warning">
                                <strong>Terdapat kesalahan pada form. Silakan periksa kembali.</strong>
                            </div>
                        <?php endif; ?>

                        <form method="POST" novalidate>
                            <div class="mb-3">
                                <label for="kode_kategori" class="form-label">
                                    Kode Kategori <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    id="kode_kategori"
                                    name="kode_kategori"
                                    class="form-control <?= isset($errors['kode']) ? 'is-invalid' : '' ?>"
                                    value="<?= $kode ?>"
                                    placeholder="Contoh: KAT-004"
                                    required>
                                <?php if (isset($errors['kode'])): ?>
                                    <div class="invalid-feedback"><?= $errors['kode'] ?></div>
                                <?php endif; ?>
                                <small class="text-muted">Format: diawali "KAT-", 4–10 karakter.</small>
                            </div>

                            <div class="mb-3">
                                <label for="nama_kategori" class="form-label">
                                    Nama Kategori <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    id="nama_kategori"
                                    name="nama_kategori"
                                    class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>"
                                    value="<?= $nama ?>"
                                    placeholder="Masukkan nama kategori"
                                    maxlength="50"
                                    required>
                                <?php if (isset($errors['nama'])): ?>
                                    <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                                <?php endif; ?>
                                <small class="text-muted">3–50 karakter.</small>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea id="deskripsi"
                                    name="deskripsi"
                                    class="form-control <?= isset($errors['deskripsi']) ? 'is-invalid' : '' ?>"
                                    rows="3"
                                    maxlength="200"
                                    placeholder="Keterangan kategori (opsional)"><?= $deskripsi ?></textarea>
                                <?php if (isset($errors['deskripsi'])): ?>
                                    <div class="invalid-feedback"><?= $errors['deskripsi'] ?></div>
                                <?php endif; ?>
                                <small class="text-muted">Maksimal 200 karakter (opsional).</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="status" id="statusAktif" value="Aktif"
                                            <?= $status === 'Aktif' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="statusAktif">Aktif</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio"
                                            name="status" id="statusNonaktif" value="Nonaktif"
                                            <?= $status === 'Nonaktif' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="statusNonaktif">Nonaktif</label>
                                    </div>
                                </div>
                                <?php if (isset($errors['status'])): ?>
                                    <div class="text-danger small mt-1"><?= $errors['status'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>