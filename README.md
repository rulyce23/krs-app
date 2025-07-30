# SIMAK - Sistem Informasi Akademik (KRS App)

## Format Pengumpulan
- Repository GitHub
- Dokumentasi Instalasi (README.md)
- File SQL Database

## Teknologi yang Digunakan
- **Bahasa Pemrograman**: PHP dengan framework Laravel 12
- **Database**: MySQL/SQLite
- **Frontend**: HTML, CSS (Tailwind CSS), JavaScript
- **Package Manager**: Composer (PHP), NPM (JavaScript)
- **Build Tool**: Vite

## Deskripsi Sistem
SIMAK adalah aplikasi berbasis web untuk pengelolaan Kartu Rencana Studi (KRS) mahasiswa. Sistem ini memungkinkan mahasiswa untuk melakukan pengisian KRS, melihat jadwal kuliah, serta memudahkan admin dalam mengelola data mahasiswa, mata kuliah, dan proses persetujuan KRS.

## Panduan Instalasi

### Persyaratan Sistem
- PHP >= 8.2
- Composer
- Node.js dan NPM (untuk pengembangan frontend)
- MySQL atau SQLite

### Langkah-langkah Instalasi
1. **Clone repository ini**
   ```bash
   git clone https://github.com/username/krs-app.git
   cd krs-app
   ```

2. **Instal dependensi PHP dan JavaScript**
   ```bash
   # Instal dependensi PHP
   composer install
   
   # Instal dependensi JavaScript (opsional, hanya untuk pengembangan frontend)
   npm install
   ```

3. **Salin file .env**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi database**
   - Buka file `.env` dan sesuaikan konfigurasi database.
   - Untuk SQLite (direkomendasikan untuk pengembangan):
     ```
     DB_CONNECTION=sqlite
     ```
   - Atau untuk MySQL:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=krs_app
     DB_USERNAME=root
     DB_PASSWORD=
     ```

6. **Buat database**
   - Jika menggunakan SQLite, file database akan dibuat otomatis saat menjalankan migrasi
   - Jika menggunakan MySQL, buat database baru bernama `krs_app`
   - Atau import file SQL yang disediakan:
     ```bash
     mysql -u root -p < database/krs_app.sql
     ```

7. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate --seed
   ```
   - Jika menggunakan file SQL yang diimport pada langkah sebelumnya, Anda tidak perlu menjalankan migrasi

8. **Jalankan server pengembangan**
   ```bash
   # Jalankan server Laravel
   php artisan serve
   ```
   
   Untuk pengembangan frontend (opsional):
   ```bash
   # Jalankan Vite development server
   npm run dev
   
   # Atau jalankan keduanya secara bersamaan (Laravel + Vite)
   composer dev
   ```

9. **Build aset frontend untuk produksi (opsional)**
   ```bash
   npm run build
   ```

10. **Akses aplikasi**
    Buka browser dan akses `http://localhost:8000`

    Login dengan kredensial default:
    - **Admin**:
      - Username: admin
      - Password: admin123
    - **Koordinator**:
      - Username: koordinator
      - Password: koordinator123
    - **Mahasiswa**:
      - NIM: 2021001
      - Password: student123

## Struktur Database

### Tabel Utama

1. **students** - Menyimpan data mahasiswa
   - id (PK)
   - nim (unique)
   - name
   - email (unique)
   - password
   - major
   - semester
   - remember_token
   - timestamps

2. **courses** - Menyimpan data mata kuliah
   - id (PK)
   - code (unique)
   - name
   - description
   - credits
   - semester
   - day
   - start_time
   - end_time
   - room
   - lecturer
   - quota
   - is_active
   - timestamps

3. **student_courses** - Menyimpan data KRS mahasiswa (relasi many-to-many)
   - id (PK)
   - student_id (FK)
   - course_id (FK)
   - academic_year
   - semester
   - status (pending, approved, rejected)
   - notes
   - timestamps
   - unique constraint: student_id, course_id, academic_year, semester

