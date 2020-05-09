<?php

namespace LeoVie\GNATWrapper;

class GNATProve
{
    private string $projectFile;
    private int $cores = 0;
    private int $level = 0;
    private bool $dontStopAtFirstError = false;
    private string $analyzationFile;
    private GNATProveMode $mode;
    private GNATProveReportMode $reportMode;
    private bool $verbose;
    private bool $debug;
    private bool $strictAdaStandard;

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

    public function mode(GNATProveMode $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function reportMode(GNATProveReportMode $reportMode): self
    {
        $this->reportMode = $reportMode;

        return $this;
    }

    public function verbose(bool $verbose = true): self
    {
        $this->verbose = $verbose;

        return $this;
    }

    public function debug(bool $debug = true): self
    {
        $this->debug = $debug;

        return $this;
    }

    public function strictAdaStandard(bool $strictAdaStandard = true): self
    {
        $this->strictAdaStandard = $strictAdaStandard;

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
        if ($this->mode !== null) {
            $command .= ' --mode=' . $this->mode->getModeString();
        }
        if ($this->reportMode !== null) {
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