@extends('user-main-layout')

@section('user-extra-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-profil.css') }}">
@endsection

@section('user-contents')
<div id="user-profil">
    <div class="profile">
        <p class="profil-hero">Hello!</p>
    </div>
    <div class="profil-container">
        <div class="profile-judul">
            <span class="profil-user">{{ Auth::guard('customer')->user()->nama_customer }}</span>
            <div class="profil-content">
                <div class="profil-email">
                    <i class="fa-solid fa-phone" aria-hidden="true" style="color: #b3acac"></i>
                    {{ Auth::guard('customer')->user()->telp_customer }}
                </div>
                <div class="profil-alamat">
                    <i class="fa-solid fa-user" aria-hidden="true" style="color: #b3acac"></i>
                    {{ Auth::guard('customer')->user()->alamat_customer }}
                </div>
            </div>
        </div>

        <div class="btn-edit-profil">
            <a href="{{ url('/edit-profil')}}">Edit Profil</a>
        </div>
    </div>
</div>

<script>
    // SWAL
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif

    @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'error',
            title: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif
</script>
@endsection
