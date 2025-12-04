
#  Claim App API

A Laravel-based backend API project for handling user claims and interactions.

##  امکانات

CRUD کامل برای Claim به همراه آپلود فایل,
Reaction (ایموجی) به هر Claim,
ارسال چالش به کاربران دیگر و قابلیت قبول یا رد چالش,
حذف Reaction‌ها
استفاده از Request class‌ها، Resource‌ها، Policy، Notification‌ها,
پروفایل و کش claims with redis,
احراز هویت با JWT.
simple test Feature and CURL,
Ratelimiting for routes,
avatar for users profile.
save claim.
simple and swagger api doc for test just AuthController.
send reaction notif with Queue for owner claim with onQueue('high') in controller and job:)
and some more featrue...

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
    ├── database/
    │   └── factories/
    │   └── migrations/
    ├── routes/
    ├── tests/

##  لایسنس

MIT License © 2025 - Githib: Abolfzl80