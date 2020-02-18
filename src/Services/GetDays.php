<?php


namespace App\Services;


class GetDays
{
    public function getDatesBetween($start, $end)
    {
        if ($start > $end) {
            return false;
        }

        $sdate = strtotime("$start +1 day");
        $edate = strtotime($end);

        $dates = array();

        for ($i = $sdate; $i < $edate; $i += strtotime('+1 day', 0)) {
            $dates[] = date('Y-m-d', $i);
        }

        array_unshift($dates, $start);
        array_push($dates, $end);
        return $dates;
    }
}