<div align="center" style="text-align: center; margin-bottom: 50px">
<img src="docs/images/logo.svg" alt="Crawler Client Logo" align="center" width="200">
<h1 align="center">Crawler Client PHP</h1>
<p>PHP Client for <a href="https://github.com/68publishers/crawler">68publishers/crawler</a></p>
</div>

<p align="center">
<a href="https://github.com/68publishers/crawler-client-php/actions"><img alt="Checks" src="https://badgen.net/github/checks/68publishers/crawler-client-php/main"></a>
<a href="https://coveralls.io/github/68publishers/crawler-client-php?branch=main"><img alt="Coverage Status" src="https://coveralls.io/repos/github/68publishers/crawler-client-php/badge.svg?branch=main"></a>
<a href="https://packagist.org/packages/68publishers/crawler-client-php"><img alt="Total Downloads" src="https://badgen.net/packagist/dt/68publishers/crawler-client-php"></a>
<a href="https://packagist.org/packages/68publishers/crawler-client-php"><img alt="Latest Version" src="https://badgen.net/packagist/v/68publishers/crawler-client-php"></a>
<a href="https://packagist.org/packages/68publishers/crawler-client-php"><img alt="PHP Version" src="https://badgen.net/packagist/php/68publishers/crawler-client-php"></a>
</p>

## Installation

```sh
$ composer require 68publishers/crawler-client-php
```

## Client initialization

The client instance is simply created by calling the static method `create()`.

```php
use SixtyEightPublishers\CrawlerClient\CrawlerClient;

$client = CrawlerClient::create('<full url to your crawler instance>');
```

