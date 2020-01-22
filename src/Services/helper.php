<?php

class date
{
    public $dateFR = '';
    public $dateUS = '';

    Const DT_format = "%d %b %Y";

    public function dateFR($oldDate)
    {
        $this->dateUS = $oldDate;
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
        $this->dateFR = strftime(self::DT_format, strtotime($oldDate));
    }
}
