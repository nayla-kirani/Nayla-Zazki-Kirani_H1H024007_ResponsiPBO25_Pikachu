<?php
declare(strict_types=1);

class TrainingSession
{
    private string $trainingType;
    private int $intensity;
    private \DateTime $time;

    public function __construct(string $trainingType, int $intensity, ?\DateTime $time = null)
    {
        $this->trainingType = $trainingType;
        $this->intensity = max(1, $intensity);
        $this->time = $time ?? new \DateTime();
    }

    public function getTrainingType(): string
    {
        return $this->trainingType;
    }

    public function getIntensity(): int
    {
        return $this->intensity;
    }

    public function getTime(): \DateTime
    {
        return $this->time;
    }

    public function getFormattedTime(): string
    {
        return $this->time->format('d-m-Y H:i:s');
    }
}
