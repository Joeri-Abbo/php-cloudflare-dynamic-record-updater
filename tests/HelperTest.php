<?php

namespace CloudFlareDynamicDnsUpdater\Tests;

use CloudFlareDynamicDnsUpdater\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testGetExternalIPReturnsString(): void
    {
        $ip = Helper::getExternalIP();
        $this->assertIsString($ip);
        $this->assertNotEmpty($ip);
    }
}
