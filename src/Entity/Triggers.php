<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TriggersRepository")
 * @ORM\Table(name="triggers",
 *     indexes={
 *      @ORM\Index(name="coin", columns={"coin"}),
 *      @ORM\Index(name="date", columns={"date"})
 *     }
 * )
 */
class Triggers
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
     * @ORM\Column(name="coin", type="string")
     */
    private $coin;

    /**
     * @var string
     *
     * @ORM\Column(name="market", type="string")
     */
    private $parser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @param string|null $coin
     * @param string|null $parser
     */
    public function __construct(string $coin = null, string $parser = null)
    {
        $this->date = new \DateTime();
        $this->coin = $coin;
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
    public function getCoin(): string
    {
        return $this->coin;
    }

    /**
     * @param string $coin
     *
     * @return Triggers
     */
    public function setCoin(string $coin): self
    {
        $this->coin = $coin;

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
     * @return Triggers
     */
    public function setParser(string $parser): self
    {
        $this->parser = $parser;

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
     * @return Triggers
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }
}
