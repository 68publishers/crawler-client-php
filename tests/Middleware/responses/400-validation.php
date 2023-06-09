<?php

declare(strict_types=1);

use SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody\ErrorResponseBody;
use SixtyEightPublishers\CrawlerClient\Controller\Common\ValueObject\ValidationError;

return new ErrorResponseBody('The request data is not valid', [
    new ValidationError(
        ['property' => 'value', 'another_property' => 'another_value'],
        'Invalid value for field "test_param_1"',
        'test_param_1',
        'body',
    ),
    new ValidationError(
        'test',
        'Invalid value for field "test_param_2"',
        'test_param_2',
        'query',
    ),
], null);
