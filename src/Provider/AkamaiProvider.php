<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;

final readonly class AkamaiProvider extends AbstractProvider
{
    /** @var string[] */
    private const array URLS = ['https://whois.ipip.net/AS63949', 'https://whois.ipip.net/AS20940'];
    private const string XPATH = '//div[@id="pills-ipv4"]//table//tr/td[1]/a/text()';

    public function getName(): string
    {
        return 'akamai';
    }

    public function getCidrList(): iterable
    {
        $cidrList = [];
        foreach(self::URLS as $url) {
            $content = $this->getContent($url);
            $crawler = new Crawler($content);
            $texts = $crawler->filterXPath(self::XPATH);

            foreach ($texts as $text) {
                $cidrList[] = $text->textContent;
            }
        }

        sort($cidrList);

        return $cidrList;
    }
}