<?php

namespace Infrastructure\Web;

use Infrastructure\Persistence\SQLiteDumpRepository;

class DumpController
{
    public function __construct(private SQLiteDumpRepository $repo) {}

    public function list(): void
    {
        echo "<hr><p>Please add the dump number in the URL:</p><hr>";
        echo "<p><a href='http://localhost:8888/dump/1'>http://localhost:8888/dump/1</a> => Companies MainUrl</p>";
        echo "<p><a href='http://localhost:8888/dump/2'>http://localhost:8888/dump/2</a> => Table Company</p>";
        echo "<p><a href='http://localhost:8888/dump/3'>http://localhost:8888/dump/3</a> => Table Website</p>";
        echo "<hr>";
    }

    public function get(string $id): void
    {
        $dumpData = match ($id){
            '1' => $this->repo->dumpCompanyMainUrl(),
            '2' => $this->repo->dumpCompany(),
            '3' => $this->repo->dumpWebsites(),
        };        
        
        echo "<pre>" . json_encode($dumpData, JSON_PRETTY_PRINT) . "</pre>";
    }

    public function create(): void
    {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
    }

        public function update(): void
    {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
    }

        public function delete(): void
    {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
    }
}