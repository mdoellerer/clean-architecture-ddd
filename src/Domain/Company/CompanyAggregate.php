<?php

namespace Domain\Company;

use Domain\MainUrl\MainUrl;
use Domain\Strategy\MainUrl\Strategy;
use Domain\Website\Website;

class CompanyAggregate
{
    readonly MainUrl $mainUrl;

    private Strategy $strategy;

    private array $removedWebsite = [];

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
        foreach ($this->websiteList as $key => $value){
            if ($website->getId() === $value->getId())
            {
                unset($this->websiteList[$key]);
            }
        }
        array_push($this->websiteList, $website);

        $this->setMainUrlBasedOnStrategy();  
    }

    public function removeWebsite(string $websiteId) : void
    {
        foreach ($this->websiteList as $key => $value){
            if ($value->getId() === $websiteId)
            {
                $this->removedWebsite[$websiteId] = $websiteId;
                unset($this->websiteList[$key]);
            }
        }

        $this->setMainUrlBasedOnStrategy();
    }

    public function getWebsiteDeletions() : array
    {
        return $this->removedWebsite;
    }

    public function getWebsiteList() : array
    {
        return $this->websiteList;
    }

    private function setMainUrlBasedOnStrategy() : void
    {
        $className = 'Domain\\Strategy\\MainUrl\\' . $this->company->getStrategyId();
        $strategy = new $className($this->websiteList);

        $this->mainUrl = $strategy?->apply();
    }

    public function updateStrategy(Strategy $strategy) { }
}