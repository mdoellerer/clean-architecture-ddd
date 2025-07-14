<?php

namespace Infrastructure\Web;

use Application\Company\CompanyService;

class CompanyController
{
    public function __construct(private CompanyService $service) {}

    private function validateRequest(array $request): void
    {
        if (empty($request['name']) || empty($request['country'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid or Missing arguments']);
            exit;
        }
    }

    public function create(array $request): void
    {
        $this->validateRequest($request);
        $company = $this->service->create($request['name'], $request['country']);
        
        echo json_encode(['id' => $company->getId()]);
    }

    public function update(array $request, string $id): void
    {
        $this->validateRequest($request);
        $company = $this->service->update($request['name'], $request['country'], $id);
        
        if ($company) {
            echo json_encode([
                'id' => $company->getId(),
                'name' => $company->getName(),
                'country' => $company->getCountry()
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Company not found']);
        }
    }

    public function list(): void
    {
        $companies = $this->service->all();
        
        echo json_encode(array_map(fn($c) => [
            'id' => $c->getId(),
            'name' => $c->getName(),
            'country' => $c->getCountry()
        ], $companies));
    }

    public function get(string $id): void
    {
        $company = $this->service->get($id);
        if ($company) {
            echo json_encode([
                'id' => $company->getId(),
                'name' => $company->getName(),
                'country' => $company->getCountry()
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Company not found']);
        }
    }

    public function delete(string $id): void
    {
        $this->service->delete($id);
        
        echo json_encode(['deleted' => true]);
    }
}
