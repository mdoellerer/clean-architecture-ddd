<?php

namespace Domain\Website;

use Domain\Website\ValueObject\Source;
use Ramsey\Uuid\Uuid;

class Website
{
    private string $id;
    private string $companyId;
    private string $address;
    private Source $source;

    public function __construct(string $companyId, string $address, string $source, ?string $id)
    {
        if (empty($id)){
            $this->setId();
        } else {
           $this->id = $id; 
        }       

        $this->companyId = $companyId;
        $this->address = $address;
        $this->source = new Source($source);
    }

    private function setId(): void
    {
        $this->id = Uuid::uuid4()->toString();
    }

    public function getId(): string 
    { 
        return $this->id; 
    }

    public function getCompanyId(): string 
    { 
        return $this->companyId; 
    }

    public function getAddress(): string 
    { 
        return $this->address; 
    }

    public function getSource(): string 
    { 
        return $this->source->getName(); 
    }
}
