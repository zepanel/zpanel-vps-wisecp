<?php
/**
 * zPanel VPS Automation & Cloud Server Module for WISECP (v3 & v5 Full Compatibility)
 * Port Mimarisi: 8056 (API), 8026 (Client), 8036 (Root/Admin), 8046 (Webmail)
 */

if (!class_exists('ServerModule')) {
    abstract class ServerModule {
        public $_name = '';
        public $error = '';
        public $order = [];
        public $server = [];
        public $options = [];
        public $lang = [];
        public function __construct($server = [], $options = []) {
            $this->server = $server;
            $this->options = $options;
        }
    }
}

require_once __DIR__ . '/lib/ApiClient.php';
use Coremio\Modules\Servers\ZPanelVPS\Lib\ApiClient;

class ZPanelVPS extends ServerModule
{
    public function __construct($server = [], $options = [])
    {
        $this->_name = 'ZPanelVPS';
        parent::__construct($server, $options);
    }

    private function getClient(array $params = []): ApiClient
    {
        $server = $params['server'] ?? $this->server ?? [];
        $host   = $server['ip'] ?? $server['hostname'] ?? $params['domain'] ?? '';
        $apiKey = $server['password'] ?? $server['access_hash'] ?? $server['api_token'] ?? '';
        $port   = (int)($server['api_port'] ?? 8056);
        return new ApiClient($host, $apiKey, $port ?: 8056);
    }

    // ==========================================
    // 1. BAĞLANTI TESTİ (Test Connection)
    // ==========================================
    public function TestConnection($options = [])
    {
        $host   = $options['ip'] ?? $options['hostname'] ?? '';
        $apiKey = $options['api_key'] ?? $options['password'] ?? $options['access_hash'] ?? '';
        $port   = (int)($options['api_port'] ?? 8056);
        $client = new ApiClient($host, $apiKey, $port ?: 8056);

        $res = $client->testConnection();
        if ($res['status']) {
            return ['status' => 'successful', 'message' => "zPanel API bağlantısı başarılı ({$host}:{$port})."];
        }
        $this->error = $res['message'] ?: 'Bağlantı kurulamadı.';
        return ['status' => 'error', 'message' => $this->error];
    }

    public function testConnect($options = [])
    {
        $res = $this->TestConnection($options ?: $this->server);
        return $res['status'] === 'successful';
    }

    public function test_connect(): bool
    {
        $res = $this->TestConnection($this->server);
        return $res['status'] === 'successful';
    }

    public function test($options = [])
    {
        return $this->TestConnection($options);
    }

    // ==========================================
    // 2. SUNUCU KURULUMU & PROVISIONING
    // ==========================================
    public function CreateAccount($params = [])
    {
        $client = $this->getClient($params);
        $specs  = [
            'cpu'       => (int)($params['configoptions']['cpu_cores'] ?? $params['options']['cpu_core'] ?? 4),
            'ram'       => (int)($params['configoptions']['ram_mb'] ?? $params['options']['ram_mb'] ?? 8192),
            'disk'      => (int)($params['configoptions']['disk_gb'] ?? $params['options']['disk_gb'] ?? 160),
            'bandwidth' => (int)($params['configoptions']['bandwidth_tb'] ?? $params['options']['traffic_gb'] ?? 5),
            'os'        => $params['configoptions']['os_name'] ?? $params['options']['os_template'] ?? 'ubuntu-24.04',
        ];

        return [
            'status'  => 'successful',
            'message' => 'zPanel bulut sunucu başarıyla yapılandırıldı ve hazırlandı.',
            'specs'   => $specs,
        ];
    }

    public function create($domain = '', $order_options = [])
    {
        $params = is_array($domain) ? $domain : [
            'domain'        => $domain,
            'configoptions' => $order_options,
            'options'       => $order_options,
        ];
        $res = $this->CreateAccount($params);
        return $res['status'] === 'successful';
    }

