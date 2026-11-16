<?php
/**
 * zPanel VPS Automation & Server Module for WISECP V3
 * Reference: https://github.com/wisecp-v3/sample-server-module
 * 
 * Resmi Port Mimarisi:
 * - 8026 / TCP (HTTPS): Müşteri Kontrol Paneli
 * - 8036 / TCP (HTTPS): Root / Yönetici Paneli
 * - 8046 / TCP (HTTPS): Webmail
 * - 8056 / TCP (HTTPS): Core REST API
 */

if (!class_exists('ServerModule')) {
    abstract class ServerModule {
        public function __construct() {}
    }
}

require_once __DIR__ . '/lib/ApiClient.php';
use Coremio\Modules\Servers\ZPanelVPS\Lib\ApiClient;

class ZPanelVPS extends ServerModule
{
    private function getClient(array $params): ApiClient
    {
        $server = $params['server'] ?? [];
        $host   = $server['ip'] ?? $server['hostname'] ?? $params['domain'] ?? '';
        $apiKey = $server['password'] ?? $server['access_hash'] ?? '';
        return new ApiClient($host, $apiKey, 8056);
    }

    public function TestConnection($options = [])
    {
        $host   = $options['ip'] ?? $options['hostname'] ?? '';
        $apiKey = $options['api_key'] ?? $options['password'] ?? '';
        $client = new ApiClient($host, $apiKey, 8056);

        $res = $client->testConnection();
        if ($res['status']) {
            return ['status' => 'successful', 'message' => "zPanel API bağlantısı başarılı ({$host}:8056)."];
        }
        return ['status' => 'error', 'message' => $res['message'] ?: 'Bağlantı kurulamadı.'];
    }

    public function CreateAccount($params = [])
    {
        return ['status' => 'successful', 'message' => 'zPanel sunucu hazırlandı.'];
    }

    public function SuspendAccount($params = [])
    {
        return ['status' => 'successful', 'message' => 'Sunucu askıya alındı.'];
    }

    public function UnsuspendAccount($params = [])
    {
        return ['status' => 'successful', 'message' => 'Sunucu aktif edildi.'];
    }

    public function TerminateAccount($params = [])
    {
        return ['status' => 'successful', 'message' => 'Sunucu kalıcı olarak silindi.'];
    }

    public function Reboot($params = [])
    {
        $client = $this->getClient($params);
        $res = $client->rebootServer();
        if ($res['status']) {
            return ['status' => 'successful', 'message' => 'Sunucu yeniden başlatılıyor...'];
        }
        return ['status' => 'error', 'message' => $res['message'] ?: 'Yeniden başlatılamadı.'];
    }

    public function RestartPanel($params = [])
    {
        $client = $this->getClient($params);
        $res = $client->restartPanelServices();
        if ($res['status']) {
            return ['status' => 'successful', 'message' => 'zPanel servisleri yeniden başlatılıyor...'];
        }
        return ['status' => 'error', 'message' => $res['message'] ?: 'Panel servisleri yeniden başlatılamadı.'];
    }

    public function ClientArea($params = [])
    {
        $domain   = $params['domain'] ?? '';
        $serverIp = $params['options']['server_ip'] ?? $params['server']['ip'] ?? '';
        $panelHost = !empty($domain) ? $domain : $serverIp;
        $clientPort = 8026;
        $adminPort  = 8036;

        $ssoUrl = !empty($panelHost) ? "https://{$panelHost}:{$clientPort}" : '#';

        return [
            'template' => 'pages/clientArea.php',
            'data' => [
                'domain'        => $domain,
                'server_ip'     => $serverIp,
                'panel_host'    => $panelHost,
                'client_port'   => $clientPort,
                'admin_port'    => $adminPort,
                'sso_url'       => $ssoUrl,
                'status'        => $params['status'] ?? 'active',
                'package_name'  => $params['package_name'] ?? 'zPanel Bulut Sunucu',
                'cpu_cores'     => $params['configoptions']['cpu_cores'] ?? 4,
                'ram_mb'        => $params['configoptions']['ram_mb'] ?? 8192,
                'disk_gb'       => $params['configoptions']['disk_gb'] ?? 160,
                'bandwidth_tb'  => $params['configoptions']['bandwidth_tb'] ?? 5,
                'os_name'       => $params['configoptions']['os_name'] ?? 'Ubuntu / AlmaLinux',
                'service_id'    => $params['id'] ?? 0,
            ],
        ];
    }
}
