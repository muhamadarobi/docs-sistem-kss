@extends('auth.login')

@section('content')
    <div class="container-login">
        <img class="image-login" src="FOTO/KSS.png" alt="">
        <div class="box-login d-flex flex-column align-items-center">
            <span class="title-login" style="font-size: 24px;">Masukkan Data Akun</span>
            <span>Sistem Manajemen Dokumen Operasional</span>
        </div>
        <form action="" class="form-login d-flex flex-column align-items-start align-self-stretch" style="gap: 20px;">
            <div class="login-input d-flex flex-column align-items-start align-self-stretch" style="gap: 8px;">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="login-input d-flex flex-column align-items-start align-self-stretch" style="gap: 8px;">
                <label for="password">Password</label>
                <input type="text" id="password" name="password" required>
            </div>
            <div class="login-input d-flex flex-column align-items-start align-self-stretch" style="gap: 8px;">
                <label for="role">Role</label>
                <select class="form-select" name="" id="">
                    <option value="" selected disabled>Pilih Role...</option>
                    <option value="Manajer Operasional">Manajer Operasional</option>
                    <option value="Manajer Operasional">Petugas Lapangan</option>
                </select>
            </div>
            <button class="btn-login">Masuk</button>
        </form>
    </div>
@endsection
