<?php

namespace App;

class ParserService
{
    /**
     * @var ParserInterface[]
     */
    private $parsers = [];

    /**
     * @param ParserInterface $parser
     */
    public function addParser(ParserInterface $parser): void
    {
        $this->parsers[$parser->getName()] = $parser;
    }

    /**
     * @param string $name
     * @param string $coin
     * @param string $currency
     * @param int    $decimals
     *
     * @return Entity\MarketPrice
     *
     * @throws ParserException
     */
    public function getParser($name, $coin, $currency, $decimals): Entity\MarketPrice
    {
        if (!isset($this->parsers[$name])) {
            throw new ParserException('Parser "'.$name.'" not found');
        }

        return $this->parsers[$name]->parse($coin, $currency, $decimals);
    }
}
