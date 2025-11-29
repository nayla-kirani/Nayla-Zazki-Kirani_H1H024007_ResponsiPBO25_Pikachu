<?php
declare(strict_types=1);

class TrainingResult
{
    private TrainingSession $session;
    private int $levelBefore;
    private int $levelAfter;
    private int $hpBefore;
    private int $hpAfter;
    private string $specialMoveDescription;
    private string $notes;

    public function __construct(
        TrainingSession $session,
        int $levelBefore,
        int $levelAfter,
        int $hpBefore,
        int $hpAfter,
        string $specialMoveDescription,
        string $notes
    ) {
        $this->session = $session;
        $this->levelBefore = $levelBefore;
        $this->levelAfter = $levelAfter;
        $this->hpBefore = $hpBefore;
        $this->hpAfter = $hpAfter;
        $this->specialMoveDescription = $specialMoveDescription;
        $this->notes = $notes;
    }

    public function toArray(): array
    {
        return [
            'training_type' => $this->session->getTrainingType(),
            'intensity'     => $this->session->getIntensity(),
            'level_before'  => $this->levelBefore,
            'level_after'   => $this->levelAfter,
            'hp_before'     => $this->hpBefore,
            'hp_after'      => $this->hpAfter,
            'time'          => $this->session->getFormattedTime(),
            'special_move'  => $this->specialMoveDescription,
            'notes'         => $this->notes,
        ];
    }
}
