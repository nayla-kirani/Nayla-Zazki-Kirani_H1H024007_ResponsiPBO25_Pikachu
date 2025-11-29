<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';

$log = $_SESSION['training_log'] ?? [];

$totalSessions = count($log);
$totalLevelGain = 0;
$totalHpGain = 0;
$maxIntensitySession = null;

foreach ($log as $row) {
    $totalLevelGain += (int)$row['level_after'] - (int)$row['level_before'];
    $totalHpGain += (int)$row['hp_after'] - (int)$row['hp_before'];

    if ($maxIntensitySession === null || (int)$row['intensity'] > (int)$maxIntensitySession['intensity']) {
        $maxIntensitySession = $row;
    }
}

$dexData = $pokemon->getDexData();
$baseStats = $pokemon->getBaseStats();
$trainingProfile = $pokemon->getTrainingProfile();
$moves = $pokemon->getMoves();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PokéCare Nay - Beranda</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
<div class="page-wrapper">
    <header class="header">
        <div class="logo">PokéCare Nay</div>
        <nav>
            <a href="index.php" class="nav-link active">Beranda</a>
            <a href="training.php" class="nav-link">Latihan</a>
            <a href="history.php" class="nav-link">Riwayat</a>
        </nav>
    </header>

    <main class="container">
        <section class="card hero-pokedex reveal-up">
            <div class="hero-left">
                <p class="hero-label">Welcome Trainer</p>
                <h1>Selamat datang di PokéCare Nay</h1>
                <p class="subtitle">
                    Ini adalah ruang latihan pribadi untuk kamu dan PokéCare Pikachu. Di sini semua informasi tentang Pikachu
                    dikumpulkan dalam satu tempat: mulai dari data dasar, gaya bertarung, sampai catatan dari setiap sesi latihan.

                </p>
                <p class="subtitle">
                    Lewat halaman ini kamu bisa mengatur sesi latihan, memilih fokus (Attack, Defense, Speed), lalu langsung melihat
                    perubahan Level dan HP setelah latihan selesai. Riwayatnya tersimpan rapi, jadi kamu bisa membaca ulang pola
                    perkembangan Pikachu kapan saja saat ingin mengecek seberapa jauh ia sudah berkembang.

                </p>

                <div class="hero-actions">
                    <a href="training.php" class="btn btn-primary">Mulai Latihan Pertama</a>
                    <a href="history.php" class="btn btn-secondary">Lihat Riwayat</a>
                </div>

                <div class="hero-info-card">
                    <h3 class="section-title">Apa saja yang bisa kamu lakukan?</h3>
                    <ul class="feature-list">
                        <li>Lihat profil lengkap Pikachu — mulai dari tipe, tinggi, berat, sampai catatan penelitian.</li>
                        <li>Atur sesi latihan — pilih jenis latihan (Attack, Defense, Speed) dan intensitasnya sendiri.</li>
                        <li>Pantau riwayat — setiap sesi tersimpan lengkap, jadi kamu bisa analisis pola latihan dengan mudah.</li>
                    </ul>
                </div>
            </div>

            
<div class="hero-right">
                <div class="circle-orbit">
                    <div class="orbit orbit-main">
                        <div class="main-sprite-wrapper">
                            <img src="assets/pikachu-main.png" alt="Pikachu PokéCare" class="main-sprite">
                        </div>
                    </div>
                    <div class="main-circle-info">
                        <span class="dex-number">No. 007</span>
                        <span class="dex-name">Pikachu</span>
                        <span class="trainer-tag">
                            Trainer aktif: <?= htmlspecialchars($pokemon->getTrainerName(), ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    </div>
                </div>


<div class="hero-mini-card">
                    <span class="mini-label">Status singkat</span>
                    <p class="mini-text">
                        Level <?= $pokemon->getLevel(); ?> · HP <?= $pokemon->getHp(); ?>/<?= $pokemon->getMaxHp(); ?>
                        · Sesi latihan tersimpan: <?= $totalSessions; ?>
                    </p>
                </div>
            </div>
        </section>

        <section class="card detail-grid reveal-up">
            <div class="detail-column">
                <h2 class="section-title">Panel Pokédex</h2>
                <p class="subtitle">
                    Bagian ini berisi data dasar Pikachu yang dipakai PRTC sebagai referensi sebelum dan sesudah latihan.
                    Susunannya seperti kartu resmi supaya kamu bisa cepat membaca informasi pentingnya.
                </p>

                <div class="subpanel">
                    <div class="dex-grid">
                        <?php foreach ($dexData as $label => $value): ?>
                            <div class="dex-item">
                                <span class="dex-label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="dex-value"><?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="subpanel">
                    <h3 class="section-title">Catatan Gaya Latihan</h3>
                    <div class="dex-grid small-grid">
                        <?php foreach ($trainingProfile as $label => $value): ?>
                            <div class="dex-item">
                                <span class="dex-label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="dex-value"><?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="detail-column">
                <h2 class="section-title">Statistik Dasar</h2>
                <p class="subtitle">
                    Grafik di bawah menunjukkan kemampuan dasar Pikachu. Setelah beberapa sesi latihan,
                    kamu bisa membandingkan ulang dengan catatan di riwayat untuk melihat pola kenaikannya.
                </p>

                <div class="subpanel">
                    <div class="base-stats-grid">
                        <?php foreach ($baseStats as $label => $value): ?>
                            <div class="base-stat-item">
                                <span class="base-stat-label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span>
                                <div class="base-stat-bar">
                                    <div class="base-stat-fill" style="width: <?= max(10, min(100, (int)$value)); ?>%;"></div>
                                </div>
                                <span class="base-stat-value"><?= (int)$value; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="subpanel compact">
                    <div class="progress-summary">
                        <div class="summary-pill">
                            <span class="summary-label">Total sesi latihan</span>
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
                        <?php if ($maxIntensitySession): ?>
                            <div class="summary-pill">
                                <span class="summary-label">Sesi paling intensif</span>
                                <span class="summary-value">
                                    <?= (int)$maxIntensitySession['intensity']; ?>
                                    (<?= htmlspecialchars($maxIntensitySession['training_type'], ENT_QUOTES, 'UTF-8'); ?>)
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="card moves-card reveal-up">
            <h2 class="section-title">Set Jurus PokéCare Pikachu</h2>
            <p class="subtitle">
                Jurus-jurus di bawah dipakai sebagai referensi latihan. Kamu bisa melihat tipe, kategori, dan
                penjelasan singkat kenapa jurus itu cocok dengan konsep PokéCare.
            </p>

            <div class="moves-list">
                <?php foreach ($moves as $move): ?>
                    <article class="move-item">
                        <h3><?= htmlspecialchars($move->getName(), ENT_QUOTES, 'UTF-8'); ?></h3>
                        <div class="move-meta">
                            <span class="type-pill type-pill-electric">Tipe: <?= htmlspecialchars($move->getType(), ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="type-pill type-pill-category">Kategori: <?= htmlspecialchars($move->getCategory(), ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="type-pill type-pill-power"><?= htmlspecialchars($move->getPowerInfo(), ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <p class="move-description">
                            <?= htmlspecialchars($move->getDescription(), ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</div>
</body>
</html>
