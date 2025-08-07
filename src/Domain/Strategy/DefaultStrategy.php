<?php

namespace Domain\Strategy;

class DefaultStrategy implements Strategy
{
    public const STRATEGY_NAME = 'DefaultStrategy';

    private array $websites;

    public function getName(): string
    {
        return self::STRATEGY_NAME;
    }

    public function setWebsites(array $websiteList): void
    {
        $this->websites = $websiteList;
    }

    public function apply(): bool
    {
        if (empty($this->websites))
        {
            return false;
        }

        return true;
    }
}