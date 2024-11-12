<?php

namespace App\Service;

use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AgeService extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_age', [$this, 'getAge']),
        ];
    }
    public function getAge(): int
    {
        $birthdayDate = new DateTime('1999-10-28');
        $date = new DateTime();
        $diff = $date->diff($birthdayDate);

        return $diff->y;
    }
}