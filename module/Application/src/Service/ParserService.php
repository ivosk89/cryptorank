<?php

namespace Application\Service;

require_once('phpQuery/phpQuery-onefile.php');

class ParserService
{
    private const SELENIUM_SCRIPT = 'public/js/selenium/cryptorank.coin-tags.js';

    private const BASE_URL = 'https://cryptorank.io';

    private const COINS_URL = '/all-coins-list';


    public function __construct()
    {
    }

    public function request(): array
    {
        $topCoins = $this->getTopCoins();
        if (!empty($topCoins)) {
            foreach ($topCoins as $n => $coin) {
                $topCoins[$n]['timestamp'] = (new \DateTime())->format('m.d.Y H:i:s');
                if (!empty($coin['link'])) {
                    $topCoins[$n]['tags'] = [];
                    if ($parseCoinPage = $this->seleniumGetCoinPage($coin['link'])) {
                        $topCoins[$n]['tags'] = $this->getCoinTags($parseCoinPage);
                    }
                }
            }
        }

        return $topCoins;
    }

    private function getTopCoins(): array
    {
        $html = file_get_contents(static::BASE_URL . static::COINS_URL);
        $dom = \phpQuery::newDocument($html);

        $topCoins = [];
        $coinsTable = $dom->find('.data-table__table-content:first tbody tr');
        foreach ($coinsTable as $tr) {
            if (count($topCoins) == 3) {
                break;
            }

            $trDom = pq($tr);
            $name = $trDom->find('td:eq(1) > div:eq(0)');
            $topCoins[] = [
                'name' => $name->attr('title'),
                'link' => $name->children('a:eq(0)')->attr('href')
            ];
        }

        \phpQuery::unloadDocuments();

        return $topCoins;
    }

    private function seleniumGetCoinPage(string $url): string
    {
        $parseCoinPage = shell_exec('node ' . static::SELENIUM_SCRIPT .' '. static::BASE_URL . $url);

        return $parseCoinPage ?? '';
    }

    private function getCoinTags(string $parseCoinPage): array
    {
        $dom = \phpQuery::newDocument($parseCoinPage);
        $tagsList = $dom->find('div[class*="ContainerCoinLabel-sc"]:eq(0)')
            ->children()
            ->text();

        $tags = array_filter(explode(PHP_EOL, $tagsList));
        foreach ($tags as $n => $tag) {
            if ($tag == 'View All') {
                unset($tags[$n]);
                $additionalTagsList = $dom->find('div[class*="tags-modal__ModalStyled-sc"]:eq(0) a[class*="styled__CoinLabel-sc"]');
                if ($additionalTagsList = $additionalTagsList->text()) {
                    $additionalTags = array_filter(explode(PHP_EOL, $additionalTagsList));
                }
            }
        }

        \phpQuery::unloadDocuments();

        return array_values(
            array_unique(
                array_merge(
                    $tags ?? [],
                    $additionalTags ?? []
                )
            )
        );
    }

}