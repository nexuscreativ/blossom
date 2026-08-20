<?php

declare(strict_types=1);

namespace App\ValueObjects;

final readonly class Money
{
    public function __construct(
        private int $amount,
        private string $currency = 'NGN',
    ) {
        if ($this->amount < 0) {
            throw new \InvalidArgumentException('Money amount cannot be negative');
        }
    }

    public static function fromNaira(float $naira): self
    {
        return new self((int) round($naira * 100));
    }

    public static function fromKobo(int $kobo): self
    {
        return new self($kobo);
    }

    public function toInt(): int
    {
        return $this->amount;
    }

    public function toNaira(): float
    {
        return $this->amount / 100;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function formatted(): string
    {
        return $this->currency . ' ' . number_format($this->toNaira(), 2);
    }
}
