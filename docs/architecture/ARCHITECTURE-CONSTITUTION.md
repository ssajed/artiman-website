
---

## ۵. Active Modules

### Core
**مسئولیت:**
- Shared Traits / Base Classes / Helpers
- System Settings
- Feature Flags
- Audit Log
- Change History
- Workflow زیرساخت (Interface + Trait)

**شامل نمی‌شود:**
- Generic Workflow Engine
- Business Logic خاص

### Identity
**مسئولیت:**
- User Model مرکزی
- Authentication
- Role/Permission
- Authorization

**جدول‌ها:**
- `users` (بدون prefix، استاندارد Laravel)
- جدول‌های RBAC (بدون prefix)

**نقش‌ها:**
- Super Admin
- Admin
- Employee
- Customer
- Supplier
- Guest

---

## ۶. Future Module Roadmap

### Next Business Modules
- **CRM** — مدیریت مشتریان و ارتباطات
- **Sales** — سفارشات فروش، پیش‌فاکتور
- **Production** — برنامه‌ریزی و اجرای تولید
- **Inventory** — مدیریت موجودی
- **CoolingTowerConfigurator** — پیکربندی برج خنک‌کننده

### Future Reserved
- Products
- Projects
- Engineering
- QC
- Costing
- Documents
- Reports
- Notifications
- Procurement
- OdooIntegration

### Out of Current Scope
- CMS
- PageBuilder

**نکته:** این ماژول‌ها فعلاً در Runtime ثبت نمی‌شوند. فقط در Documentation موجود هستند.

---

## ۷. Module Boundary Rules

### اصل جداسازی
ماژول‌ها باید **مرزهای واضح** داشته باشند و coupling مستقیم و کنترل‌نشده با یکدیگر نداشته باشند.

### قوانین

1. **بدون دسترسی مستقیم و کنترل‌نشده به Model ماژول دیگر**
   - ارتباط باید از طریق Service Contract یا Event باشد
   - جزئیات نحوه ارجاع بین ماژول‌ها در Database Convention / ADR مشخص می‌شود

2. **ارتباط بین ماژول‌ها:**
   - **Sync:** Service Contract (Interface)
   - **Async:** Events + Listeners
   - نوع ارتباط بر اساس ماهیت عملیات تعیین می‌شود

3. **Database:**
   - یک دیتابیس مشترک
   - Prefix برای هر ماژول: `{module}_{entity}`
   - جزئیات Foreign Key بین ماژول‌ها در Database Convention / ADR مشخص می‌شود

4. **Routes:**
   - هر ماژول routes خود را ثبت می‌کند
   - Prefix: `/{module}/...`

5. **Views:**
   - هر ماژول views خود را دارد
   - Namespace: `{module}::view_name`

---

## ۸. Dependency Governance

### قوانین افزودن Dependency

1. **هیچ Dependency جدید بدون بررسی و تأیید اضافه نشود**
2. هر Dependency باید:
   - نیاز واقعی داشته باشد
   - با Architecture سازگار باشد
   - نگهداری‌شده و پایدار باشد
   - لایسنس مناسب داشته باشد
3. Dependencyهای مهم باید در ADR ثبت شوند
4. Version Constraint باید با سیاست واقعی Composer/NPM پروژه سازگار باشد

### Dependencyهای تأییدشده

**Production:**
- Packageهای RBAC (Spatie Permission)
- Packageهای Audit Log (Spatie Activity Log)
- Packageهای Image manipulation

**Development:**
- Static analysis (Larastan/PHPStan)
- Code style (Laravel Pint)
- Testing (PHPUnit)

### Dependencyهای Proposed / Pending Approval

این موارد فعلاً به‌عنوان نیاز احتمالی شناسایی شده‌اند و قبل از نصب نیاز به بررسی و تأیید جداگانه دارند:

- Image manipulation package (انتخاب نهایی مشخص نشده)
- سایر موارد بر اساس نیاز واقعی در فازهای بعدی

### Dependencyهای ممنوعه (تا اطلاع ثانوی)

- ❌ Microservices frameworks
- ❌ Event Sourcing packages
- ❌ Redis / Horizon (تا نیاز واقعی)
- ❌ Elasticsearch / Meilisearch (تا نیاز واقعی)
- ❌ Graph Database drivers
- ❌ Multiple authentication packages
- ❌ Heavy admin panels (Voyager, Backpack, Filament)

---

## ۹. Database Architecture Rules

### Naming Convention

**جداول:**
- Format: `{module}_{entity}` (snake_case، جمع)
- استثنا: `users` (بدون prefix، استاندارد Laravel)

**ستون‌ها:**
- snake_case
- Primary Key: `id` (bigint, auto-increment)
- Foreign Key: `{entity}_id`
- Boolean: `is_{adjective}`
- Timestamp: `created_at`, `updated_at`, `deleted_at`
- Audit: `created_by`, `updated_by`, `deleted_by`

### Foreign Key Rules

- جزئیات Foreign Key بین ماژول‌ها در Database Convention / ADR مشخص می‌شود
- اصل مهم: جلوگیری از coupling مستقیم و کنترل‌نشده بین ماژول‌ها

