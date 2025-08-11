<?php

namespace Domain\Company;

use Domain\Company\ValueObject\Country;
use Domain\Strategy\Strategy;
use Domain\Website\Website;

class CompanyAggregate
{
    public function __construct(
            private string $id,
            private string $name,
            private Country $country,
            private string $strategyId,
            private array $websiteList
        ) {}

    public function addWebsite(Website $website) {}

    public function updateWebsite(Website $website) {}

    public function removeWebsite(string $websiteId) {}

    public function updateStrategy(Strategy $strategy) { }

    private function setMainUrlBasedOnStrategy() {}
}