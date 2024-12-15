<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite('resources/css/app.css') --}}
    <link rel="stylesheet" href="{{ asset('css/user/user-footer.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Katerpilar Outdoor Gear & Rental</title>
</head>
<body>
    <div id="user-footer">
        <div class="content-footer">
            <div class="logo-footer">
                <img src="{{ asset('img/logo-black.png') }}">
                <div class="logo-text">
                    <div>Katerpilar Outdoor</div>
                    <div>Gear & Rental</div>
                </div>
            </div>
            <div class="right-footer">
                <div class="contact">
                    <div class="judul-footer">Kontak</div>
                    <div class="name-footer">
                        <a href="#">
                            <i class="fa-brands fa-whatsapp"></i>
                            <div class="name">WhatsApp</div>
                        </a>
                        <a href="#">
                            <i class="fa-brands fa-instagram"></i>
                            <div class="name">Instagram</div>
                        </a>
                    </div>
                </div>
                <div class="address">
                    <div class="judul-footer">Alamat</div>
                    <div class="address-footer">
                        <a href="#">
                            <div>Katerpilar Outdoor Gear & Rental, Kemiri</div>
                            <div>006/008, Kemiri, Tulung, Klaten, Jawa Tengah</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="copyright">&copy; 2024 Katerpilar Outdoor Gear & Rental</div>
    </div>
</body>
</html>
