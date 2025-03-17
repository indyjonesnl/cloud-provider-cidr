<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;

abstract readonly class IpipProvider extends AbstractProvider
{
    /** @return string[] */
    abstract public function getUrls(): array;

    protected function getXpath(): string
    {
        return '//div[@id="pills-ipv4"]//table/tr/td[1]/a/text()';
    }

    public function getCidrList(): iterable
    {
        $cidrList = [];
        foreach($this->getUrls() as $url) {
            $content = $this->getContent($url);
            $crawler = new Crawler($content);
            $texts = $crawler->filterXPath($this->getXpath());

            foreach ($texts as $text) {
                $cidrList[] = $text->textContent;
            }
        }

        sort($cidrList);

        return $cidrList;
    }
}