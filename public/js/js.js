// ADD BARANG (create barang)

        const addItemBtn = document.getElementById('addItemBtn');
        const selectBox = document.getElementById('inputGroupSelect04');
        const selectedItemsContainer = document.getElementById('selectedItems');
        const barangSewaInput = document.getElementById('barangSewaInput');
        const jumlahSewaInput = document.getElementById('jumlahSewaInput');
        const totalBayarDisplay = document.getElementById('totalBayar');
        const selectedItems = {}; // Menyimpan data barang dan jumlah

        addItemBtn.addEventListener('click', function () {
            const selectedValue = selectBox.value;
            const selectedText = selectBox.options[selectBox.selectedIndex].text;

            if (selectedValue === "") {
                alert('Pilih barang terlebih dahulu!');
                return;
            }

            // Ambil harga sewa berdasarkan lama sewa (harga_sewa1, harga_sewa2, harga_sewa3)
            const hargaSewa1 = parseFloat(selectBox.options[selectBox.selectedIndex].dataset.harga_sewa1 || 0);
            const hargaSewa2 = parseFloat(selectBox.options[selectBox.selectedIndex].dataset.harga_sewa2 || 0);
            const hargaSewa3 = parseFloat(selectBox.options[selectBox.selectedIndex].dataset.harga_sewa3 || 0);

            if (isNaN(hargaSewa1) || isNaN(hargaSewa2) || isNaN(hargaSewa3)) {
                alert('Harga sewa tidak valid! Pastikan data barang memiliki harga.');
                return;
            }

            // Tentukan harga berdasarkan lama sewa
            let hargaPerItem = 0;
            const tglSewa = new Date(document.getElementById('tanggalSewa').value);
            const tglKembali = new Date(document.getElementById('tanggalKembali').value);
            const lamaSewa = Math.ceil((tglKembali - tglSewa) / (1000 * 3600 * 24));  // Lama sewa dalam hari

            if (lamaSewa <= 1) {
                hargaPerItem = hargaSewa1;
            } else if (lamaSewa <= 3) {
                hargaPerItem = hargaSewa2;
            } else {
                hargaPerItem = hargaSewa3;
            }

            // Jika barang sudah ada, tambahkan jumlahnya
            if (selectedItems[selectedValue]) {
                selectedItems[selectedValue].quantity += 1;
                selectedItems[selectedValue].price = hargaPerItem;

                // Update tampilan jumlah
                const itemElement = document.querySelector(`.selected-item[data-value="${selectedValue}"]`);
                itemElement.querySelector('.item-quantity').textContent = `Jumlah: ${selectedItems[selectedValue].quantity}`;
                itemElement.querySelector('.item-price').textContent = `Harga: Rp ${(selectedItems[selectedValue].quantity * hargaPerItem).toFixed(2)}`;
            } else {
                // Tambahkan barang baru
                selectedItems[selectedValue] = {
                    name: selectedText,
                    quantity: 1,
                    price: hargaPerItem
                };

                const itemDiv = document.createElement('div');
                itemDiv.className = 'selected-item';
                itemDiv.dataset.value = selectedValue;
                itemDiv.innerHTML = `
                    ${selectedText} <span class="item-quantity">Jumlah: 1</span>
                    <span class="item-price">Harga: Rp ${hargaPerItem.toFixed(2)}</span>
                `;

                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn btn-danger btn-sm ms-2';
                removeBtn.textContent = 'Hapus';
                removeBtn.addEventListener('click', function () {
                    delete selectedItems[selectedValue];
                    selectedItemsContainer.removeChild(itemDiv);
                    updateHiddenInputs();
                });

                itemDiv.appendChild(removeBtn);
                selectedItemsContainer.appendChild(itemDiv);
            }

            updateHiddenInputs();
            updateTotalBayar();
        });

        // Fungsi untuk memperbarui input tersembunyi
        function updateHiddenInputs() {
            const barangSewa = [];
            const jumlahSewa = [];

            for (const [id, data] of Object.entries(selectedItems)) {
                barangSewa.push(id);
                jumlahSewa.push(data.quantity);
            }

            barangSewaInput.value = JSON.stringify(barangSewa);
            jumlahSewaInput.value = JSON.stringify(jumlahSewa);
        }

        // Fungsi untuk menghitung total bayar
        // function updateTotalBayar() {
        //     let totalBayar = 0;
        //     const tglSewa = new Date(document.getElementById('tanggalSewa').value);
        //     const tglKembali = new Date(document.getElementById('tanggalKembali').value);

        //     // Hitung lama sewa dalam hari
        //     const lamaSewa = Math.ceil((tglKembali - tglSewa) / (1000 * 3600 * 24));

        //     if (lamaSewa < 1) {
        //         alert('Tanggal kembali tidak valid!');
        //         return;
        //     }

        //     // Kalkulasi total bayar
        //     for (const [id, data] of Object.entries(selectedItems)) {
        //         totalBayar += data.price * data.quantity * lamaSewa;
        //     }

        //     totalBayarDisplay.textContent = `Rp ${totalBayar.toFixed(2)}`;
        // }

        function updateTotalBayar() {
            let totalBayar = 0;

            for (const [id, data] of Object.entries(selectedItems)) {
                totalBayar += data.price * data.quantity;
            }

            totalBayarDisplay.textContent = `Rp ${totalBayar.toFixed(2)}`;
        }

        console.log('Tanggal Sewa:', tglSewa);
        //     console.log('Tanggal Kembali:', tglKembali);
        //     console.log('Lama Sewa:', lamaSewa);
            // console.log('Harga Sewa 1:', hargaSewa1);
            // console.log('Harga Sewa 2:', hargaSewa2);
            // console.log('Harga Sewa 3:', hargaSewa3);
            // console.log('Harga Per Item:', hargaPerItem);
            console.log('Selected Items:', selectedItems);



// ADD BARANG KODE 2
let barangSewaArray = [];
        let jumlahSewaArray = [];

        document.getElementById('addItemBtn').addEventListener('click', function () {
            const selectedBarang = document.getElementById('inputGroupSelect04');
            const jumlahBarang = document.querySelector('input[name="jumlah_sewa"]');

            // Validasi input
            if (!selectedBarang.value || jumlahBarang.value <= 0) {
                alert("Pilih barang dan masukkan jumlah yang valid.");
                return;
            }

            // Ambil nilai
            const barangValue = selectedBarang.value;
            const barangText = selectedBarang.options[selectedBarang.selectedIndex].text;
            const jumlahValue = jumlahBarang.value;

            // Tambahkan ke daftar barang yang dipilih
            const itemList = document.getElementById('itemList');
            const listItem = document.createElement('li');
            listItem.textContent = `${barangText} (${jumlahValue} pcs)`;
            itemList.appendChild(listItem);

            // Tambahkan data ke array
            barangSewaArray.push(barangValue);
            jumlahSewaArray.push(jumlahValue);

            // Kosongkan pilihan setelah ditambahkan
            selectedBarang.value = '';
            jumlahBarang.value = '';
        });

        // Saat formulir dikirim, perbarui nilai input tersembunyi
        const form = document.querySelector('form');
        form.addEventListener('submit', function () {
            document.getElementById('barangSewaInput').value = JSON.stringify(barangSewaArray);
            document.getElementById('jumlahSewaInput').value = JSON.stringify(jumlahSewaArray);
        });
