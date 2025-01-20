<?php

namespace App\Service;

use DateTime;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DateService extends AbstractExtension
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_date', [$this, 'getDate']),
        ];
    }

    public function getDate(DateTime $startDate, DateTime|null $endDate, bool $showMonth = false): string
    {
        if ($endDate === null) {
            switch ($this->requestStack->getCurrentRequest()->getLocale()) {
                case "en":
                    return "Since " . ($showMonth ? $startDate->format("M. Y") : $startDate->format("Y"));
                default:
                    return "Depuis " . ($showMonth ? $startDate->format("M. Y") : $startDate->format("Y"));
            }
        }

        if (
            $startDate->format("Y") === $endDate->format("Y")
            || $startDate->format("Y m") === $endDate->format("Y m") && $showMonth
        ) {
            switch ($this->requestStack->getCurrentRequest()->getLocale()) {
                case "en":
                    return "During " . ($showMonth ? $startDate->format("M. Y") : $startDate->format("Y"));
                default:
                    return "En " . ($showMonth ? $startDate->format("M. Y") : $startDate->format("Y"));
            }
        } else {
            if ($showMonth) {
                return $startDate->format("M. Y") . ' - ' . $endDate->format("M. Y");
            } else {
                return $startDate->format("Y") . ' - ' . $endDate->format("Y");
            }
        }
    }
}