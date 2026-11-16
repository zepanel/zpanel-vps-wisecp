<?php
/**
 * zPanel VPS - Admin Sipariş Detay Formu (Order Detail)
 * WiseCP 3 ve WiseCP 5 Çekirdek Standartlarına Uygundur.
 */
defined('CORE_FOLDER') OR exit('You can not access this file.');

$LANG     = $module->lang ?? [];
$order    = isset($order) && $order ? $order : [];
$options  = isset($order['options']) ? $order['options'] : [];
$config   = isset($options['config']) ? $options['config'] : [];
$domain   = isset($options['domain']) ? $options['domain'] : ($order['domain'] ?? '');
$serverIp = isset($order['server']['ip']) ? $order['server']['ip'] : ($options['server_ip'] ?? '');
$adminUrl = !empty($serverIp) ? "https://{$serverIp}:8036" : '#';
$vncUrl   = !empty($serverIp) ? "https://{$serverIp}:8036/console" : '#';

$cpuCore = $options['configoptions']['cpu_cores'] ?? ($options['cpu_core'] ?? 4);
$ramMb   = $options['configoptions']['ram_mb'] ?? ($options['ram_mb'] ?? 8192);
$diskGb  = $options['configoptions']['disk_gb'] ?? ($options['disk_gb'] ?? 160);
$bwTb    = $options['configoptions']['bandwidth_tb'] ?? ($options['traffic_gb'] ?? 5);
$osName  = $options['configoptions']['os_name'] ?? ($options['os_template'] ?? 'Ubuntu 24.04 LTS');

$esc = function ($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); };
?>
<link rel="stylesheet" href="coremio/modules/Servers/ZPanelVPS/assets/css/admin.css">

<div class="zp-admin-section">
    <h4 class="zp-admin-section-heading">zPanel VPS Sunucu Yönetimi &amp; Donanım</h4>

    <div class="zp-admin-grid-server">
        <div>
            <label class="zp-admin-label">Sunucu IP / Hostname</label>
            <input type="text" value="<?php echo $esc($serverIp ?: $domain); ?>" readonly class="zp-admin-input-mono">
        </div>
        <div>
            <label class="zp-admin-label">İşlemci (vCPU)</label>
            <input type="text" value="<?php echo (int)$cpuCore; ?> Çekirdek" readonly class="zp-admin-input">
        </div>
        <div>
            <label class="zp-admin-label">Bellek (RAM)</label>
            <input type="text" value="<?php echo (int)$ramMb; ?> MB" readonly class="zp-admin-input">
        </div>
        <div>
            <label class="zp-admin-label">Disk (NVMe SSD)</label>
            <input type="text" value="<?php echo (int)$diskGb; ?> GB" readonly class="zp-admin-input">
        </div>
    </div>

    <div class="zp-admin-row-margin">
        <label class="zp-admin-label">İşletim Sistemi İmajı</label>
        <input type="text" value="<?php echo $esc($osName); ?>" readonly class="zp-admin-input-bold">
    </div>

    <div class="zp-admin-row-margin">
        <a href="<?php echo $esc($adminUrl); ?>" target="_blank" class="zp-btn-test-conn">
            <span>zPanel Root Girişi (:8036) &rarr;</span>
        </a>
        <a href="<?php echo $esc($vncUrl); ?>" target="_blank" class="zp-btn-test-conn">
            <span>Acil Durum Web Konsolu (Web SSH/VNC) &rarr;</span>
        </a>
    </div>
</div>
