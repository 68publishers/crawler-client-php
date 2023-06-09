<div align="center" style="text-align: center; margin-bottom: 50px">
<img src="images/logo.svg" alt="Crawler Client Logo" align="center" width="200">
<h1 align="center">Advanced options</h1>
</div>

## Middlewares

Middlewares are classes that implement the `MiddlewareInterface`. By default, middlewares from guzzle are used (except `http_errors`) and the client adds 3 custom middlewares:

- [ResponseExceptionMiddleware](https://github.com/68publishers/crawler-client-php/blob/main/src/Middleware/ResponseExceptionMiddleware.php) - throws exceptions for status codes between 400 - 500
- [UnexpectedErrorMiddleware](https://github.com/68publishers/crawler-client-php/blob/main/src/Middleware/UnexpectedErrorMiddleware.php) - wraps an exception that is not expected into the `UnexpectedErrorException`
- [AuthenticationMiddleware](https://github.com/68publishers/crawler-client-php/blob/main/src/Middleware/AuthenticationMiddleware.php) - adds the `Authorization` header

To register your own middleware, use the `CrawlerClient::withMiddlewares()` method, which returns a new instance of the client.
To remove the middleware use the `CrawlerClient::withoutMiddlewares()` method.

```php
$client = $client
    ->withMiddlewares(new MyCustomMiddleware())
    ->withoutMiddlewares('unexpected_error');
```

If you would like to register some of "legacy" middlewares from Guzzle, it is possible to wrap them in an instance of the `ClosureMiddleware` object.

```php
use GuzzleHttp\Middleware;
use SixtyEightPublishers\CrawlerClient\Middleware\ClosureMiddleware;

$container = [];
$client = $client->withMiddlewares(new ClosureMiddleware('history', 10, Middleware::history($container)));
```

## Serializer

The client uses an object implementing the `SerializerInterface` for serialization and deserialization of request and response bodies.
Serializer is implemented using [jms/serializer](https://github.com/schmittjoh/serializer).

The [default serializer](https://github.com/68publishers/crawler-client-php/blob/main/src/Serializer/JmsSerializer.php) is implemented using [jms/serializer](https://github.com/schmittjoh/serializer) and can be changed via the method `CrawlerClient::withSerializer()`.

```php
$client = $client->withSerializer(new MyCustomSerializer());
```

It is not a good idea to change the default implementation completely, the option to replace the serializer is more for emergencies, in case some error occurs and you need to fix it quickly in the application.
