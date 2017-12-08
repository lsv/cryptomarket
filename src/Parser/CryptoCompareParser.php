<?php

namespace App\Parser;

use App\Entity\MarketPrice;
use App\ParserException;
use App\ParserInterface;

class CryptoCompareParser implements ParserInterface
{
    public const PARSER_NAME = 'cryptocompare';

    private static $market = 'https://min-api.cryptocompare.com/data/price?fsym=%coin%&tsyms=%currency%';

    /**
     * Parse the input.
     *
     * @param string $coin
     * @param string $currency
     * @param int    $currencyDecimals
     *
     * @return MarketPrice
     *
     * @throws \App\ParserException
     */
    public function parse(string $coin, string $currency, int $currencyDecimals): MarketPrice
    {
        $url = str_replace(
            ['%coin%', '%currency%'],
            [$coin, $currency],
            self::$market
        );

        $json = json_decode(file_get_contents($url));
        if (isset($json->{$currency})) {
            $price = $json->{$currency};
            $price *= (int) '1'.str_repeat(0, $currencyDecimals);

            return new MarketPrice($coin, $price, $currency, $currencyDecimals, $this->getName());
        }

        throw new ParserException('Currency "'.$currency.'" not supported');
    }

    /**
     * The name of the parser.
     *
     * @return string
     */
    public function getName(): string
    {
        return self::PARSER_NAME;
    }
}
