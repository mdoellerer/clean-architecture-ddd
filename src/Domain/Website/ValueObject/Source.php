<?php

    namespace Domain\Website\ValueObject;

final class Source
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function equals(Source $other): bool
    {
        return $this->name === $other->getName();
    }
}