<?php

namespace Domain\Website;

use Domain\Website\ValueObject\Source;
use Ramsey\Uuid\Type\Time;
use Ramsey\Uuid\Uuid;

class Website
{
    private string $id;
    private string $companyId;
    private string $address;
    private Source $source;
    private ?int $roi;
    private ?int $subscribers;
    private int $updatedAt;

    public function __construct(string $companyId, string $address, string $source, ?string $id, ?int $roi, ?int $subscribers, ?int $updatedAt)
    {
        if (empty($id)){
            $this->setId();
        } else {
           $this->id = $id; 
        }       

        $this->companyId = $companyId;
        $this->address = $address;
        $this->source = new Source($source);
        $this->roi = $roi;
        $this->subscribers = $subscribers;

        $this->setUpdatedAt($updatedAt);
    }

    private function setId(): void
    {
        $this->id = Uuid::uuid4()->toString();
    }

    private function setUpdatedAt(?int $updateAt): void
    {
        $this->updatedAt = $updateAt ?? time();
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

    public function getSource(): Source 
    { 
        return $this->source; 
    }

    public function getRoi(): ?int
    {
        return $this->roi;
    }

    public function getSubscribers(): ?int
    {
        return $this->subscribers;
    }

    public function getUpdatedAt(): int
    {
        return $this->updatedAt;
    }
}