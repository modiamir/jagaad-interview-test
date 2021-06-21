# City Weather (Interview Technical Test)

## Step 1

To run the app run below commands:
```shell
docker-compose run --rm app composer install
docker-compose run --rm app php app.php cities:fetch-weather
```

### Stack
This project is based on PHP 7.4 (because it was requested in the task description).
I didn't use any framework but used some of Symfony's components to build this app.
The components I have used is as below:

*  `symfony/dependency-injection`
*  `symfony/config":`
*  `symfony/console":`
*  `symfony/serializer":`
*  `symfony/property-access`
*  `symfony/http-client`

### Tests
I wrote unit tests with 93% coverage. To run tests execute below command:
```shell
docker-compose run --rm app php ./vendor/bin/phpunit
```

### Code Style
I followed PSR12 coding standard for my code style, Also I added php code sniffer package to verify
PSR12 is not being violates. To run that execute below command:
```shell
docker-compose run --rm app php ./vendor/bin/phpcs
```

### Static Analyzer
I used PHPStan as the static analyzer. To run PHPStan run below command:
```shell
docker-compose run --rm app php ./vendor/bin/phpstan analyze src tests -l 8
```
