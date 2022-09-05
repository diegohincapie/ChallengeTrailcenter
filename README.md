# Book Store

## Justification
This app "Book Store" is the response for the proposal challenge

## Requirements
The requirements are in the file called "trailercentral_test_task.md" in this folder

## Focus
The focus of this development was "simplicity", I believe in "Keep It Simple, Stupid", I create 3 Controllers (Authors, Books, Library) and 3 Models (Author, Book, Library) and code the API routes Al was managed by API The Front, is jQuery+Bootstrap, ¿why? For the simplicity: Bootstrap provides CSS classes and functionalities for creating a layout easily, and jQuery work perfect with Bootstrap, only for this reason simplicity and code speed

## Troubles
I have difficult for create files for docker, but was for a problem with my Laptop

## Install and run via docker (recommended):
Step in main folder (this folder) and run: docker-compose run --build

when the command stop in success, you can enter to http://localhost:8000 in your browser

Possible problems with this method:
- don't have docker-compose, in this case the solution is easy, install docker-compose
- ports 3306 (MySQL) or 8000 are busy in another service, you must stop the others services temporary

## Install and run via PHP artisan
- You must have preinstalled MySQL
- You must have php7.3+ in CLI installed
- create a database for this application
- step in this folder and edit .env for put MySQL data connections
- run php artisan migrate
- run php artisan serve