### Timestamp & Soft Delete

- همه جداول: `created_at`, `updated_at`
- Entityهای کسب‌وکاری: `deleted_at` (soft delete)
- جداول سیستمی: بدون soft delete

### Audit Fields

- `created_by`, `updated_by`, `deleted_by`
- نوع: `unsignedBigInteger nullable`
- بدون FK فیزیکی
- Audit Service مسئول ثبت ارتباط

### Audit / Change History / Workflow History

- سه سیستم باید از نظر مفهومی و داده‌ای جدا باشند
- نام فیزیکی جدول‌ها و جزئیات پیاده‌سازی در Database Convention / ADR مشخص می‌شود

---

## ۱۰. Identity & RBAC Rules

### User Model

- یک `User` Model مرکزی
- جدول: `users` (بدون prefix)
- محل: `App\Modules\Identity\Models\User`

### Role/Permission

- ساختار: `{module}.{submodule}.{action}`
- مثال: `sales.orders.create`, `crm.customers.edit`

### Profile Tables

- Customer: جدول `customers` با `user_id`
- Supplier: جدول `suppliers` با `user_id`
- هر ماژول Profile خود را مدیریت می‌کند

### Multi-Guard

- فعلاً یک Guard
- معماری آماده برای افزودن Guard در آینده
- فقط در صورت نیاز واقعی

### 2FA

- فعلاً پیاده‌سازی نمی‌شود
- Architecture باید قابلیت افزودن داشته باشد

---

## ۱۱. Audit / Change History / Workflow Rules

### سه سیستم جدا

1. **Audit Log**
   - چه کسی، چه کاری، چه زمانی
   - امنیت، compliance

2. **Change History**
   - تغییرات فیلد به فیلد
   - Business intelligence

3. **Workflow History**
   - تغییرات state
   - Process tracking

### الزامات

- هر سه سیستم باید از نظر مفهومی و داده‌ای جدا باشند
- Change History می‌تواند ساختار عمومی داشته باشد
- Workflow History مخصوص هر Entity است
- نام فیزیکی جدول‌ها در Database Convention / ADR مشخص می‌شود

---

## ۱۲. Integration Governance

### External Integrations (مثل Odoo)

**Source of Truth:**
- سطح Entity/Field تعیین می‌شود
- برای هر Entity باید مشخص باشد کدام سیستم منبع اصلی است

**Sync Direction:**
- بر اساس Source of Truth تعیین می‌شود
- بدون Two-way Sync آزاد و بدون مالکیت فیلدها

**Architecture:**
- Integration Layer مستقل
- Odoo (یا هر سیستم خارجی) نباید Dependency اصلی سایت باشد
- Fallback mechanism الزامی است
- جزئیات پیاده‌سازی در ADR اختصاصی Integration مشخص می‌شود

### سایر Integrationها

- هر Integration مهم باید ADR اختصاصی داشته باشد
- نباید Dependency اصلی سیستم شود
- Fallback mechanism الزامی است

---

## ۱۳. Frontend Architecture Rules

### Stack

- **Template Engine:** Blade
- **Interactivity:** Alpine.js
- **CSS Framework:** Bootstrap RTL + Custom CSS
- **Font:** Vazirmatn

**نکته:** نسخه ابزارها در Baseline ثبت می‌شود، نه در Constitution. Constitution فقط نوع ابزار را مشخص می‌کند.

### اصول

- **RTL-first:** همه CSS از ابتدا RTL
- **Design Tokens:** مرکزی (Colors, Typography, Spacing, etc.)
- **Blade Components:** قابل استفاده مجدد
- **بدون SPA سراسری:** مگر در موارد خاص با تأیید معماری

---

## ۱۴. Multilingual Architecture

### زبان‌ها

- **فارسی:** زبان اصلی
- **انگلیسی:** زبان دوم
- معماری آماده برای زبان سوم

### URL Strategy

- Subdirectory: `/fa/...`, `/en/...`

### Translation Scope

- UI (دکمه‌ها، منوها، پیام‌ها)
- Content (مقالات، محصولات، صفحات)

### RTL/LTR

- RTL-first
- LTR به‌عنوان حالت دوم

---

## ۱۵. Testing & Code Quality

### ابزارها

- **Code Style:** Laravel Pint
- **Testing:** PHPUnit (Unit/Feature)
- **Static Analysis:** Larastan (تدریجی)

### قوانین

- Testing اجباری است
- همه تغییرات مهم باید test داشته باشند
- Static analysis از ابتدا فعال، سخت‌گیری تدریجی

### CI/CD

- GitHub Actions: test + Pint + Static analysis در PR
- Auto-deploy در صورت نیاز و با تأیید

---

## ۱۶. Git & ADR Governance

### Git Workflow

- GitHub Flow: `main` + `feature/*` + PR
- PR review برای تغییرات مهم
- Commit message استاندارد

### ADR

- تصمیمات معماری مهم باید ADR داشته باشند
- ADRها در `docs/adr/` ذخیره شوند
- ADR مرجع تصمیمات جزئی است
- Constitution مرجع اصول کلی است

### تعارض ADR و Constitution

