<?php
declare(strict_types=1);

class Pikachu extends ElectricPokemon
{
    /** @var array<string,string> */
    private array $dexData;

    /** @var array<string,int> */
    private array $baseStats;

    /** @var array<string,string> */
    private array $trainingProfile;

    public function __construct(
        string $name,
        string $type,
        int $level,
        int $hp,
        string $specialMoveName,
        string $trainerName
    ) {
        parent::__construct($name, $type, $level, $hp, $specialMoveName, $trainerName);

        $this->dexData = [
            'No. Pokédex'     => '007',
            'Nama Spesies'    => 'Mouse Pokémon',
            'Region Asal'     => 'Kanto',
            'Tipe Utama'      => 'Electric',
            'Tinggi'          => '0,4 m',
            'Berat'           => '6,0 kg',
            'Kemampuan'       => 'Static · Lightning Rod (PokéCare fokus ke Static)',
            'Kelemahan'       => 'Ground',
            'Fokus Penelitian'=> 'Respons emosi Pikachu saat diberikan pola latihan yang berbeda-beda.',
            'Trainer'         => $trainerName,
            'Status Sekarang' => 'Level ' . $this->level . ' · HP ' . $this->hp . '/' . $this->maxHp,
        ];

        $this->baseStats = [
            'HP'               => 35,
            'Attack'           => 55,
            'Defense'          => 40,
            'Sp. Atk'          => 50,
            'Sp. Def'          => 50,
            'Speed'            => 90,
        ];

        $this->trainingProfile = [
            'Fokus Latihan'        => 'Speed dan kontrol serangan elektrik.',
            'Zona Nyaman Intensitas' => '20–70 untuk sesi rutin harian.',
            'Sesi Simulasi Battle' => '70–100, dipakai saat kondisi fisik dan mental sudah siap.',
            'Catatan PRTC'         => 'Setiap sesi ditutup dengan cooldown dan pengecekan HP supaya Pikachu tidak overtraining.',
        ];

        $this->moves = [
            new Move(
                'Thunder Care Pulse',
                'Electric',
                'Spesial',
                'Power sedang, akurasi tinggi',
                'Gelombang listrik hangat yang bukan cuma menyerang, tapi membaca emosi lawan dan menurunkan tensi battle.'
            ),
            new Move(
                'Empathy Spark',
                'Electric',
                'Status',
                'Meningkatkan Sp. Def & Speed',
                'Percikan listrik halus yang membuat Pikachu lebih peka terhadap ritme lawan dan rekan satu tim.'
            ),
            new Move(
                'Focus Dash',
                'Normal',
                'Physical',
                'Serangan pembuka cepat',
                'Serangan dash secepat kilat untuk membuka jarak atau menutup celah, cocok untuk latihan speed.'
            ),
            new Move(
                'Recharge Break',
                'Electric',
                'Recovery',
                'Memulihkan sebagian HP',
                'Pikachu menarik napas dalam, menyalurkan listrik ke tubuh sendiri untuk memulihkan energi secara perlahan.'
            ),
        ];
    }

    public function getDexData(): array
    {
        $this->dexData['Trainer'] = $this->trainerName;
        $this->dexData['Status Sekarang'] = 'Level ' . $this->level . ' · HP ' . $this->hp . '/' . $this->maxHp;

        return $this->dexData;
    }

    public function getBaseStats(): array
    {
        return $this->baseStats;
    }

    public function getTrainingProfile(): array
    {
        return $this->trainingProfile;
    }

    public function specialMove(): string
    {
        return $this->specialMoveName .
            ' — rangkaian jurus PokéCare yang menggabungkan serangan elektrik, kontrol emosi, dan jeda pemulihan supaya Pikachu tetap sehat.';
    }
}
