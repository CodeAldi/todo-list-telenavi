# 📌 Todo API – Laravel 12 - Backend dev take home test

API ini digunakan untuk mengelola data Todo, melakukan export Excel, serta menyediakan data statistik untuk kebutuhan chart. Dibangun menggunakan Laravel 12 dan Laravel Excel.

## 🚀 Tech Stack
- Laravel 12
- PHP 8.2+
- sqlite
- Laravel Excel 3.1
- Postman (Testing)

## 📂 Cara Install
1. Clone repo dan install dependencies:
```
git clone <repository-url>
cd <nama-project>
composer install
```

2. Generate key & buat .env
```
cp .env.example .env
php artisan key:generate
```

3. Migrasi database:
```
php artisan migrate --seed
```

4. Jalankan server:
```
php artisan serve
```

## 🔑 Base URL
`http://localhost:8000/api`

## 📝 Endpoints
### CRUD Todos
- GET /todos
- GET /todos/{id}
- POST /todos
- PUT /todos/{id}
- DELETE /todos/{id}

### Export Excel
- GET /export-todos
- GET /export-todos?filter1=xxx&filter2=yyy...

### Chart Data
- GET /chart?type=status
- GET /chart?type=priority
- GET /chart?type=assignee


