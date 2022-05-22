# Getting started
1. Clone the repository with `git clone https://github.com/karintomania/20220522_PHP_Test.git`.
1. Run `docker-compose up -d` to start the environment.
1. Run `docker exec -it test-app composer install` to install the dependencies.
1. Run `docker exec -it test-app touch app/Database/db.sqlite` to create a db.
1. Run `docker exec -it test-app composer run-script test` to run tests.

# Project's overview.


## Bootstrap (app/bootstrap.php)
Start DI container for this app.  
Config for the container is in app/config.php.  

## Basket (app/Basket.php)
Basket is the main class of this project.  
This class contains the functions below:

| name | description|
|---|---|
|init| add eligible offers for the given user |
|add| add product to the basket|
|total| add product to the basket|

## Persistance layer
This project uses DB (sqlite) to persist data.  
### Repositories
Two repositories (located in app/Repositories) below have functions to communicate with the database.
- OfferRepository
- ProductRepository 

### Tables
This project uses the tables below:
| name | description|
|---|---|
|products| hold information of Products |
|users| hold information of Users |
|user_product| association table for User and Product |
|user_offer| association table for User and Offer |

Each table has a corresponding model in app/Models.  

*Note*: Offer doesn't have a table for it as Offers are managed as classes in app/Offers.   
Because Offers have logics inside (like checking eligibility of users) which can be saved as functions in class (or, can't be saved in DB), Offers are saved as classes.

### Migrations and seeders
When `docker exec -it test-app composer run-script test` command is executed, the DB migration and seedings are also executed.  
Also, you can run migration and seeding by the command below:  
`docker exec -it test-app composer run-script migrate`  
`docker exec -it test-app composer run-script seed`  

## Dependencies
This project uses the libraries below:  

| name | description|
|---|---|
|php-di/php-di| DI container |
|illuminate/database| ORM |
|phpunit/phpunit| Testing framework |