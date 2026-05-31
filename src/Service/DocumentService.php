<?php

namespace App\Service;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DocumentService extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('file_exists', [$this, 'fileExists']),
        ];
    }

    public function fileExists(string $filename): bool
    {
        return file_exists(getcwd() . $filename);
    }
}
