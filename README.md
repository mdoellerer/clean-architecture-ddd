# clean-architecture-ddd
Simple, framework-agnostic project to demonstrate the Domain Driven Design using Clean Architecture. 

The 'fake' framework works as a very simplified RestAPI with a bootstrap and routing.
The DDD and layers are located inside the src folder. 

## Requirements
 - PHP 8.0 or higher (it might work with 7.4)
 - ext-pdo_sqlite
 - Composer


## Usage

### Download Code and run Composer
You should be able to git clone or download the .zip file on your computer. On the application root (where the file composer.json is) run the command:
`composer update`

It will install the dependencies and create a file for your database (as sqlite). 


### Publishing the application

Next step is to publish the application, the root should be the public/index.php so, the easiest way is to run a php server from the public folder:
<br>`cd public/`
<br>`php -S localhost:8080`

You can specify a diferent port, but usually 8080 is a good one.
After the server is running try to access the companies endpoint: 
<br>http://localhost:8080/companies

This should show you an empty collection, it means it is working!

Now, you should also test the websites endpoint 
<br>http://localhost:8080/companies//websites

This should also return an empty collection at first.

### Data Operations

Now you only need to add/edit/delete some data. Since this works as an API endpoint you can use your favourite RestAPI client (such as Postman, Insomnia) to create and manage your requests.

Just point your requests to http://localhost:8080/companies with method **GET** to list all, or **POST** to add a new one, in the last case you need the Request Body of type *JSON* and the fields "name" and "country" to be set and filled.

The **PUT** method also requires the *JSON*  fields explained above.For the methods **PUT** and **DELETE** (or to **GET** only one specific object) you will need to add the id of a given object in the url, like this: <br>
http://localhost:8080/companies/e0434c05-0bdc-4cc4-91e0-f80d3b61ebde 

The endpoint for Websites is now implemented. You can find them nested in the Companies endpoint. The same operations mentioned above are suported, only now you have a different endpoint. <br>
Some possible examples:<br>
http://localhost:8080/companies//websites (list all websites)
http://localhost:8080/companies/e0434c05-0bdc-4cc4-91e0-f80d3b61ebde/websites/ (all websites of the company defined by the UID)<br>
http://localhost:8080/companies/e0434c05-0bdc-4cc4-91e0-f80d3b61ebde/websites/fa1370af-3ce2-430e-a6ce-760760cc4c6e/ (will bring you the exact website requested)
<br><br>
And so on...
<br><br>
It is also possible to make the requests using cURL, maybe in the future I add them here :)


## Known Issues

This is not a perfect solution, the aim here is to show some DDD principles inside a Clean Architecture, the location of folders and files, and a suggestion on how to organize them. This is not supposed to be an actual API. 
It has simplifications here and there, and some of those issues I might address in the future, let's see how it goes. 

 - Aggregates not implemented yet, but it is planned 
 - PUT method can create a new Object entirely
 - No implementation for PATCH
 - Id creation does not check for existing uid
 - No fields for timestamps (createdAt, updatedAt)
 - No logging


