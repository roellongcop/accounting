<?php

namespace app\helpers;

class Date
{
	public static function currentDateAndTime($format='Y-m-d H:i:s', $timezone='UTC')
	{
		$utc = new \DateTimeZone($timezone);
    $dateTime = new \DateTime('now', $utc);
    return $dateTime->format($format);
	}
}