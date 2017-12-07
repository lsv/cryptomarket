<?php

namespace App;

use App\Entity\MarketPrice;

interface ParserInterface
{

    /**
     * Parse the input
     *
     * @param string $coin
     * @param string $currency
     * @param int $currencyDecimals
     *
     * @return MarketPrice
     */
    public function parse(string $coin, string $currency, int $currencyDecimals): MarketPrice;

    /**
     * The name of the parser
     *
     * @return string
     */
    public function getName(): string;

}