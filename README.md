# 🛠️ Setup Project Laravel 12 di Lokal

Dokumentasi ini menjelaskan langkah-langkah untuk melakukan clone dan setup project Laravel 12 secara lokal.

---

## 📥 Clone Repository

```cmd
git clone <URL_REPO_ANDA>
cd <NAMA_FOLDER_PROJECT>
```

> Ganti `<URL_REPO_ANDA>` dan `<NAMA_FOLDER_PROJECT>` sesuai dengan nama repository Anda.

---

## ⚙️ Setup Laravel

### 1. Salin file `.env`
Sebelum menjalankan Laravel, **pastikan sudah memiliki file `.env` yang sesuai**. Hubungi Daniel untuk mendapatkan file `.env` nya.

```cmd
cp .env.example .env
```

> Setelah mendapatkan `.env`, salin dan timpa file `.env` yang ada jika perlu.

### 2. Install Dependency Composer

```cmd
composer install
```

### 3. Generate App Key

```cmd
php artisan key:generate
```

### 4. Jalankan Migration (Opsional)

Jika Anda ingin langsung membuat struktur tabel:

```cmd
php artisan migrate
```

---

## 🧶 Setup Frontend (Vite + Tailwind)

### 1. Install Dependency NPM

```cmd
npm install
```

### 2. Jalankan Dev Server

```cmd
npm run dev
```

---

## 🚀 Jalankan Server Laravel

```cmd
php artisan serve
```

---

## 🔁 Jalankan Semua Proses Sekaligus (Opsional)

Jika ingin menjalankan Laravel, Vite, dan Queue Listener secara bersamaan (gunakan untuk mode development):

```cmd
composer run dev
```

---

## 📁 Tambahan File Excel

Beberapa file Excel dibutuhkan untuk sistem berjalan. Silakan hubungi Daniel untuk mendapatkan **file Excel** tersebut, kemudian **letakkan di direktori** berikut:

```
storage/app/private/
```

---

## ✅ Selesai

Project Laravel 12 Anda sudah siap dijalankan secara lokal 🎉