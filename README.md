Symfony 2 ORM demo
====
This code was used as demonstration for the talk [ORM won't kill any kittens](http://jmolivas.com/slides/mxlos/orm-wont-kill-any-kittens) 

### Instructions

#### Clone repository
````
$git clone https://github.com/jmolivas/orm.dev.git
````

#### Download dependencies
````
$composer install 
````

#### Create database & schema
````
$app/console doctrine:database:create  
$app/console doctrine:schema:create
````

#### Load fixtures
````
$app/console doctrine:fixtures:load
````

#### Available URLs
````
/articles

/articles-array

/articles-optimized
````