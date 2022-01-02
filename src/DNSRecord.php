<?php

namespace CloudFlareDynamicDnsUpdater;

class DNSRecord
{
    /**
     * Type of records
     */
    private const TYPES = [
        self::TYPE_A,
        self::TYPE_AAAA,
        self::TYPE_CAA,
        self::TYPE_CERT,
        self::TYPE_CNAME,
        self::TYPE_DS,
        self::TYPE_HTTPS,
        self::TYPE_LOC,
        self::TYPE_MX,
        self::TYPE_NAPTER,
        self::TYPE_NS,
        self::TYPE_PTR,
        self::TYPE_SMIMEA,
        self::TYPE_SPF,
        self::TYPE_SRV,
        self::TYPE_SSHFP,
        self::TYPE_SVCB,
        self::TYPE_TLSA,
        self::TYPE_TXT,
        self::TYPE_URI
    ];

    /**
     * Record types
     */
    public const TYPE_A = 'A';
    public const TYPE_AAAA = 'AAAA';
    public const TYPE_CAA = 'CAA';
    public const TYPE_CERT = 'CERT';
    public const TYPE_CNAME = 'CNAME';
    public const TYPE_DS = 'DS';
    public const TYPE_HTTPS = 'HTTPS';
    public const TYPE_LOC = 'LOC';
    public const TYPE_MX = 'MX';
    public const TYPE_NAPTER = 'NAPTER';
    public const TYPE_NS = 'NS';
    public const TYPE_PTR = 'PTR';
    public const TYPE_SMIMEA = 'SMIMEA';
    public const TYPE_SPF = 'SPF';
    public const TYPE_SRV = 'SRV';
    public const TYPE_SSHFP = 'SSHFP';
    public const TYPE_SVCB = 'SVCB';
    public const TYPE_TLSA = 'TLSA';
    public const TYPE_TXT = 'TXT';
    public const TYPE_URI = 'URI';

    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $content;
    /**
     * @var int
     */
    private $ttl;
    /**
     * @var bool
     */
    private $proxied;

    /**
     * DNSRecord constructor.
     * @param string|null $type
     * @param string|null $name
     * @param string|null $content
     * @param int $ttl
     * @param bool $proxied
     */
    public function __construct(string $type = null, string $name = null, string $content = null, int $ttl = 1, bool $proxied = true)
    {
        $this->type = $type;
        $this->name = $name;
        $this->content = $content;
        $this->ttl = $ttl;
        $this->proxied = $proxied;
    }

    /**
     * Get the name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the name
     * @return string
     */
    public function setName(): string
    {
        return $this->name;
    }

    /**
     * Get the content
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the content
     * @return string
     */
    public function setContent(): string
    {
        return $this->content;
    }

    /**
     * Get the ttl
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * Set the ttl
     * @return int
     */
    public function setTtl(): int
    {
        return $this->ttl;
    }

    /**
     * Get the proxied
     * @return bool
     */
    public function getProxied(): bool
    {
        return $this->proxied;
    }

    /**
     * Set the proxied
     * @return bool
     */
    public function setProxied(): bool
    {
        return $this->proxied;
    }

    /**
     * Get the type
     * @return string
     */
    public function getType(): string
    {
        return in_array($this->type, self::TYPES) ? $this->type : dd('no valid type for record');
    }

    /**
     * Set the type
     * @return string
     */
    public function setType(): string
    {
        return in_array($this->type, self::TYPES) ? $this->type : dd('no valid type for record');
    }

    /**
     * Get the record
     * @return array
     */
    public function getRecord(): array
    {
        return [
            'type' => $this->getType(),
            'name' => $this->getName(),
            'content' => $this->content,
            'ttl' => $this->ttl,
            'proxied' => $this->proxied
        ];
    }
}
