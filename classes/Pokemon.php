<?php
declare(strict_types=1);

abstract class Pokemon implements Trainable
{
    protected string $name;
    protected string $type;
    protected int $level;
    protected int $hp;
    protected int $maxHp;
    protected string $specialMoveName;
    protected string $trainerName;

    /** @var Move[] */
    protected array $moves = [];

    public function __construct(
        string $name,
        string $type,
        int $level,
        int $hp,
        string $specialMoveName,
        string $trainerName
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->level = max(1, $level);
        $this->hp = max(1, $hp);
        $this->maxHp = max(1, $hp);
        $this->specialMoveName = $specialMoveName;
        $this->trainerName = $trainerName;
    }

    // Encapsulation: getter & setter
    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getHp(): int
    {
        return $this->hp;
    }

    public function getMaxHp(): int
    {
        return $this->maxHp;
    }

    public function getSpecialMoveName(): string
    {
        return $this->specialMoveName;
    }

    public function getTrainerName(): string
    {
        return $this->trainerName;
    }

    public function setTrainerName(string $trainerName): void
    {
        $this->trainerName = $trainerName;
    }

    public function setLevel(int $level): void
    {
        $this->level = max(1, $level);
    }

    public function setHp(int $hp): void
    {
        if ($hp < 1) {
            $hp = 1;
        }
        if ($hp > $this->maxHp) {
            $hp = $this->maxHp;
        }

        $this->hp = $hp;
    }

    public function heal(int $amount = 10): void
    {
        $this->setHp($this->hp + $amount);
    }

    // Polymorphism: logika train() menggunakan calculateTrainingEffect() yang di-override di child
    public function train(TrainingSession $session): TrainingResult
    {
        $levelBefore = $this->level;
        $hpBefore = $this->hp;

        $effect = $this->calculateTrainingEffect($session);

        $this->setLevel($this->level + $effect['levelGain']);
        $this->setHp($this->hp + $effect['hpGain']);

        $specialMoveDescription = $this->specialMove();

        return new TrainingResult(
            $session,
            $levelBefore,
            $this->level,
            $hpBefore,
            $this->hp,
            $specialMoveDescription,
            $effect['description']
        );
    }

    /**
     * Data dex untuk panel deskripsi.
     * @return array<string,string>
     */
    abstract public function getDexData(): array;

    /**
     * Statistik dasar untuk grafik bar.
     * @return array<string,int>
     */
    abstract public function getBaseStats(): array;

    /**
     * Catatan gaya latihan.
     * @return array<string,string>
     */
    abstract public function getTrainingProfile(): array;

    /**
     * @return Move[]
     */
    public function getMoves(): array
    {
        return $this->moves;
    }

    // Abstraction
    abstract protected function calculateTrainingEffect(TrainingSession $session): array;

    abstract public function specialMove(): string;
}
