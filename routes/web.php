<?php

use Infrastructure\Web\CompanyController;
use Infrastructure\Persistence\SQLiteCompanyRepository;
use Application\Company\CompanyService;
use Application\Website\WebsiteService;
use Infrastructure\Persistence\SQLiteWebsiteRepository;
use Infrastructure\Web\WebsiteController;

$uri = $_SERVER['REQUEST_URI'];
$splitUri = explode('/', $uri);
$entity = $splitUri[1] ?? null;
$entityId = $splitUri[2] ?? null;

$controller = getController($entity);
$methodAndParameters = getMethodAndParameters($entityId);

if ($controller && $methodAndParameters) {
    $method = key($methodAndParameters);
    $parameters = $methodAndParameters[$method];

    if ($parameters){
        $controller->$method(...$parameters);
    } else {
        $controller->$method();
    }    
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}


function getController(string $entity)
{
    if ($entity === COMPANY_ENTITY_API_NAME){
        $repo = new SQLiteCompanyRepository();
        $service = new CompanyService($repo);
        return new CompanyController($service);  
    }

    if ($entity === WEBSITE_ENTITY_API_NAME){
        $repo = new SQLiteWebsiteRepository();
        $service = new WebsiteService($repo);
        return new WebsiteController($service);  
    }
}

function getMethodAndParameters($entityId)
{
    $method = $_SERVER['REQUEST_METHOD']; 

    if ($entityId){
        if ($method === 'GET') {
            return ["get" => [$entityId]];;
        } 
        if ($method === 'PUT') {
            $data = json_decode(file_get_contents('php://input'), true);
            return ["update" => [$data, $entityId]];
        } 
        if ($method === 'DELETE') {
            return ["delete" => [$entityId]];;
        }        
    } else {
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            return ["create" => [$data]];
        } 
        if ($method === 'GET') {
            return ["list" => null];
        } 
    }

}
