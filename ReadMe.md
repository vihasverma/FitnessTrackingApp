#  FitnessActivity

## Summary

Fitness Activity Tracking:

1. Create Activity 
2. List All Activities
4. Filter By Activity Type
5. Count of time Elapsed as per activity type
6. Rest API to create new activity
7. Unit Testing 

## Total Time
10 hrs

## Intallation Steps

`git clone https://github.com/vihasverma/FitnessActivity.git`

`docker-compose up`

`docker-compose exec php /bin/bash `

`composer install`

`php bin/console doctrine:migrations:migrate`

## Functionality

**Login:** `http://localhost:8080/login`
![](/doc/login.png)


**username: vihas@example.com**

**password: admin**


**Dashboard:** `http://localhost:8080/activity` 
![](/doc/dashboard.png)

**Create Activity** `http://localhost:8080/activity/create`
![](/doc/create.png)

**API** 

Login: localhost:8080/api/login_check

CreateActivity API: localhost:8080/api/create_activity

## Unit Test
`docker-compose exec php /bin/bash `

`php bin/phpunit --group=tests`

`php bin/phpunit --group=functional_test`

![](/doc/tests.png)

## Code Architecture

I tried to implement Hexagonal architecture 

## Things to improve

Time limitation to create ActivityType in database

More unit test 
