<?php

namespace LeoVie\GNATWrapper\GNATProve;

class GNATProve
{
    private string $projectFile;
    private int $cores = 0;
    private int $level = 0;
    private bool $dontStopAtFirstError = false;
    private string $analyzationFile;
    private GNATProveMode $mode;
    private GNATProveReportMode $reportMode;
    private bool $verbose = false;
    private bool $debug = false;
    private bool $strictAdaStandard = false;

    private string $command;

    private function __construct(string $projectFile)
    {
        $this->projectFile = $projectFile;
        $this->buildCommand();
    }

    public static function create(string $projectFile): self
    {
        return new self($projectFile);
    }

    public function limitCoresTo(int $cores): self
    {
        $this->cores = $cores;
        $this->buildCommand();

        return $this;
    }

    public function level(int $level): self
    {
        $this->level = $level;
        $this->buildCommand();

        return $this;
    }

    public function dontStopAtFirstError(bool $dontStopAtFirstError = true): self
    {
        $this->dontStopAtFirstError = $dontStopAtFirstError;
        $this->buildCommand();

        return $this;
    }

    public function analyzeSingleFile(string $filename): self
    {
        $this->analyzationFile = $filename;
        $this->buildCommand();

        return $this;
    }

    public function mode(GNATProveMode $mode): self
    {
        $this->mode = $mode;
        $this->buildCommand();

        return $this;
    }

    public function reportMode(GNATProveReportMode $reportMode): self
    {
        $this->reportMode = $reportMode;
        $this->buildCommand();

        return $this;
    }

    public function verbose(bool $verbose = true): self
    {
        $this->verbose = $verbose;
        $this->buildCommand();

        return $this;
    }

    public function debug(bool $debug = true): self
    {
        $this->debug = $debug;
        $this->buildCommand();

        return $this;
    }

    public function strictAdaStandard(bool $strictAdaStandard = true): self
    {
        $this->strictAdaStandard = $strictAdaStandard;
        $this->buildCommand();

        return $this;
    }

    public function execute(): string
    {
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
        if (isset($this->analyzationFile)) {
            $command .= ' -u ' . $this->analyzationFile;
        }
        if ($this->dontStopAtFirstError) {
            $command .= ' -k';
        }
        if (isset($this->mode)) {
            $command .= ' --mode=' . $this->mode->getModeString();
        }
        if (isset($this->reportMode)) {
            $command .= ' --report=' . $this->reportMode->getModeString();
        }
        if ($this->verbose) {
            $command .= ' --verbose';
        }
        if ($this->debug) {
            $command .= ' --debug';
        }
        if ($this->strictAdaStandard) {
            $command .= ' --pedantic';
        }

        $this->command = $command;
    }
}