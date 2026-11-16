<?php
/**
 * WISECP v3 zPanel VPS Module - Client Area View
 * Reference: https://github.com/wisecp-v3/sample-server-module
 * Port Mimarisi: 8026 (Client), 8036 (Root), 8046 (Webmail), 8056 (API)
 */
defined('CORE_FOLDER') OR exit('You can not access this file.');

$domain      = $data['domain'] ?? '';
$serverIp    = $data['server_ip'] ?? '';
$panelHost   = $data['panel_host'] ?? ($domain ?: $serverIp);
$clientPort  = $data['client_port'] ?? 8026;
$adminPort   = $data['admin_port'] ?? 8036;
$status      = $data['status'] ?? 'active';
$packageName = $data['package_name'] ?? 'zPanel Bulut Sunucu';
$ssoUrl      = $data['sso_url'] ?? '#';

$cpuCore = $data['cpu_cores'] ?? 4;
$ramMb   = $data['ram_mb'] ?? 8192;
$diskGb  = $data['disk_gb'] ?? 160;
$bwTb    = $data['bandwidth_tb'] ?? 5;
$osName  = $data['os_name'] ?? 'Ubuntu / AlmaLinux';
?>

<link rel="stylesheet" href="coremio/modules/Servers/ZPanelVPS/assets/css/client.css">

<div class="zp-wisecp-vps">
  <!-- Üst Başlık Kartı -->
  <div class="zp-card">
    <div class="zp-header-flex">
      <div>
        <div class="zp-title-wrap">
          <h2 class="zp-main-title"><?php echo htmlspecialchars($packageName, ENT_QUOTES, 'UTF-8'); ?></h2>
          <span class="zp-ver-badge">zPanel v1.0</span>
        </div>
        <div class="zp-meta-sub">
          <?php if (!empty($domain)): ?>
            <a href="https://<?php echo htmlspecialchars($domain, ENT_QUOTES, 'UTF-8'); ?>:<?php echo (int)$clientPort; ?>" target="_blank" class="zp-domain-link">
              <?php echo htmlspecialchars($domain, ENT_QUOTES, 'UTF-8'); ?>:<?php echo (int)$clientPort; ?>
            </a>
            &bull;
          <?php endif; ?>
          Sunucu IP: <strong class="zp-code-bold"><?php echo htmlspecialchars($serverIp ?: 'Atanmadı', ENT_QUOTES, 'UTF-8'); ?></strong>
          &bull;
          İşletim Sistemi: <strong class="zp-strong"><?php echo htmlspecialchars($osName, ENT_QUOTES, 'UTF-8'); ?></strong>
        </div>
      </div>
      <div>
        <a href="<?php echo htmlspecialchars($ssoUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="zp-btn-login">
          zPanel Giriş (:<?php echo (int)$clientPort; ?>) &rarr;
        </a>
      </div>
    </div>
  </div>

  <!-- Makine Donanım Özellikleri Kartları -->
  <div class="zp-specs-grid">
    <div class="zp-spec-card">
      <div class="zp-spec-label">İşlemci Kapasitesi</div>
      <div class="zp-spec-val"><?php echo (int)$cpuCore; ?> <span class="zp-spec-unit">vCPU</span></div>
      <div class="zp-spec-sub">Yüksek Performans Çekirdek</div>
    </div>

    <div class="zp-spec-card">
      <div class="zp-spec-label">Bellek (RAM)</div>
      <div class="zp-spec-val"><?php echo (int)$ramMb; ?> <span class="zp-spec-unit">MB</span></div>
      <div class="zp-spec-sub">DDR4 / DDR5 ECC RAM</div>
    </div>

    <div class="zp-spec-card">
      <div class="zp-spec-label">Depolama Alanı</div>
      <div class="zp-spec-val"><?php echo (int)$diskGb; ?> <span class="zp-spec-unit">GB NVMe</span></div>
      <div class="zp-spec-sub">Saf NVMe SSD RAID10</div>
    </div>

    <div class="zp-spec-card">
      <div class="zp-spec-label">Aylık Trafik Kotası</div>
      <div class="zp-spec-val"><?php echo (int)$bwTb; ?> <span class="zp-spec-unit">TB</span></div>
      <div class="zp-spec-sub">1 Gbps Korumalı Hat</div>
    </div>
  </div>

  <!-- Hızlı Eylemler Kartı -->
  <div class="zp-card">
    <h3 class="zp-section-title">Hızlı Sunucu Eylemleri</h3>
    
    <div class="zp-btn-group">
      <button type="button" onclick="if(confirm('Sunucuyu yeniden başlatmak istediğinize emin misiniz?')) { window.location.href='?action=reboot'; }" class="zp-btn-danger-outline">
        <span>&#x21bb;</span> Sunucuyu Yeniden Başlat
      </button>

      <button type="button" onclick="if(confirm('zPanel servislerini yeniden başlatmak istediğinize emin misiniz?')) { window.location.href='?action=restart_panel'; }" class="zp-btn-secondary-outline">
        <span>&#x2699;</span> zPanel Servislerini Yeniden Başlat
      </button>

      <a href="https://<?php echo htmlspecialchars($panelHost, ENT_QUOTES, 'UTF-8'); ?>:8046" target="_blank" class="zp-btn-action-outline">
        <span>&#x2709;</span> Webmail Giriş (:8046)
      </a>
    </div>
  </div>

  <!-- Ağ ve Port Detayları Kartı -->
  <div class="zp-card">
    <h3 class="zp-section-title">Sunucu Ağ ve Port Yapılandırması</h3>
    
    <table class="zp-table">
      <tr><td>Statik IPv4 Adresi</td><td class="zp-code-bold"><?php echo htmlspecialchars($serverIp ?: 'Atanmadı', ENT_QUOTES, 'UTF-8'); ?></td></tr>
      <tr><td>Web Sunucusu</td><td class="zp-strong">zMaxServer &amp; OpenLiteSpeed (LSAPI)</td></tr>
      <tr><td>zPanel Müşteri Paneli</td><td class="zp-code-bold">8026 / TCP (HTTPS)</td></tr>
      <tr><td>zPanel Root / Yönetici Paneli</td><td class="zp-code-bold">8036 / TCP (HTTPS)</td></tr>
      <tr><td>Webmail Portu</td><td class="zp-code-bold">8046 / TCP (HTTPS)</td></tr>
      <tr><td>Core REST API Portu</td><td class="zp-code-bold">8056 / TCP (HTTPS)</td></tr>
    </table>
  </div>
</div>