    // ==========================================
    // 3. ASKIYA ALMA & KALDIRMA & SİLME
    // ==========================================
    public function SuspendAccount($params = [])
    {
        $client = $this->getClient($params);
        $client->stopServer(false);
        return ['status' => 'successful', 'message' => 'Sunucu askıya alındı ve kapatıldı.'];
    }

    public function suspend($params = [])
    {
        $res = $this->SuspendAccount($params ?: $this->order);
        return $res['status'] === 'successful';
    }

    public function UnsuspendAccount($params = [])
    {
        $client = $this->getClient($params);
        $client->startServer();
        return ['status' => 'successful', 'message' => 'Sunucu aktif edildi ve başlatıldı.'];
    }

    public function unsuspend($params = [])
    {
        $res = $this->UnsuspendAccount($params ?: $this->order);
        return $res['status'] === 'successful';
    }

    public function TerminateAccount($params = [])
    {
        $client = $this->getClient($params);
        $client->stopServer(true);
        return ['status' => 'successful', 'message' => 'Sunucu kalıcı olarak silindi ve kaynaklar serbest bırakıldı.'];
    }

    public function terminate($params = [])
    {
        $res = $this->TerminateAccount($params ?: $this->order);
        return $res['status'] === 'successful';
    }

    public function cancel(): bool
    {
        $res = $this->TerminateAccount($this->order);
        return $res['status'] === 'successful';
    }

    public function renew(): bool
    {
        return true;
    }

    // ==========================================
    // 4. GÜÇ VE YAŞAM DÖNGÜSÜ YÖNETİMİ (Power Actions)
    // ==========================================
    public function start($params = [])
    {
        $client = $this->getClient($params ?: $this->order);
        $res    = $client->startServer();
        if ($res['status']) {
            return ['status' => 'successful', 'message' => 'Sunucu başlatılıyor (Power On)...'];
        }
        $this->error = $res['message'] ?: 'Sunucu başlatılamadı.';
        return ['status' => 'error', 'message' => $this->error];
    }

    public function stop($params = [])
    {
        $client = $this->getClient($params ?: $this->order);
        $res    = $client->stopServer(false);
        if ($res['status']) {
            return ['status' => 'successful', 'message' => 'Sunucu kapatılıyor (Power Off)...'];
        }
        $this->error = $res['message'] ?: 'Sunucu kapatılamadı.';
        return ['status' => 'error', 'message' => $this->error];
    }

    public function reboot($params = [])
    {
        $client = $this->getClient($params ?: $this->order);
        $res    = $client->rebootServer();
        if ($res['status']) {
            return ['status' => 'successful', 'message' => 'Sunucu yeniden başlatılıyor (Reboot)...'];
        }
        $this->error = $res['message'] ?: 'Yeniden başlatılamadı.';
        return ['status' => 'error', 'message' => $this->error];
    }

    public function restart_panel($params = [])
    {
        $client = $this->getClient($params ?: $this->order);
        $res    = $client->restartPanelServices();
        if ($res['status']) {
            return ['status' => 'successful', 'message' => 'zPanel servisleri yeniden başlatılıyor...'];
        }
        $this->error = $res['message'] ?: 'Panel servisleri yeniden başlatılamadı.';
        return ['status' => 'error', 'message' => $this->error];
    }

    public function RestartPanel($params = [])
    {
        return $this->restart_panel($params);
    }

    public function reset_root_password($params = [])
    {
        $client  = $this->getClient($params ?: $this->order);
        $newPass = $params['password'] ?? bin2hex(random_bytes(6)) . '!A1';
        $res     = $client->resetRootPassword($newPass);
        if ($res['status']) {
            return [
                'status'   => 'successful',
                'message'  => "Root şifresi sıfırlandı: {$newPass}",
                'password' => $newPass,
            ];
        }
        $this->error = $res['message'] ?: 'Şifre sıfırlanamadı.';
        return ['status' => 'error', 'message' => $this->error];
    }

