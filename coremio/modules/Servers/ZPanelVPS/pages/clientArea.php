<?php
/**
 * WISECP v3 zPanel VPS Module - Client Area View
 * Reference: https://github.com/wisecp-v3/sample-server-module
 * 
 * Dinamik Değerler: Müşterinin alan adı ($domain), sunucu IP'si ($server_ip) ve zPanel portları (:8026).
 */
defined('CORE_FOLDER') OR exit('You can not access this file.');

$domain      = $data['domain'] ?? '';
$serverIp    = $data['server_ip'] ?? '';
$panelHost   = $data['panel_host'] ?? ($domain ?: $serverIp);
$clientPort  = $data['client_port'] ?? 8026;
$status      = $data['status'] ?? 'Active';
$packageName = $data['package_name'] ?? 'Cloud VPS';
$ssoUrl      = $data['sso_url'] ?? '#';

$cpuCore = $data['cpu_core'] ?? 4;
$ramMb   = $data['ram_mb'] ?? 8192;
$diskGb  = $data['disk_gb'] ?? 160;
$bwTb    = $data['bw_tb'] ?? 5;
$osName  = $data['os_name'] ?? 'Ubuntu 24.04 LTS (zPanel Pre-installed)';
?>

<!-- Modül Kendi Varlıkları (Assets) -->
<link rel="stylesheet" href="coremio/modules/Servers/ZPanelVPS/assets/css/client.css">
<script src="coremio/modules/Servers/ZPanelVPS/assets/js/client.js"></script>

