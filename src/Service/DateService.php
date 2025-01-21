<?php

namespace App\Service;

use Carbon\Carbon;
use DateTime;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DateService extends AbstractExtension
{
    private RequestStack $requestStack;
    private TranslatorInterface $translatorInterface;

    public function __construct(RequestStack $requestStack, TranslatorInterface $translatorInterface)
    {
        $this->requestStack = $requestStack;
        $this->translatorInterface = $translatorInterface;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_date', [$this, 'getDate']),
        ];
    }

    public function getDate(DateTime $startDate, DateTime|null $endDate, bool $showMonth = false): string
    {
        Carbon::setLocale($this->requestStack->getCurrentRequest()->getLocale());
        $startDateCarbon = new Carbon($startDate);
        $endDateCarbon = $endDate ? new Carbon($endDate) : null;
        $startDateString = $showMonth
            ? $startDateCarbon->getTranslatedShortMonthName() . " " . $startDateCarbon->format('Y')
            : $startDateCarbon->format('Y');
        $endDateString = null;
        if ($endDateCarbon !== null) {
            $endDateString = $showMonth
                ? $endDateCarbon->getTranslatedShortMonthName() . " " . $endDateCarbon->format('Y')
                : $endDateCarbon->format('Y');
        }

        if ($endDateString === null) {
            return $this->translatorInterface->trans("app.since", ['date' => $startDateString]);
        } else if ($startDateString === $endDateString) {
            return $this->translatorInterface->trans("app.during", ['date' => $startDateString]);
        } else {
            return $startDateString . ' - ' . $endDateString;
        }
    }
}