4. **admins** - Menyimpan data admin
   - id (PK)
   - username (unique)
   - name
   - email (unique)
   - password
   - role
   - remember_token
   - timestamps

### Diagram Relasi

```
+------------+       +------------------+       +----------+
|  students  |       | student_courses  |       |  courses |
+------------+       +------------------+       +----------+
| id         |<----->| student_id      |       | id       |
| nim        |       | course_id       |<----->| code     |
| name       |       | academic_year   |       | name     |
| email      |       | semester        |       | credits  |
| password   |       | status          |       | semester |
| major      |       | notes           |       | day      |
| semester   |       | timestamps      |       | time     |
| timestamps |       |                 |       | room     |
+------------+       +------------------+       | lecturer |
                                                | quota    |
+------------+                                  | is_active|
|   admins   |                                  | timestamps|
+------------+                                  +----------+
| id         |
| username   |
| name       |
| email      |
| password   |
| role       |
| timestamps |
+------------+
```

## Asumsi dan Batasan Sistem

1. **Asumsi**
   - Sistem digunakan untuk satu institusi pendidikan
   - Tahun akademik menggunakan format "YYYY/YYYY" (contoh: "2024/2025")
   - Semester menggunakan format angka (1-8) atau nama (ganjil/genap)
   - Password default untuk admin adalah "admin123" dan untuk mahasiswa adalah "student123"
   - Setiap mata kuliah memiliki kuota maksimal mahasiswa

2. **Batasan**
   - Mahasiswa hanya dapat mengambil mata kuliah yang aktif (is_active = true)
   - Mahasiswa tidak dapat mengambil mata kuliah yang jadwalnya bentrok
   - Mahasiswa tidak dapat mengambil mata kuliah yang sama lebih dari satu kali dalam satu semester
   - Total SKS yang dapat diambil mahasiswa dibatasi (maksimal 24 SKS)
   - KRS harus disetujui oleh admin sebelum dianggap valid
   - Mahasiswa hanya dapat melihat dan mengelola KRS miliknya sendiri
   - Admin dapat mengelola semua data dalam sistem

3. **Keamanan**
   - Autentikasi menggunakan sistem login dengan password terenkripsi
   - Otorisasi berbasis role (admin dan mahasiswa)
   - Session timeout setelah periode tidak aktif
   - Validasi input untuk mencegah SQL injection dan XSS

## Library dan Dependency

### PHP (Backend)
#### Dependency Utama
- **laravel/framework (^12.0)**: Framework PHP Laravel
- **laravel/sanctum (^4.2)**: Package untuk autentikasi API
- **laravel/tinker (^2.10.1)**: REPL (Read-Eval-Print Loop) untuk Laravel

#### Dependency Development
- **fakerphp/faker (^1.23)**: Library untuk generate data dummy
- **laravel/pail (^1.2.2)**: Laravel log viewer
- **laravel/pint (^1.13)**: PHP code style fixer
- **laravel/sail (^1.41)**: Docker development environment
- **mockery/mockery (^1.6)**: Library untuk mocking dalam testing
- **nunomaduro/collision (^8.6)**: Error handling yang lebih baik
- **phpunit/phpunit (^11.5.3)**: Framework untuk unit testing



### JavaScript (Frontend)
#### Development Dependencies
- **@tailwindcss/vite (^4.0.0)**: Plugin Vite untuk Tailwind CSS
- **axios (^1.8.2)**: HTTP client untuk request AJAX
- **concurrently (^9.0.1)**: Untuk menjalankan beberapa perintah secara bersamaan
- **laravel-vite-plugin (^2.0.0)**: Plugin Vite untuk Laravel
- **tailwindcss (^4.0.0)**: Framework CSS utility-first
- **vite (^7.0.4)**: Build tool dan development server

   