<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';

$log = $_SESSION['training_log'] ?? [];

if (isset($_GET['reset']) && $_GET['reset'] === '1') {
    $_SESSION['training_log'] = [];
    $log = [];
}

$totalSessions = count($log);
$totalLevelGain = 0;
$totalHpGain = 0;

foreach ($log as $row) {
    $totalLevelGain += (int)$row['level_after'] - (int)$row['level_before'];
    $totalHpGain += (int)$row['hp_after'] - (int)$row['hp_before'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PokéCare Nay - Riwayat Latihan</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
<div class="page-wrapper">
    <header class="header">
        <div class="logo">PokéCare Nay</div>
        <nav>
            <a href="index.php" class="nav-link">Beranda</a>
            <a href="training.php" class="nav-link">Latihan</a>
            <a href="history.php" class="nav-link active">Riwayat</a>
        </nav>
    </header>

    <main class="container">
        <section class="card reveal-up">
            <h1>Riwayat Latihan PokéCare Pikachu</h1>
            <p class="subtitle">
                Semua sesi latihan yang kamu jalankan akan tercatat di sini dalam satu sesi penggunaan aplikasi.
                Data ini bisa kamu pakai untuk membaca pola latihan dan perkembangan Pikachu dari waktu ke waktu.
            </p>

            <div class="history-header">
                <div class="pokemon-mini">
                    <span class="mini-name"><?= htmlspecialchars($pokemon->getName(), ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="chip chip-electric"><?= htmlspecialchars($pokemon->getType(), ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="mini-level">Level saat ini: <?= $pokemon->getLevel(); ?></span>
                </div>
                <div class="history-actions">
                    <a href="training.php" class="btn btn-secondary">Tambah Latihan</a>
                    <a href="history.php?reset=1"
                       class="btn btn-outline"
                       onclick="return confirm('Reset semua riwayat latihan sesi ini?');">
                        Reset Riwayat
                    </a>
                </div>
            </div>

            <div class="progress-summary">
                <div class="summary-pill">
                    <span class="summary-label">Total sesi</span>
                    <span class="summary-value"><?= $totalSessions; ?> sesi</span>
                </div>
                <div class="summary-pill">
                    <span class="summary-label">Total kenaikan Level</span>
                    <span class="summary-value"><?= $totalLevelGain; ?></span>
                </div>
                <div class="summary-pill">
                    <span class="summary-label">Total kenaikan HP</span>
                    <span class="summary-value"><?= $totalHpGain; ?></span>
                </div>
            </div>

            <?php if (empty($log)): ?>
                <p class="placeholder">
                    Belum ada sesi latihan yang tercatat. Mulai dari halaman <strong>Latihan</strong> untuk menambah riwayat.
                </p>
            <?php else: ?>
                <div class="table-wrapper">
                    <table class="history-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Waktu Latihan</th>
                            <th>Jenis Latihan</th>
                            <th>Intensitas</th>
                            <th>Level (Sebelum → Sesudah)</th>
                            <th>HP (Sebelum → Sesudah)</th>
                            <th>Jurus Spesial</th>
                            <th>Catatan Gaya Latihan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($log as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= htmlspecialchars($row['time'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($row['training_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= (int)$row['intensity']; ?></td>
                                <td><?= (int)$row['level_before']; ?> → <?= (int)$row['level_after']; ?></td>
                                <td><?= (int)$row['hp_before']; ?> → <?= (int)$row['hp_after']; ?></td>
                                <td class="col-small">
                                    <?= htmlspecialchars($row['special_move'], ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="col-small">
                                    <?= htmlspecialchars($row['notes'], ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
</div>
</body>
</html>
