# zPanel VPS & Cloud Server ServerModule for WISECP V3

WISECP v3 için zPanel VPS ve Bulut Sunucu KVM/LXC otomasyonu modülü.

🌐 **Resmi Web Sitesi:** [www.zepanel.com](https://www.zepanel.com)  
📖 **Dokümantasyon:** [www.zepanel.com/docs](https://www.zepanel.com/docs)  
🔑 **Partner Portalı:** [console.zepanel.com/partner](https://console.zepanel.com/partner)

---

## 🌐 zPanel Hakkında
zPanel (www.zepanel.com), modern web hosting ve bulut sunucu (VPS/VDS/KVM/LXC) altyapılarını yönetmek için sıfırdan tasarlanmış yüksek performanslı yeni nesil bir sunucu kontrol panelidir. 

OpenLiteSpeed (OLS) mikro mimarisiyle çalışır ve sunucu kaynaklarını en verimli şekilde kullanır.

---

## 🔒 Resmi Port Mimarisi

- **8056 / TCP (HTTPS):** Güvenli REST API Portu
- **8026 / TCP (HTTPS):** Müşteri Kontrol Paneli & SSO
- **8036 / TCP (HTTPS):** Bayi (Reseller) & Root Yönetici Paneli & SSO
- **8046 / TCP (HTTPS):** Webmail Paneli
- **8047 / TLS:** İlk Kurulum & Bakım Paneli

---

## 🚀 Hızlı Kurulum

`ash
curl -sSL https://get.zepanel.com/install.sh | bash
`

Resmi site: [https://www.zepanel.com](https://www.zepanel.com)
