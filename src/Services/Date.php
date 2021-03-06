<?php

namespace App\Services;

use DateTime;

class Date
{
    public $dateFR = '';
    public $dateUS = '';

    Const DT_format = "%d %b %Y";

    /**
     * @param $oldDate
     * @return string
     */
    public function dateFR($oldDate)
    {
        $this->dateUS = $oldDate;
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
        $this->dateFR = strftime(self::DT_format, strtotime($oldDate));
        return $this->dateFR;
    }

    /**
     * @param $oldDate
     * @return string
     * @throws \Exception
     * Give the month and the year in Letters from a given date
     */
    public function MonthYear($oldDate)
    {
        $date = new DateTime($oldDate);
        $date = $date->getTimestamp();

        $month = date('F', $date);
        $year = date('Y', $date);
        return $month . ' ' . $year;
    }
}