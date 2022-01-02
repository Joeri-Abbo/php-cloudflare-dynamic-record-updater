<?php

namespace CloudFlareDynamicDnsUpdater;

class Helper
{
    /**
     * Get external ip
     * @return string
     */
    public static function getExternalIP(): string
    {
        return file_get_contents('https://api.ipify.org');
    }
}
