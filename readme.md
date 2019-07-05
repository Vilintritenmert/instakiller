## Instagram Killer 

### Setup 

1. make clone of project 
2. copy `.env.example` to `.env`  
3. run command `docker-compose up`
4. after start run command in other cli `docker-compose run --rm --no-deps app composer install`
4. after start run command in other cli `docker-compose run --rm --no-deps app php artisan migrate`
5. enjoy `http://localhost:81`

