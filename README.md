# Proxify Test Task

To test the parallel workers I used Supervisor. Should work with any process manager as well.

## Initial setup

```bash
cp .env.example .env
```
and set the DB info

```bash
composer install
php artisan migrate
php artisan db:seed
php artisan serve
```
## Add new values

To add new url entries use 
```curl
curl -H "Content-Type: application/json" -X POST -d '{"urls": ["https://google.com","https://proxify.io"]}' http://localhost:8000/api/create
```

## Dispatch a job
```curl
curl -X POST http://localhost:8000/api/dispatch
```

## Running on Supervisor
Below is a command example to set in the Supervisor worker configuration
```bash
php /PATH/TO/artisan queue:work sqs --sleep=3 --tries=3
```
