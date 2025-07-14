<?php

namespace Domain\Company;

use Domain\Company\ValueObject\Country;
use Ramsey\Uuid\Uuid;

class Company
{
    private string $id;
    private string $name;
    private Country $country;

    public function __construct(string $name, string $country, ?string $id)
    {
        if (empty($id)){
            $this->setId();
        } else {
           $this->id = $id; 
        }       

        $this->name = $name;
        $this->country = new Country($country);
    }

    private function setId(): void
    {
        $this->id = Uuid::uuid4()->toString();
    }

    public function getId(): string 
    { 
        return $this->id; 
    }

    public function getName(): string 
    { 
        return $this->name; 
    }

    public function getCountry(): string 
    { 
        return $this->country->getName(); 
    }
}
