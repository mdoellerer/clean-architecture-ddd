<?php

namespace Infrastructure\Web;

use Infrastructure\Persistence\SQLiteReportRepository;

class ReportController
{
    public function __construct(private SQLiteReportRepository $repo) {}

    public function list(): void
    {
        $companyWebsiteReport = $this->repo->list();
        
        echo json_encode($companyWebsiteReport);
    }
}