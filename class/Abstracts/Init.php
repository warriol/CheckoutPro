<?php

namespace Abstracts;

abstract class Init
{
    protected readonly string $key;
    protected int $debug = 0;
    private $ACCESS_TOKEN;
    private $BASE_URL;
    private $NOTIFICATION_URL;
    private $rutaEnv = __DIR__ . '/../../.env';

    /**
     * @throws Exception
     */
    public function __construct($sc)
    {
        $this->debug("INICIO", "------------------------------------------------------//////");
        $this->rutaEnv = $sc;
        $this->loadConfig();
    }

    private function loadConfig(): void
    {
        $filePath = $this->rutaEnv;
        if (!file_exists($filePath)) {
            throw new Exception(".env no encontrado.");
        }
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            list($name, $value) = explode('=', $line, 2);
            $this->setConfigVariable(trim($name), trim($value));
        }
    }

    private function setConfigVariable($name, $value): void
    {
        switch ($name) {
            case 'KEY':
                $this->key = $value;
                break;
            case 'ACCESS_TOKEN':
                $this->ACCESS_TOKEN = $value;
                break;
            case 'BASE_URL':
                $this->BASE_URL = $this->desencriptarTexto($value);
                break;
            case 'NOTIFICATION_URL':
                $this->NOTIFICATION_URL = $this->desencriptarTexto($value);
                break;
        }
    }

    protected function desencriptarTexto($textoEncriptado): string
    {
        $datos = base64_decode($textoEncriptado);
        $iv = substr($datos, 0, openssl_cipher_iv_length('aes-256-cbc'));
        $textoEncriptado = substr($datos, openssl_cipher_iv_length('aes-256-cbc'));
        return openssl_decrypt($textoEncriptado, 'aes-256-cbc', $this->key, 0, $iv);
    }

    protected function getAccessToken(): string
    {
        return $this->ACCESS_TOKEN;
    }
    protected function getBaseUrl(): string
    {
        return $this->BASE_URL;
    }
    protected function getNotificationUrl(): string
    {
        return $this->NOTIFICATION_URL;
    }

    public function debug($var, $val = '-'): void{
        if ($this->debug) {
            $file = fopen("./debug.log", "a") or die("Error creando archivo");
            $texto = '[' . date("Y-m-d H:i:s") . ']::[' . $var . ']:-> [' . $val . ']';
            fwrite($file, $texto . PHP_EOL) or die("Error escribiendo en el archivo");
            fclose($file);
        }
    }
}