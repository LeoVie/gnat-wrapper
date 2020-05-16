<?php

namespace LeoVie\GNATWrapper\GNATProve;

class GNATProveMode
{
    public const CHECK = 'check';
    public const CHECK_ALL = 'check_all';
    public const FLOW = 'flow';
    public const PROVE = 'prove';
    public const ALL = 'all*';
    public const STONE = 'stone';
    public const BRONZE = 'bronze';
    public const SILVER = 'silver';
    public const GOLD = 'gold';

    private string $mode;

    private function __construct(string $mode)
    {
        $this->mode = $mode;
    }

    public static function check(): self
    {
        return new self(self::CHECK);
    }

    public static function checkAll(): self
    {
        return new self(self::CHECK_ALL);
    }

    public static function flow(): self
    {
        return new self(self::FLOW);
    }

    public static function prove(): self
    {
        return new self(self::PROVE);
    }

    public static function all(): self
    {
        return new self(self::ALL);
    }

    public static function stone(): self
    {
        return new self(self::STONE);
    }

    public static function bronze(): self
    {
        return new self(self::BRONZE);
    }

    public static function silver(): self
    {
        return new self(self::SILVER);
    }

    public static function gold(): self
    {
        return new self(self::GOLD);
    }

    public function getModeString(): string
    {
        return $this->mode;
    }
}