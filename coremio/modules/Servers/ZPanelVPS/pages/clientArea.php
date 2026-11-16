<?php
/**
 * WISECP zPanel VPS Module - Client Area View
 * Port Mimarisi: 8026 (Client), 8036 (Root/Admin), 8046 (Webmail), 8056 (API)
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
$vncUrl      = $data['vnc_url'] ?? '#';

$cpuCore = $data['cpu_cores'] ?? 4;
$ramMb   = $data['ram_mb'] ?? 8192;
$diskGb  = $data['disk_gb'] ?? 160;
$bwTb    = $data['bandwidth_tb'] ?? 5;
$osName  = $data['os_name'] ?? 'Ubuntu 24.04 LTS';
?>

<link rel="stylesheet" href="coremio/modules/Servers/ZPanelVPS/assets/css/client.css">

<div class="zp-wisecp-vps">
  <!-- Üst Başlık Kartı -->
  <div class="zp-card">
    <div class="zp-header-flex">
      <div>
        <div class="zp-title-wrap">
          <h2 class="zp-main-title"><?php echo htmlspecialchars($packageName, ENT_QUOTES, 'UTF-8'); ?></h2>
          <span class="zp-ver-badge">zPanel VPS</span>
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

  <!-- Sunucu Güç & Yaşam Döngüsü Eylemleri -->
  <div class="zp-card">
    <h3 class="zp-section-title">Sunucu Güç &amp; Yaşam Döngüsü Yönetimi</h3>
    
    <div class="zp-btn-group">
      <form method="post" class="zp-inline-form">
        <input type="hidden" name="module_action" value="start">
        <button type="submit" class="zp-btn-success-outline">
          <span>&#x25b6;</span> Sunucuyu Başlat
        </button>
      </form>

      <form method="post" class="zp-inline-form">
        <input type="hidden" name="module_action" value="stop">
        <button type="submit" onclick="return confirm('Sunucuyu kapatmak istediğinize emin misiniz?');" class="zp-btn-danger-outline">
          <span>&#x25a0;</span> Sunucuyu Kapat
        </button>
      </form>

      <form method="post" class="zp-inline-form">
        <input type="hidden" name="module_action" value="reboot">
        <button type="submit" onclick="return confirm('Sunucuyu yeniden başlatmak istediğinize emin misiniz?');" class="zp-btn-warning-outline">
          <span>&#x21bb;</span> Yeniden Başlat
        </button>
      </form>

      <form method="post" class="zp-inline-form">
        <input type="hidden" name="module_action" value="restart_panel">
        <button type="submit" onclick="return confirm('zPanel servislerini yeniden başlatmak istediğinize emin misiniz?');" class="zp-btn-secondary-outline">
          <span>&#x2699;</span> Servisleri Yeniden Başlat
        </button>
      </form>

      <form method="post" class="zp-inline-form">
        <input type="hidden" name="module_action" value="reset_root_password">
        <button type="submit" onclick="return confirm('Root şifresi sıfırlansın ve yeni şifre oluşturulsun mu?');" class="zp-btn-danger-outline">
          <span>&#x1f511;</span> Root Şifresi Sıfırla
        </button>
      </form>

      <a href="<?php echo htmlspecialchars($vncUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="zp-btn-action-outline">
        <span>&#x2328;</span> Acil Durum Web Konsolu
      </a>
    </div>
  </div>

  <!-- 3. Port & Ağ Erişim Bilgileri -->
  <div class="zp-card">
    <h3 class="zp-section-title">Ağ &amp; Servis Port Mimarisi</h3>
    
    <div class="zp-ports-grid">
      <div class="zp-port-row">
        <div class="zp-port-num">8026</div>
        <div>
          <div class="zp-port-title">Kullanıcı Kontrol Paneli</div>
          <div class="zp-port-desc">HTTPS Güvenli Web Kontrol Paneli</div>
        </div>
      </div>

      <div class="zp-port-row">
        <div class="zp-port-num">8036</div>
        <div>
          <div class="zp-port-title">Root / Yönetici Paneli</div>
          <div class="zp-port-desc">HTTPS Yönetimsel Giriş Portu</div>
        </div>
      </div>

      <div class="zp-port-row">
        <div class="zp-port-num">8046</div>
        <div>
          <div class="zp-port-title">Webmail Girişi</div>
          <div class="zp-port-desc">Roundcube Webmail Arayüzü</div>
        </div>
      </div>

      <div class="zp-port-row">
        <div class="zp-port-num">8056</div>
        <div>
          <div class="zp-port-title">Core REST API v1</div>
          <div class="zp-port-desc">Otomasyon ve Entegrasyon API Geçidi</div>
        </div>
      </div>
    </div>
  </div>
</div>
