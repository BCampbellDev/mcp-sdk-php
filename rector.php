<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\DowngradeSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/examples',
        __DIR__ . '/webclient',
    ]);


    $rectorConfig->sets([
        DowngradeSetList::PHP_81,
        DowngradeSetList::PHP_80,
        DowngradeSetList::PHP_74
    ]);
};
