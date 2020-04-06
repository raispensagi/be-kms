<p align="center"><img src="https://media.tenor.com/images/b5a827dab33d5469cbcb26652828f0d2/tenor.gif" height=250px></p>


## Back-End KMS Kelapa Sawit

Berikut adalah back-end dari KMS Kelapa Sawit sebagai projek dari penelitian skripsi

## Instalasi 

### Program Esensial
Untuk menjalankan projek ini, dibutuhkan program berikut:

- **[Composer](https://getcomposer.org/download/)**
- **[XAMPP](https://www.apachefriends.org/download.html)**
- **[Git for Windows](https://gitforwindows.org/)**
- **[Atom](https://atom.io/)** atau **Text Editor yang lain**

### Menjalankan Web

- Clone repository ini dan simpan pada sebuah folder (disarankan dalam folder xampp/htdocs/[nama folder]).
- Buka folder tersebut dan dalam folder tersebut klik kanan dan pilih **Git Bash Here**.
- Dalam terminal GitBash, update composer untuk mengikuti bawaan projek ini:
```
composer update
```
- Aktifkan **XAMPP Control Panel** dan aktifkan **Apache** dan **MySQL**.
- Pada database (defaultnya [localhost/phpmyadmin](http://localhost/phpmyadmin)), buat database baru bernama `kms_sawit`.
- Edit isi dari `.env.example` dengan *text editor*. Ganti bagian `DB_` sesuai dengan database Anda dan simpan sebagai file baru bernama `.env`
```
// Berikut adalah contoh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kms_sawit // bagian ini yang biasa diganti
DB_USERNAME=root
DB_PASSWORD=
```
- Kembali pada terminal GitBash, generasi key untuk laravel:
```
php artisan key:generate
```
- Kemudian, migrasi database:
```
php artisan migrate
```
- Karena projek ini menggunakan otentikasi JWT Token, maka harus *publish* terlebih dahulu
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
- Kemudian, dapatkan secret-key-nya
```
php artisan jwt:secret
```
- Penginstalan server sudah selesai~ Jalankan server local (default [localhost:8000](http://localhost:8000/)):
```
php artisan serve
```

## API List (Untuk sementara ini)

### Otentikasi
#### Petani
- Login
```
POST::  http://localhost:8000/api/petani/login
//  need
    nomor_telefon
    password
```
- Register
```
POST::  http://localhost:8000/api/petani/register
//  need
    nama
    nomor_telefon
    password
    jenis_kelamin
```
- Logout
```
POST::  http://localhost:8000/api/petani/logout
```
- Profil
```
GET::   http://localhost:8000/api/petani/profil
```

#### Pakar Sawit
- Login
```
POST::  http://localhost:8000/api/pakar/login
//  need
    email
    password
```
- Register
```
POST::  http://localhost:8000/api/pakar/register
//  need
    nama
    email
    nomor_telefon
    password
    jenis_kelamin
```
- Logout
```
POST::  http://localhost:8000/api/pakar/logout
```
- Profil
```
GET::   http://localhost:8000/api/pakar/profil
```

## Sekian

Terima Kasih
