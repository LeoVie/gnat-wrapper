<?php

namespace LeoVie\GNATWrapper\GNATPP;

class GNATPP
{
    private string $file;
    private string $command;

    private function __construct(string $file)
    {
        $this->file = $file;
        $this->buildCommand();
    }

    public static function create(string $file): self
    {
        return new self($file);
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function execute(): string
    {
        return shell_exec($this->command);
    }

    private function buildCommand(): void
    {
        $command = 'gnatpp ' . realpath($this->file);

        $this->command = $command;
    }
}