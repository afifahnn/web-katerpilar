@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-upload.css') }}">
@endsection

@section('user-contents')
<div id="upload-bukti">
    <div class="container-rental">
        <div class="judul-rental">FORM UPLOAD BUKTI PEMBAYARAN</div>
        {{-- <form action="{{ route('user.rental') }}" method="post" enctype="multipart/form-data"> --}}
            {{-- @csrf --}}
            <div class="input-data">
                <div class="content-tf">Silahkan transfer di nomor rekening berikut :</div>
                <div class="norek-content">
                    <div class="bank-content">BRI</div>
                    <div class="norek">000192887466371817</div>
                </div>
            </div>
            <div class="input-data">
                <div class="content" for="metode_bayar">Metode Pembayaran</div>
                <input type="text" name="metode_bayar" placeholder="e.g. Transfer Bank B**"></input>
            </div>
            <div class="input-data">
                <div class="content" for="bukti_bayar">Upload Bukti Pembayaran</div>
                <input type="file" name="bukti_bayar" accept="image/*" required id="imageInput">
                <div id="imagePreview">
                    <img id="preview" src="" alt="Preview Gambar">
                </div>
            </div>

            <div class="btn-add-create" id="addData">
                <div class="btn-add-data">
                    <button type="submit">Upload</button>
                </div>
            </div>
        {{-- </form> --}}
    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
    // PREVIEW GAMBAR
    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('preview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection
