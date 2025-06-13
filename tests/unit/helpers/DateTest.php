<?php
namespace tests\unit\helpers;

use app\helpers\Date;
use app\helpers\App;

class DateTest extends \Codeception\Test\Unit
{
    public function testCurrentDateAndTimeWithCustomTimezone()
    {
        $actual = Date::currentDateAndTime('Y-m-d H:i', 'UTC');
        $expected = (new \DateTime('now', new \DateTimeZone('UTC')))->format('Y-m-d H:i');
        $this->assertEquals($expected, $actual);
    }

    public function testCurrentDateAndTimeDefaultTimezone()
    {
        $timezone = App::setting('system')->timezone;
        $actual = Date::currentDateAndTime('Y-m-d H:i');
        $expected = (new \DateTime('now', new \DateTimeZone($timezone)))->format('Y-m-d H:i');
        $this->assertEquals($expected, $actual);
    }
}
