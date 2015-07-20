Assessment
==========

A Symfony project created on July 16, 2015, 1:34 pm.

Prerequisite:
1. composer install
2. Populate Database => php app/console doctrine:database:create
3. Populate Table => php app/console doctrine:schema:update --force

### Task 1: Basic Functionality
* Build a REST Server for a password manager. We recommend using FOSRestBundle (https://github.com/FriendsOfSymfony/FOSRestBundle),
  documentation can be found here: http://symfony.com/doc/master/bundles/FOSRestBundle/index.html (Done)

* Authentication is done by providing a http header (X-ACCESS-TOKEN).
  The access token needs to match an constant environment variable set up in symfony2 (e.g. aC9Uu5JR9zvZi99e).
  All requests with invalid access token should throw an error (401). (Not Yet)

* Using HTTP-Requests (PUT, GET, POST, DELETE), users should be able to list, get, create, store and delete passwords using curl
  (example curl requests below) (Done)

* Passwords should be stored in a database (MySQL). Only one table required ('passwords') (Done)

* All requests and responses should use the JSON format. (Done)

### Task 2A: Unit Tests
* Write unit tests for all five request types using PHPUnit (https://symfony.com/doc/current/book/testing.html).
* If you prefer TDD (Test driven development),
  feel free to start with "Task 2A: Unit Tests" before/along with "Task 1: Basic Functionality". (Done)
  command : phpunit -c app

### Task 2B: Web Client
* Write a simple AngularJS Client that communicates with the server.
  The user interface should fulfill all REST features
  (create password, edit password, list of passwords, show password details, delete a password).
  # I Worked for 2B But all not functions running well.
  ( http://localhost:8000/api/v1/passwords )

## API Operations (REST)
The following operations / api-endpoints should be implemented

### Create Password
curl -X POST -H "Content-Type: application/json" -d '{"key":"google", "username": "info@gmail.com", "password": "asdfasdf"}' "http://localhost:8000/api/v1/passwords"

### Update Password:
curl -X PUT -H "Content-Type: application/json" -d '{"username": "info@gmail.com", "password": "asdfasdf"}' "http://localhost:8000/api/v1/passwords/google.json"

### List Passwords:
curl -X GET -H "Content-Type: application/json" "http://localhost:8000/api/v1/passwords.json"

### Get Password:
curl -X GET -H "Content-Type: application/json" "http://localhost:8000/api/v1/passwords/google.json"

### Delete Password:
curl -X DELETE -H "Content-Type: application/json" "http://localhost:8000/api/v1/passwords/google.json"