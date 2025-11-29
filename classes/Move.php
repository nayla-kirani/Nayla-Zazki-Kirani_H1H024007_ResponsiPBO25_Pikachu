<?php
declare(strict_types=1);

class Move
{
    private string $name;
    private string $type;
    private string $category;
    private string $powerInfo;
    private string $description;

    public function __construct(
        string $name,
        string $type,
        string $category,
        string $powerInfo,
        string $description
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->category = $category;
        $this->powerInfo = $powerInfo;
        $this->description = $description;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPowerInfo(): string
    {
        return $this->powerInfo;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
