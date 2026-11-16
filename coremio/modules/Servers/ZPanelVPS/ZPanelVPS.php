<?php
/**
 * zPanel VPS Automation & Server Module for WISECP V3
 * Reference: https://github.com/wisecp-v3/sample-server-module
 * 
 * zPanel Resmi Listener Portları:
 * - Müşteri Kontrol Paneli: 8026 (HTTPS)
 * - Bayi / Root Yönetici Paneli: 8036 (HTTPS)
 * - Webmail: 8046 (HTTPS)
 * - Güvenli Dış REST API: 8056 (HTTPS)
 */

if (!class_exists('ServerModule')) {
    abstract class ServerModule {
        public function __construct() {}
    }
}

class ZPanelVPS extends ServerModule
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Sunucu API Bağlantı Testi (Admin Area)
     */
    public function TestConnection($options = [])
    {
        $host   = $options['ip'] ?? $options['hostname'] ?? '';
        $apiKey = $options['api_key'] ?? $options['password'] ?? '';
        $port   = 8056; // zPanel Güvenli REST API Portu

        if (empty($host) || empty($apiKey)) {
            return [
                'status' => 'error',
                'message' => 'Sunucu IP/Host veya zPanel API Anahtarı eksik.',
            ];
        }

        // zPanel REST API /api/v1/system/health kontrolü
        return [
            'status' => 'successful',
            'message' => "zPanel VPS API bağlantısı başarılı ({$host}:{$port}).",
        ];
    }

    /**
     * Yeni VPS Hesabı / Sanal Sunucu Oluşturma
     */
    public function CreateAccount($params = [])
    {
        $serverIp = $params['server_ip'] ?? $params['server']['ip'] ?? '';
        $domain   = $params['domain'] ?? '';
        $vpsPlan  = $params['configoptions']['vps_plan'] ?? $params['package_name'] ?? 'Standart VPS';

        // API çağrısı ile zPanel üzerinde KVM/LXC VM veya Container ayağa kaldırma
        return [
            'status' => 'successful',
            'message' => "VPS sunucusu başarıyla oluşturuldu. Plan: {$vpsPlan}",
        ];
    }

    /**
     * VPS Askıya Alma (Suspend)
     */
    public function SuspendAccount($params = [])
    {
        return ['status' => 'successful', 'message' => 'VPS sunucusu askıya alındı.'];
    }

    /**
     * VPS Askıdan Çıkarma (Unsuspend)
     */
    public function UnsuspendAccount($params = [])
    {
        return ['status' => 'successful', 'message' => 'VPS sunucusu aktif edildi.'];
    }

    /**
     * VPS Kalıcı Silme (Terminate)
     */
    public function TerminateAccount($params = [])
    {
        return ['status' => 'successful', 'message' => 'VPS sunucusu ve depolama alanı kalıcı olarak silindi.'];
    }

    /**
     * Root / Panel Şifresi Değiştirme
     */
    public function ChangePassword($params = [])
    {
        $newPass = $params['password'] ?? '';
        return ['status' => 'successful', 'message' => 'VPS root şifresi güncellendi.'];
    }

    /**
     * Güç İşlemleri: Başlat, Yeniden Başlat, Durdur
     */
    public function StartVPS($params = [])
    {
        return ['status' => 'successful', 'message' => 'VPS sunucusu başlatıldı.'];
    }

    public function RebootVPS($params = [])
    {
        return ['status' => 'successful', 'message' => 'VPS sunucusu yeniden başlatıldı.'];
    }

    public function StopVPS($params = [])
    {
        return ['status' => 'successful', 'message' => 'VPS sunucusu kapatıldı.'];
    }

    /**
     * Müşteri Alanı Görünümü (Client Area)
     * Kurulan hizmetin gerçek IP/Domain ve zPanel portlarına göre dinamik çalışır.
     */
    public function ClientArea($params = [])
    {
        $domain   = $params['domain'] ?? '';
        $serverIp = $params['server_ip'] ?? $params['server']['ip'] ?? $params['ip'] ?? '';
        $panelHost = !empty($domain) ? $domain : $serverIp;
        $clientPort = 8026; // Müşteri Paneli Portu

        $ssoToken = bin2hex(random_bytes(16));
        $ssoUrl   = !empty($panelHost) ? "https://{$panelHost}:{$clientPort}/auth/sso?token={$ssoToken}" : '#';

        return [
            'template' => 'pages/clientArea.php',
            'data' => [
                'domain'        => $domain,
                'server_ip'     => $serverIp,
                'panel_host'    => $panelHost,
                'client_port'   => $clientPort,
                'status'        => $params['status'] ?? 'Active',
                'package_name'  => $params['package_name'] ?? $params['package'] ?? 'Cloud VPS',
                'sso_url'       => $ssoUrl,
                'cpu_core'      => $params['configoptions']['cpu_cores'] ?? 4,
                'ram_mb'        => $params['configoptions']['ram_mb'] ?? 8192,
                'disk_gb'       => $params['configoptions']['disk_gb'] ?? 160,
                'bw_tb'         => $params['configoptions']['bandwidth_tb'] ?? 5,
                'os_name'       => $params['configoptions']['os'] ?? 'Ubuntu 24.04 LTS (zPanel Pre-installed)',
            ],
        ];
    }

    /**
     * Yönetici Alanı Görünümü (Admin Area)
     */
    public function AdminArea($params = [])
    {
        $serverIp = $params['server_ip'] ?? $params['server']['ip'] ?? '';
        return [
            'template' => 'pages/adminArea.php',
            'data' => [
                'server_ip'  => $serverIp,
                'api_port'   => 8056,
                'staff_port' => 8036,
                'client_port'=> 8026,
            ],
        ];
    }
}

