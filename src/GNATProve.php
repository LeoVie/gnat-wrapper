<?php

namespace LeoVie\GNATWrapper;

class GNATProve
{
    private string $projectFile;
    private int $cores = 0;
    private int $level = 0;
    private bool $dontStopAtFirstError = false;
    private string $analyzationFile;

    private string $command;

    private function __construct(string $projectFile)
    {
        $this->projectFile = $projectFile;
    }

    public static function create(string $projectFile): self
    {
        return new self($projectFile);
    }

    public function limitCoresTo(int $cores): self
    {
        $this->cores = $cores;

        return $this;
    }

    public function level(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function dontStopAtFirstError(bool $dontStopAtFirstError = true): self
    {
        $this->dontStopAtFirstError = $dontStopAtFirstError;

        return $this;
    }

    public function analyzeSingleFile(string $filename): self
    {
        $this->analyzationFile = $filename;

        return $this;
    }

    public function execute(): string
    {
        $this->buildCommand();
        return shell_exec($this->command);
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    private function buildCommand(): void
    {
        $command = 'gnatprove';
        $command .= ' -P "' . realpath($this->projectFile) . '"';
        $command .= ' -j' . $this->cores;
        $command .= ' --level=' . $this->level;
        if ($this->analyzationFile !== '') {
            $command .= ' -u ' . $this->analyzationFile;
        }
        if ($this->dontStopAtFirstError) {
            $command .= ' -k';
        }

        $this->command = $command;
    }
}