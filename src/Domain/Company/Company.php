<?php

namespace Domain\Company;

use Domain\Company\ValueObject\Country;
use Domain\Strategy\MainUrl\DefaultStrategy;
use Ramsey\Uuid\Uuid;

class Company
{
    private string $id;
    private string $name;
    private Country $country;
    private string $strategyId;

    public function __construct(string $name, string $country, ?string $strategyId, ?string $id)
    {
        if (empty($id)){
            $this->setId();
        } else {
           $this->id = $id; 
        }       

        $this->name = $name;
        $this->country = new Country($country);

        $this->setStrategyId($strategyId);
    }

    private function setId(): void
    {
        $this->id = Uuid::uuid4()->toString();
    }

    private function setStrategyId(?string $strategyId): void
    {
        if (empty($strategyId)){
            $this->strategyId = DefaultStrategy::STRATEGY_NAME;
        } else {
            $this->strategyId = $strategyId;
        }        
    }

    public function getId(): string 
    { 
        return $this->id; 
    }

    public function getName(): string 
    { 
        return $this->name; 
    }

    public function getCountry(): Country 
    { 
        return $this->country; 
    }

    public function getStrategyId(): string 
    { 
        return $this->strategyId; 
    }
}
