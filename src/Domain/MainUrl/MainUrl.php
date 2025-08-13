<?php

namespace Domain\MainUrl;


class MainUrl
{
    public function __construct(
        private string $companyId, 
        private ?string $websiteId
        )
    {}

}
