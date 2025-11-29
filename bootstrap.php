<?php
declare(strict_types=1);

session_start();

// Autoload
spl_autoload_register(function (string $className): void {
    $path = __DIR__ . '/classes/' . $className . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

// Trainer name
if (isset($_SESSION['trainer_name']) && $_SESSION['trainer_name'] !== '') {
    $trainerName = (string)$_SESSION['trainer_name'];
} else {
    $trainerName = 'Nayla Zazki Kirani';
    $_SESSION['trainer_name'] = $trainerName;
}

// Pokemon data stored in session (level & HP akan berubah seiring latihan)
if (!isset($_SESSION['pokemon_data'])) {
    $_SESSION['pokemon_data'] = [
        'name'         => 'Pikachu',
        'type'         => 'Electric',
        'level'        => 5,
        'hp'           => 100,
        'special_move' => 'Thunder Care Pulse',
    ];
}

$data = $_SESSION['pokemon_data'];

$pokemon = new Pikachu(
    $data['name'],
    $data['type'],
    (int)$data['level'],
    (int)$data['hp'],
    $data['special_move'],
    $trainerName
);

// Training log
if (!isset($_SESSION['training_log'])) {
    $_SESSION['training_log'] = [];
}
