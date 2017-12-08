<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarketPriceRepository")
 * @ORM\Table(name="market_price",
 *     indexes={
 *      @ORM\Index(name="type", columns={"type"}),
 *      @ORM\Index(name="price", columns={"price"}),
 *      @ORM\Index(name="date", columns={"date"})
 *     }
 * )
 */
class MarketPrice
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string")
     */
    private $currency;

    /**
     * @var int
     *
     * @ORM\Column(name="decimals", type="integer")
     */
    private $decimals;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="triggered", type="integer")
     */
    private $triggered = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="parser", type="string")
     */
    private $parser;

    /**
     * @param string      $type
     * @param int         $price
     * @param string      $currency
     * @param int|null    $decimals
     * @param string|null $parser
     */
    public function __construct(string $type = null, int $price = null, string $currency = null, int $decimals = null, string $parser = null)
    {
        $this->date = new \DateTime();
        $this->type = $type;
        $this->price = $price;
        $this->currency = $currency;
        $this->decimals = $decimals;
        $this->parser = $parser;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return MarketPrice
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     *
     * @return MarketPrice
     */
    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return MarketPrice
     */
    public function setCurrency($currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return int
     */
    public function getDecimals(): int
    {
        return $this->decimals;
    }

    /**
     * @param int $decimals
     *
     * @return MarketPrice
     */
    public function setDecimals(int $decimals): self
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return MarketPrice
     */
    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return int
     */
    public function getTriggered(): int
    {
        return $this->triggered;
    }

    /**
     * @param int $triggered
     *
     * @return MarketPrice
     */
    public function setTriggered(int $triggered): self
    {
        $this->triggered = $triggered;

        return $this;
    }

    /**
     * @return MarketPrice
     */
    public function addTrigger(): self
    {
        ++$this->triggered;

        return $this;
    }

    /**
     * @return string
     */
    public function getParser(): string
    {
        return $this->parser;
    }

    /**
     * @param string $parser
     *
     * @return MarketPrice
     */
    public function setParser(string $parser): self
    {
        $this->parser = $parser;

        return $this;
    }
}
