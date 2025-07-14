<?php

namespace Domain\Company\ValueObject;

final class Country
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

    public function equals(Country $other): bool
    {
        return $this->name === $other->getName();
    }
}