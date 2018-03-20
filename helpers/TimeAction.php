<?php

namespace app\helpers;


class TimeAction 
{
    public static function timeToSecond($time)
    {
        $part = explode(':', $time);
        $second = $part[0]*3600 + $part[1]*60 + $part[2];
        return $second;
    }
    
    public static function secondToTime($second)
    {
        $hours = intdiv($second, 3600);
        $minutes = intdiv(($second - $hours*3600), 60);
        $seconds = $second - $hours*3600 - $minutes*60;
        
        return date('H:i:s', mktime($hours,$minutes,$seconds));
    }
}
