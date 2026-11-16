<?php
/**
 * zPanel VPS Kontrol Modülü - WISECP v3 Konfigürasyonu
 * Resmi WISECP Standartlarına ve zPanel Mimari Portlarına (API: 8055, Müşteri: 8025, Admin: 8035) Uygundur.
 */
return [
    'type-version'      => '3.0',
    'name'              => 'ZPanelVPS',
    'readable-name'     => 'zPanel VPS Yönetim Modülü',
    'status'            => true,
    'authors'           => 'zPanel Team',
    'version'           => '1.0.0',

    // Sunucu Ekleme / Bağlama Ekranında Admin'den İstenen Alanlar
    'server-fields'     => [
        'ip'            => [
            'name'        => 'Sunucu IP veya Hostname',
            'type'        => 'text',
            'description' => 'zPanel kurulu sunucunun IP adresi veya FQDN adı (Örn: 203.0.113.31 veya srv388.morgancreative.com)',
        ],
        'api_port'      => [
            'name'        => 'Dış REST API Portu',
            'type'        => 'text',
            'default'     => '8056',
            'description' => 'zPanel REST API portu (Resmi: 8056/TCP HTTPS)',
        ],
        'client_port'   => [
            'name'        => 'Kullanıcı Panel Portu',
            'type'        => 'text',
            'default'     => '8026',
            'description' => 'Müşterilerin web üzerinden panele erişim portu (Resmi: 8026/TCP HTTPS)',
        ],
        'admin_port'    => [
            'name'        => 'Bayi / Root Panel Portu',
            'type'        => 'text',
            'default'     => '8036',
            'description' => 'Yönetici personelin panele erişim portu (Resmi: 8036/TCP HTTPS)',
        ],
        'api_token'     => [
            'name'        => 'API Token / Gizli Anahtar',
            'type'        => 'password',
            'description' => '/etc/zpanel/api.env dosyasındaki API_INTERNAL_TOKEN değeri',
        ],
        'secure'        => [
            'name'        => 'SSL (HTTPS) Güvenli Bağlantı',
            'type'        => 'approval',
            'checked'     => true,
            'description' => 'API ve Panel iletişiminde SSL/TLS protokolünü etkinleştirin',
        ],
    ],

    // Paket Tanımlama / Ürün Özellikleri Ekranında Admin'den İstenen Alanlar
    'options'           => [
        'vps_plan_id'   => [
            'name'        => 'zPanel VPS Plan Adı / Kodu',
            'type'        => 'text',
            'default'     => 'cloud-vps-8',
            'description' => 'Sunucudaki karşılık gelen paket profili',
        ],
        'cpu_core'      => [
            'name'        => 'CPU Çekirdek Limiti',
            'type'        => 'text',
            'default'     => '4',
            'description' => 'Örn: 1, 2, 4, 8 Core',
        ],
        'ram_mb'        => [
            'name'        => 'RAM Boyutu (MB)',
            'type'        => 'text',
            'default'     => '8192',
            'description' => 'Örn: 8192 (8 GB RAM)',
        ],
        'disk_gb'       => [
            'name'        => 'Disk Kapasitesi (GB)',
            'type'        => 'text',
            'default'     => '25',
            'description' => 'NVMe / SSD Disk alanı (GB)',
        ],
        'traffic_gb'    => [
            'name'        => 'Aylık Trafik Limiti (GB)',
            'type'        => 'text',
            'default'     => '2000',
            'description' => 'Aylık bant genişliği (0 = Limitsiz)',
        ],
        'os_template'   => [
            'name'        => 'Varsayılan İşletim Sistemi',
            'type'        => 'select',
            'options'     => [
                'debian-12'      => 'Debian 12 (Bookworm)',
                'ubuntu-24.04'   => 'Ubuntu 24.04 LTS (Noble)',
                'almalinux-9'    => 'AlmaLinux 9',
                'rocky-9'        => 'Rocky Linux 9',
            ],
            'description' => 'İlk kurulumda yüklenecek OS imajı',
        ],
    ],
];
