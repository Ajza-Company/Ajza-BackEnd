# دليل نظام المستخدمين والأدوار والصلاحيات - مشروع Ajza

## 📋 جدول المحتويات

1. [نظرة عامة على النظام](#نظرة-عامة-على-النظام)
2. [الأدوار (Roles)](#الأدوار-roles)
3. [الصلاحيات (Permissions)](#الصلاحيات-permissions)
4. [نموذج المستخدم (User Model)](#نموذج-المستخدم-user-model)
5. [كيفية استخدام النظام](#كيفية-استخدام-النظام)
6. [الملفات الرئيسية](#الملفات-الرئيسية)
7. [إضافة أدوار وصلاحيات جديدة](#إضافة-أدوار-وصلاحيات-جديدة)
8. [أمثلة عملية](#أمثلة-عملية)
9. [استكشاف الأخطاء](#استكشاف-الأخطاء)

---

## 🏗️ نظرة عامة على النظام

مشروع Ajza يستخدم نظام أدوار وصلاحيات متقدم مبني على مكتبة **Spatie Laravel Permission**، ويتكون من:

- **5 أدوار رئيسية** (Admin, Client, Workshop, Supplier, Representative)
- **صلاحيات مفصلة** لكل دور
- **نظام تحكم مرن** في الوصول
- **دعم متعدد اللغات** (عربي/إنجليزي)

---

## 👥 الأدوار (Roles)

### الأدوار المتاحة في النظام:

| الدور | الوصف | الصلاحيات |
|-------|-------|-----------|
| **Admin** | مدير النظام | جميع الصلاحيات |
| **Client** | العميل | صلاحيات محدودة للتصفح والشراء |
| **Workshop** | ورشة عمل | إدارة الطلبات والإصلاحات |
| **Supplier** | المورد | إدارة المتاجر والمنتجات |
| **Representative** | المندوب | إدارة المبيعات والتسويق |

### ملف تعريف الأدوار:
```json
[
    {"name": "Admin", "guard_name": "api"},
    {"name": "Client", "guard_name": "api"},
    {"name": "Workshop", "guard_name": "api"},
    {"name": "Supplier", "guard_name": "api"},
    {"name": "Representative", "guard_name": "api"}
]
```

---

## 🔐 الصلاحيات (Permissions)

### صلاحيات المورد (Supplier):

#### إدارة الطلبات:
- `view-orders` - عرض الطلبات
- `accept-orders` - قبول الطلبات
- `view-orders-statistics` - عرض إحصائيات الطلبات

#### إدارة العروض:
- `view-offers` - عرض العروض
- `control-offer` - التحكم في العرض

#### إدارة المستخدمين:
- `view-users` - عرض المستخدمين
- `edit-users` - تعديل المستخدمين

#### إدارة المتاجر:
- `view-stores` - عرض المتاجر
- `edit-stores` - تعديل المتاجر

#### إدارة الفئات:
- `view-categories` - عرض الفئات
- `edit-categories` - تعديل الفئات

#### إدارة المنتجات:
- `view-products` - عرض المنتجات
- `edit-products` - تعديل المنتجات

### صلاحيات المدير (Admin):

#### إدارة المستخدمين:
- `a.show-all-users` - عرض جميع المستخدمين
- `a.control-user` - التحكم في المستخدم

#### إدارة المتاجر:
- `a.show-all-stores` - عرض جميع المتاجر
- `a.control-store` - التحكم في المتجر

#### إدارة المنتجات:
- `a.show-all-products` - عرض جميع المنتجات
- `a.control-product` - التحكم في المنتج

#### إدارة المحافظات:
- `a.show-all-states` - عرض جميع المحافظات
- `a.control-state` - التحكم في المحافظة

#### إدارة العروض:
- `a.show-all-offers` - عرض جميع العروض
- `a.control-offers` - التحكم في العروض

#### إدارة المحادثات:
- `a.show-all-chat` - عرض جميع المحادثات
- `a.control-chat` - التحكم في المحادثات

#### إدارة مندوبي المبيعات:
- `a.show-all-repSales` - عرض جميع مندوبي المبيعات
- `a.control-repSales` - التحكم في مندوبي المبيعات

#### إدارة العروض الترويجية:
- `a.show-all-promos` - عرض جميع العروض الترويجية
- `a.control-promo` - التحكم في العروض الترويجية

---

## 👤 نموذج المستخدم (User Model)

### الخصائص الأساسية:
```php
protected $fillable = [
    'name',           // اسم المستخدم
    'email',          // البريد الإلكتروني
    'full_mobile',    // رقم الهاتف
    'password',       // كلمة المرور
    'avatar',         // الصورة الشخصية
    'is_active',      // حالة التفعيل
    'is_registered',  // حالة التسجيل
    'gender',         // الجنس
    'state_id',       // معرف المحافظة
];
```

### العلاقات الرئيسية:
- `favorites()` - المفضلة
- `orders()` - الطلبات
- `addresses()` - العناوين
- `stores()` - المتاجر
- `company()` - الشركة
- `wallet()` - المحفظة
- `repOrders()` - طلبات المندوبين
- `userFcmTokens()` - رموز الإشعارات

---

## 🛠️ كيفية استخدام النظام

### 1. التحقق من الصلاحيات في Controllers:

```php
// التحقق من صلاحية معينة
if ($user->can('view-orders')) {
    // يمكن عرض الطلبات
    return $this->showOrders();
}

// التحقق من عدة صلاحيات
if ($user->can(['view-orders', 'accept-orders'])) {
    // يمكن عرض وقبول الطلبات
}

// التحقق من الدور
if ($user->hasRole('Supplier')) {
    // المستخدم مورد
}

// التحقق من عدة أدوار
if ($user->hasAnyRole(['Admin', 'Supplier'])) {
    // المستخدم إما مدير أو مورد
}
```

### 2. استخدام Policies:

```php
class OrderPolicy
{
    public function view(User $user): bool
    {
        return $user->can('view-orders');
    }
    
    public function accept(User $user): bool
    {
        return $user->can('accept-orders');
    }
}
```

### 3. استخدام Middleware:

```php
// Route مع صلاحية واحدة
Route::middleware(['auth:sanctum', 'permission:view-orders'])
    ->get('/orders', [OrderController::class, 'index']);

// Route مع عدة صلاحيات
Route::middleware(['auth:sanctum', 'permission:view-orders|accept-orders'])
    ->post('/orders/{id}/accept', [OrderController::class, 'accept']);

// Route مع دور معين
Route::middleware(['auth:sanctum', 'role:Supplier'])
    ->group(function () {
        // Routes للموردين فقط
    });
```

---

## 📁 الملفات الرئيسية

### Enums:
- `app/Enums/RoleEnum.php` - تعريف الأدوار
- `app/Enums/PermissionEnum.php` - تعريف الصلاحيات

### Data Files:
- `database/data/roles.json` - بيانات الأدوار
- `database/data/permissions.json` - بيانات الصلاحيات

### Seeders:
- `database/seeders/RoleSeeder.php` - إنشاء الأدوار
- `database/seeders/PermissionSeeder.php` - إنشاء الصلاحيات
- `database/seeders/UserSeeder.php` - إنشاء المستخدمين

### Controllers:
- `app/Http/Controllers/api/v1/Supplier/S_PermissionController.php` - إدارة صلاحيات المورد

### Models:
- `app/Models/User.php` - نموذج المستخدم

---

## ➕ إضافة أدوار وصلاحيات جديدة

### إضافة دور جديد:

#### 1. أضف في `app/Enums/RoleEnum.php`:
```php
const NEW_ROLE = 'NewRole';
```

#### 2. أضف في `database/data/roles.json`:
```json
{"name": "NewRole", "guard_name": "api"}
```

#### 3. أعد تشغيل الـ seeder:
```bash
php artisan db:seed --class=RoleSeeder
```

### إضافة صلاحية جديدة:

#### 1. أضف في `app/Enums/PermissionEnum.php`:
```php
const NEW_PERMISSION = 'new-permission';
```

#### 2. أضف في `database/data/permissions.json`:
```json
{
    "name": "new-permission",
    "group_name": "NewGroup",
    "guard_name": "api",
    "role_name": "Supplier",
    "friendly_name": "الصلاحية الجديدة"
}
```

#### 3. أعد تشغيل الـ seeder:
```bash
php artisan db:seed --class=PermissionSeeder
```

### إضافة صلاحية لمستخدم معين:

```php
// إضافة صلاحية واحدة
$user->givePermissionTo('view-orders');

// إضافة عدة صلاحيات
$user->givePermissionTo(['view-orders', 'accept-orders']);

// إزالة صلاحية
$user->revokePermissionTo('view-orders');

// مزامنة الصلاحيات (إزالة القديمة وإضافة الجديدة)
$user->syncPermissions(['view-orders', 'accept-orders']);
```

---

## 💡 أمثلة عملية

### مثال 1: إنشاء مستخدم مورد جديد

```php
$supplier = User::create([
    'name' => 'أحمد محمد',
    'email' => 'ahmed@example.com',
    'full_mobile' => '+966501234567',
    'password' => Hash::make('password123'),
    'is_active' => true,
    'is_registered' => true,
]);

// إضافة دور المورد
$supplier->assignRole('Supplier');

// إضافة صلاحيات المورد
$supplierPermissions = [
    'view-orders',
    'accept-orders',
    'view-offers',
    'control-offer',
    'view-stores',
    'edit-stores',
    'view-products',
    'edit-products'
];

$supplier->syncPermissions($supplierPermissions);
```

### مثال 2: التحقق من الصلاحيات في API

```php
public function index(Request $request)
{
    $user = auth()->user();
    
    // التحقق من الصلاحية
    if (!$user->can('view-orders')) {
        return response()->json([
            'status' => false,
            'message' => 'ليس لديك صلاحية لعرض الطلبات'
        ], 403);
    }
    
    // إذا كان المستخدم مورد، اعرض طلبات متجره فقط
    if ($user->hasRole('Supplier')) {
        $orders = $user->stores->flatMap->orders;
    } else {
        // إذا كان مدير، اعرض جميع الطلبات
        $orders = Order::all();
    }
    
    return OrderResource::collection($orders);
}
```

### مثال 3: إنشاء Policy للتحكم المعقد

```php
class StorePolicy
{
    public function view(User $user, Store $store): bool
    {
        // المدير يمكنه رؤية جميع المتاجر
        if ($user->hasRole('Admin')) {
            return true;
        }
        
        // المورد يمكنه رؤية متجره فقط
        if ($user->hasRole('Supplier')) {
            return $user->stores->contains($store->id);
        }
        
        return false;
    }
    
    public function update(User $user, Store $store): bool
    {
        return $user->can('edit-stores') && 
               ($user->hasRole('Admin') || $user->stores->contains($store->id));
    }
}
```

---

## 🔧 استكشاف الأخطاء

### مشاكل شائعة وحلولها:

#### 1. الصلاحية لا تعمل:
```php
// تأكد من أن الصلاحية موجودة في قاعدة البيانات
$permission = Permission::where('name', 'view-orders')->first();
if (!$permission) {
    // أعد تشغيل seeder الصلاحيات
    php artisan db:seed --class=PermissionSeeder
}
```

#### 2. الدور لا يعمل:
```php
// تأكد من أن الدور موجود
$role = Role::where('name', 'Supplier')->first();
if (!$role) {
    // أعد تشغيل seeder الأدوار
    php artisan db:seed --class=RoleSeeder
}
```

#### 3. Cache مشاكل:
```bash
# امسح cache الصلاحيات
php artisan permission:cache-reset

# امسح cache التطبيق
php artisan cache:clear
```

#### 4. تحقق من Guard:
```php
// تأكد من استخدام Guard الصحيح
$user->can('view-orders', 'api'); // تحديد guard
```

---

## 📊 المستخدمين الحاليين في النظام

### Admin:
- **Email:** `store@ajza.net`
- **Password:** `1Alqarawi1`
- **Role:** Admin (جميع الصلاحيات)

### Suppliers:
- **Email:** `supplier1@ajza.net` / **Password:** `password123`
- **Email:** `supplier2@ajza.net` / **Password:** `password123`
- **Email:** `supplier3@ajza.net` / **Password:** `password123`
- **Role:** Supplier (صلاحيات المورد)

---

## 🎯 نصائح للتطوير

1. **استخدم Enums دائماً** للصلاحيات والأدوار لتجنب الأخطاء
2. **تحقق من الصلاحيات** قبل تنفيذ العمليات الحساسة
3. **استخدم Policies** للتحكم المعقد في الصلاحيات
4. **اختبر الصلاحيات** في Postman قبل النشر
5. **وثق الصلاحيات الجديدة** في ملفات JSON
6. **استخدم Cache** لتحسين الأداء
7. **راجع الصلاحيات** دورياً وتأكد من عدم وجود صلاحيات غير مستخدمة

---

## 📞 الدعم

للمساعدة في نظام الأدوار والصلاحيات:
1. راجع ملفات `database/data/` للصلاحيات والأدوار
2. تحقق من `app/Enums/` للتعريفات
3. راجع `storage/logs/laravel.log` للأخطاء
4. استخدم `php artisan tinker` لاختبار الصلاحيات

---

**آخر تحديث:** أغسطس 2025  
**الإصدار:** Ajza App v1.0