- اگر ADR با Constitution تعارض دارد:
  1. ابتدا Constitution بررسی شود
  2. در صورت نیاز، Constitution به‌روزرسانی رسمی شود
  3. سپس ADR اجرا شود

---

## ۱۷. Forbidden / Restricted Architectural Decisions

### ممنوعه (تا اطلاع ثانوی)

- ❌ Microservices
- ❌ Event Sourcing
- ❌ Repository Pattern برای همه Modelها
- ❌ Redis / Horizon (تا نیاز واقعی)
- ❌ Elasticsearch / Meilisearch (تا نیاز واقعی)
- ❌ Graph Database
- ❌ Multiple Authentication Packages
- ❌ Heavy Admin Panels
- ❌ Generic Workflow Engine در Core
- ❌ Multi-Guard (تا نیاز واقعی)
- ❌ 2FA (تا نیاز واقعی)

### محدود

- ⚠️ Dynamic Workflow Designer (فقط در صورت نیاز واقعی)
- ⚠️ A/B Testing (فقط زیرساخت، نه پیاده‌سازی کامل)
- ⚠️ SLA/Escalation خودکار (فقط Architecture-ready)

---

## ۱۸. Architecture Change Process

### مراحل

1. **پیشنهاد:** Programmer یا Architect پیشنهاد می‌دهد
2. **بررسی:** Architect انطباق با Constitution را بررسی می‌کند
3. **ADR:** اگر نیاز است، ADR تهیه شود
4. **تأیید:** Project Owner تأیید می‌کند
5. **اجرا:** Programmer پیاده‌سازی می‌کند
6. **مستندسازی:** Constitution در صورت نیاز به‌روزرسانی شود

### تغییرات کوچک

- تغییرات جزئی (مثل نام‌گذاری) نیاز به ADR ندارند
- ولی باید در PR مستند شوند

### تغییرات بزرگ

- تغییرات معماری مهم حتماً ADR نیاز دارند
- تأیید Project Owner الزامی است

---

## ۱۹. Architecture Drift Check

### Checklist قبل از تغییرات مهم

قبل از هر تغییر مهم، این سوالات را بررسی کنید:

- [ ] آیا تغییر با Architecture Constitution سازگار است؟
- [ ] آیا Boundary ماژول‌ها حفظ شده؟
- [ ] آیا Module جدید بدون تأیید ایجاد نشده؟
- [ ] آیا Dependency جدید بررسی شده؟
- [ ] آیا Database Convention حفظ شده؟
- [ ] آیا Identity/RBAC Rules حفظ شده؟
- [ ] آیا Source of Truth تغییر نکرده؟
- [ ] آیا تصمیم معماری جدید نیاز به ADR دارد؟
- [ ] آیا Phase/Scope فعلی نقض نشده؟
- [ ] آیا تغییر باعث Architectural Drift می‌شود؟

### اگر پاسخ هر سوال "خیر" است:

1. تغییر را متوقف کنید
2. با Architect مشورت کنید
3. در صورت نیاز، ADR تهیه کنید
4. Constitution را در صورت نیاز به‌روزرسانی کنید

---

## ۲۰. Current Architecture Baseline

### ⚠️ توجه مهم

**Baseline وضعیت فعلی معماری است.** در صورت تغییر معماری، Baseline باید از طریق فرآیند Architecture Change Process و در صورت نیاز ADR به‌روزرسانی شود.

Baseline به‌تنهایی نباید باعث شود هر تغییر کوچک نیازمند تغییر Constitution شود. تغییرات جزئی در Baseline (مثل به‌روزرسانی نسخه ابزار) بدون تغییر Constitution امکان‌پذیر است.

### Active Modules

- Core
- Identity

### Next Business Modules

- CRM
- Sales
- Production
- Inventory
- CoolingTowerConfigurator

### Future Reserved

- Products
- Projects
- Engineering
- QC
- Costing
- Documents
- Reports
- Notifications
- Procurement
- OdooIntegration

### Out of Current Scope

- CMS
- PageBuilder

### Stack (وضعیت فعلی)

- Laravel 13
- PHP 8.3
- MySQL 8
- Bootstrap RTL + Alpine.js
- Blade Templates

**نکته:** نسخه دقیق ابزارها در `composer.json` و `package.json` مشخص است و ممکن است به‌روزرسانی شود.

### Phase 0 Scope

- ✅ Environment Verification
- ✅ Install essential packages
- ✅ Create Core Module (Skeleton)
- ✅ Create Identity Module (Skeleton)
- ✅ Module Discovery System
- ✅ Code Quality setup
- ❌ Business Modules
- ❌ Services (بعد از Skeleton)

---

## 📝 Change Log

| Version | Date | Changes |
|---------|------|---------|
| 1.0 | 2026-09-20 | Initial version |
| 1.1 | 2026-09-20 | Updated module list, removed CMS/PageBuilder from scope |
| 1.2 | 2026-09-20 | Removed implementation details, softened ADR requirement for modules, separated Constitution from Baseline, removed hard FK rules between modules, removed coverage %, marked unapproved dependencies as pending |

---

**End of Constitution**