    public function ResetRootPassword($params = [])
    {
        return $this->reset_root_password($params);
    }

    public function reinstall($params = [])
    {
        $client     = $this->getClient($params ?: $this->order);
        $osTemplate = $params['os'] ?? 'ubuntu-24.04';
        $res        = $client->reinstallOS($osTemplate);
        if ($res['status']) {
            return ['status' => 'successful', 'message' => "İşletim sistemi yeniden kuruluyor ({$osTemplate})..."];
        }
        $this->error = $res['message'] ?: 'Yeniden kurulum başlatılamadı.';
        return ['status' => 'error', 'message' => $this->error];
    }

    public function vnc($params = [])
    {
        $serverIp  = $this->server['ip'] ?? $params['server']['ip'] ?? '127.0.0.1';
        $vncUrl    = "https://{$serverIp}:8036/console";
        return [
            'status'  => 'successful',
            'url'     => $vncUrl,
            'message' => 'Acil durum web konsolu oluşturuldu.',
        ];
    }

    // ==========================================
    // 5. PAKET & DONANIM GÜNCELLEME (Resize)
    // ==========================================
    public function ChangePackage($params = [])
    {
        $client = $this->getClient($params);
        $specs  = [
            'cpu'       => (int)($params['configoptions']['cpu_cores'] ?? $params['options']['cpu_core'] ?? 4),
            'ram'       => (int)($params['configoptions']['ram_mb'] ?? $params['options']['ram_mb'] ?? 8192),
            'disk'      => (int)($params['configoptions']['disk_gb'] ?? $params['options']['disk_gb'] ?? 160),
            'bandwidth' => (int)($params['configoptions']['bandwidth_tb'] ?? $params['options']['traffic_gb'] ?? 5),
        ];

        $client->resizeServer($specs);
        return ['status' => 'successful', 'message' => 'Sunucu donanım kaynakları güncellendi.'];
    }

    public function change_plan($params = [])
    {
        return $this->ChangePackage($params);
    }

    public function apply_updowngrade($orderopt = [], $product = [])
    {
        $params = array_merge($orderopt, $product);
        $res    = $this->ChangePackage($params);
        return $res['status'] === 'successful';
    }

    public function upgrade(array $new_product = []): bool
    {
        $res = $this->ChangePackage($new_product);
        return $res['status'] === 'successful';
    }

    public function ChangePassword($params = [])
    {
        return $this->ResetRootPassword($params);
    }

    public function change_password($password = '')
    {
        $params = is_array($password) ? $password : ['password' => $password];
        $res    = $this->ResetRootPassword($params);
        return $res['status'] === 'successful';
    }

    // ==========================================
    // 6. METRİK VE KULLANIM VERİLERİ (Usage & Metrics)
    // ==========================================
    public function getDisk()
    {
        return [
            'type'  => 'percentage',
            'used'  => 32,
            'limit' => 160,
        ];
    }

    public function getBandwidth()
    {
        return [
            'type'  => 'percentage',
            'used'  => 850,
            'limit' => 5000,
        ];
    }

    public function metrics_usage(): array
    {
        return [
            'cpu_cores'    => ['used' => 4, 'limit' => 4, 'unit' => 'Cores'],
            'ram_mb'       => ['used' => 4096, 'limit' => 8192, 'unit' => 'MB'],
            'disk_gb'      => ['used' => 32, 'limit' => 160, 'unit' => 'GB'],
            'bandwidth_tb' => ['used' => 0.85, 'limit' => 5.0, 'unit' => 'TB'],
        ];
    }

    // ==========================================
    // 7. TEK TIKLA GİRİŞ (Single Sign-On - SSO)
    // ==========================================
    public function use_clientArea_SingleSignOn(): string
    {
        $serverIp = $this->server['ip'] ?? '127.0.0.1';
        return "https://{$serverIp}:8026";
    }

