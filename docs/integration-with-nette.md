<div align="center" style="text-align: center; margin-bottom: 50px">
<img src="images/logo.svg" alt="Crawler Client Logo" align="center" width="200">
<h1 align="center">Integration with Nette Framework</h1>
</div>

For integration with the Nette Framework use the provided compiler extension. The minimum configuration looks like this:

```neon
extensions:
    crawler_client: SixtyEightPublishers\CrawlerClient\Bridge\Nette\DI\CrawlerClientExtension

crawler_client:
    crawler_host_url: <full url to your crawler instance>
```

## Authentication

Requests to the Crawler API must always be authenticated, so we must provide credentials.

```neon
crawler_client:
    crawler_host_url: <full url to your crawler instance>
    credentials:
        username: <username>
        password: <password>
```

If you don't want to have credentials hardcoded in the configuration (for example, you want to get them from the database), you can write your own class implementing the `CredentialsInterface` and register it as a service.

```neon
crawler_client:
    crawler_host_url: <full url to your crawler instance>

services:
    - MyCredentialsService
```

## Default Guzzle config

The client uses the [Guzzle](https://github.com/guzzle/guzzle) library to communicate with the Crawler API. If you want to pass some custom options to the configuration for Guzzle, use the `guzzle_config` section.

```neon
crawler_client:
    crawler_host_url: <full url to your crawler instance>
    guzzle_config:
        # your custom options e.g.
        timeout: 0
```

## Middlewares

Custom middlewares can be registered as follows.

```neon
crawler_client:
    crawler_host_url: <full url to your crawler instance>
    middlewares:
        - MyCustomMiddleware
        - AnotherCustomMiddleware()
```

You can read more about middleware [here](docs/advanced-options.md#middlewares).

## Serializer

The default serializer implementation can also be replaced by the following option.

```neon
crawler_client:
    crawler_host_url: <full url to your crawler instance>
    serializer: MyExtendedSerializer()
```

You can read more about the serializer [here](docs/advanced-options.md#serializer).
