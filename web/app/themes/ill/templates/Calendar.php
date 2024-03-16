<?php

use Carbon\Carbon;
require 'vendor/autoload.php';

class Calendar
{
    private $dt, $now;
    public $weekdays, $dayweeks, $status, $year, $month, $this_dt;

    public function __construct($which, $status)
    {
        $this->dt = Carbon::today("Asia/Tokyo")->addHour(9);
        $this->now = Carbon::now("Asia/Tokyo");
        $this->status = $this->setStatus($which, $status);
        $this->weekdays = $this->setWeekDays();
        $this->dayweeks = $this->setDayWeeks($this->weekdays);
        $this->this_dt = $this->dt;
        // $this->reserve = Reserve::whereBetween("reserve_dt", [$this->now, $this->dt->copy()->addDay(6)->addMinute(810)])->get();
    }

    private function setStatus($which, $state)
    {
        //現在の値を吟味し、何日ずらして表示するか
        //which どちらを押したか
        //state 現在から何週間進んだか
        $value = 0;
        if ($which === "plus") {
            $value = $state + 1;
            $this->dt->addDay($value * 7);
        } else if ($which === "minus") {
            $value = $state - 1;
            $this->dt->addDay($value * 7);
        } else {
            $value;
        }

        return $value;
    }

    private function setWeekDays()
    {
        $list = array();
        for ($day = 0; $day < 7; $day++) {
            array_push(
                $list,
                $this->dt->copy()->addDay($day)
            );
        }
        return $list;
    }

    private function setDayWeeks($weekdays)
    {
        $dayweeks = array();
        //曜日を決定してリストに格納
        foreach ($weekdays as $wd) {
            if ($wd->dayOfWeek === 1) {
                array_push($dayweeks, "月");
            } else if ($wd->dayOfWeek === 2) {
                array_push($dayweeks, "火");
            } else if ($wd->dayOfWeek === 3) {
                array_push($dayweeks, "水");
            } else if ($wd->dayOfWeek === 4) {
                array_push($dayweeks, "木");
            } else if ($wd->dayOfWeek === 5) {
                array_push($dayweeks, "金");
            } else if ($wd->dayOfWeek === 6) {
                array_push($dayweeks, "土");
            } else {
                array_push($dayweeks, "日");
            }
        }
        return $dayweeks;
    }

    public function outSchedule()
    {
        $schedule = array();
        global $wpdb;

        for ($min = 0; $min < 27; $min++) {
            $minutes = $min * 30;
            $datetimes = array();
            $states = array();
            for ($day = 0; $day < 7; $day++) {
                $past = $this->dt->copy()->addMinute($minutes)->addDay($day);
                $day === 0 ? $this->this_dt = $past : null;
                global $wpdb;
                $reserve = $this->outputDb($past);
                array_push($datetimes, $past);
                if ($reserve === true) {
                    //予約がすでにあるということなのでfalse確定
                    array_push($states, false);
                } else {
                    //現在時刻よりも前ならfalse
                    array_push($states, $past->isFuture());
                }
            }
            $data = [
                'state' => $states,
                'dt' => $datetimes,
            ];
            $data += array('dt' => $datetimes, 'state' => $past);
            array_push($schedule, $data);
        }
        return $schedule;
    }

    public function outputDb($params)
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM reserves");
        // var_dump($result);
        foreach($result as $item){
            $mysqldt = new Carbon("$item->reserve_dt", "Asia/Tokyo");
            if ($params->eq($mysqldt)){
                return true;
            } else {
                continue;
            }
        };

        return false;
    }
}