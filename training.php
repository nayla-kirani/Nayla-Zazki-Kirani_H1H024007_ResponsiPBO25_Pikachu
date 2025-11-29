<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';

$trainingResult = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trainerName = trim($_POST['trainer_name'] ?? '');
    if ($trainerName === '') {
        $trainerName = 'Trainer';
    }
    $_SESSION['trainer_name'] = $trainerName;
    $pokemon->setTrainerName($trainerName);

    $type = $_POST['training_type'] ?? 'Attack';
    $intensityRaw = $_POST['intensity'] ?? '10';

    if (!is_numeric($intensityRaw)) {
        $error = 'Intensitas harus berupa angka.';
    } else {
        $intensity = (int)$intensityRaw;
        if ($intensity < 1) {
            $intensity = 1;
        }
        if ($intensity > 100) {
            $intensity = 100;
        }

        $sessionObj = new TrainingSession($type, $intensity, new DateTime());
        $trainingResult = $pokemon->train($sessionObj);

        // simpan kembali state pokemon ke session
        $_SESSION['pokemon_data']['level'] = $pokemon->getLevel();
        $_SESSION['pokemon_data']['hp'] = $pokemon->getHp();
        $_SESSION['pokemon_data']['special_move'] = $pokemon->getSpecialMoveName();

        $_SESSION['training_log'][] = $trainingResult->toArray();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PokéCare Nay - Latihan</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
<div class="page-wrapper">
    <header class="header">
        <div class="logo">PokéCare Nay</div>
        <nav>
            <a href="index.php" class="nav-link">Beranda</a>
            <a href="training.php" class="nav-link active">Latihan</a>
            <a href="history.php" class="nav-link">Riwayat</a>
        </nav>
    </header>

    <main class="container two-column">
        <section class="card reveal-up">
            <div class="title-with-pill">
                <h1>Latihan Pokémon</h1>
                <span class="session-pill">Session Trainer: live</span>
            </div>
            <p class="subtitle">
                Atur nama trainer, jenis latihan, dan intensitasnya untuk melihat bagaimana
                <strong><?= htmlspecialchars($pokemon->getName(), ENT_QUOTES, 'UTF-8'); ?></strong>
                berkembang. Tipe <strong><?= htmlspecialchars($pokemon->getType(), ENT_QUOTES, 'UTF-8'); ?></strong>
                akan memengaruhi gaya pelatihan dan peningkatan kemampuan.
            </p>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form method="post" class="form">
                <div class="form-group">
                    <label for="trainer_name">Nama Trainer</label>
                    <input
                        type="text"
                        id="trainer_name"
                        name="trainer_name"
                        value="<?= htmlspecialchars($pokemon->getTrainerName(), ENT_QUOTES, 'UTF-8'); ?>"
                        placeholder="Isi dengan namamu"
                        required
                    >
                    <small>Nama ini akan muncul di seluruh halaman sebagai trainer aktif Pikachu.</small>
                </div>

                <div class="form-group">
                    <label for="training_type">Jenis Latihan</label>
                    <select name="training_type" id="training_type" required>
                        <option value="Attack">Attack — fokus serangan</option>
                        <option value="Defense">Defense — fokus ketahanan</option>
                        <option value="Speed">Speed — fokus kecepatan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="intensity">Intensitas Latihan (1–100)</label>
                    <input
                        type="number"
                        name="intensity"
                        id="intensity"
                        min="1"
                        max="100"
                        value="<?= isset($_POST['intensity']) ? (int)$_POST['intensity'] : 20; ?>"
                        required
                    >
                    <small>Semakin tinggi intensitas, semakin besar potensi peningkatan Level dan HP.</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Latih Sekarang</button>
                    <a href="index.php" class="btn btn-outline">Kembali ke Beranda</a>
                    <a href="history.php" class="btn btn-secondary">Lihat Riwayat</a>
                </div>
            </form>
        </section>

        <section class="card card-side reveal-up">
            <h2>Status Pokémon Saat Ini</h2>
            <div class="pokemon-card small">
                <div class="pokemon-header">
                    <h3><?= htmlspecialchars($pokemon->getName(), ENT_QUOTES, 'UTF-8'); ?></h3>
                    <span class="chip chip-electric">
                        <?= htmlspecialchars($pokemon->getType(), ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                </div>
                <p class="current-trainer">
                    Trainer: <strong><?= htmlspecialchars($pokemon->getTrainerName(), ENT_QUOTES, 'UTF-8'); ?></strong>
                </p>
                <div class="pokemon-visual">
                    <div class="pokemon-sprite">
                        <img src="assets/pikachu-training.png" alt="Pikachu sprite">
                    </div>
                </div>
                <div class="stats-grid">
                    <div class="stat">
                        <span class="label">Level</span>
                        <span class="value"><?= $pokemon->getLevel(); ?></span>
                    </div>
                    <div class="stat">
                        <span class="label">HP</span>
                        <span class="value"><?= $pokemon->getHp(); ?>/<?= $pokemon->getMaxHp(); ?></span>
                    </div>
                </div>
                <div class="special-move">
                    <h3>Jurus Spesial</h3>
                    <p class="move-name"><?= htmlspecialchars($pokemon->getSpecialMoveName(), ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="move-desc">
                        Kombinasi serangan elektrik dan kontrol emosi yang menjadi ciri utama sistem PokéCare.
                    </p>
                </div>
            </div>

            <?php if ($trainingResult): ?>
                <?php $data = $trainingResult->toArray(); ?>
                <div class="result-card">
                    <h2>Hasil Latihan Terakhir</h2>
                    <p><strong>Jenis Latihan:</strong> <?= htmlspecialchars($data['training_type'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Intensitas:</strong> <?= $data['intensity']; ?></p>
                    <div class="result-grid">
                        <div>
                            <span class="label">Level</span>
                            <span class="value-before">Sebelum: <?= $data['level_before']; ?></span>
                            <span class="value-after">Sesudah: <?= $data['level_after']; ?></span>
                        </div>
                        <div>
                            <span class="label">HP</span>
                            <span class="value-before">Sebelum: <?= $data['hp_before']; ?></span>
                            <span class="value-after">Sesudah: <?= $data['hp_after']; ?></span>
                        </div>
                    </div>
                    <p class="timestamp"><strong>Waktu Latihan:</strong> <?= htmlspecialchars($data['time'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <h3>Deskripsi Jurus Spesial</h3>
                    <p class="notes"><?= htmlspecialchars($data['special_move'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <h3>Catatan Gaya Pelatihan</h3>
                    <p class="notes"><?= htmlspecialchars($data['notes'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php else: ?>
                <p class="placeholder">
                    Belum ada latihan pada halaman ini. Isi form di kiri dan klik <strong>Latih Sekarang</strong> untuk melihat hasil.
                </p>
            <?php endif; ?>
        </section>
    </main>
</div>
</body>
</html>
