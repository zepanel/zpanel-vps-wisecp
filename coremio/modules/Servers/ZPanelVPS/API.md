# zPanel Dedicated & VPS Sunucu Modülü API Dokümantasyonu (WISECP)

zPanel VPS sunucu modülü, sunucu üzerindeki zPanel Core REST API (:8056) aracılığıyla güvenli iletişim kurar. Web sunucu altyapısında **zMaxServer (OpenLiteSpeed & LSPHP / LSAPI)** yer alır.

---

## 1. Port ve Servis Haritası

- **8026 / TCP (HTTPS):** Müşteri Kontrol Paneli
- **8036 / TCP (HTTPS):** Root / Yönetici Paneli
- **8046 / TCP (HTTPS):** Webmail Servisi
- **8056 / TCP (HTTPS):** Core REST API

---

## 2. API Yetkilendirme

WISECP `api_token` alanı üzerinden `Authorization: Bearer <token>` başlığıyla haberleşir.

---

## 3. Desteklenen WISECP Metotları ve API Uç Noktaları

| WISECP Metodu | HTTP Yöntemi | zPanel Core API Uç Noktası | Açıklama |
|---|---|---|---|
| `TestConnection` / `test` | `GET` | `/v1/health` | Sunucu erişilebilirliği ve API doğrulaması |
| `CreateAccount` / `create` | Dahili | - | Sunucu hizmetinin müşteri alanında aktifleştirilmesi |
| `SuspendAccount` / `suspend` | Dahili | - | Sunucu durumunu askıya alma |
| `UnsuspendAccount` / `unsuspend` | Dahili | - | Sunucu durumunu aktife alma |
| `TerminateAccount` / `terminate` | Dahili | - | Sunucu hizmetini sonlandırma |
| `Reboot` / `reboot` | `POST` | `/v1/system/reboot` | Sunucuyu işletim sistemi seviyesinde yeniden başlatma |
| `RestartPanel` / `restart_panel` | `POST` | `/v1/system/restart-panel` | zPanel Core ve zMaxServer servislerini yeniden başlatma |
| `ChangePackage` / `change_plan` | Dahili | - | Donanım paketi revizyonu |
| `ClientArea` / `clientArea` | Dahili | `pages/clientArea.php` | Donanım metrikleri, port bilgileri ve hızlı eylemler |

