/**
 * WISECP v3 zPanel VPS Module - Client Area JavaScript
 */
(function() {
  function renderGauge(elementId, percent, color) {
    var svg = document.getElementById(elementId);
    if (!svg) return;
    var radius = 48;
    var cx = 65;
    var cy = 60;
    var circumference = Math.PI * radius;
    var offset = circumference - (percent / 100) * circumference;

    svg.innerHTML = `
      <path d="M 17 60 A 48 48 0 0 1 113 60" fill="none" stroke="#e2e8f0" stroke-width="9" stroke-linecap="round" />
      <path d="M 17 60 A 48 48 0 0 1 113 60" fill="none" stroke="${color}" stroke-width="9" stroke-linecap="round"
            stroke-dasharray="${circumference}" stroke-dashoffset="${offset}" style="transition: stroke-dashoffset 0.8s ease;" />
    `;
  }

  window.initWisecpVPSGauges = function(cpu, ram, disk) {
    renderGauge('wisecp-gauge-cpu', cpu, '#2563eb');
    renderGauge('wisecp-gauge-ram', ram, '#10b981');
    renderGauge('wisecp-gauge-disk', disk, '#f59e0b');
  };

  window.setWisecpVPSTab = function(e, tabId) {
    e.preventDefault();
    document.querySelectorAll('.zp-tab-item').forEach(function(el) { el.classList.remove('active'); });
    document.querySelectorAll('.zp-pane').forEach(function(el) { el.classList.remove('active'); });
    e.currentTarget.classList.add('active');
    var target = document.getElementById(tabId);
    if (target) target.classList.add('active');
  };

  window.runWisecpVPSAction = function(action, orderId) {
    var warnings = {
      reboot: 'Sunucuyu yeniden başlatmak istiyor musunuz?',
      stop: 'Sunucuyu kapatmak istiyor musunuz?',
      resetRoot: 'Root parolanız sıfırlanıp e-postanıza gönderilsin mi?'
    };

    if (warnings[action] && !confirm(warnings[action])) return;

    var btn = event ? event.currentTarget : null;
    if (btn) btn.style.opacity = '0.5';

    fetch(window.location.href, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'moduleAction=' + encodeURIComponent(action) + '&orderId=' + encodeURIComponent(orderId)
    })
    .then(function(res) { return res.json(); })
    .then(function(resp) {
      if (btn) btn.style.opacity = '1';
      if (resp.status === 'successful' || resp.status === 'success') {
        alert(resp.message || 'İşlem tamamlandı.');
        if (action === 'reboot' || action === 'start' || action === 'stop') {
          setTimeout(function() { location.reload(); }, 1200);
        }
      } else {
        alert('Hata: ' + (resp.message || 'İşlem başarısız.'));
      }
    })
    .catch(function(err) {
      if (btn) btn.style.opacity = '1';
      alert('İstek gönderilemedi.');
    });
  };
})();

