# 📚 API SIA (Sistem Informasi Akademik)

REST API untuk Sistem Informasi Akademik menggunakan Laravel 12 dengan Laravel Sanctum untuk autentikasi. API ini mendukung dua jenis akses: **Web API** (stateful dengan session) dan **Mobile API** (stateless dengan token).

## 🚀 Fitur

-   ✅ **Dual Authentication**: Web (Session) dan Mobile (Token)
-   ✅ **Course Management**: Melihat mata kuliah aktif
-   ✅ **Course Registration**: Registrasi mata kuliah per semester
-   ✅ **Payment System**: Melihat dan pembayaran tagihan
-   ✅ **User Management**: Register, login, profile, logout
-   ✅ **Rate Limiting**: Pembatasan request per menit
-   ✅ **CORS Support**: Cross-origin resource sharing

## 🛠️ Tech Stack

-   **Backend**: Laravel 12
-   **Authentication**: Laravel Sanctum
-   **Database**: SQLite (development)
-   **API Documentation**: RESTful API

## 📋 Prerequisites

-   PHP 8.2+
-   Composer
-   Laravel 12

## ⚡ Quick Start

### 1. Clone Repository

```bash
git clone https://github.com/Fahmi-mi/latihan-api-laravel.git
cd latihan-api-laravel
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup

```bash
php artisan migrate
php artisan db:seed
```

### 5. Start Server

```bash
php artisan serve --port=8000
```

Server akan berjalan di `http://localhost:8000`

## 📚 API Documentation

### Base URLs

-   **Web API**: `http://localhost:8000/api/web`
-   **Mobile API**: `http://localhost:8000/api/mobile`

### Authentication

#### Web API (Stateful)

-   Menggunakan session cookies
-   Login via `/api/web/login`
-   Menyertakan cookies pada setiap request

#### Mobile API (Stateless)

-   Menggunakan Bearer tokens
-   Login/Register via `/api/mobile/login` atau `/api/mobile/register`
-   Header: `Authorization: Bearer {token}`

### Test Accounts

```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

```json
{
    "email": "admin@sia.com",
    "password": "password123"
}
```

## 📱 Mobile API Endpoints

### Authentication

#### Register User

```http
POST /api/mobile/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "device_name": "iPhone 15"
}
```

**Response (201 Created):**

```json
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "token": "1|abcdef123456...",
    "token_type": "Bearer"
}
```

#### Login

```http
POST /api/mobile/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123",
    "device_name": "iPhone 15"
}
```

**Response (200 OK):**

```json
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "token": "2|ghijkl789012...",
    "token_type": "Bearer"
}
```

#### Get Profile

```http
GET /api/mobile/profile
Authorization: Bearer {token}
```

**Response (200 OK):**

```json
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "2025-09-09T10:00:00.000000Z"
    }
}
```

#### Logout

```http
POST /api/mobile/logout
Authorization: Bearer {token}
```

**Response (200 OK):**

```json
{
    "message": "Token revoked"
}
```

### Course Management

#### Get Active Courses

```http
GET /api/mobile/courses
Authorization: Bearer {token}
```

**Response (200 OK):**

```json
[
    {
        "id": 1,
        "name": "Pemrograman Web",
        "code": "PWB001",
        "credits": 3,
        "tuition_fee": 2500000,
        "description": "Mata kuliah yang mempelajari dasar-dasar pengembangan web...",
        "is_active": true,
        "created_at": "2025-09-09T10:00:00.000000Z"
    },
    {
        "id": 2,
        "name": "Database Management System",
        "code": "DMS001",
        "credits": 3,
        "tuition_fee": 2750000,
        "description": "Mata kuliah yang mempelajari konsep database, SQL...",
        "is_active": true,
        "created_at": "2025-09-09T10:00:00.000000Z"
    }
]
```

### Registration

#### Register for Course

```http
POST /api/mobile/registrations
Authorization: Bearer {token}
Content-Type: application/json

{
    "course_id": 1,
    "semester": "2025-Ganjil"
}
```

**Response (200 OK):**

```json
{
    "message": "Registration successful",
    "data": {
        "id": 1,
        "student_id": 2,
        "course_id": 1,
        "semester": "2025-Ganjil",
        "status": "registered",
        "created_at": "2025-09-09T12:00:00.000000Z"
    }
}
```

### Payment

#### Get Payment List

```http
GET /api/mobile/payments
Authorization: Bearer {token}
```

**Response (200 OK):**

```json
[
    {
        "id": 1,
        "student_id": 2,
        "registration_id": 1,
        "amount": 2500000,
        "status": "unpaid",
        "paid_at": null,
        "created_at": "2025-09-09T12:00:00.000000Z"
    }
]
```

#### Pay Invoice

```http
POST /api/mobile/payments
Authorization: Bearer {token}
Content-Type: application/json

{
    "payment_id": 1
}
```

**Response (200 OK):**

```json
{
    "message": "Payment successful",
    "data": {
        "id": 1,
        "student_id": 2,
        "registration_id": 1,
        "amount": 2500000,
        "status": "paid",
        "paid_at": "2025-09-09T13:00:00.000000Z",
        "updated_at": "2025-09-09T13:00:00.000000Z"
    }
}
```

## 🌐 Web API Endpoints

### Authentication

#### Login

```http
POST /api/web/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200 OK):**

```json
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "message": "Login successful"
}
```

> **Note**: Simpan cookies dari response untuk request selanjutnya

#### Logout

```http
POST /api/web/logout
Cookie: {session_cookies}
```

**Response (200 OK):**

```json
{
    "message": "Logged out"
}
```

### Other Endpoints

Web API memiliki endpoint yang sama dengan Mobile API untuk:

-   Course registration (`POST /api/web/registrations`)
-   Payment list (`GET /api/web/payments`)
-   Payment processing (`POST /api/web/payments`)

Perbedaannya hanya pada autentikasi (menggunakan session cookies).

## ⚠️ Error Responses

### 400 Bad Request

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password field is required."]
    }
}
```

### 401 Unauthorized

```json
{
    "message": "Unauthenticated."
}
```

### 404 Not Found

```json
{
    "message": "No query results for model..."
}
```

### 422 Unprocessable Entity

```json
{
    "message": "The email has already been taken.",
    "errors": {
        "email": ["The email has already been taken."]
    }
}
```

## 🔧 Rate Limiting

-   **Default**: 60 requests per minute per IP/user
-   **Login endpoints**: 5 requests per minute
-   **Register endpoint**: 3 requests per minute

## 🚀 Development

### Database Schema

#### Users Table

-   `id`, `name`, `email`, `password`, `created_at`, `updated_at`

#### Courses Table

-   `id`, `name`, `code`, `credits`, `tuition_fee`, `description`, `is_active`, `created_at`, `updated_at`

#### Registrations Table

-   `id`, `student_id`, `course_id`, `semester`, `status`, `created_at`, `updated_at`

#### Payments Table

-   `id`, `student_id`, `registration_id`, `amount`, `status`, `paid_at`, `created_at`, `updated_at`

### Testing

Gunakan Postman atau tools API testing lainnya:

1. Import Postman collection (jika tersedia)
2. Set base URL ke `http://localhost:8000`
3. Test Mobile API endpoints dengan Bearer token
4. Test Web API endpoints dengan session cookies

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Redberry](https://redberry.international/laravel-development)**
-   **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
