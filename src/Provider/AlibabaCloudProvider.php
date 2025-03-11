<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;

final readonly class AlibabaCloudProvider extends AbstractProvider
{
    private const string XPATH = '//div[@id="pills-ipv4"]//table/tr/td[1]/a/text()';
    private const string URL = 'https://whois.ipip.net/AS37963';

    public function getName(): string
    {
        return 'alibaba';
    }

    public function getCidrList(): iterable
    {
        $content = $this->getContent(self::URL);
        $crawler = new Crawler($content);
        $texts = $crawler->filterXPath(self::XPATH);

        $cidrList = [];

        foreach ($texts as $text) {
            $cidrList[] = $text->textContent;
        }

        sort($cidrList);

        return $cidrList;
    }
}