<?php

namespace Coremio\Modules\Servers\ZPanelVPS\Lib;

/**
 * zPanel API İstemcisi (WISECP V3 & V5)
 * Port Mimarisi: 8056 (Core REST API), 8026 (Client), 8036 (Root)
 */
class ApiClient
{
    private string $host;
    private string $apiKey;
    private int $apiPort = 8056;
    private int $timeout = 20;

    public function __construct(string $host, string $apiKey, int $apiPort = 8056)
    {
        $this->host = trim($host, '/');
        $this->apiKey = trim($apiKey);
        $this->apiPort = $apiPort > 0 ? $apiPort : 8056;
    }

    public function request(string $method, string $uri, array $data = []): array
    {
        $cleanUri = ltrim($uri, '/');
        if (!str_starts_with($cleanUri, 'v1/')) {
            $cleanUri = 'v1/' . $cleanUri;
        }

        $url = "https://{$this->host}:{$this->apiPort}/" . $cleanUri;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: WISECP-zPanel-VPS/1.1',
        ]);

        $method = strtoupper($method);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        } elseif ($method === 'PUT' || $method === 'PATCH') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $res = curl_exec($ch);
        $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['status' => false, 'http_code' => 0, 'message' => "Bağlantı Hatası: {$err}", 'data' => null];
        }

        $json = json_decode((string)$res, true);
        $isOk = ($code >= 200 && $code < 300);

        return [
            'status' => $isOk,
            'http_code' => $code,
            'data' => $json,
            'message' => $json['message'] ?? ($isOk ? 'Başarılı' : "HTTP Hata {$code}"),
        ];
    }

    public function testConnection(): array
    {
        return $this->request('GET', 'health');
    }

    public function startServer(): array
    {
        return $this->request('POST', 'system/start');
    }

    public function stopServer(bool $force = false): array
    {
        return $this->request('POST', 'system/stop', ['force' => $force]);
    }

    public function rebootServer(): array
    {
        return $this->request('POST', 'system/reboot');
    }

    public function restartPanelServices(): array
    {
        return $this->request('POST', 'system/restart-panel');
    }

    public function resetRootPassword(string $newPassword): array
    {
        return $this->request('POST', 'system/reset-root-password', [
            'password' => $newPassword,
        ]);
    }

    public function reinstallOS(string $osTemplate): array
    {
        return $this->request('POST', 'system/reinstall', [
            'os' => $osTemplate,
        ]);
    }

    public function resizeServer(array $specs): array
    {
        return $this->request('PATCH', 'system/specs', $specs);
    }
}
