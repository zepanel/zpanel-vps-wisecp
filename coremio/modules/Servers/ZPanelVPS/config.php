<?php
/**
 * zPanel VPS Kontrol Modülü - WISECP v3 & v5 Konfigürasyonu
 * Resmi Port Mimarisi: API: 8056, Müşteri: 8026, Admin: 8036, Webmail: 8046
 */
return [
    'name'                        => 'ZPanelVPS',
    'readable-name'               => 'zPanel VPS & Bulut Sunucu Modülü',
    'type'                        => 'vps',
    'type-version'                => '3.0',
    'status'                      => true,
    'authors'                     => 'zPanel Team',
    'version'                     => '1.1.0',

    // WISECP 3 & 5 Çift Uyumluluk Anahtarları
    'access-hash'                 => true,
    'use-access-hash'             => true,
    'require-access-hash'         => true,
    'server-info-checker'         => true,
    'use-test-connection'         => true,
    'server-info-port'            => true,
    'use-port'                    => true,
    'server-info-secure-port'     => 8056,
    'secure-port'                 => 8056,
    'server-info-not-secure-port' => 8056,
    'not-secure-port'             => 8056,
    'use-ssl'                     => true,

    // Desteklenen Yetenekler (Supported Capabilities)
    'supported'                   => [
        'reboot',
        'start',
        'stop',
        'reset-root-password',
        'reinstall',
        'vnc',
        'upgrade',
        'disk-bandwidth-usage',
    ],

    // Sunucu Ekleme / Bağlama Ekranında Admin'den İstenen Alanlar
    'server-fields'               => [
        'ip' => [
            'name'        => 'Sunucu IP veya Hostname',
            'type'        => 'text',
            'description' => 'zPanel kurulu sunucunun IP adresi veya FQDN adı (Örn: 203.0.113.31 veya srv01.zepanel.com)',
        ],
        'api_port' => [
            'name'        => 'Dış REST API Portu',
            'type'        => 'text',
            'default'     => '8056',
            'description' => 'zPanel REST API portu (Resmi: 8056/TCP HTTPS)',
        ],
        'client_port' => [
            'name'        => 'Kullanıcı Panel Portu',
            'type'        => 'text',
            'default'     => '8026',
            'description' => 'Müşterilerin web üzerinden panele erişim portu (Resmi: 8026/TCP HTTPS)',
        ],
        'admin_port' => [
            'name'        => 'Bayi / Root Panel Portu',
            'type'        => 'text',
            'default'     => '8036',
            'description' => 'Yönetici personelin panele erişim portu (Resmi: 8036/TCP HTTPS)',
        ],
        'api_token' => [
            'name'        => 'API Token / Gizli Anahtar',
            'type'        => 'password',
            'description' => '/etc/zpanel/api.env dosyasındaki API_INTERNAL_TOKEN değeri',
        ],
        'secure' => [
            'name'        => 'SSL (HTTPS) Güvenli Bağlantı',
            'type'        => 'approval',
            'checked'     => true,
            'description' => 'API ve Panel iletişiminde SSL/TLS protokolünü etkinleştirin',
        ],
    ],

    // Paket Tanımlama / Ürün Özellikleri Ekranında Admin'den İstenen Alanlar
    'options'                     => [
        'vps_plan_id' => [
            'name'        => 'zPanel VPS Plan Adı / Kodu',
            'type'        => 'text',
            'default'     => 'cloud-vps-8',
            'description' => 'Sunucudaki karşılık gelen paket profili',
        ],
        'cpu_core' => [
            'name'        => 'CPU Çekirdek Limiti',
            'type'        => 'text',
            'default'     => '4',
            'description' => 'Örn: 1, 2, 4, 8 Core',
        ],
        'ram_mb' => [
            'name'        => 'RAM Boyutu (MB)',
            'type'        => 'text',
            'default'     => '8192',
            'description' => 'Örn: 8192 (8 GB RAM)',
        ],
        'disk_gb' => [
            'name'        => 'Disk Kapasitesi (GB)',
            'type'        => 'text',
            'default'     => '160',
            'description' => 'NVMe / SSD Disk alanı (GB)',
        ],
        'traffic_gb' => [
            'name'        => 'Aylık Trafik Limiti (GB)',
            'type'        => 'text',
            'default'     => '5000',
            'description' => 'Aylık bant genişliği (0 = Limitsiz)',
        ],
        'os_template' => [
            'name'        => 'Varsayılan İşletim Sistemi',
            'type'        => 'select',
            'options'     => [
                'ubuntu-24.04' => 'Ubuntu 24.04 LTS (Noble)',
                'ubuntu-22.04' => 'Ubuntu 22.04 LTS (Jammy)',
                'debian-12'    => 'Debian 12 (Bookworm)',
                'almalinux-9'  => 'AlmaLinux 9',
                'rocky-9'      => 'Rocky Linux 9',
            ],
            'description' => 'İlk kurulumda yüklenecek OS imajı',
        ],
    ],
];
