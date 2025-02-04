<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual User</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/user/user-manual.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @yield('extra-css')
</head>
<body id="manual-user">
    <div class="container mt-5">
        <h2 class="text-center fw-bold">📖 Manual User</h2>
        <p class="text-center text-muted">Panduan penggunaan sistem Katerpilar Outdoor Gear & Rental</p>

        <div class="accordion mt-4" id="manualAccordion">
            <!-- S&K -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#skSection">
                        📌 <b>Syarat dan Ketentuan</b>
                    </button>
                </h2>
                <div id="skSection" class="accordion-collapse collapse show" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        1. Penyewa meninggalkan identitas diri KTP/kartu pelajar berlaku sebagai jaminan.<br>
                        2. Pemesanan alat dapat dilakukan via sistem atau datang langsung ke toko.<br>
                        3. Pelunasan transaksi maksimal saat ambil alat.<br>
                        4. Hitungan sewa 1 hari = 2 hari 1 malam.<br>
                        5. Harga sewa jika lebih dari 3 hari menyesuaikan.<br>
                        6. Jika ada kehilangan atau kerusakan alat ditanggung penyewa.<br>
                        7. Keterlambatan pengembalian alat akan dikenakan biaya tambahan sesuai hari dan alat yang disewa.
                    </div>
                </div>
            </div>

            <!-- LOGIN -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#loginSection">
                        🔑 <b>Login</b>
                    </button>
                </h2>
                <div id="loginSection" class="accordion-collapse collapse" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        Apabila sudah mempunyai akun dapat melakukan login, dengan tata cara sebagai berikut : <br>
                        1. Buka halaman login di <a href="{{ url('/login') }}" class="login-link">/login</a> <br>
                        2. Masukkan username dan password yang telah didaftarkan <br>
                        3. Klik tombol <b>Login</b> untuk masuk ke akun Anda
                    </div>
                </div>
            </div>

            <!-- REGISTER -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#registerSection">
                        📝 <b>Register</b>
                    </button>
                </h2>
                <div id="registerSection" class="accordion-collapse collapse" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        Lakukan registrasi akun terlebih dahulu apabila belum memiliki akun, dengan tata cara sebagai berikut : <br>
                        1. Buka halaman pendaftaran di <a href="{{ url('/register') }}" class="login-link">/register</a> <br>
                        2. Isi semua data yang diperlukan, seperti username, nama, nomor telepon, alamat, dan password <br>
                        3. Klik tombol <b>Register</b> untuk membuat akun baru
                    </div>
                </div>
            </div>

            <!-- LUPA PASSWORD -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#forgotPasswordSection">
                        🔄 <b>Lupa Password</b>
                    </button>
                </h2>
                <div id="forgotPasswordSection" class="accordion-collapse collapse" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        Jika Anda lupa password, hubungi admin melalui WhatsApp atau telepon di nomor berikut
                        <b>
                            <a href="https://wa.me/6281390986967" target="_blank" rel="noopener noreferrer" class="whatsapp-link">
                                <i class="fa-brands fa-whatsapp"></i> WhatsApp
                            </a>
                        </b>. <br>
                        Admin akan mereset password dan memberikan informasi baru kepada Anda. <br>
                        <b>Note:</b> <br>
                        Segera ganti password Anda dengan yang baru untuk menjaga keamanan akun.
                    </div>
                </div>
            </div>

            <!-- HOME -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#homeSection">
                        🏠 <b>Halaman Home</b>
                    </button>
                </h2>
                <div id="homeSection" class="accordion-collapse collapse" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        Halaman <a href="{{ url('/') }}" class="login-link">/home</a> berisi katalog barang yang dapat diakses tanpa melakukan login. <br>
                        Anda dapat melihat ketersediaan stok barang, harga sewa, dan deskripsi barang di halaman ini.
                    </div>
                </div>
            </div>

            <!-- PESAN -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rentalSection">
                        🛒 <b>Cara Menyewa Barang</b>
                    </button>
                </h2>
                <div id="rentalSection" class="accordion-collapse collapse" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        1. Buka halaman <a href="{{ url('/rental') }}" class="login-link">Pesan</a>. <br>
                        2. Isikan formulir pemesanan. <br>
                        3. Apabila memilih pembayaran transfer (non-cash), silahkan melakukan pembayaran ke nomor rekening yang tersedia dan upload bukti pembayaran. <br>
                        4. Pelunasan untuk pembayaran cash dapat dilakukan maksimal saat pengambilan alat. <br>
                        5. Periksa kembali pesanan Anda dan klik tombol Pesan apabila sudah sesuai. <br>
                        6. Anda dapat melihat riwayat pemesanan di halaman <a href="{{ url('/riwayat') }}" class="login-link">/riwayat</a> <br>
                        7. Barang yang sudah dipesan harus diambil di
                        <a href="https://maps.app.goo.gl/3Pk8wwyH8J3Yqaaf6" target="_blank" rel="noopener noreferrer" class="whatsapp-link">
                            Toko
                        </a> maksimal pada hari H tanggal sewa. <br>
                        8. Jika ada perubahan tanggal, harap segera menghubungi Admin.
                    </div>
                </div>
            </div>

            <!-- RIWAYAT -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#riwayatSection">
                        📝 <b>Melihat Riwayat Pemesanan</b>
                    </button>
                </h2>
                <div id="riwayatSection" class="accordion-collapse collapse" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        1. Buka halaman <a href="{{ url('/riwayat') }}" class="login-link">Riwayat</a>. <br>
                        2. Semua riwayat pemesanan akan ditampilkan, dan Anda dapat memfilter berdasarkan status pemesanan. <br>
                        3. Pesanan yang baru saja dilakukan akan berstatus <b>Menunggu</b>, yang berarti belum dikonfirmasi oleh Admin. <br>
                        4. Jika pesanan telah dikonfirmasi oleh Admin, statusnya akan berubah menjadi <b>Booking</b>. <br>
                        5. Anda dapat membatalkan pesanan maksimal H-1 dari tanggal sewa.
                    </div>
                </div>
            </div>

            <!-- PROFIL -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#profilSection">
                        👤 <b>Ubah Profil</b>
                    </button>
                </h2>
                <div id="profilSection" class="accordion-collapse collapse" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        1. Buka halaman <a href="{{ url('/profil') }}" class="login-link">Profil</a>. <br>
                        2. Perbarui informasi profil sesuai kebutuhan. <br>
                        3. Jika Anda pernah mengalami <b>Lupa Password</b> dan telah dilakukan reset oleh Admin, segera ganti password Anda dengan yang baru untuk menjaga keamanan akun.
                    </div>
                </div>
            </div>

            <!-- KONTAK ADMIN -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#contactSection">
                        📞 <b>Kontak Admin</b>
                    </button>
                </h2>
                <div id="contactSection" class="accordion-collapse collapse" data-bs-parent="#manualAccordion">
                    <div class="accordion-body">
                        Jika ada kendala, hubungi admin melalui: <br>
                        <a href="https://wa.me/6281390986967" target="_blank" rel="noopener noreferrer" class="whatsapp-link">
                            📱 WhatsApp: 0813-9098-6967
                        </a> <br>
                        <a href="https://www.instagram.com/katerpilar.outdoor" target="_blank" rel="noopener noreferrer" class="whatsapp-link">
                            🌐 Instagram: @katerpilar.outdoor
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
