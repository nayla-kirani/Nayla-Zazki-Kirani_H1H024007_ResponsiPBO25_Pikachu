<?php
declare(strict_types=1);

abstract class ElectricPokemon extends Pokemon
{
    protected float $attackMultiplier = 1.2;
    protected float $speedMultiplier = 1.4;
    protected float $defenseMultiplier = 1.0;

    protected function calculateTrainingEffect(TrainingSession $session): array
    {
        $intensity = $session->getIntensity();
        $type = strtolower($session->getTrainingType());

        $levelGain = 0;
        $hpGain = 0;
        $desc = '';

        switch ($type) {
            case 'attack':
                $levelGain = (int)ceil($intensity * 0.15 * $this->attackMultiplier);
                $hpGain = (int)ceil($intensity * 0.05);
                $desc = 'Latihan Attack: Pikachu fokus ke ledakan serangan elektrik yang lebih terarah.';
                break;

            case 'speed':
                $levelGain = (int)ceil($intensity * 0.12 * $this->speedMultiplier);
                $hpGain = (int)ceil($intensity * 0.03);
                $desc = 'Latihan Speed: Pikachu melatih refleks dan kecepatan dash untuk menghindari serangan.';
                break;

            case 'defense':
                $levelGain = (int)ceil($intensity * 0.10 * $this->defenseMultiplier);
                $hpGain = (int)ceil($intensity * 0.08);
                $desc = 'Latihan Defense: fokus ke stamina dan kontrol napas supaya tetap stabil saat battle panjang.';
                break;

            default:
                $levelGain = (int)ceil($intensity * 0.10);
                $hpGain = (int)ceil($intensity * 0.05);
                $desc = 'Latihan umum untuk menjaga kebugaran Pikachu.';
                break;
        }

        if ($levelGain < 1) {
            $levelGain = 1;
        }

        return [
            'levelGain'   => $levelGain,
            'hpGain'      => $hpGain,
            'description' => $desc . ' (Bonus tipe Electric: ada fokus tambahan ke kecepatan dan kontrol listrik.)',
        ];
    }
}
