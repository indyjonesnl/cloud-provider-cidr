<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.cidr.provider')]
interface ProviderInterface
{
    public function getName(): string;

    /** @return string[] */
    public function getCidrList(): iterable;

    /** @return int Number of CIDR addresses downloaded. */
    public function downloadToFile(string $filename): int;
}