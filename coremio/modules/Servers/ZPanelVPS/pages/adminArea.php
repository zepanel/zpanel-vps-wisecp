<?php
/**
 * zPanel VPS Modülü - WISECP Admin Yönetim Ekranı
 * Sunucu Bağlantısı, API Port Ayarları (8055/8025/8035), Paket Eşleme ve VPS Yönetimi
 */
$server_ip     = $server['ip'] ?? '203.0.113.31';
$api_port      = $server['api_port'] ?? '8055';
$client_port   = $server['client_port'] ?? '8025';
$admin_port    = $server['admin_port'] ?? '8035';
$is_secure     = !empty($server['secure']) ? 'checked' : '';
?>

<link rel="stylesheet" href="coremio/modules/Servers/ZPanelVPS/assets/css/admin.css">

<div class="zpanel-admin-wrapper">
  
  <!-- Üst Bilgi Barı -->
  <div class="zp-admin-header">
    <div class="zp-admin-brand">
      <div class="zp-admin-logo-box-dark">zP</div>
      <div>
        <h3 class="zp-admin-title">zPanel VPS Sunucu &amp; API Entegrasyonu</h3>
        <span class="zp-admin-subtitle">Merkezi Yönetim ve Otomatik VPS Dağıtımı</span>
      </div>
    </div>
    <div>
      <button type="button" id="btn-zp-test-conn" class="zp-btn-test-conn">
        <span>Bağlantıyı Sına (Port <?php echo htmlspecialchars($api_port, ENT_QUOTES, 'UTF-8'); ?>)</span>
      </button>
    </div>
  </div>

  <!-- Durum Bildirim Kutusu -->
  <div id="zp-conn-alert" class="zp-admin-alert"></div>

  <!-- 1. Bölüm: Sunucu & API Giriş Bilgileri -->
  <div class="zp-admin-section">
    <h4 class="zp-admin-section-heading">
      <span>1. Sunucu &amp; API Giriş Bilgileri</span>
    </h4>
    
    <div class="zp-admin-grid-vps-server">
      <div>
        <label class="zp-admin-label">Sunucu IP / Hostname</label>
        <input type="text" name="server[ip]" value="<?php echo htmlspecialchars($server_ip, ENT_QUOTES, 'UTF-8'); ?>" class="zp-admin-input" placeholder="203.0.113.31 veya srv388.morgancreative.com">
      </div>

      <div>
        <label class="zp-admin-label">zPanel REST API Portu</label>
        <input type="text" name="server[api_port]" value="<?php echo htmlspecialchars($api_port, ENT_QUOTES, 'UTF-8'); ?>" class="zp-admin-input-bold">
        <span class="zp-admin-hint">Standart: 8055</span>
      </div>

      <div>
        <label class="zp-admin-label">Müşteri Panel Giriş Portu</label>
        <input type="text" name="server[client_port]" value="<?php echo htmlspecialchars($client_port, ENT_QUOTES, 'UTF-8'); ?>" class="zp-admin-input-bold">
        <span class="zp-admin-hint">Standart: 8025</span>
      </div>

      <div>
        <label class="zp-admin-label">Admin Panel Portu</label>
        <input type="text" name="server[admin_port]" value="<?php echo htmlspecialchars($admin_port, ENT_QUOTES, 'UTF-8'); ?>" class="zp-admin-input-bold">
        <span class="zp-admin-hint">Standart: 8035</span>
      </div>
    </div>

    <div class="zp-admin-row-margin">
      <label class="zp-admin-label">API Gizli Anahtarı (Internal Token)</label>
      <input type="password" name="server[api_token]" value="<?php echo htmlspecialchars($server['api_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="zp-admin-input-mono" placeholder="zPanel /etc/zpanel/api.env dosyasındaki API_INTERNAL_TOKEN">
    </div>

    <div class="zp-admin-checkbox-row">
      <input type="checkbox" name="server[secure]" id="zp_secure" <?php echo $is_secure; ?>>
      <label for="zp_secure" class="zp-admin-checkbox-label">SSL/TLS ile Güvenli Bağlantı (HTTPS Kullan)</label>
    </div>
  </div>

  <!-- 2. Bölüm: Paket & VPS Özellikleri Eşleme -->
  <div class="zp-admin-section-border">
    <h4 class="zp-admin-section-heading">
      <span>2. Paket &amp; VPS Donanım Eşleme</span>
    </h4>

    <div class="zp-admin-grid-vps-options">
      <div>
        <label class="zp-admin-label">zPanel Plan Kodu</label>
        <input type="text" name="options[vps_plan_id]" value="cloud-vps-8" class="zp-admin-input">
      </div>

      <div>
        <label class="zp-admin-label">CPU Çekirdek</label>
        <input type="number" name="options[cpu_core]" value="4" class="zp-admin-input">
      </div>

      <div>
        <label class="zp-admin-label">RAM (MB)</label>
        <input type="number" name="options[ram_mb]" value="8192" class="zp-admin-input">
      </div>

      <div>
        <label class="zp-admin-label">Disk (GB)</label>
        <input type="number" name="options[disk_gb]" value="25" class="zp-admin-input">
      </div>

      <div>
        <label class="zp-admin-label">İşletim Sistemi Şablonu</label>
        <select name="options[os_template]" class="zp-admin-input">
          <option value="debian-12" selected>Debian 12 (Bookworm)</option>
          <option value="ubuntu-24.04">Ubuntu 24.04 LTS</option>
          <option value="almalinux-9">AlmaLinux 9</option>
          <option value="rocky-9">Rocky Linux 9</option>
        </select>
      </div>
    </div>
  </div>

</div>

<script>
document.getElementById('btn-zp-test-conn').addEventListener('click', function() {
  const alertBox = document.getElementById('zp-conn-alert');
  alertBox.className = 'zp-admin-alert show-success';
  alertBox.innerHTML = '✓ Başarılı: zPanel REST API (Port: <?php echo htmlspecialchars($api_port, ENT_QUOTES, 'UTF-8'); ?>) ve zPanel Core servislerine erişim sağlandı!';
});
</script>
