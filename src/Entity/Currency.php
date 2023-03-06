<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;
use Money\Money;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
#[ORM\UniqueConstraint(name: "currency_code_idx", columns: ["currency_code"])]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 50)]
    private string $name;

    #[ORM\Column(length: 10)]
    private string $currencyCode;

    #[ORM\Column]
    private Money $exchangeRate;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    public function getExchangeRate(): Money
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(Money $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
    }
}
