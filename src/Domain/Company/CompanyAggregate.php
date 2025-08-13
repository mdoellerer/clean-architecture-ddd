<?php

namespace Domain\Company;

use Domain\MainUrl\MainUrl;
use Domain\Strategy\MainUrl\Strategy;
use Domain\Website\Website;

class CompanyAggregate
{
    private MainUrl $mainUrl;

    private Strategy $strategy;

    public array $removedWebsite = [];

    public function __construct(
            private Company $company,
            private array $websiteList
        ) {}

    public function addWebsite(Website $website) : void
    {
        array_push($this->websiteList, $website);

        $this->setMainUrlBasedOnStrategy();
    }

    public function updateWebsite(Website $website) : void
    {
        $this->removeWebsite($website->getId());
        $this->addWebsite($website);    

        $this->setMainUrlBasedOnStrategy();
    }

    public function removeWebsite(string $websiteId) : void
    {
        // @var Website $website
        foreach ($this->websiteList as $key => $website){
            if ($website->getId() === $websiteId)
            {
                $this->removedWebsite[$key] = $key;
                unset($this->websiteList[$key]);
            }
        }

        $this->setMainUrlBasedOnStrategy();
    }

    private function setMainUrlBasedOnStrategy() : void
    {
        $className = 'Domain\\Strategy\\MainUrl\\' . $this->company->getStrategyId();
        $strategy = new $className($this->websiteList);

        $this->mainUrl = $strategy?->apply();
    }

    public function updateStrategy(Strategy $strategy) { }
}