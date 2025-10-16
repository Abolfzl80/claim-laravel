
#  Claim App API

A Laravel-based backend API project for handling user claims and interactions.

##  امکانات

CRUD کامل برای Claim به همراه آپلود فایل,
Reaction (ایموجی) به هر Claim,
ارسال چالش به کاربران دیگر و قابلیت قبول یا رد چالش,
حذف Reaction‌ها
استفاده از Request class‌ها، Resource‌ها، Policy، Notification‌ها,
احراز هویت با JWT.

##  راه‌اندازی سریع

bash:
git clone https://github.com/Abolfzl80/laravel-Claim-App-Beckend.git
composer install
php artisan migrate
php artisan serve
test = CURLTEST.txt 

##  احراز هویت با توکن

Authorization: Bearer YOUR_TOKEN_HERE

##  ساختار پروژه

app/
├── Http/
│   └── Controllers/
│   └── Requests/
│   └── Resources/
├── Models/
├── Notifications/
├── Policies/
├──database/
├──routes/

##  لایسنس

MIT License © 2025 - Githib: Abolfzl80