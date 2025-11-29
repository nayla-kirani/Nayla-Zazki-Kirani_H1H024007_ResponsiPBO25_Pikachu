<?php
declare(strict_types=1);

interface Trainable
{
    public function train(TrainingSession $session): TrainingResult;

    public function specialMove(): string;
}
