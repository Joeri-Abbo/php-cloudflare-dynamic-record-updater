<?php

namespace CloudFlareDynamicDnsUpdater\Tests;

use CloudFlareDynamicDnsUpdater\DNSRecord;
use PHPUnit\Framework\TestCase;

class DNSRecordTest extends TestCase
{
    public function testConstructorDefaults(): void
    {
        $record = new DNSRecord(DNSRecord::TYPE_A, 'example.com', '1.2.3.4');
        $this->assertSame('example.com', $record->getName());
        $this->assertSame('1.2.3.4', $record->getContent());
        $this->assertSame(1, $record->getTtl());
        $this->assertTrue($record->getProxied());
    }

    public function testGetTypeReturnsValidType(): void
    {
        $record = new DNSRecord(DNSRecord::TYPE_A, 'example.com', '1.2.3.4');
        $this->assertSame('A', $record->getType());
    }

    public function testGetTypeThrowsOnInvalidType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $record = new DNSRecord('INVALID', 'example.com', '1.2.3.4');
        $record->getType();
    }

    public function testGetRecordReturnsExpectedArray(): void
    {
        $record = new DNSRecord(DNSRecord::TYPE_AAAA, 'sub.example.com', '::1', 300, false);
        $expected = [
            'type' => 'AAAA',
            'name' => 'sub.example.com',
            'content' => '::1',
            'ttl' => 300,
            'proxied' => false,
        ];
        $this->assertSame($expected, $record->getRecord());
    }

    public function testAllTypeConstantsAreValid(): void
    {
        $types = [
            DNSRecord::TYPE_A, DNSRecord::TYPE_AAAA, DNSRecord::TYPE_CAA,
            DNSRecord::TYPE_CERT, DNSRecord::TYPE_CNAME, DNSRecord::TYPE_DS,
            DNSRecord::TYPE_HTTPS, DNSRecord::TYPE_LOC, DNSRecord::TYPE_MX,
            DNSRecord::TYPE_NAPTER, DNSRecord::TYPE_NS, DNSRecord::TYPE_PTR,
            DNSRecord::TYPE_SMIMEA, DNSRecord::TYPE_SPF, DNSRecord::TYPE_SRV,
            DNSRecord::TYPE_SSHFP, DNSRecord::TYPE_SVCB, DNSRecord::TYPE_TLSA,
            DNSRecord::TYPE_TXT, DNSRecord::TYPE_URI,
        ];

        foreach ($types as $type) {
            $record = new DNSRecord($type, 'example.com', 'value');
            $this->assertSame($type, $record->getType());
        }
    }
}
