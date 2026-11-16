<?php
/**
 * zPanel VPS - Aktivasyon E-postası (Metin)
 */
defined('CORE_FOLDER') OR exit('You can not access this file.');
$serverIp    = $order['server']['ip'] ?? ($options['server_ip'] ?? '');
$adminUrl    = !empty($serverIp) ? "https://{$serverIp}:8036" : '';
$clientUrl   = !empty($serverIp) ? "https://{$serverIp}:8026" : '';
$cpuCore     = $options['configoptions']['cpu_cores'] ?? ($options['cpu_core'] ?? 4);
$ramMb       = $options['configoptions']['ram_mb'] ?? ($options['ram_mb'] ?? 8192);
$diskGb      = $options['configoptions']['disk_gb'] ?? ($options['disk_gb'] ?? 160);
$osName      = $options['configoptions']['os_name'] ?? ($options['os_template'] ?? 'Ubuntu 24.04 LTS');
?>
Bulut Sunucunuz (VPS) Aktif Edildi!

Sunucu IP Adresi: <?php echo $serverIp; ?>

İşletim Sistemi: <?php echo $osName; ?>

Donanım: <?php echo (int)$cpuCore; ?> vCPU / <?php echo (int)$ramMb; ?> MB RAM / <?php echo (int)$diskGb; ?> GB NVMe SSD

zPanel Müşteri Paneli: <?php echo $clientUrl; ?> (:8026)

zPanel Root Girişi: <?php echo $adminUrl; ?> (:8036)

Saygılarımızla,
Bulut Sunucu & Altyapı Ekibi
