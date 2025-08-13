<?php

namespace Domain\MainUrl;


class MainUrl
{
    public function __construct(
        readonly string $companyId, 
        readonly ?string $websiteId
        )
    {}

}
