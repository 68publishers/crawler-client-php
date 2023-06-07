<?php

declare(strict_types=1);

namespace SixtyEightPublishers\CrawlerClient\Controller;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use SixtyEightPublishers\CrawlerClient\Exception\ControllerExceptionInterface;
use SixtyEightPublishers\CrawlerClient\Exception\UnexpectedErrorException;
use SixtyEightPublishers\CrawlerClient\Serializer\SerializerInterface;
use Throwable;
use function assert;
use function class_exists;
use function sprintf;
use function strpos;

trait ControllerResponseHandlerTrait
{
    protected GuzzleClientInterface $client;

    protected SerializerInterface $serializer;

    public function __construct(GuzzleClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    /**
     * @template T of object
     *
     * @param class-string<T>|null $bodyValueObjectClassname
     *
     * @return array{0: ResponseInterface, 1: T|null}
     * @phpstan-return ($bodyValueObjectClassname is null ? array{0: ResponseInterface, 1: null} : array{0: ResponseInterface, 1: T})
     *
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpDocMissingThrowsInspection
     */
    public function handle(callable $fetchResponseCallback, ?string $bodyValueObjectClassname): array
    {
        assert(null === $bodyValueObjectClassname || class_exists($bodyValueObjectClassname));

        try {
            $response = $fetchResponseCallback();
            assert($response instanceof ResponseInterface);

            if (null === $bodyValueObjectClassname) {
                return [
                    $response,
                    null,
                ];
            }

            if (false === strpos($response->getHeaderLine('Content-Type'), 'application/json')) {
                throw new RuntimeException(sprintf(
                    'Invalid Content-Type "%s" header received, expected "application/json".',
                    $response->getHeaderLine('Content-Type'),
                ));
            }

            return [
                $response,
                $this->serializer->deserialize((string) $response->getBody(), $bodyValueObjectClassname),
            ];
        } catch (Throwable $e) {
            if ($e instanceof ControllerExceptionInterface) {
                throw $e;
            }

            throw new UnexpectedErrorException($e);
        }
    }
}
