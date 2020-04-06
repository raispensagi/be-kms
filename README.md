<p align="center"><img src="https://thumbs.gfycat.com/CheerfulDazzlingChinchilla-size_restricted.gif" height=250px></p>


## Back-End KMS Kelapa Sawit

Berikut adalah back-end dari KMS Kelapa Sawit sebagai projek dari penelitian skripsi. Untuk mengaksesnya secara online/live, dapat diakses melalui ```http://[ip_address]/kms_backend/public/[link api]```

## Instalasi 

### Program Esensial
Untuk menjalankan projek ini, dibutuhkan program berikut:

- **[Composer](https://getcomposer.org/download/)**
- **[XAMPP](https://www.apachefriends.org/download.html)**
- **[Git for Windows](https://gitforwindows.org/)**
- **[Atom](https://atom.io/)** atau **Text Editor yang lain**

### Menjalankan Web

- Clone repository ini dan simpan pada sebuah folder (disarankan dalam folder ```xampp/htdocs/[nama folder]```).
- Buka folder tersebut dan dalam folder tersebut klik kanan dan pilih **Git Bash Here**.
- Dalam terminal GitBash, update composer untuk mengikuti bawaan projek ini:
```
composer update
```
- Sebagai bagian dari otentikasi, buatlah file PHP dalam folder ```vendor/framework/src/Illuminate/Foundation/Auth```. File-file yang akan dibuat dinamakan ```Admin```, ```SuperAdmin```, ```Validator```, ```PakarSawit```, ```Petani```. Untuk isi dari file PHP tersebut, dapat mengikuti contoh ini:
```
<?php

namespace Illuminate\Foundation\Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Admin extends Model implements    //Admin adalah contoh dari classname, dapat diganti sesuai nama file seperti Petani
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
}
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

#### Petani
```
POST::  http://localhost:8000/api/petani/login
//  nomor_telefon
    password
POST::  http://localhost:8000/api/petani/register
//  nama
    nomor_telefon
    password
    jenis_kelamin
POST::  http://localhost:8000/api/petani/logout
GET::   http://localhost:8000/api/petani/profil

GET::  http://localhost:8000/api/petani/artikel/show                // show semua artikel
```

#### Pakar Sawit

```
POST::  http://localhost:8000/api/pakar/login
//  email
    password
POST::  http://localhost:8000/api/pakar/register
//  nama
    email
    nomor_telefon
    password
    jenis_kelamin
POST::  http://localhost:8000/api/pakar/logout
GET::   http://localhost:8000/api/pakar/profil

POST::  http://localhost:8000/api/pakar/artikel/draft               // menyimpan draft
//  judul
    konten
POST::  http://localhost:8000/api/pakar/artikel/post                // melakukan posting
//  id (di URL)
    judul
    konten
PUT::   http://localhost:8000/api/pakar/artikel/draft_to_post/{id}  // posting draft
PUT::   http://localhost:8000/api/pakar/artikel/edit/{id}           // edit artikel
//  id (di URL)
    judul
    konten
GET::   http://localhost:8000/api/pakar/artikel/show                // show artikel milik pakar
```

## Sekian

Terima Kasih
