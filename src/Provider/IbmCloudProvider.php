<?php

namespace App\Provider;

use Symfony\Component\DomCrawler\Crawler;

final readonly class IbmCloudProvider extends AbstractProvider
{
    public function getName(): string
    {
        return 'ibm';
    }

    public function getCidrList(): iterable
    {
        $crawler = new Crawler(
            $this->getContent('https://cloud.ibm.com/docs-content/v4/content/e8d2280c93ad2597d17c50f3f0581e24dd501960/infrastructure-hub/ips.html'),
        );
        $tableData = $crawler->filterXPath('//table//td');

        $cidrList = [];

        /** @var \DOMElement[] $tableData */
        foreach ($tableData as $td) {
            if (preg_match('/([0-9]{1,3}\.){3}[0-9]{1,3}($|\/([1-9]|[12][0-9]|3[012]))/', $td->textContent, $matches)) {
                if (!str_starts_with($matches[0], '10.')) {
                    $cidrList[] = $matches[0];
                }
            }
        }

        sort($cidrList);

        return $cidrList;
    }
}