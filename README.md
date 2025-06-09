# 📱 Aplikasi Absensi Online — Face-Go!

Aplikasi absensi berbasis web dan mobile yang memungkinkan absensi menggunakan **selfie** dan **deteksi lokasi**, cocok untuk penggunaan **kantor**, **usaha lokal**, maupun **sekolah**.

Dibangun menggunakan:
- **Laravel** (backend, API, multi-auth)
- **Inertia.js** (bridge Laravel ↔ Vue)
- **Vue.js** + **Quasar** (frontend SPA)
- **SQLite/MySQL** (database)

---

## 🚀 Fitur Utama

### 👨‍💼 Modul Karyawan (Employee)
- Login menggunakan akun karyawan
- Absensi **masuk dan pulang** menggunakan kamera dan GPS
- Validasi **lokasi** dengan radius yang ditentukan admin
- Menyimpan foto selfie setiap kali absensi dilakukan
- Riwayat absensi pribadi (per bulan)
- Dashboard: status absensi hari ini
- Edit profil dan logout

### 🛠️ Modul Admin
- Login menggunakan akun admin
- Dashboard statistik absensi
- Manajemen data karyawan (CRUD)
- Pengaturan titik lokasi kantor
- Laporan dan riwayat absensi semua karyawan
- Export laporan ke Excel/PDF (fitur lanjutan)

---

## 📦 Rencana Pengembangan (Post-MVP)
### 🎓 Modul Siswa
- Login siswa untuk absensi masuk dan pulang
- Lokasi & selfie saat absen
- Riwayat kehadiran pribadi

### 👨‍👩 Modul Orang Tua
- Login orang tua untuk memantau anak
- Status kehadiran anak hari ini
- Notifikasi ketika anak tidak hadir

---

## ⚙️ Teknologi & Tools

| Layer        | Tools                    |
|--------------|--------------------------|
| Backend      | Laravel 11               |
| Frontend     | Vue 3 + Quasar Framework |
| SPA Engine   | Inertia.js               |
| Auth         | Multi-auth guard (admin, employee) |
| Location     | HTML5 Geolocation API    |
| Image        | Camera via `<input type="file">` + JS |
| Database     | MySQL / SQLite (dev)     |

---
