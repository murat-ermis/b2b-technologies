# ✅ Laravel Test Case: "B2B Sipariş Yönetimi API"

## 🎯 Amaç  
Adayın Laravel framework üzerinde **REST API geliştirme**, **authentication**, **role-based erişim**, **Eloquent ilişkiler**, **pivot kullanımı** ve **cache** becerilerini değerlendirmek.

---

## 🧩 Senaryo  
Bir B2B platformunda müşteri kullanıcılarının ürünleri görüntüleyip sipariş verebildiği basit bir sistem geliştirilmesi beklenmektedir.

---

## 👤 Kullanıcı Rolleri

| Rol      | Yetkiler                                                                 |
|----------|--------------------------------------------------------------------------|
| `admin`  | Tüm kullanıcıları ve siparişleri görebilir, ürün yönetebilir             |
| `customer` | Sadece kendi siparişlerini görebilir ve yeni sipariş oluşturabilir      |

---

## 📘 Modeller

### 1. User  
**Alanlar:** `name`, `email`, `password`, `role` (`admin` veya `customer`)

### 2. Product  
**Alanlar:** `name`, `sku`, `price`, `stock_quantity`

### 3. Order  
**Alanlar:** `user_id`, `status` (`pending`, `approved`, `shipped`), `total_price`

### 4. OrderItem (Pivot)  
**Alanlar:** `order_id`, `product_id`, `quantity`, `unit_price`

---

## 🔧 Beklenen API Özellikleri

### 1. Authentication
- Laravel Sanctum ya da Laravel Passport kullanılmalı
- Aşağıdaki endpoint'ler oluşturulmalı:
  - `POST /api/register`
  - `POST /api/login`

### 2. Authorization
- Role-based erişim sağlanmalı (middleware veya policy kullanımıyla)

### 3. Ürün İşlemleri

| Endpoint                | Erişim            |
|-------------------------|------------------|
| `GET /api/products`     | Herkes erişebilir<br>✅ Bu endpoint cache’lenmeli (`file` cache yeterli, `Redis` kullanımı artı puandır) |
| `POST /api/products`    | Sadece `admin`    |
| `PUT /api/products/{id}`| Sadece `admin`    |
| `DELETE /api/products/{id}` | Sadece `admin` |

### 4. Sipariş İşlemleri

| Endpoint                 | Açıklama                                                              |
|--------------------------|-----------------------------------------------------------------------|
| `GET /api/orders`        | Admin tüm siparişleri, müşteri sadece kendi siparişlerini görebilmeli |
| `POST /api/orders`       | Müşteri yeni sipariş oluşturmalı                                     |
| `GET /api/orders/{id}`   | Yalnızca yetkili kullanıcı erişebilmeli                               |

---

## 🔁 Pivot Model Kullanımı

Sipariş oluşturulurken birden fazla ürün içerecek şekilde veri gönderilmelidir.

**Örnek JSON payload:**

```json
{
  "items": [
    { "product_id": 1, "quantity": 2 },
    { "product_id": 3, "quantity": 1 }
  ]
}
```

## 🐳 Ekstra Puan

Aşağıdaki geliştirmeler teknik değerlendirme sürecinde **artı puan** kazandıracaktır:

- Projenin **Docker ile çalışabilir** şekilde hazırlanmış olması
- `docker-compose.yml` dosyasının aşağıdaki servisleri içermesi:
  - Laravel
  - MySQL
  - Redis (**opsiyonel** ancak varsa ekstra puan sağlar)
- Ortam yapılandırması için `.env.example` dosyasının sağlanması

---

## 📁 Teslim Şartları

- Proje bir **GitHub reposu** olarak paylaşılmalıdır
- Aşağıdaki bilgiler `README.md` dosyasında yer almalıdır:
  - Projeyi çalıştırma talimatları (Docker kullanılıyorsa adım adım açıklanmalı)
  - Örnek kullanıcılar (örneğin bir `admin` ve bir `customer` hesabı)
  - API istek örnekleri (isteğe bağlı olarak Postman collection da paylaşılabilir)

---

## 🧪 Bonus (İsteğe Bağlı)

Aşağıdaki öğelerin projeye dahil edilmesi artı puan olarak değerlendirilir:

- Unit test ve/veya Feature test dosyaları
- Tüm endpoint’ler için **request validation** kurallarının doğru şekilde uygulanmış olması
- Laravel **Resource sınıfları** kullanılarak JSON response çıktılarının yapılandırılması

