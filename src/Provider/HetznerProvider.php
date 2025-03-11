<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;

final readonly class HetznerProvider extends AbstractProvider
{
    private const string URL = 'https://whois.ipip.net/AS24940';

    private const string XPATH = '//div[@id="pills-ipv4"]//table//tr/td[contains(text(),"Hetzner Online GmbH")]/../td[1]/a/text()';

    public function getName(): string
    {
        return 'hetzner';
    }

    public function getCidrList(): iterable
    {
        $content = $this->getContent(self::URL);
        $crawler = new Crawler($content);
        $elements = $crawler->filterXPath(self::XPATH);

        $cidrList = [];
        foreach ($elements as $element) {
            $cidrList[] = $element->textContent;
        }

        sort($cidrList);

        return $cidrList;
    }
}