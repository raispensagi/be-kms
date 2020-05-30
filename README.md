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
```diff
! Akun
POST::  http://localhost:8000/api/petani/register
- Request
+ nama
+ email
+ nomor_telefon (optional, ga di isi ga papa)
+ password

! Bookmark dan Riwayat
GET::   http://localhost:8000/api/petani/bookmark               (Show bookmark)
POST::  http://localhost:8000/api/petani/bookmark/add/{id}      (Tambah bookmark, id adalah id dari konten)
DEL::   http://localhost:8000/api/petani/bookmark/delete/{id}   (Hapus bookmark, id adalah id dari konten)
GET::   http://localhost:8000/api/petani/riwayat                (Show riwayat)

```

#### Pakar Sawit
```diff
! Akun
POST::  http://localhost:8000/api/pakar/register
- Request
+ nama
+ email
+ nomor_telefon (optional, ga di isi ga papa)
+ password
+ foto
POST::  http://localhost:8000/api/pakar/profil/update       (update profil sendiri)
- Sama seperti register

! Konten
POST::  http://localhost:8000/api/pakar/artikel/draft           (Draft Artikel)
- Request
+ judul
+ kategori
+ sub_kategori
+ isi
+ foto
POST::  http://localhost:8000/api/pakar/artikel/post            (Post Artikel)
- Sama seperti draft
POST::  http://localhost:8000/api/pakar/video_audio/draft       (Draft Video/Audio)
- Request
+ judul
+ kategori
+ sub_kategori
+ isi
+ video_audio
POST::  http://localhost:8000/api/pakar/video_audio/post        (Post Video/Audio)
- Sama seperti draft
POST::  http://localhost:8000/api/pakar/edokumen/draft          (Draft E-Dokumen)
- Request
+ judul
+ kategori
+ sub_kategori
+ penulis
+ tahun
+ penerbit
+ halaman
+ bahasa
+ deskripsi
+ file
POST::  http://localhost:8000/api/pakar/edokumen/post           (Post E-Dokumen)
- Sama seperti draft
POST::  http://localhost:8000/api/pakar/draft/post/{id}         (Post Draft, id adalah id dari konten)
POST::  http://localhost:8000/api/pakar/draft/edit/{id}         (Edit draft, tergantung tipe konten Artikel/Video/Edoks)
- if Artikel
+ judul
+ kategori
+ sub_kategori
+ isi
+ foto
- if VideoAudio
+ judul
+ kategori
+ sub_kategori
+ isi
+ video_audio
- if EDokumen
+ judul
+ kategori
+ sub_kategori
+ penulis
+ tahun
+ penerbit
+ halaman
+ bahasa
+ deskripsi
+ file
GET::   http://localhost:8000/api/pakar/draft/my        (Get draft konten punya sendiri)
GET::   http://localhost:8000/api/pakar/post/my         (Get post konten punya sendiri)
GET::   http://localhost:8000/api/pakar/revisi/my       (Get revisi konten punya sendiri)

! Notifikasi
POST:: http://localhost:8000/api/pakar/notifikasi/add          (Menambah notifikasi)
+ Request
- headline
- isi
```

