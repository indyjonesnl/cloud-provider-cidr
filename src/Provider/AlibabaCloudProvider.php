<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;

final readonly class AlibabaCloudProvider extends AbstractProvider
{
    public function getName(): string
    {
        return 'alibaba';
    }

    public function getCidrList(): iterable
    {
        $content = $this->getContent('https://whois.ipip.net/AS37963');
        $crawler = new Crawler($content);
        $texts = $crawler->filterXPath('//table/tr/td[1]/a/text()');

        $cidrList = [];

        /** @var \DOMText $text */
        foreach ($texts as $text) {
            if (preg_match(self::IP_REGEX, $text->textContent, $matches)) {
                $cidrList[] = $matches[0];
            }
        }

        sort($cidrList);

        return $cidrList;
    }
}