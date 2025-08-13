<?php

namespace Domain\Strategy\MainUrl;

use Domain\MainUrl\MainUrl;

class DefaultStrategy implements Strategy
{
    public const STRATEGY_NAME = 'DefaultStrategy';

    private array $websites;
    private ?string $mainUrlId;

    public function __construct(array $websiteList)
    {
        $this->websites = $websiteList;
    }

    public function getName(): string
    {
        return self::STRATEGY_NAME;
    }

    public function apply(): ?MainUrl
    {
        if (empty($this->websites))
        {
            return null;
        }
        
       $biggestValue = 0;
       $companyId = null;

        foreach ($this->websites as $website){
            $current = $website->getUpdatedAt();
            $companyId = $companyId ?? $website->getCompanyId();
            if ($current > $biggestValue){
                $this->mainUrlId = $website->getId();
                $biggestValue = $current;
            }
        }

        return new MainUrl($companyId, $this->mainUrlId);
    }
}