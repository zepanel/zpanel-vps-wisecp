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

<div class="zp-wisecp-vps" style="font-family: inherit;">
  <!-- Üst Başlık Kartı -->
  <div class="zp-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; margin-bottom: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
      <div>
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
          <h2 style="font-size: 19px; font-weight: 700; margin: 0; color: #0f172a;"><?php echo htmlspecialchars($packageName); ?></h2>
          <span style="background: #e0f2fe; color: #0369a1; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 9999px;">zPanel v1.0</span>
        </div>
        <div style="font-size: 13px; color: #64748b;">
          <?php if (!empty($domain)): ?>
            <a href="https://<?php echo htmlspecialchars($domain); ?>:<?php echo $clientPort; ?>" target="_blank" style="color: #2563eb; text-decoration: none; font-weight: 700;">
              <?php echo htmlspecialchars($domain); ?>:<?php echo $clientPort; ?>
            </a>
            &bull;
          <?php endif; ?>
          Sunucu IP: <strong style="font-family: monospace; color: #0f172a;"><?php echo htmlspecialchars($serverIp ?: 'Atanmadı'); ?></strong>
          &bull;
          İşletim Sistemi: <strong style="color: #0f172a;"><?php echo htmlspecialchars($osName); ?></strong>
        </div>
      </div>
      <div>
        <a href="<?php echo htmlspecialchars($ssoUrl); ?>" target="_blank" style="background: #2563eb; color: #fff; text-decoration: none; font-weight: 600; padding: 9px 18px; border-radius: 8px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
          zPanel Giriş (:<?php echo $clientPort; ?>) &rarr;
        </a>
      </div>
    </div>
  </div>

  <!-- Makine Donanım Özellikleri Kartları -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 16px; margin-bottom: 20px;">
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
      <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">İşlemci Kapasitesi</div>
      <div style="font-size: 26px; font-weight: 800; color: #0f172a; line-height: 1;"><?php echo htmlspecialchars($cpuCore); ?> <span style="font-size: 13px; font-weight: 600; color: #64748b;">vCPU</span></div>
      <div style="font-size: 12px; color: #94a3b8; margin-top: 6px;">Yüksek Performans Çekirdek</div>
    </div>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
      <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">Bellek (RAM)</div>
      <div style="font-size: 26px; font-weight: 800; color: #0f172a; line-height: 1;"><?php echo htmlspecialchars($ramMb); ?> <span style="font-size: 13px; font-weight: 600; color: #64748b;">MB</span></div>
      <div style="font-size: 12px; color: #94a3b8; margin-top: 6px;">DDR4 / DDR5 ECC RAM</div>
    </div>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
      <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">Depolama Alanı</div>
      <div style="font-size: 26px; font-weight: 800; color: #0f172a; line-height: 1;"><?php echo htmlspecialchars($diskGb); ?> <span style="font-size: 13px; font-weight: 600; color: #64748b;">GB NVMe</span></div>
      <div style="font-size: 12px; color: #94a3b8; margin-top: 6px;">RAID10 NVMe SSD Depolama</div>
    </div>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
      <div style="font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">Aylık Trafik Kotası</div>
      <div style="font-size: 26px; font-weight: 800; color: #0f172a; line-height: 1;"><?php echo htmlspecialchars($bwTb); ?> <span style="font-size: 13px; font-weight: 600; color: #64748b;">TB</span></div>
      <div style="font-size: 12px; color: #94a3b8; margin-top: 6px;">1 Gbps Korumalı Hat</div>
    </div>
  </div>

  <!-- Gerçek Sunucu Eylemleri Butonları -->
  <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; margin-bottom: 20px;">
    <h3 style="font-size: 15px; font-weight: 700; margin: 0 0 16px 0; color: #1e293b;">Sunucu Yönetim Eylemleri</h3>
    
    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
      <form method="post" action="" onsubmit="return confirm('Sunucuyu yeniden başlatmak istediğinize emin misiniz?');">
        <input type="hidden" name="module_action" value="Reboot">
        <button type="submit" style="background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; padding: 9px 18px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer;">
          &#x21bb; Sunucuyu Yeniden Başlat
        </button>
      </form>

      <form method="post" action="" onsubmit="return confirm('zPanel servislerini yeniden başlatmak istediğinize emin misiniz?');">
        <input type="hidden" name="module_action" value="RestartPanel">
        <button type="submit" style="background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; padding: 9px 18px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer;">
          &#x2699; zPanel Servislerini Yeniden Başlat
        </button>
      </form>

      <a href="https://<?php echo htmlspecialchars($panelHost); ?>:8046" target="_blank" style="background: #f8fafc; color: #0f172a; border: 1px solid #cbd5e1; padding: 9px 18px; border-radius: 8px; font-weight: 600; font-size: 13px; text-decoration: none;">
        &#x2709; Webmail Giriş (:8046)
      </a>
    </div>
  </div>

  <!-- Ağ ve Port Detayları Tablosu -->
  <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px;">
    <h3 style="font-size: 15px; font-weight: 700; margin: 0 0 14px 0; color: #1e293b;">Sunucu Ağ &amp; Port Yapılandırması</h3>
    <table style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
      <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px 0; color: #64748b;">Statik IPv4 Adresi</td><td style="padding: 10px 0; font-family: monospace; font-weight: 700;"><?php echo htmlspecialchars($serverIp ?: 'Atanmadı'); ?></td></tr>
      <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px 0; color: #64748b;">Web Sunucusu</td><td style="padding: 10px 0; font-weight: 600;">zMaxServer &amp; OpenLiteSpeed (LSAPI)</td></tr>
      <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px 0; color: #64748b;">zPanel Müşteri Paneli</td><td style="padding: 10px 0; font-family: monospace; color: #2563eb; font-weight: 700;">8026 / TCP (HTTPS)</td></tr>
      <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px 0; color: #64748b;">zPanel Root / Yönetici Paneli</td><td style="padding: 10px 0; font-family: monospace; color: #d97706; font-weight: 700;">8036 / TCP (HTTPS)</td></tr>
      <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px 0; color: #64748b;">Webmail Portu</td><td style="padding: 10px 0; font-family: monospace; font-weight: 700;">8046 / TCP (HTTPS)</td></tr>
      <tr style="border-bottom: 1px solid #f1f5f9;"><td style="padding: 10px 0; color: #64748b;">Core REST API Portu</td><td style="padding: 10px 0; font-family: monospace; font-weight: 700;">8056 / TCP (HTTPS)</td></tr>
    </table>
  </div>
</div>