The [Guzzle](https://github.com/guzzle/guzzle) library is used to communicate with the Crawler API.
If you want to pass some custom options to the configuration for Guzzle, use the second optional parameter.

```php
use SixtyEightPublishers\CrawlerClient\CrawlerClient;

$client = CrawlerClient::create('<full url to your crawler instance>', [
    'timeout' => 0,
]);
```

Requests to the Crawler API must always be authenticated, so we must provide credentials.

```php
use SixtyEightPublishers\CrawlerClient\CrawlerClient;
use SixtyEightPublishers\CrawlerClient\Authentication\Credentials;

$client = CrawlerClient::create('<full url to your crawler instance>');

$client = $client->withAuthentication(new Credentials('<username>', '<password>'));
```

It should be pointed out that the client is immutable - calling the `with*` methods always returns a new instance.
This is all that is needed for the client to work properly. You can read about other options on the [Advanced options](docs/advanced-options.md) page.

## Nette Framework integration

For integration with the Nette Framework please follow [this link](docs/integration-with-nette.md).

## Working with scenarios

Scenarios are handled by `ScenarioController`.

```php
use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ScenariosController;

$controller = $client->getController(ScenariosController::class);
```

### List scenarios

```php
/**
 * @param int $page
 * @param int $limit
 * @param array<string, string|array<string>> $filter
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\Scenario\ScenarioListingResponse
 * 
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\BadRequestException
 */
```

```php
$response = $controller->listScenarios(1, 10);

$filteredResponse = $controller->listScenarios(1, 10, [
    'name' => 'Test',
    'status' => 'failed',
])
```

### Get scenario

```php
/**
 * @param string $scenarioId
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\Scenario\ScenarioResponse
 * 
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\BadRequestException
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\NotFoundException
 */
```

```php
$response = $controller->getScenario('<id>');
```

### Run scenario

```php
/**
 * @param \SixtyEightPublishers\CrawlerClient\Controller\Scenario\RequestBody\ScenarioRequestBody $requestBody
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\Scenario\ScenarioResponse
 * 
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\BadRequestException
 */
```

As a scenario config we can pass a normal array or use prepared value objects. Both options are valid.

```php
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\RequestBody\ScenarioRequestBody;

$requestBody = new ScenarioRequestBody(
    name: 'My scenario',
    flags: ['my_flag' => 'my_flag_value'],
    config: [
        'scenes' => [ /* ... */ ],
        'options' => [ /* ... */ ],
        'entrypoint' => [ /* ... */ ],
    ],
)

$response = $controller->runScenario($requestBody);
```

```php
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\RequestBody\ScenarioRequestBody;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Entrypoint;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Action;

$requestBody = new ScenarioRequestBody(
    name: 'My scenario',
    flags: ['my_flag' => 'my_flag_value'],
    config: (new ScenarioConfig(new Entrypoint('<url>', 'default')))
        ->withOptions(/* ... */)
        ->withScene('default', [
            new Action('...', [ /* ... */ ])
            new Action('...', [ /* ... */ ])
        ]),
)

$response = $controller->runScenario($requestBody);
```

### Validate scenario

```php
/**
 * @param \SixtyEightPublishers\CrawlerClient\Controller\Scenario\RequestBody\ScenarioRequestBody $requestBody
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValidateScenarioResponse
 */
```

As a scenario config we can pass a normal array or use prepared value objects. Both options are valid.

```php
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\RequestBody\ScenarioRequestBody;

$requestBody = new ScenarioRequestBody(
    name: 'My scenario',
    flags: ['my_flag' => 'my_flag_value'],
    config: [
        'scenes' => [ /* ... */ ],
        'options' => [ /* ... */ ],
        'entrypoint' => [ /* ... */ ],
    ],
)

$response = $controller->validateScenario($requestBody);
```

```php
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\RequestBody\ScenarioRequestBody;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Entrypoint;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Action;

$requestBody = new ScenarioRequestBody(
    name: 'My scenario',
    flags: ['my_flag' => 'my_flag_value'],
    config: (new ScenarioConfig(new Entrypoint('<url>', 'default')))
        ->withOptions(/* ... */)
        ->withScene('default', [
            new Action('...', [ /* ... */ ])
            new Action('...', [ /* ... */ ])
        ]),
)

$response = $controller->validateScenario($requestBody);
```

### Abort scenario

```php
/**
 * @param string $scenarioId
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\Common\NoContentResponse
 * 
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\BadRequestException
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\NotFoundException
 */
```

```php
$response = $controller->abortScenario('<id>');
```

## Working with scenario schedulers

Scenario schedulers are handled by `ScenarioSchedulersController`.

```php
use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ScenarioSchedulersController;

$controller = $client->getController(ScenarioSchedulersController::class);
```

### List scenario schedulers

```php
/**
 * @param int $page
 * @param int $limit
 * @param array<string, string|array<string>> $filter
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ScenarioSchedulerListingResponse
 * 
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\BadRequestException
 */
```

```php
$response = $controller->listScenarioSchedulers(1, 10);

$filteredResponse = $controller->listScenarioSchedulers(1, 10, [
    'name' => 'Test',
    'userId' => '<id>',
])
```

### Get scenario scheduler

```php
/**
 * @param string $scenarioSchedulerId
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ScenarioSchedulerResponse
 * 
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\BadRequestException
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\NotFoundException
 */
```

```php
$response = $controller->getScenarioScheduler('<id>');
$etag = $response->getEtag(); # you need Etag for update
```

### Create scenario scheduler

```php
/**
 * @param \SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody $requestBody
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ScenarioSchedulerResponse
 * 
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\BadRequestException
 */
```

As a scenario config we can pass a normal array or use prepared value objects. Both options are valid.

```php
 use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody;

$requestBody = new ScenarioSchedulerRequestBody(
    name: 'My scenario',
    flags: ['my_flag' => 'my_flag_value'],
    active: true,
    expression: '0 2 * * *',
    config: [
        'scenes' => [ /* ... */ ],
        'options' => [ /* ... */ ],
        'entrypoint' => [ /* ... */ ],
    ],
)

$response = $controller->createScenarioScheduler($requestBody);
$etag = $response->getEtag(); # you need Etag for update
```

```php
 use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Entrypoint;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Action;

$requestBody = new ScenarioSchedulerRequestBody(
    name: 'My scenario',
    flags: ['my_flag' => 'my_flag_value'],
    active: true,
    expression: '0 2 * * *',
    config: (new ScenarioConfig(new Entrypoint('<url>', 'default')))
        ->withOptions(/* ... */)
        ->withScene('default', [
            new Action('...', [ /* ... */ ])
            new Action('...', [ /* ... */ ])
        ]),
)

$response = $controller->runScenario($requestBody);
$etag = $response->getEtag(); # you need Etag for update
```

### Update scenario scheduler

```php
/**
 * @param string $scenarioSchedulerId
 * @param string $etag
 * @param \SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody $requestBody
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ScenarioSchedulerResponse
 * 
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\BadRequestException
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\PreconditionFailedException
 */
```

As a scenario config we can pass a normal array or use prepared value objects. Both options are valid.

```php
 use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody;

$requestBody = new ScenarioSchedulerRequestBody(
    name: 'My scenario',
    flags: ['my_flag' => 'my_flag_value'],
    active: true,
    expression: '0 2 * * *',
    config: [
        'scenes' => [ /* ... */ ],
        'options' => [ /* ... */ ],
        'entrypoint' => [ /* ... */ ],
    ],
)

$response = $controller->updateScenarioScheduler('<id>', '<etag>', $requestBody);
$etag = $response->getEtag(); # you need Etag for next update
```

```php
 use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Entrypoint;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Action;

$requestBody = new ScenarioSchedulerRequestBody(
    name: 'My scenario',
    flags: ['my_flag' => 'my_flag_value'],
    active: true,
    expression: '0 2 * * *',
    config: (new ScenarioConfig(new Entrypoint('<url>', 'default')))
        ->withOptions(/* ... */)
        ->withScene('default', [
            new Action('...', [ /* ... */ ])
            new Action('...', [ /* ... */ ])
        ]),
)

$response = $controller->updateScenarioScheduler('<id>', '<etag>', $requestBody);
$etag = $response->getEtag(); # you need Etag for next update
```

### Validate scenario scheduler

```php
/**
 * @param \SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody $requestBody
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ValidateScenarioSchedulerResponse
 */
```

As a scenario config we can pass a normal array or use prepared value objects. Both options are valid.

```php
 use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody;

$requestBody = new ScenarioSchedulerRequestBody(
    name: 'My scenario',
    flags: ['my_flag' => 'my_flag_value'],
    active: true,
    expression: '0 2 * * *',
    config: [
        'scenes' => [ /* ... */ ],
        'options' => [ /* ... */ ],
        'entrypoint' => [ /* ... */ ],
    ],
)

$response = $controller->validateScenarioScheduler($requestBody);
```

```php
 use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\ScenarioConfig;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Entrypoint;
 use SixtyEightPublishers\CrawlerClient\Controller\Scenario\ValueObject\Action;

$requestBody = new ScenarioSchedulerRequestBody(
    name: 'My scenario',
    flags: ['my_flag' => 'my_flag_value'],
    active: true,
    expression: '0 2 * * *',
    config: (new ScenarioConfig(new Entrypoint('<url>', 'default')))
        ->withOptions(/* ... */)
        ->withScene('default', [
            new Action('...', [ /* ... */ ])
            new Action('...', [ /* ... */ ])
        ]),
)

$response = $controller->validateScenarioScheduler($requestBody);
```

### Activate/deactivate scenario scheduler

```php
/**
 * @param string $scenarioSchedulerId
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\ScenarioSchedulerResponse
 * 
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\BadRequestException
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\NotFoundException
 */
```

```php
 use SixtyEightPublishers\CrawlerClient\Controller\ScenarioScheduler\RequestBody\ScenarioSchedulerRequestBody;

# to activate the scenario scheduler:
$response = $controller->activateScenarioScheduler('<id>');

# to deactivate the scenario scheduler:
$response = $controller->deactivateScenarioScheduler('<id>');
```

### Delete scenario scheduler

```php
/**
 * @param string $scenarioSchedulerId
 * 
 * @returns \SixtyEightPublishers\CrawlerClient\Controller\Common\NoContentResponse
 * 
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\BadRequestException
 * @throws \SixtyEightPublishers\CrawlerClient\Exception\NotFoundException
 */
```

```php
$response = $controller->deleteScenarioScheduler('<id>');
```

## License

The package is distributed under the MIT License. See [LICENSE](LICENSE.md) for more information.
