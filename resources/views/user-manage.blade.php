@extends('layouts.admin')

@section('content')
<style>
    tr.body td.aksi {
        padding: 8px 15px;
    }



</style>

            <h1 class="title-page align-self-stretch">Manajemen Pengguna</h1>
            <div class="data-user d-flex flex-column align-items-start align-self-stretch" style="gap: 20px;">
                <button class="btn-add" type="button">
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
                            <table class="table" style="border-radius: 0 0 10px 10px; margin-bottom: 0;"> <!-- margin-bottom: 0 -->
                                <tr class="head d-flex align-items-center align-self-stretch" style="background-color: #EAEAEA;">
                                    <th class="number">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>No Telp</th>
                                    <th class="status">Status</th> <!-- Class ditambahkan -->
                                    <th class="aksi">Aksi</th>
                                </tr>
                                <tr class="body d-flex align-items-center align-self-stretch">
                                    <td class="number">1</td>
                                    <td>Muhammad Arobi</td>
                                    <td>Robi1714</td>
                                    <td>Petugas Lapangan</td>
                                    <td>085161511717</td>
                                    <!-- PERUBAHAN HTML: Toggle Switch ditambahkan -->
                                    <td class="status-cell">
                                        <span class="status-text">Aktif</span>
                                        <label class="toggle-switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td class="aksi">
                                        <button class="btn-edit">Edit</button>
                                        <button class="btn-call">Hubungi</button>
                                    </td>
                                </tr>
                                <tr class="body d-flex align-items-center align-self-stretch">
                                    <td class="number">1</td>
                                    <td>Muhammad Arobi</td>
                                    <td>Robi1714</td>
                                    <td>Petugas Lapangan</td>
                                    <td>085161511717</td>
                                    <!-- PERUBAHAN HTML: Toggle Switch ditambahkan -->
                                    <td class="status-cell">
                                        <span class="status-text">Aktif</span>
                                        <label class="toggle-switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td class="aksi">
                                        <button class="btn-edit">Edit</button>
                                        <button class="btn-call">Hubungi</button>
                                    </td>
                                </tr>
                                <!-- Tambahkan baris data lain di sini jika perlu -->
                            </table>
                        </div>
                </div>
            </div>
@endsection
