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
$entityId = $splitUri[2] ?? '';
$childEntity = $splitUri[3] ?? null;
$childEntityId = $splitUri[4] ?? '';

$controller = getController($entity, $childEntity);
$methodAndParameters = getMethodAndParameters($entityId, $childEntityId, $childEntity);

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


function getController(?string $entity, ?string $childEntity)
{
    if (isChildEntity($childEntity)) 
    {
        return getControllerChildEntity($childEntity);
    }

    return getControllerEntity($entity);
}

function getControllerEntity(?string $entity)
{
    if ($entity === COMPANY_ENTITY_API_NAME)
        {
        $repo = new SQLiteCompanyRepository();
        $service = new CompanyService($repo);
        return new CompanyController($service);  
    }
}

function getControllerChildEntity(?string $childEntity)
{
    if ($childEntity === WEBSITE_ENTITY_API_NAME){
        $repo = new SQLiteWebsiteRepository();
        $service = new WebsiteService($repo);
        return new WebsiteController($service);  
    }
}

function isChildEntity(?string $childEntity): bool
{
    return empty($childEntity) === false;
}

function getMethodAndParameters(?string $entityId, ?string $childEntityId, ?string $childEntity)
{
    $method = $_SERVER['REQUEST_METHOD']; 

    $currentObjectID =  $childEntity ? $childEntityId : $entityId;

    if (!empty($currentObjectID)){
        if ($method === 'GET') {
            return ["get" => [$currentObjectID]];;
        } 
        if ($method === 'PUT') {
            $data = getDataFromInput();
            addParentIdToData($data, $currentObjectID, $entityId);
            return ["update" => [$data, $currentObjectID]];
        } 
        if ($method === 'DELETE') {
            return ["delete" => [$currentObjectID]];;
        }        
    } else {
        if ($method === 'POST') {
            $data = getDataFromInput();
            addParentIdToData($data, $currentObjectID, $entityId);
            return ["create" => [$data]];
        } 
        if ($method === 'GET') {
            $data = [];
            addParentIdToData($data, $currentObjectID, $entityId);
            return ["list" => [$data]];
        } 
    }

}

function addParentIdToData(array &$data, ?string $currentId, ?string $parentId)
{
    if ($currentId !== $parentId){
        $data["parent"] = $parentId;   
    }
}

function getDataFromInput(): array
{
    return json_decode(file_get_contents('php://input'), true) ?? [];
}
