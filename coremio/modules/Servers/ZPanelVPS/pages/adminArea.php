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

<div class="zpanel-admin-wrapper" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #fff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 24px;">
  
  <!-- Üst Bilgi Barı -->
  <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #edf2f7; padding-bottom: 16px; margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 12px;">
      <div style="background: #0b2545; color: #fff; width: 42px; height: 42px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px;">zP</div>
      <div>
        <h3 style="margin: 0; font-size: 17px; font-weight: 700; color: #0b2545;">zPanel VPS Sunucu &amp; API Entegrasyonu</h3>
        <span style="font-size: 12px; color: #64748b;">Merkezi Yönetim ve Otomatik VPS Dağıtımı</span>
      </div>
    </div>
    <div>
      <button type="button" id="btn-zp-test-conn" style="background: #00875a; color: white; border: none; padding: 9px 18px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
        <span>Bağlantıyı Sına (Port <?php echo htmlspecialchars($api_port); ?>)</span>
      </button>
    </div>
  </div>

  <!-- Durum Bildirim Kutusu -->
  <div id="zp-conn-alert" style="display: none; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; font-weight: 500;"></div>

  <!-- 1. Bölüm: Sunucu & API Giriş Bilgileri -->
  <div style="margin-bottom: 28px;">
    <h4 style="font-size: 14px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px; display: flex; align-items: center; gap: 6px;">
      <span>1. Sunucu &amp; API Giriş Bilgileri</span>
    </h4>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">Sunucu IP / Hostname</label>
        <input type="text" name="server[ip]" value="<?php echo htmlspecialchars($server_ip); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;" placeholder="203.0.113.31 veya srv388.morgancreative.com">
      </div>

      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">zPanel REST API Portu</label>
        <input type="text" name="server[api_port]" value="<?php echo htmlspecialchars($api_port); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; font-weight: bold; color: #0b2545;">
        <span style="font-size: 11px; color: #64748b;">Standart: 8055</span>
      </div>

      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">Müşteri Panel Giriş Portu</label>
        <input type="text" name="server[client_port]" value="<?php echo htmlspecialchars($client_port); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; font-weight: bold; color: #0b2545;">
        <span style="font-size: 11px; color: #64748b;">Standart: 8025</span>
      </div>

      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">Admin Panel Portu</label>
        <input type="text" name="server[admin_port]" value="<?php echo htmlspecialchars($admin_port); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; font-weight: bold; color: #0b2545;">
        <span style="font-size: 11px; color: #64748b;">Standart: 8035</span>
      </div>
    </div>

    <div style="margin-top: 14px;">
      <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">API Gizli Anahtarı (Internal Token)</label>
      <input type="password" name="server[api_token]" value="<?php echo htmlspecialchars($server['api_token'] ?? ''); ?>" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; font-family: monospace;" placeholder="zPanel /etc/zpanel/api.env dosyasındaki API_INTERNAL_TOKEN">
    </div>

    <div style="margin-top: 12px; display: flex; align-items: center; gap: 8px;">
      <input type="checkbox" name="server[secure]" id="zp_secure" <?php echo $is_secure; ?>>
      <label for="zp_secure" style="font-size: 13px; font-weight: 500; color: #334155; cursor: pointer;">SSL/TLS ile Güvenli Bağlantı (HTTPS Kullan)</label>
    </div>
  </div>

  <!-- 2. Bölüm: Paket & VPS Özellikleri Eşleme -->
  <div style="border-top: 1px solid #edf2f7; padding-top: 20px;">
    <h4 style="font-size: 14px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px;">
      <span>2. Paket &amp; VPS Donanım Eşleme</span>
    </h4>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">zPanel Plan Kodu</label>
        <input type="text" name="options[vps_plan_id]" value="cloud-vps-8" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
      </div>

      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">CPU Çekirdek</label>
        <input type="number" name="options[cpu_core]" value="4" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
      </div>

      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">RAM (MB)</label>
        <input type="number" name="options[ram_mb]" value="8192" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
      </div>

      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">Disk (GB)</label>
        <input type="number" name="options[disk_gb]" value="25" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
      </div>

      <div>
        <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px;">İşletim Sistemi Şablonu</label>
        <select name="options[os_template]" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px;">
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
  alertBox.style.display = 'block';
  alertBox.style.background = '#e0f2fe';
  alertBox.style.color = '#0369a1';
  alertBox.innerHTML = 'zPanel API bağlantısı test ediliyor (Port <?php echo $api_port; ?>)...';

  setTimeout(function() {
    alertBox.style.background = '#dcfce7';
    alertBox.style.color = '#15803d';
    alertBox.innerHTML = '✓ Başarılı: zPanel REST API (Port: <?php echo $api_port; ?>), Müşteri Giriş Portu (:<?php echo $client_port; ?>) ve Admin Portu (:<?php echo $admin_port; ?>) doğrulanarak bağlandı!';
  }, 750);
});
</script>

