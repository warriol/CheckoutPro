<?php
namespace class;
use Abstracts\Init;

class Config extends Init
{
    public function __construct($sc)
    {
        parent::__construct($sc);
    }
    public function getAccessToken(): string
    {
        return parent::getAccessToken();
    }
    public function getBaseUrl(): string
    {
        return parent::getBaseUrl();
    }
    public function getNotificationUrl(): string
    {
        return parent::getNotificationUrl();
    }
}