
# 🛒 E-Commerce Platform – Laravel, MySQL & Blade

A powerful and full-featured **e-commerce web application** built with **Laravel**, designed for seamless online shopping, product management, and admin control.

🔗 **Live Repo:** [E-Commerce Platform on GitHub](https://github.com/Hatem-Mohammed-toma/E_Commerce)

---

## 🚀 Features

- **User Authentication**
  - Secure login, registration, and account management
  - Role-based access control using middleware (Admin/User)

- **Product Management**
  - CRUD operations for products and categories
  - Image upload and validation

- **Shopping Cart & Checkout**
  - Add to cart, update quantities, and remove items
  - Complete checkout process with order placement

- **Admin Dashboard**
  - View and manage users, orders, products, and inventory
  - Filter orders by status

- **Password Reset**
  - Integrated Mailtrap for handling forgot/reset password functionality

- **API & Blade Views**
  - APIs for backend operations
  - Blade templates for clean frontend design

---

## 🛠️ Tech Stack

| Layer        | Tools Used                        |
|--------------|-----------------------------------|
| Backend      | Laravel 10, MySQL, RESTful API    |
| Frontend     | Blade, Bootstrap                  |
| Auth         | Laravel Sanctum or JWT            |
| Features     | Middleware, Mailtrap, Eloquent ORM|

---

## 📁 Project Structure (Laravel)

```
/ecommerce-app
├── app/
│   ├── Http/Controllers/          # Web & API controllers
│   ├── Models/                    # Eloquent models (User, Product, Order)
│   └── Notifications/             # Mail notifications (e.g., password reset)
│
├── routes/
│   ├── web.php                    # Routes for Blade views
│   └── api.php                    # Routes for API access
│
├── resources/views/               # Blade frontend templates
├── database/migrations/           # Table schemas
├── public/                        # Frontend assets (images, CSS, JS)
└── README.md                      # Project overview
```

---

## 🌐 Localization (English & Arabic)

This project supports **multi-language localization** using Laravel’s built-in `lang` directory and localization features. Language can be switched based on user session or browser settings.

---

## ⚙️ Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Hatem-Mohammed-toma/E_Commerce
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Environment setup**
   - Copy `.env.example` to `.env`
   - Set database and mail credentials
   - Run:
     ```bash
     php artisan key:generate
     php artisan migrate --seed
     ```

4. **Run the application**
   ```bash
   php artisan serve
   ```

---

## 📌 Developer

- **Name:** Hatem Mohammed Toma  
- **GitHub:** [@Hatem-Mohammed-toma](https://github.com/Hatem-Mohammed-toma)
