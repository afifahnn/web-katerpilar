@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-upload.css') }}">
@endsection

@section('user-contents')
<div id="upload-bukti">
    <div class="container-rental">
        <div class="judul-rental">FORM UPLOAD BUKTI PEMBAYARAN</div>
        <form action="{{ route('user.upload.update', $transaksi->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="input-data">
                <div class="content-tf">Silahkan transfer di nomor rekening berikut :</div>
                <div class="norek-content">
                    <div class="bank-content">{{ $admin->jenis_rekening }}</div>
                    <div class="norek">{{ $admin->no_rekening }}</div>
                </div>
            </div>
            <div class="input-data">
                <div class="content" for="metode_bayar">Metode Pembayaran</div>
                <input type="text" name="metode_bayar" value="{{ $transaksi->metode_bayar }}" placeholder="e.g. Transfer Bank B**" required></input>
            </div>
            <div class="input-data">
                <div class="content" for="bukti_bayar">Upload Bukti Pembayaran</div>
                <input type="file" name="bukti_bayar" accept="image/*" required id="imageInput" required>
                @if($transaksi->bukti_bayar)
                    <div id="imagePreview">
                        <img src="{{ asset('storage/' . $transaksi->bukti_bayar) }}" alt="{{ $transaksi->metode_bayar }}">
                    </div>
                @else
                    <div id="noImageText">Tidak ada gambar saat ini.</div>
                @endif
                <div id="imagePreview">
                    <img id="preview" src="" alt="Preview Gambar">
                </div>
            </div>

            <div class="btn-add-create">
                <div class="btn-add-data">
                    <button type="submit">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
    // PREVIEW GAMBAR
    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('preview');
    const noImageText = document.getElementById('noImageText');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';

                if (noImageText) {
                    noImageText.style.display = 'none';
                }
            }
            reader.readAsDataURL(file);
        }
    });

    // SWAL REQUIRED
    document.querySelectorAll('form input[required], form select[required]').forEach(function (input) {
        input.addEventListener('invalid', function () {
            Swal.fire({
                position: 'bottom-end',
                title: 'Peringatan!',
                text: 'Semua field yang wajib diisi harus diisi terlebih dahulu!',
                icon: 'warning',
                toast: true,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: false,
            });
        });
    });
</script>

@endsection
