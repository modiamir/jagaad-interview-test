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

## Step 2
For saving forecast on Musement's API we need a POST endpoint to the `forecast` resource that is a sub-resource of `city`
resource. So the URI for that sub-resource can be like this:
`/api/v3/cities/{cityId}/forecast.json`

So we can send below HTTP request to save forecast information to a city with ID 10:
```http request
POST https://sandbox.musement.com/api/v3/cities/10/forecasts.json
Content-Type: application/json
Accept: application/json

{
    "date": "2021-12-23",
    "text": "Cloudy",
    "icon": "https://cdn.weatherapi.com/weather/64x64/night/119.png"
}
```

That API can have below responses:

### Successful response

Request:
```json
{
    "date": "2021-12-23",
    "text": "Cloudy",
    "icon": "https://cdn.weatherapi.com/weather/64x64/night/119.png"
}
```
Status code: 200
Body:

```json
{
  "id": 20,
  "date": "2021-12-23",
  "text": "Cloudy",
  "icon": "https://cdn.weatherapi.com/weather/64x64/night/119.png"
}
```

### Bad Request Response
Request:
```json
a malformed json request
```

Status code: 400

### Unprocessable Entity Response
Request:
```json
{
  "text": "Cloudy",
  "icon": "https://cdn.weatherapi.com/weather/64x64/night/119.png"
}
```

Status code: 422

Body:
```json
{
  "message": "You have some validation error on your request",
  "errors": {
    "date": [
      "`date` field is required."
    ]
  }
}
```

For getting list of forecasts we can have below endpoint:
```http request
GET https://sandbox.musement.com/api/v3/cities/10/forecasts.json
Accept: application/json
```

responses can be like this:
```json
{
  "data": [
    {
      "id": 20,
      "date": "2021-12-23",
      "text": "Cloudy",
      "icon": "https://cdn.weatherapi.com/weather/64x64/night/119.png"
    },
    {
      "id": 20,
      "date": "2021-12-23",
      "text": "Cloudy",
      "icon": "https://cdn.weatherapi.com/weather/64x64/night/119.png"
    }
  ],
  "meta": {
    "total": 2,
    "current_page": 1,
    "next": null,
    "previous": null
  }
}
```

To filter forecasts for a city we can have below requests:

```http request
GET https://sandbox.musement.com/api/v3/cities/10/forecasts.json?filters[date]=2021-12-23
Accept: application/json
```

Or:

```http request
GET https://sandbox.musement.com/api/v3/cities/10/forecasts.json?filters[date]=today
Accept: application/json
```

Or:

```http request
GET https://sandbox.musement.com/api/v3/cities/10/forecasts.json?filters[date]=tomorrow
Accept: application/json
```

In above links we are filtering forecasts by `date` field that can be a `Y-m-d` format or keywords like today, tomorrow.
