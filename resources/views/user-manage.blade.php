@extends('layouts.admin')

@section('content')
<style>
        tr.body td.aksi {
            padding: 8px 15px;
        }
        /* --- STYLES BARU UNTUK TOGGLE SWITCH (LEBIH KECIL) --- */
        .status-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: space-between;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px; /* Lebar toggle (lebih kecil) */
            height: 20px; /* Tinggi toggle (lebih kecil) */
            flex-shrink: 0; /* Mencegah toggle menciut */
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc; /* Warna nonaktif */
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px; /* Tinggi lingkaran (lebih kecil) */
            width: 14px; /* Lebar lingkaran (lebih kecil) */
            left: 3px; /* Jarak kiri */
            bottom: 3px; /* Jarak bawah */
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: var(--green-call); /* Warna aktif dari btn-call */
        }

        input:focus + .slider {
            box-shadow: 0 0 1px var(--green-call);
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(20px);
            -ms-transform: translateX(20px);
            transform: translateX(20px); /* Jarak pergeseran (40-14-3-3) */
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 20px; /* Disesuaikan dgn tinggi */
        }

        .slider.round:before {
            border-radius: 50%;
        }

        /*
            Class .popup-adduser tidak lagi diperlukan karena
            styling-nya dipindahkan langsung ke elemen modal
        */

        .input-item label {
            align-self: stretch;
            color: rgba(17, 17, 17, 0.5);
            font-size: 12px;
            font-weight: 400;
        }

        .input-item input, .input-item select { /* Dibuat lebih spesifik */
            display: flex;
            padding: 12px 15px;
            align-self: stretch;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.20);
            background: #F9F9F9;
            font-size: 12px;
            width: 100%; /* Pastikan input/select mengisi penuh */
        }

        .btn-submit {
            display: flex;
            padding: 12px 10px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            align-self: stretch;
            border-radius: 50px;
            background: #FFD117;
            border: none;
            font-size: 14px;
            font-weight: 600;
            width: 100%; /* Pastikan tombol mengisi penuh */
        }

        /* -- PERBAIKAN MODAL -- */
        /* Terapkan style border dan radius Anda ke .modal-content */
        #ModalAddUser .modal-content,
        #ModalEditUser .modal-content {
            border-radius: 20px;
            border: 4px solid #00D0FF;
            background: #FFF;
        }

        /* Terapkan padding Anda ke .modal-body, .modal-header, .modal-footer */
        #ModalAddUser .modal-header,
        #ModalEditUser .modal-header {
            padding: 45px 60px 0 60px;
            border-bottom: 0; /* Hapus garis bawaan */
            align-items: flex-start; /* Jaga-jaga */
        }

        #ModalAddUser .modal-body,
        #ModalEditUser .modal-body {
            padding: 20px 60px 20px 60px; /* Padding utama */
            display: flex;
            flex-direction: column;
            gap: 20px; /* Jarak antar grup form */
        }

        #ModalAddUser .modal-footer,
        #ModalEditUser .modal-footer {
            padding: 0 60px 45px 60px;
            border-top: 0; /* Hapus garis bawaan */
        }
