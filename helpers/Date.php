<?php

namespace app\helpers;

class Date
{
	public static function currentDateAndTime($format='Y-m-d H:i:s', $timezone='')
	{
    $timezone = $timezone ?: App::setting('system')->timezone;
		$dateTimezone = new \DateTimeZone($timezone);
    $dateTime = new \DateTime('now', $dateTimezone);
    return $dateTime->format($format);
	}
}