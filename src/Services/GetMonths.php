<?php

namespace App\Model;

class GetMonths
{
    /**
     * Gets list of months between two dates
     * $start date format Y-m-d
     * $end date format Y-m-d
     * @return array
     */
    public function intervalDate($start, $end)
    {
        $ret = array();

        $monthStart = date_parse($start)['month'];
        $yearStart = date_parse($start)['year'];
        $monthEnd = date_parse($end)['month'];
        $yearEnd = date_parse($end)['year'];

        $monthCurrent = $monthStart;
        $yearCurrent = $yearStart;

        while ($yearCurrent < $yearEnd) { // 2018 < 2020
            while ($monthCurrent <= 12) {
                array_push($ret, $yearCurrent . '-' . $monthCurrent . '-01');
                $monthCurrent = $monthCurrent + 1;
            }
            $yearCurrent = $yearCurrent + 1;
            $monthCurrent = 1;
        }

        while ($monthCurrent <= $monthEnd) {
            array_push($ret, $yearCurrent . '-' . $monthCurrent . '-01');
            $monthCurrent = $monthCurrent + 1;
        }

        return $ret;
    }

    public function DateBounds($date)
    {
        $time = mktime(0, 0, 0, date_parse($date)['month'], 1, date_parse($date)['year']);
        $lowerBound = date('Y-m-d', $time);

        $time = mktime(0, 0, 0, date_parse($date)['month'] + 1, 1, date_parse($date)['year']);
        $time--; // Recule d'une seconde
        $upperBound = date('Y-m-d', $time);

        return [$lowerBound, $upperBound];
    }

    public function isSooner($date1, $date2)
    {
//        var_dump('on compare ', $date1, ' avec ', $date2);
        $date1 = mktime(0, 0, 0, date_parse($date1)['month'], date_parse($date1)['day'], date_parse($date1)['year']);
        $date2 = mktime(0, 0, 0, date_parse($date2)['month'], date_parse($date2)['day'], date_parse($date2)['year']);
        if ($date1 < $date2) {
            $compare = -1;
        } else {
            $compare = 1;
        };

        return $compare;
    }
}