<div class="zp-wisecp-vps">
  <!-- Üst Başlık Kartı -->
  <div class="zp-card">
    <div class="zp-header-flex">
      <div>
        <div class="d-flex align-items-center gap-2 mb-1">
          <h2 class="zp-vps-title mb-0"><?php echo htmlspecialchars($packageName); ?></h2>
          <span class="zp-badge-status">
            <?php echo htmlspecialchars($status); ?>
          </span>
        </div>
        <div class="text-muted small font-monospace">
          <?php if (!empty($domain)): ?>
            <a href="https://<?php echo htmlspecialchars($domain); ?>:<?php echo $clientPort; ?>" target="_blank" class="text-primary text-decoration-none fw-bold">
              <?php echo htmlspecialchars($domain); ?>:<?php echo $clientPort; ?>
            </a>
            &bull;
          <?php endif; ?>
          Sunucu IP: <strong><?php echo htmlspecialchars($serverIp ?: 'Belirtilmedi'); ?></strong>
        </div>
      </div>
      <div class="d-flex gap-2">
        <a href="<?php echo htmlspecialchars($ssoUrl); ?>" target="_blank" class="zp-act-btn zp-act-sso px-4 py-2 rounded-pill">
          zPanel Giriş (:<?php echo $clientPort; ?>) &rarr;
        </a>
      </div>
    </div>
  </div>

  <!-- 6 Sade Sekme (Kaydırma Çubuğu Asla Yok) -->
  <div class="zp-tabs">
    <a href="#" class="zp-tab-item active" onclick="setWisecpVPSTab(event, 'tab-overview')">Genel Bakış</a>
    <a href="#" class="zp-tab-item" onclick="setWisecpVPSTab(event, 'tab-management')">Yönetim</a>
    <a href="#" class="zp-tab-item" onclick="setWisecpVPSTab(event, 'tab-addons')">Eklentiler</a>
    <a href="#" class="zp-tab-item" onclick="setWisecpVPSTab(event, 'tab-billing')">Faturalama</a>
    <a href="#" class="zp-tab-item" onclick="setWisecpVPSTab(event, 'tab-activity')">Aktivite</a>
    <a href="#" class="zp-tab-item" onclick="setWisecpVPSTab(event, 'tab-cancel')">İptal</a>
  </div>

  <!-- 1. Sekme: Genel Bakış -->
  <div id="tab-overview" class="zp-pane active">
    <!-- 3 Gauge İbre Kartları -->
    <div class="zp-gauges-row">
      <div class="zp-gauge-box">
        <div class="zp-gauge-label">CPU Kullanımı</div>
        <svg id="wisecp-gauge-cpu" class="zp-gauge-svg"></svg>
        <div class="zp-gauge-val">12%</div>
        <div class="zp-gauge-sub"><?php echo htmlspecialchars($cpuCore); ?> vCPU Çekirdek</div>
      </div>
      <div class="zp-gauge-box">
        <div class="zp-gauge-label">Bellek (RAM)</div>
        <svg id="wisecp-gauge-ram" class="zp-gauge-svg"></svg>
        <div class="zp-gauge-val">28%</div>
        <div class="zp-gauge-sub">2.2 GB / <?php echo round($ramMb / 1024, 1); ?> GB</div>
      </div>
      <div class="zp-gauge-box">
        <div class="zp-gauge-label">Depolama (Disk)</div>
        <svg id="wisecp-gauge-disk" class="zp-gauge-svg"></svg>
        <div class="zp-gauge-val">15%</div>
        <div class="zp-gauge-sub">24 GB / <?php echo htmlspecialchars($diskGb); ?> GB NVMe</div>
      </div>
    </div>

    <!-- 8 Hızlı İşlem Butonu -->
    <div class="zp-actions-grid">
      <button class="zp-act-btn" onclick="runWisecpVPSAction('reboot', '<?php echo htmlspecialchars($serverIp); ?>')">
        <span class="fs-5">🔄</span>
        <span>Yeniden Başlat</span>
      </button>
      <button class="zp-act-btn" onclick="runWisecpVPSAction('start', '<?php echo htmlspecialchars($serverIp); ?>')">
        <span class="fs-5">▶️</span>
        <span>Başlat</span>
      </button>
      <button class="zp-act-btn" onclick="runWisecpVPSAction('stop', '<?php echo htmlspecialchars($serverIp); ?>')">
        <span class="fs-5">⏹️</span>
        <span>Kapat</span>
      </button>
      <button class="zp-act-btn" onclick="runWisecpVPSAction('vnc', '<?php echo htmlspecialchars($serverIp); ?>')">
        <span class="fs-5">🖥️</span>
        <span>VNC Konsol</span>
      </button>
      <button class="zp-act-btn" onclick="runWisecpVPSAction('resetRoot', '<?php echo htmlspecialchars($serverIp); ?>')">
        <span class="fs-5">🔑</span>
        <span>Root Şifresi</span>
      </button>
      <button class="zp-act-btn" onclick="runWisecpVPSAction('rebuild', '<?php echo htmlspecialchars($serverIp); ?>')">
        <span class="fs-5">⚡</span>
        <span>Yeniden Kur</span>
      </button>
      <button class="zp-act-btn" onclick="runWisecpVPSAction('snapshot', '<?php echo htmlspecialchars($serverIp); ?>')">
        <span class="fs-5">💾</span>
        <span>Snapshot</span>
      </button>
      <a href="<?php echo htmlspecialchars($ssoUrl); ?>" target="_blank" class="zp-act-btn zp-act-sso">
        <span class="fs-5">🌐</span>
        <span>zPanel SSO (:<?php echo $clientPort; ?>)</span>
      </a>
    </div>

    <!-- Donanım ve Erişim Detayı -->
    <div class="zp-card p-4">
      <h3 class="h6 fw-bold mb-3">Sunucu ve Donanım Detayı</h3>
      <table class="table table-sm table-borderless mb-0">
        <tbody>
          <tr><td class="text-muted fw-bold" style="width: 25%;">İşletim Sistemi:</td><td><?php echo htmlspecialchars($osName); ?></td></tr>
          <tr><td class="text-muted fw-bold">Statik IP:</td><td class="font-monospace fw-bold"><?php echo htmlspecialchars($serverIp ?: 'Atanmadı'); ?></td></tr>
          <tr><td class="text-muted fw-bold">Müşteri Portu:</td><td class="font-monospace">8026 (HTTPS)</td></tr>
          <tr><td class="text-muted fw-bold">Aylık Trafik:</td><td><?php echo htmlspecialchars($bwTb); ?> TB Yüksek Hızlı Trafik</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <div id="tab-management" class="zp-pane"><div class="zp-card p-4"><p class="text-muted mb-0">DNS, Güvenlik Duvarı ve Port İletme Kuralları zPanel API üzerinden yönetilmektedir.</p></div></div>
  <div id="tab-addons" class="zp-pane"><div class="zp-card p-4"><p class="text-muted mb-0">Ek IP, Ek Disk ve Yedekleme eklentileri aktif.</p></div></div>
  <div id="tab-billing" class="zp-pane"><div class="zp-card p-4"><p class="text-muted mb-0">Sonraki fatura dönemi ve ödeme geçmişi.</p></div></div>
  <div id="tab-activity" class="zp-pane"><div class="zp-card p-4"><p class="text-muted mb-0">Sunucu yeniden başlatma, yedek alma ve kullanıcı giriş günlükleri.</p></div></div>
  <div id="tab-cancel" class="zp-pane"><div class="zp-card p-4"><p class="text-muted mb-0">Hizmet iptal talebi oluşturma ekranı.</p></div></div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (window.initWisecpVPSGauges) {
      window.initWisecpVPSGauges(12, 28, 15);
    }
  });
</script>