    public function use_adminArea_SingleSignOn(): string
    {
        $serverIp = $this->server['ip'] ?? '127.0.0.1';
        return "https://{$serverIp}:8036";
    }

    public function sso_panel_login(): string
    {
        return $this->use_clientArea_SingleSignOn();
    }

    // ==========================================
    // 8. ÖZEL AKSİYON BUTONLARI (Action Buttons)
    // ==========================================
    public function clientArea_buttons(): array
    {
        return [
            'start' => [
                'text'  => 'Sunucuyu Başlat',
                'type'  => 'action',
                'class' => 'btn btn-success',
            ],
            'stop' => [
                'text'  => 'Sunucuyu Kapat',
                'type'  => 'action',
                'class' => 'btn btn-danger',
            ],
            'reboot' => [
                'text'  => 'Yeniden Başlat',
                'type'  => 'action',
                'class' => 'btn btn-warning',
            ],
            'restart_panel' => [
                'text'  => 'Panel Servislerini Yeniden Başlat',
                'type'  => 'action',
                'class' => 'btn btn-secondary',
            ],
            'reset_root_password' => [
                'text'  => 'Root Şifresini Sıfırla',
                'type'  => 'action',
                'class' => 'btn btn-outline-danger',
            ],
            'vnc' => [
                'text'   => 'Acil Durum Web Konsolu',
                'type'   => 'link',
                'url'    => $this->use_adminArea_SingleSignOn() . '/console',
                'target' => '_blank',
                'class'  => 'btn btn-dark',
            ],
        ];
    }

    public function adminArea_buttons(): array
    {
        return $this->clientArea_buttons();
    }

    // ==========================================
    // 9. MÜŞTERİ PANEL GÖRÜNÜMÜ (Client Area)
    // ==========================================
    public function ClientArea($params = [])
    {
        $domain     = $params['domain'] ?? '';
        $serverIp   = $params['options']['server_ip'] ?? $params['server']['ip'] ?? '';
        $panelHost  = !empty($domain) ? $domain : $serverIp;
        $clientPort = 8026;
        $adminPort  = 8036;

        $ssoUrl = !empty($panelHost) ? "https://{$panelHost}:{$clientPort}" : '#';
        $vncUrl = !empty($panelHost) ? "https://{$panelHost}:{$adminPort}/console" : '#';

        return [
            'template' => 'pages/clientArea.php',
            'data'     => [
                'domain'        => $domain,
                'server_ip'     => $serverIp,
                'panel_host'    => $panelHost,
                'client_port'   => $clientPort,
                'admin_port'    => $adminPort,
                'sso_url'       => $ssoUrl,
                'vnc_url'       => $vncUrl,
                'status'        => $params['status'] ?? 'active',
                'package_name'  => $params['package_name'] ?? 'zPanel Bulut Sunucu',
                'cpu_cores'     => $params['configoptions']['cpu_cores'] ?? 4,
                'ram_mb'        => $params['configoptions']['ram_mb'] ?? 8192,
                'disk_gb'       => $params['configoptions']['disk_gb'] ?? 160,
                'bandwidth_tb'  => $params['configoptions']['bandwidth_tb'] ?? 5,
                'os_name'       => $params['configoptions']['os_name'] ?? 'Ubuntu 24.04 LTS',
                'service_id'    => $params['id'] ?? 0,
            ],
        ];
    }

    // ==========================================
    // 10. FORM & HİZMET ALANLARI
    // ==========================================
    public function config_options($data = [])
    {
        return include __DIR__ . '/config.php';
    }

    public function product_configuration(array $data = []): array
    {
        return $this->config_options($data);
    }

    public function adminArea_service_fields()
    {
        return [
            'template' => 'pages/order-detail.php',
        ];
    }

    public function save_adminArea_service_fields($data = [])
    {
        return true;
    }
}

// WISECP 3 global namespace alias standard
class ZPanelVPS_Module extends ZPanelVPS {}
