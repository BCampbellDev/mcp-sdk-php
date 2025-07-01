<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\DowngradeSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->skip([
        __DIR__ . '/vendor'
                        ]);
    $rectorConfig->paths([
        __DIR__

    ]);

    $rectorConfig->sets([
        DowngradeSetList::PHP_81,
        DowngradeSetList::PHP_80,
        DowngradeSetList::PHP_74
    ]);
};