#### Validator
```diff
!Akun
POST::  http://localhost:8000/api/validator/register
- Request
+ nama
+ email
+ nomor_telefon (optional, ga di isi ga papa)
+ password
+ foto
POST::  http://localhost:8000/api/validator/profil/update       (update profil sendiri)
- Sama seperti register

! Konten
POST::  http://localhost:8000/api/validator/artikel/draft       (Draft Artikel)
- Request
+ judul
+ kategori
+ sub_kategori
+ isi
+ foto
POST::  http://localhost:8000/api/validator/artikel/post        (Post Artikel)
- Sama seperti draft
POST::  http://localhost:8000/api/validator/video_audio/draft   (Draft Video/Audio)
- Request
+ judul
+ kategori
+ sub_kategori
+ isi
+ video_audio
POST::  http://localhost:8000/api/validator/video_audio/post        (Post Video/Audio)
- Sama seperti draft
POST::  http://localhost:8000/api/validator/edokumen/draft          (Draft E-Dokumen)
- Request
+ judul
+ kategori
+ sub_kategori
+ penulis
+ tahun
+ penerbit
+ halaman
+ bahasa
+ deskripsi
+ file
POST::  http://localhost:8000/api/validator/edokumen/post           (Post E-Dokumen)
- Sama seperti draft
POST::  http://localhost:8000/api/validator/draft/post/{id}         (Post Draft, id adalah id dari konten)
POST::  http://localhost:8000/api/validator/draft/edit/{id}         (Edit draft, tergantung tipe konten Artikel/Video/Edoks)
- if Artikel
+ judul
+ kategori
+ sub_kategori
+ isi
+ foto
- if VideoAudio
+ judul
+ kategori
+ sub_kategori
+ isi
+ video_audio
- if EDokumen
+ judul
+ kategori
+ sub_kategori
+ penulis
+ tahun
+ penerbit
+ halaman
+ bahasa
+ deskripsi
+ file
GET::   http://localhost:8000/api/validator/draft/my        (Get draft konten punya sendiri)
GET::   http://localhost:8000/api/validator/post/my         (Get post konten punya sendiri)
GET::   http://localhost:8000/api/validator/konten/all      (Get all konten)
POST::  http://localhost:8000/api/validator/konten/hide/{id}          (Menyembunyikan konten berdasarkan id)
POST::  http://localhost:8000/api/validator/konten/unhide/{id}        (Memunculkan konten yg telah disembunyikan)
DEL::   http://localhost:8000/api/validator/konten/delete/{id}        (Menghapus konten yg berdasarkan id)

! Validasi
GET::   http://localhost:8000/api/validator/konten/not_valid            (Get konten yang belum valid)
GET::   http://localhost:8000/api/validator/konten/not_valid/user/{id}  (Get konten yang belum valid dari user)
POST::  http://localhost:8000/api/validator/konten/validasi/{id}        (Validasi konten, id adalah id konten)
POST::  http://localhost:8000/api/validator/konten/revisi/{id}          (Revisi konten, id adalah id konten)
- Request
+ komentar

! Notifikasi
POST:: http://localhost:8000/api/validator/notifikasi/add         (Menambah notifikasi)
+ Request
- headline
- isi
```

#### Admin dan Super Admin
```diff
!Akun
POST::  http://localhost:8000/api/admin/register            (untuk Admin)
- Request
+ nama
+ email
+ nomor_telefon (optional, ga di isi ga papa)
+ password
+ foto
POST::  http://localhost:8000/api/admin/register/super      (untuk Super Admin)
- Sama seperti register Admin
POST::  http://localhost:8000/api/admin/create_admin        (membuat akun Admin lain oleh Super Admin)
- Sama seperti register Admin
GET::   http://localhost:8000/api/admin/profil
POST::  http://localhost:8000/api/admin/profil/update       (update profil sendiri)
- Sama seperti register Admin
GET::   http://localhost:8000/api/admin/user/list           (menampilkan daftar user)
POST::  http://localhost:8000/api/admin/user/update/{id}    (update profil user lain berdasarkan id)
- Sama seperti register Admin
DEL::   http://localhost:8000/api/admin/user/delete/{id}    (menghapus profil user lain berdasarkan id)

! Konten
GET::   http://localhost:8000/api/admin/konten/all                (Get all konten)
POST::  http://localhost:8000/api/admin/konten/hide/{id}          (Menyembunyikan konten berdasarkan id)
POST::  http://localhost:8000/api/admin/konten/unhide/{id}        (Memunculkan konten yg telah disembunyikan)
DEL::   http://localhost:8000/api/admin/konten/delete/{id}        (Menghapus konten yg berdasarkan id)

! Notifikasi
POST:: http://localhost:8000/api/admin/notifikasi/add          (Menambah notifikasi)
+ Request
- headline
- isi
```

#### Universal
```diff
!Akun
POST::  http://localhost:8000/api/login
- Request
+ email
+ password
POST::  http://localhost:8000/api/logout
GET::   http://localhost:8000/api/profil
GET::   http://localhost:8000/api/profil/show/{id}                  (Show profil user lain berdasarkan id)

! Notifikasi
GET::   http://localhost:8000/api/notifikasi/show/{id}              (Show notifikasi berdasar id)
GET::   http://localhost:8000/api/notifikasi/all                    (Get all notifikasi)

!Konten
POST::   http://localhost:8000/api/konten/pencarian                 (Search biasa)
- Request
+ keyword
POST::   http://localhost:8000/api/konten/pencarian/kategori        (Search kategori)
- Request
+ keyword
GET::   http://localhost:8000/api/konten/penulis/{id}               (Show konten dari penulis, id adalah id dari penulis)
GET::   http://localhost:8000/api/konten/post                       (Show all konten posted)
GET::   http://localhost:8000/api/konten/artikel                    (Show all artikel posted)
GET::   http://localhost:8000/api/konten/video_audio                (Show all video audio posted)
GET::   http://localhost:8000/api/konten/edokumen                   (Show all edokumen posted)
GET::   http://localhost:8000/api/konten/show/{id}                  (Show isi konten)
```
## Sekian

Terima Kasih
