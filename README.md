# PokéCare Nay – Simulasi Latihan Pikachu (PHP Native OOP)

Nama: Nayla Zazki Kirani
NIM : H1H024007
Shift Awal : Shift C
Shift Akhir : Shift A

Project ini adalah web PokéCare Nay, simulasi latihan Pokémon berbasis web yang dibuat khusus untuk responsi PBO:

- Bahasa pemrograman: PHP Native (tanpa framework)
- Konsep: menerapkan 4 Pilar OOP melalui class `Pokemon`, `ElectricPokemon`, `Pikachu`, `TrainingSession`, dll.
- Tema: tampilan seperti Pokédex interaktif, dengan panel data, statistik bar, dan animasi halus saat scroll.

## Halaman & Isi Website

### 1. Beranda (`index.php`)
Berisi:

- Welcome section berjudul “Selamat datang di PokéCare Nay” yang menjelaskan kegunaan web:
  profil Pikachu, pengaturan latihan, dan pemantauan perkembangan Level/HP.
- Panel Pokédex berisi informasi:
  - No. Pokédex, nama spesies, region asal, tipe utama.
  - Tinggi, berat, kemampuan, kelemahan, dan fokus penelitian.
  - Nama trainer aktif dan status Level + HP saat ini.
- Panel Catatan Gaya Latihan:
  - Fokus latihan (misalnya Speed & kontrol listrik).
  - Zona intensitas nyaman untuk latihan harian.
  - Catatan kapan intensitas tinggi dipakai dan catatan PRTC.
- Panel Statistik Dasar:
  - Grafik bar untuk HP, Attack, Defense, Sp. Atk, Sp. Def, Speed.
  - Ringkasan: total sesi latihan, total kenaikan Level, total kenaikan HP,
    dan sesi dengan intensitas tertinggi.
- Panel Set Jurus PokéCare Pikachu:
  - Daftar 4 jurus dengan tipe, kategori, power info, dan deskripsi singkat.
- Visual:
  - Orbit pikachu dengan gambar `pikachu-main.png` di tengah.
  - Animasi lembut saat halaman dibuka dan saat user scroll ke bawah.

### 2. Halaman Latihan (`training.php`)
Fitur utama:

- Form latihan:
  - Nama Trainer (disimpan di session, muncul di semua halaman).
  - Jenis latihan: Attack, Defense, Speed.
  - Intensitas latihan (1–100) dengan validasi.
- Logika latihan:
  - Membuat `TrainingSession` baru.
  - Memanggil `train()` pada objek `Pikachu`.
  - Level dan HP Pikachu berubah sesuai rumus di `ElectricPokemon`.
  - Hasil latihan dikemas dalam `TrainingResult` dan disimpan ke `$_SESSION['training_log']`.
- Panel kanan:
  - Kartu status Pikachu (gambar, Level, HP, nama trainer, jurus spesial).
  - Jika ada latihan terakhir, ditampilkan:
    - Level sebelum → sesudah.
    - HP sebelum → sesudah.
    - Waktu latihan.
    - Deskripsi jurus spesial.
    - Catatan gaya pelatihan.

### 3. Halaman Riwayat Latihan (`history.php`)
Berisi:

- Ringkasan singkat:
  - Total sesi latihan.
  - Total kenaikan Level.
  - Total kenaikan HP.
- Tabel riwayat:
  - Nomor urut.
  - Waktu latihan.
  - Jenis latihan & intensitas.
  - Level sebelum → sesudah.
  - HP sebelum → sesudah.
  - Deskripsi jurus spesial.
  - Catatan gaya pelatihan.
- Tombol:
  - Tambah Latihan → kembali ke halaman latihan.
  - Reset Riwayat → mengosongkan `$_SESSION['training_log']` untuk sesi tersebut.

## Penerapan Konsep OOP

- Encapsulation
  - Properti Pokémon (nama, tipe, level, hp, dsb.) dibuat `protected`/`private`.
  - Akses lewat getter & setter (`getLevel()`, `setHp()`, dll) dengan validasi batas bawah/atas.

- Inheritance
  - `Pokemon` → kelas dasar abstrak.
  - `ElectricPokemon` → mewarisi `Pokemon` dan menambahkan multiplier khusus tipe Electric.
  - `Pikachu` → turunan `ElectricPokemon` dengan data dex, base stats, dan catatan latihan khusus.

- Polymorphism
  - Method `train()` ada di `Pokemon`, tetapi logika perhitungan efek latihan
    di-override oleh `calculateTrainingEffect()` di `ElectricPokemon`.
  - `specialMove()` diimplementasikan secara spesifik di `Pikachu`.

- Abstraction
  - `Pokemon` didefinisikan sebagai `abstract class` dengan method abstrak:
    `calculateTrainingEffect()`, `getDexData()`, `getBaseStats()`, `getTrainingProfile()`, dan `specialMove()`.
  - Interface `Trainable` mendefinisikan kontrak umum untuk makhluk yang bisa dilatih:
    `train()` dan `specialMove()`.

## Cara Menjalankan

1. Extract folder ke direktori web server, misalnya:
   `C:\xampp\htdocs\Pokecare_Nay_Final`
2. Jalankan Apache (XAMPP / Laragon / WAMP).
3. Buka di browser:
   `http://localhost:7000/index.php`
4. Alur:
   - Buka Beranda untuk melihat profil dan statistik Pikachu.
   - Masuk ke Latihan, isi nama trainer, jenis latihan, dan intensitas → submit.
   - Buka Riwayat untuk melihat tabel perkembangan Level dan HP.

Project ini dibuat agar:
- Sesuai ketentuan responsi (PHP native, OOP, tanpa framework),
- Tampilan rapi dan konsisten ,
- Dan siap dinilai sebagai project Responsi PBO.

  ## Video Demonstrasi
[Klik untuk menonton video](https://github.com/nayla-kirani/Nayla-Zazki-Kirani_H1H024007_ResponsiPBO25_Pikachu/raw/refs/heads/main/1129(1).mp4)

