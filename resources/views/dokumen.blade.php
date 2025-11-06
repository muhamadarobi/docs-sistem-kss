@extends('layouts.admin')

@section('content')
<h1 class="title-page align-self-stretch">Manajemen Dokumen</h1>
<div class="content d-flex flex-column justify-content-center align-items-center align-self-stretch " style="gap: 20px;">
    <div class="box-filter d-flex align-items-end align-self-stretch" style="gap: 40px;">
        <form class="filters d-flex align-items-center" style="gap: 30px; flex: 1 0 0;">
            <div class="filter d-flex flex-column align-items-start" style="gap: 10px; flex: 1 0 0;">
                <label for="cari">Cari Dokumen</label>
                <input type="search" name="cari" id="cari" placeholder="Cari Dokumen...">
            </div>
            <div class="filter d-flex flex-column align-items-start" style="gap: 10px; flex: 1 0 0;">
                <label for="jenis">Jenis Dokumen</label>
                <select name="jenis" id="jenis">
                    <option value="" selected disabled>Pilih Jenis Dokumen...</option>
                    <option value="surat_jalan">Surat Jalan</option>
                    <option value="invoice">Invoice</option>
                    <option value="kontrak">Kontrak</option>
                </select>
            </div>
            <div class="filter d-flex flex-column align-items-start" style="gap: 10px; flex: 1 0 0;">
                <label for="tanggal">Filter Tanggal</label>
                <input type="date" name="tanggal" id="tanggal">
            </div>
        </form>
        <button class="submit-filter" type="submit">Terapkan Filter</button>
    </div>
    <div class="box-table d-flex flex-column justify-content-center align-items-center align-self-stretch" style="gap: 30px;">
        <div class="document-table d-flex flex-column align-items-start align-self-stretch">
            <div class="box-title d-flex flex-column align-items-start align-self-stretch" style="padding: 15px; border-radius: 10px;">
                <span class="title-table" style="font-size:14px;font-weight: 600; color: var(--black-color);">
                    Tabel Dokumen
                </span>
            </div>
            <table class="table" style="border-radius: 0 0 10px 10px;">
                <tr class="head d-flex align-items-center align-self-stretch" style="background-color: #EAEAEA;">
                    <th class="number">No</th>
                    <th>Jenis Dokumen</th>
                    <th>Pengunggah</th>
                    <th>Waktu</th>
                    <th class="keterangan">Keterangan</th>
                    <th>Aksi</th>
                </tr>
                <tr class="body d-flex align-items-center align-self-stretch">
                    <td class="number">1</td>
                    <td>Surat Keluar</td>
                    <td>Ahmad Faaza</td>
                    <td>Waktu</td>
                    <td class="keterangan">Nomor Polisi: KT 1427 DV</td>
                    <td class="aksi">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10" fill="none">
                                <path d="M6.00012 0C8.2324 0.0210762 10.3055 1.16099 11.5197 3.03418C12.1606 3.97373 12.1606 5.20986 11.5197 6.14941C10.3055 8.02261 8.23239 9.16253 6.00012 9.18359C3.76712 9.16197 1.69317 8.02094 0.479614 6.14648C-0.15992 5.20765 -0.159852 3.97302 0.479614 3.03418C1.69385 1.16087 3.76771 0.0209436 6.00012 0ZM6.00012 1.50781C4.26208 1.5207 2.64986 2.41765 1.72278 3.8877C1.4338 4.3122 1.43386 4.87037 1.72278 5.29492C2.64984 6.76524 4.26193 7.66292 6.00012 7.67578C7.73818 7.66276 9.34952 6.76512 10.2765 5.29492C10.5655 4.87036 10.5655 4.31222 10.2765 3.8877C9.34944 2.4178 7.73795 1.52081 6.00012 1.50781ZM5.99915 2.58105C7.10949 2.58105 8.00989 3.48153 8.00989 4.5918C8.0098 5.70199 7.10943 6.60156 5.99915 6.60156C4.88906 6.60133 3.98947 5.70185 3.98938 4.5918C3.98938 3.48167 4.88901 2.58129 5.99915 2.58105Z" fill="#0077C2"/>
                            </svg>
                        </button>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M11.25 7.25C11.6642 7.25 12 7.58578 12 8V10.2959C11.9987 11.2366 11.2367 11.9989 10.2959 12H1.70508C0.764312 11.9989 0.00131589 11.2366 0 10.2959V8C4.6351e-06 7.58592 0.33596 7.2502 0.75 7.25C1.16421 7.25 1.5 7.58579 1.5 8V10.2959C1.50047 10.4085 1.59238 10.4997 1.70508 10.5H10.2959C10.4086 10.4997 10.4995 10.4085 10.5 10.2959V8C10.5 7.58592 10.836 7.2502 11.25 7.25ZM6 0C6.41421 0 6.75 0.335789 6.75 0.75L6.76172 7.57422L8.15332 6.18359C8.15934 6.17736 8.16562 6.17106 8.17188 6.16504C8.46982 5.87737 8.94469 5.88569 9.23242 6.18359C9.52003 6.48154 9.51175 6.95643 9.21387 7.24414L7.60742 8.84961C6.72873 9.72828 5.30445 9.7283 4.42578 8.84961L2.81934 7.24316C2.53904 6.95252 2.53885 6.49169 2.81934 6.20117C3.10697 5.90337 3.58192 5.89525 3.87988 6.18262L5.26074 7.56348L5.25 0.75C5.25 0.335882 5.58592 0.000150331 6 0Z" fill="#F39C12"/>
                            </svg>
                        </button>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 12 14" fill="none">
                                <path d="M6.81836 0C7.85501 0.00344539 8.77744 0.659027 9.12207 1.63672H11.1816C11.6334 1.63672 11.9998 2.00242 12 2.4541C12 2.90596 11.6335 3.27246 11.1816 3.27246H10.9092V10.0908C10.9091 11.7475 9.56591 13.0907 7.90918 13.0908H4.09082C2.43401 13.0908 1.09088 11.7476 1.09082 10.0908V3.27246H0.818359C0.366493 3.27246 0 2.90596 0 2.4541C0.000212022 2.00242 0.366624 1.63672 0.818359 1.63672H2.87793C3.22258 0.658955 4.1449 0.00335062 5.18164 0H6.81836ZM2.72754 10.0908C2.7276 10.8439 3.33775 11.4541 4.09082 11.4541H7.90918C8.66216 11.454 9.2724 10.8438 9.27246 10.0908V3.27246H2.72754V10.0908ZM4.63672 4.90918C5.08838 4.90942 5.4541 5.27583 5.4541 5.72754V9C5.454 9.45162 5.08832 9.81812 4.63672 9.81836C4.18492 9.81836 3.81846 9.45177 3.81836 9V5.72754C3.81836 5.27568 4.18485 4.90918 4.63672 4.90918ZM7.36328 4.90918C7.81515 4.90918 8.18164 5.27568 8.18164 5.72754V9C8.18154 9.45177 7.81508 9.81836 7.36328 9.81836C6.91158 9.81824 6.54503 9.45169 6.54492 9V5.72754C6.54492 5.27576 6.91152 4.9093 7.36328 4.90918Z" fill="#D20000"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