</style>
          <h1 class="title-page align-self-stretch">Manajemen Pengguna</h1>
          <div class="data-user d-flex flex-column align-items-start align-self-stretch" style="gap: 20px;">
              <button class="btn-add" data-bs-target="#ModalAddUser" data-bs-toggle="modal">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                      <path d="M4.5 6.99902C6.98405 7.00177 8.99712 9.01493 9 11.499C9 11.7752 8.77613 11.999 8.5 11.999H0.5C0.223859 11.999 0 11.7752 0 11.499C0.00290797 9.01493 2.01595 7.00179 4.5 6.99902ZM10 3.99902C10.2761 3.99907 10.5 4.22293 10.5 4.49902V5.49902H11.5C11.7761 5.49907 11.9999 5.72294 12 5.99902C12 6.27515 11.7761 6.49898 11.5 6.49902H10.5V7.49902C10.5 7.77515 10.2761 7.99898 10 7.99902C9.72386 7.99902 9.5 7.77517 9.5 7.49902V6.49902H8.5C8.22386 6.49902 8 6.27517 8 5.99902C8.00005 5.72292 8.22389 5.49902 8.5 5.49902H9.5V4.49902C9.50003 4.2229 9.72388 3.99902 10 3.99902ZM4.5 0C6.15685 0 7.5 1.3431 7.5 3C7.49978 4.65672 6.15672 6 4.5 6C2.84328 6 1.50022 4.65672 1.5 3C1.5 1.3431 2.84315 0 4.5 0Z" fill="white"/>
                  </svg>
                  Tambah
              </button>
              <div class="box-table d-flex flex-column justify-content-center align-items-center align-self-stretch" style="gap: 30px;">
                          <div class="document-table d-flex flex-column align-items-start align-self-stretch">
                              <div class="box-title d-flex flex-column align-items-start align-self-stretch" style="padding: 15px; border-radius: 10px;">
                                  <span class="title-table" style="font-size:14px;font-weight: 600; color: var(--black-color);">
                                      Tabel User
                                  </span>
                              </div>
                              <table class="table" style="border-radius: 0 0 10px 10px; margin-bottom: 15px;">
                                  <tr class="head d-flex align-items-center align-self-stretch" style="background-color: #EAEAEA;">
                                      <th class="number">No</th>
                                      <th>Nama Lengkap</th>
                                      <th>Username</th>
                                      <th>Role</th>
                                      <th>No Telp</th>
                                      <th class="status">Status</th>
                                      <th class="aksi">Aksi</th>
                                  </tr>

                                  {{-- LOOPING DATA PENGGUNA --}}
                                  @forelse ($users as $user)
                                  <tr class="body d-flex align-items-center align-self-stretch">
                                      <td class="number">{{ $loop->iteration }}</td>
                                      <td>{{ $user->name }}</td>
                                      <td>{{ $user->username }}</td>
                                      {{-- $user->role->name aman digunakan karena kita pakai 'with('role')' di controller --}}
                                      <td>{{ $user->role->name }}</td>
                                      <td>{{ $user->no_telp }}</td>

                                      <!-- TOGGLE SWITCH FUNGSIONAL -->
                                      <td class="status-cell">
                                          <span
                                              id="status-text-{{ $user->id }}"
                                              class="status-text {{ $user->status == 'aktif' ? 'aktif' : 'nonaktif' }}">
                                              {{ $user->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}
                                          </span>
                                          <label class="toggle-switch">
                                              <input
                                                  type="checkbox"
                                                  class="status-toggle"
                                                  data-id="{{ $user->id }}"
                                                  {{ $user->status == 'aktif' ? 'checked' : '' }}>
                                              <span class="slider round"></span>
                                          </label>
                                      </td>
                                      <td class="aksi">
                                          <button data-bs-target="#ModalEditUser" data-bs-toggle="modal" class="btn-edit">Edit</button>
                                          <button class="btn-call">Hubungi</button>
                                      </td>
                                  </tr>
                                  @empty
                                  {{-- TAMPIL JIKA TIDAK ADA DATA --}}
                                  <tr class="body d-flex align-items-center align-self-stretch">
                                      <td colspan="7" style="text-align: center; padding: 20px; width: 100%;">
                                          Tidak ada data pengguna dengan role "petugas".
                                      </td>
                                  </tr>
                                  @endforelse
                                  {{-- AKHIR LOOP --}}

                              </table>
                          </div>
              </div>
          </div>

{{-- ======================================================= --}}
{{-- MODAL TAMBAH (STRUKTUR DIPERBARUI) --}}
{{-- ======================================================= --}}
<div class="modal fade" id="ModalAddUser" aria-hidden="true" aria-labelledby="ModalAddUserLabel" tabindex="-1">
  {{-- Terapkan lebar custom ke .modal-dialog --}}
  <div class="modal-dialog modal-dialog-centered" style="width: 550px;">
    {{-- .modal-content adalah kontainer utama untuk styling --}}
    <div class="modal-content">
        <div class="modal-header">
            {{-- Judul Anda --}}
            <span class="title-popup align-self-stretch" style="color: var(--black-color); font-size: 24px; font-weight: 600;">
                Buat Pengguna Baru
            </span>
            {{-- Tombol close standar Bootstrap --}}
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {{-- Bungkus body dan footer dengan <form> --}}
        <form>
            <div class="modal-body">
                {{-- Grup form pertama --}}
                <div class="account-info d-flex flex-column align-items-start align-self-stretch" style="gap: 10px;">
                    <span style="font-size: 14px;">Informasi Akun</span>
                    <div class="input-item d-flex flex-column align-items-start align-self-stretch" style="gap: 5px;">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-item d-flex flex-column align-items-start align-self-stretch" style="gap: 5px;">
                        <label for="password">Password</label>
                        <input type="text" id="password" name="password" required>
                    </div>
                    <div class="input-item d-flex flex-column align-items-start align-self-stretch" style="gap: 5px;">
                        <label for="Role">Role</label>
                        <select name="role" id="role">
                            <option selected disabled>Pilih Role...</option>
                            <option value="admin">Manajer Operasional</option>
                            <option value="petugas">Petugas Lapangan</option>
                        </select>
                    </div>
                </div>
                {{-- Grup form kedua --}}
                <div class="account-info d-flex flex-column align-items-start align-self-stretch" style="gap: 10px;">
                    <span style="font-size: 14px;">Informasi Pengguna</span>
                    <div class="input-item d-flex flex-column align-items-start align-self-stretch" style="gap: 5px;">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" required>
                    </div>
                    <div class="input-item d-flex flex-column align-items-start align-self-stretch" style="gap: 5px;">
                        <label for="notelp">Nomor Telepon</label>
                        <input type="text" id="notelp" name="notelp" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- Tombol submit Anda --}}
                <button class="btn-submit" type="submit">Buat Akun</button>
            </div>
        </form>
    </div>
  </div>
</div>


