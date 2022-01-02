<?php

namespace CloudFlareDynamicDnsUpdater;

use Exception;

class Client
{

    /**
     * Base api
     */
    public const CLOUD_FLARE_BASE_API = 'https://api.cloudflare.com';

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $api_key;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $cloudflare_domain;

    /**
     * @var string|null
     */
    private $cloudflare_domain_id = null;

    /**
     * Client constructor.
     * @param string $email
     * @param string $api_key
     */
    public function __construct(string $email, string $api_key)
    {
        $this->email = $email;
        $this->api_key = $api_key;
    }

    /**
     * Set the domain
     *
     * @param string $domain
     */
    public function setDomain(string $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Get the domain
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * Get the id
     * @return string|null
     */
    public function getCloudFlareDomainId(): ?string
    {
        if (is_null($this->cloudflare_domain_id)) {
            $this->getCloudFlareDomainInformation();
        }

        return $this->cloudflare_domain_id;
    }

    /**
     * Get information of domain at cloudflare
     */
    private function getCloudFlareDomainInformation()
    {

        $response = $this->makeCall(self::CLOUD_FLARE_BASE_API . "/client/v4/zones?name=$this->domain");
        try {
            if (is_null($response)) {
                throw new Exception('No valid domain');

            } else {
                $this->cloudflare_domain = $response[0];
                $this->cloudflare_domain_id = $response[0]['id'];
            }
        } catch (Exception $e) {
            echo $e;
            exit;
        }
    }

    /**
     * Get zone url
     * @return string
     */
    private function getZoneURL()
    {
        return sprintf(self::CLOUD_FLARE_BASE_API . "/client/v4/zones/%s/dns_records", $this->getCloudFlareDomainId());
    }

    /**
     * Get records
     * @return bool|string
     */
    public function getRecords()
    {
        return $this->makeCall($this->getZoneURL());
    }

    /**
     * Update the record
     * @param DNSRecord $record
     * @return bool|string
     */
    public function updateRecord(DNSRecord $record)
    {

        $current_record = $this->getRecord($record->getName());

        return $this->makeCall(
            $this->getZoneURL() . "/" . $current_record[0]['id'],
            'PUT',
            $record->getRecord()
        );
    }

    /**
     * Get the record
     * @param string $name
     * @return bool|string
     */
    public function getRecord(string $name)
    {
        return $this->makeCall($this->getZoneURL() . "?name=" . $name);
    }


    /**
     * Make endpoint call
     *
     * @param string $endpoint
     * @param string $type
     * @param array|null $data
     * @return bool|string
     */
    private function makeCall(string $endpoint, string $type = "GET", array $data = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            exit('Error: ' . curl_error($ch));
        }
        curl_close($ch);


        $result = json_decode($result, true);
        try {
            if (!empty($result['result']) && $result['success']) {
                return $result['result'];
            }
            throw new Exception('no valid response. is this record added?');

        } catch (Exception $e) {
            echo $e;
            exit;
        }
    }

    /**
     * Get the headers
     * @return string[]
     */
    private function getHeaders(): array
    {
        return [
            "X-Auth-Email: {$this->email}",
            "X-Auth-Key: {$this->api_key}",
            "Content-Type:application/json"
        ];
    }

}
