# clean-architecture-ddd
Simple, framework-agnostic project to demonstrate the Domain Driven Design using Clean Architecture. 
The 'fake' framework works as a very simplified RestAPI with a bootstrap and routing.
The DDD  and layers are located inside the src folder. 

## Use Case
Imagine you have a software that manages Company Data, and some of the data has special requirements, the example here is the websites.
At first it might sound very simple and straightforward to know what a company website is, but today is not always simple. Some companies may have more engagement through their social media pages than their .com domain, and the social media of choice might be different from time to time and might vary according to marketing strategies. Imagine having that same situation for millions of Companies.

That is how this project idea was shaped, to try to tackle this problem, as well as to show how to organize code, using DDD concepts and ultimately use an Aggregate to control and enforce the Business Rules being applied always.


The rules here are:
- The logic used to define a Company's main website is called Strategy, there might be several different strategies in the system and each company can use one of them. A Strategy should ALWAYS return one candidate (except,of course the list size is 0). There is a default Strategy that is attached to every company on creation.
- On every Company's Website List, whenever a CRUD operation takes place, the Strategy must be applied taking into consideration the new data.
- Same applies when a Company changes Strategy


## Usage

### Requirements
 - PHP 8.0 or higher (it might work with 7.4)
 - ext-pdo_sqlite
 - Composer

### Download Code and run Composer
You should be able to git clone or download the .zip file on your computer. On the application root (where the file composer.json is) run the command:
`composer update`

It will install the dependencies and create a file for your database (as sqlite). 


### Publishing the application

Next step is to publish the application, the root should be the public/index.php so, the easiest way is to run a php server from the public folder:
<br>`cd public/`
<br>`php -S localhost:8080`

You can specify a different port, but usually 8080 is a good one.
After the server is running try to access the companies endpoint: 
<br>http://localhost:8080/companies

This should show you an empty collection, it means it is working!

Now, you should also test the websites endpoint 
<br>http://localhost:8080/companies//websites
(this should always return an empty collection, but no errors)

### Data Operations

Now you only need to add/edit/delete some data. Since this works as an API endpoint you can use your favourite RestAPI client (such as Postman, Insomnia) to create and manage your requests.

Just point your requests to http://localhost:8080/companies with method **GET** to list all, or **POST** to add a new one, in the last case you need the Request Body of type *JSON* and the fields "name" and "country" to be set and filled.

The **PUT** method also requires the *JSON*  fields explained above.For the methods **PUT** and **DELETE** (or to **GET** only one specific object) you will need to add the id of a given object in the url, like this: <br>
http://localhost:8080/companies/e0434c05-0bdc-4cc4-91e0-f80d3b61ebde 

The endpoint for Websites is now implemented. You can find them nested in the Companies endpoint. The same operations mentioned above are supported, only now you have a different endpoint. <br>
Some possible examples:<br>
http://localhost:8080/companies/e0434c05-0bdc-4cc4-91e0-f80d3b61ebde/websites/ (all websites of the company defined by the UID)<br>
http://localhost:8080/companies/e0434c05-0bdc-4cc4-91e0-f80d3b61ebde/websites/fa1370af-3ce2-430e-a6ce-760760cc4c6e/ (will bring you the exact website requested)
<br><br>
And so on...
<br><br>
It is also possible to make the requests using cURL, maybe in the future I'll add them here :)


## Known Issues

This is not a perfect solution, the aim here is to show some DDD principles inside a Clean Architecture, the location of folders and files, and a suggestion on how to organize them. This is not supposed to be an actual API. 
It has simplifications here and there, for example: the data integrity is not being controlled, because it is not what we wanted to demonstrate here. Some of those issues I might address in the future when time allows, let's see how it goes. 

 - PUT method can create a new Object entirely
 - Id creation does not check for existing uid
 - DELETE CASCADE not implemented
 - No implementation for PATCH
 - Not many fields for timestamps (createdAt, updatedAt)
 - No logging
 - For the moment, no tests


