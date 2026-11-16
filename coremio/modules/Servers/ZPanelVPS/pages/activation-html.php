<?php
/**
 * zPanel VPS - Aktivasyon E-postası (HTML)
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
<link rel="stylesheet" href="coremio/modules/Servers/ZPanelVPS/assets/css/client.css">

<div class="zp-mail-wrap">
    <h2>Bulut Sunucunuz (VPS) Aktif Edildi!</h2>
    <p>Merhaba,</p>
    <p>zPanel Bulut Sunucunuz başarıyla kurulmuş ve hazır hale getirilmiştir. Donanım ve erişim bilgileriniz:</p>
    
    <table class="zp-table">
        <tr class="zp-row-alt">
            <td class="zp-cell-bold">Sunucu IP Adresi:</td>
            <td class="zp-code-bold"><?php echo htmlspecialchars($serverIp, ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr>
            <td class="zp-cell-bold">İşletim Sistemi:</td>
            <td><?php echo htmlspecialchars($osName, ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <tr class="zp-row-alt">
            <td class="zp-cell-bold">İşlemci / RAM / Disk:</td>
            <td><?php echo (int)$cpuCore; ?> vCPU / <?php echo (int)$ramMb; ?> MB RAM / <?php echo (int)$diskGb; ?> GB NVMe SSD</td>
        </tr>
        <tr>
            <td class="zp-cell-bold">zPanel Müşteri Paneli:</td>
            <td><a href="<?php echo htmlspecialchars($clientUrl, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($clientUrl, ENT_QUOTES, 'UTF-8'); ?></a> (:8026)</td>
        </tr>
        <tr class="zp-row-alt">
            <td class="zp-cell-bold">zPanel Root / Yönetici:</td>
            <td><a href="<?php echo htmlspecialchars($adminUrl, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($adminUrl, ENT_QUOTES, 'UTF-8'); ?></a> (:8036)</td>
        </tr>
    </table>
    
    <p>Saygılarımızla,<br>Bulut Sunucu &amp; Altyapı Ekibi</p>
</div>
