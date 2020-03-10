<?php

namespace Dominio\Progetto\Model\ValueObject;

final class Stato
{
    private const KO = -1;
    private const OK = 1;

    private int $stato;

    /** @var array<int, int> */
    public static array $stati = [self::KO, self::OK];

    public function __construct(int $stato)
    {
        if (!\in_array($stato, self::$stati, true)) {
            throw new \InvalidArgumentException('Stato non valido.');
        }
        $this->stato = $stato;
    }

    public function getStato(): int
    {
        return $this->stato;
    }

    public function isOk(): bool
    {
        return self::OK === $this->stato;
    }
}
