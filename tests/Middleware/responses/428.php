<?php

declare(strict_types=1);

use SixtyEightPublishers\CrawlerClient\Controller\Common\ResponseBody\ErrorResponseBody;

return new ErrorResponseBody('Precondition required, please specify the "If-Match" header', [], null);