{{-- ======================================================= --}}
{{-- MODAL EDIT (STRUKTUR DIPERBARUI) --}}
{{-- ======================================================= --}}
<div class="modal fade" id="ModalEditUser" aria-hidden="true" aria-labelledby="ModalEditUserLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="width: 550px;">
    <div class="modal-content">
        <div class="modal-header">
            <span class="title-popup align-self-stretch" style="color: var(--black-color); font-size: 24px; font-weight: 600;">
                Edit Pengguna
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form>
            <div class="modal-body">
                <div class="account-info d-flex flex-column align-items-start align-self-stretch" style="gap: 10px;">
                    <span style="font-size: 14px;">Informasi Akun</span>
                    <div class="input-item d-flex flex-column align-items-start align-self-stretch" style="gap: 5px;">
                        <label for="username_edit">Username</label>
                        <input type="text" id="username_edit" name="username" required>
                    </div>
                    <div class="input-item d-flex flex-column align-items-start align-self-stretch" style="gap: 5px;">
                        <label for="password_edit">Password</label>
                        <input type="text" id="password_edit" name="password" placeholder="Isi untuk mengubah password">
                    </div>
                    <div class="input-item d-flex flex-column align-items-start align-self-stretch" style="gap: 5px;">
                        <label for="role_edit">Role</label>
                        <select name="role" id="role_edit">
                            <option selected disabled>Pilih Role...</option>
                            <option value="admin">Manajer Operasional</option>
                            <option value="petugas">Petugas Lapangan</option>
                        </select>
                    </div>
                </div>
                <div class="account-info d-flex flex-column align-items-start align-self-stretch" style="gap: 10px;">
                    <span style="font-size: 14px;">Informasi Pengguna</span>
                    <div class="input-item d-flex flex-column align-items-start align-self-stretch" style="gap: 5px;">
                        <label for="nama_edit">Nama Lengkap</label>
                        <input type="text" id="nama_edit" name="nama" required>
                    </div>
                    <div class="input-item d-flex flex-column align-items-start align-self-stretch" style="gap: 5px;">
                        <label for="notelp_edit">Nomor Telepon</label>
                        <input type="text" id="notelp_edit" name="notelp" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-submit" type="submit">Update</button>
            </div>
        </form>
    </div>
  </div>
</div>


@endsection

@push('scripts')
<script>
    // Buat fungsi untuk melampirkan listener
    function initializeUserToggles() {
        // Ambil CSRF token dari meta tag (PENTING UNTUK KEAMANAN)
        // Pastikan layout 'layouts.admin' Anda memiliki <meta name="csrf-token" ...>
        // Jika tidak ada, tambahkan di <head> admin.blade.php: <meta name="csrf-token" content="{{ csrf_token() }}">
        const csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
        if (!csrfTokenEl) {
            console.error('CSRF token not found. Please add <meta name="csrf-token" content="{{ csrf_token() }}"> to your layout.');
            return;
        }
        const csrfToken = csrfTokenEl.getAttribute('content');


        // Cari semua toggle di halaman ini
        const toggles = document.querySelectorAll('.status-toggle');

        toggles.forEach(toggle => {
            // Cek jika listener sudah dipasang, agar tidak duplikat
            if (toggle.dataset.listenerAttached) {
                return;
            }
            // Tandai bahwa listener sudah dipasang
            toggle.dataset.listenerAttached = 'true';

            // Tambahkan event 'change'
            toggle.addEventListener('change', function () {

                const userId = this.dataset.id;
                const newStatus = this.checked ? 'aktif' : 'nonaktif';
                const statusTextElement = document.getElementById(`status-text-${userId}`);

                // Kirim request ke server menggunakan fetch
                fetch(`/users/${userId}/toggle-status`, { // Route yang kita buat
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, // <-- Kirim CSRF token
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: newStatus // Kirim status baru
                    })
                })
                .then(response => {
                    // Cek jika response TIDAK ok (misal: Error 500)
                    if (!response.ok) {
                        throw new Error(`Server error: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // JIKA SUKSES: Update teks dan warna
                        statusTextElement.textContent = data.newStatus === 'aktif' ? 'Aktif' : 'Nonaktif';
                        statusTextElement.classList.remove('aktif', 'nonaktif');
                        statusTextElement.classList.add(data.newStatus);
                    } else {
                        // JIKA GAGAL (dari JSON): Kembalikan toggle ke posisi semula
                        thischecked = !this.checked;
                        alert('Gagal mengubah status.');
                    }
                })
                .catch(error => {
                    // JIKA GAGAL (koneksi atau error server): Kembalikan toggle
                    console.error('Error:', error);
                    this.checked = !this.checked;
                    alert('Terjadi kesalahan. Gagal mengubah status.');
                });
            });
        });
    }

    // Jalankan saat halaman dimuat (full refresh)
    document.addEventListener('DOMContentLoaded', initializeUserToggles);
    // Jalankan saat halaman diganti oleh Turbo.js
    document.addEventListener('turbo:load', initializeUserToggles);
</script>
@endpush
