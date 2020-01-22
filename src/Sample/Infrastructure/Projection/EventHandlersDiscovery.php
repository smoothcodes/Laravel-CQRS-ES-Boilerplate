<?php

namespace SmoothCode\Sample\Infrastructure\Projection;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use SmoothCode\Sample\Infrastructure\Projection\EventHandler\EventHandler;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use function GuzzleHttp\Psr7\str;

class EventHandlersDiscovery {
    private array $directories = [];

    private string $basePath;

    private string $rootNamespace;

    private array $ignoredFiles = [];

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function within(array $directories): self
    {
        $this->directories = $directories;

        return $this;
    }

    public function usePath(string $basePath): self
    {
        $this->basePath = $basePath;

        return $this;
    }

    public function useNamespace(string $rootNamespace): self
    {
        $this->rootNamespace = $rootNamespace;

        return $this;
    }

    public function ignoreFiles(array $ignoredFiles): self
    {
        $this->ignoredFiles = $ignoredFiles;

        return $this;
    }

    public function addToProjectionist(Projectionist $projectionist)
    {
        if (empty($this->directories)) {
            return;
        }

        $files = (new Finder())->files()->in($this->directories);

        return collect($files)
            ->reject(fn (SplFileInfo $fileInfo) => in_array($fileInfo->getPathname(), $this->ignoredFiles))
            ->map(fn (SplFileInfo $fileInfo) => $this->fullQualifiedClassNameForFile($fileInfo))
            ->filter(fn (string $eventHandlerClass) => is_subclass_of($eventHandlerClass, EventHandler::class))
            ->pipe(fn (Collection $eventHandlers) => $projectionist->addEventHandlers($eventHandlers->toArray()));
    }

    private function fullQualifiedClassNameForFile(SplFileInfo $fileInfo): string
    {
        $class = trim(str_replace($this->basePath, '', $fileInfo->getRealPath()), DIRECTORY_SEPARATOR);

        $class = str_replace(
            [DIRECTORY_SEPARATOR, 'App\\'],
            ['\\', app()->getNamespace()],
            ucfirst(Str::replaceLast('.php', '', $class))
        );

        return $this->rootNamespace . $class;
    }
}
