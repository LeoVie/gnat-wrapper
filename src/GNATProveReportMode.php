<?php

namespace LeoVie\GNATWrapper;

class GNATProveReportMode
{
    public const FAIL = 'fail';
    public const ALL = 'all';
    public const PROVERS = 'provers';
    public const STATISTICS = 'statistics';

    private string $mode;

    private function __construct(string $mode)
    {
        $this->mode = $mode;
    }

    public static function fail(): self
    {
        return new self(self::FAIL);
    }

    public static function all(): self
    {
        return new self(self::ALL);
    }

    public static function provers(): self
    {
        return new self(self::PROVERS);
    }

    public static function statistics(): self
    {
        return new self(self::STATISTICS);
    }

    public function getModeString(): string
    {
        return $this->mode;
    }
}