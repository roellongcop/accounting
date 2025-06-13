<?php
namespace tests\unit\helpers;

use app\helpers\Url;

class UrlTest extends \Codeception\Test\Unit
{
    public function testIsExternal()
    {
        $this->assertTrue(Url::isExternal('https://example.com')); 
        $this->assertFalse(Url::isExternal('/relative/path')); 
    }

    public function testIsLink()
    {
        $this->assertTrue(Url::isLink('https://example.com')); 
        $this->assertFalse(Url::isLink('not a link')); 
    }
}
