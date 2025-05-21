<!DOCTYPE html>
<html lang="en" data-theme="corporate">

<head>
    @vite('resources/css/app.css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    <!-- CSRF Token untuk AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        #reader {
            width: 500px;
            margin: 30px auto;
            border: 2px dashed #007bff;
            padding: 20px;
            background-color: white;
        }

        #reader__scan_region {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* pastikan tinggi sesuai kebutuhan */
            text-align: center;
        }

        #reader__scan_region img {
            width: 80px;
            /* atau sesuai ukuran yang kamu inginkan */
            margin-bottom: 10px;
        }

        b,
        strong {
            margin-top: 10px;
            font-size: 24px;
            color: #000;
        }

        @media (max-width: 480px) {
            #reader {
                width: 90vw;

            }
        }
    </style>
</head>

<body>
    <div style="text-align: center;">
        <h2 class="text-lg font-bold text-white">The Wedding of</h2>
        <h1 class="text-4xl font-bold text-white mb-10">Misha & Pasha</h1>
        <p class="text-white">Silahkan scan QR Code Anda</p>
    </div>

    <div id="reader"></div>
    <div style="text-align: right; margin-top: 20px;">
        <a href="/daftar-tamu" class="text-white font-bold underline">Lihat Daftar Tamu</a>

    </div>

    <!-- Modal Popup -->
    <div>

    </div>
    <div id="successModal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 flex items-center justify-center">
            <div class="w-full max-w-lg p-4">

                <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div>

                            <div class="mt-3 text-center sm:mt-0 sm:ml-4">
                                <h3 class="text-xl font-semibold text-gray-900" id="modal-title">Deactivate account</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 flex justify-center">
                        <button onclick="closeModal()" type="button" style="background-color: #114681; color: #fff; padding: 15px; border-radius: 5px;">OK</button>
                    </div>

                </div>
            </div>
        </div>
    </div>


</body>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let scanner;

    function showModal(title, message) {
        // Ubah isi modal
        document.querySelector("#successModal #modal-title").innerText = title;
        document.querySelector("#successModal p").innerHTML = message;

        // Tampilkan modal
        document.getElementById("successModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("successModal").classList.add("hidden");
        scanner.render(onScanSuccess, onScanFailure);

    }

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code matched = ${decodedText}`, decodedResult);

        scanner.clear().then(() => {
            fetch("/store", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({
                        code: decodedText
                    })
                })
                .then(response => response.json())
                .then(data => {
                    showModal("Selamat Datang",
                        "Bapak/Ibu/Saudara/i:<br><br><strong>" + decodedText + "</strong>");
                    console.log(data);


                })
                .catch(error => {
                    showModal("Scan Gagal", "QR Tidak Valid");
                    console.error("Error:", error);


                });
        });
    }

    function onScanFailure(error) {
        // Optional: log jika perlu
    }

    function getQrBoxSize() {
        return window.innerWidth < 480 ? {
                width: 300,
                height: 300
            } // Mobile
            :
            {
                width: 250,
                height: 250
            }; // Desktop
    }

    scanner = new Html5QrcodeScanner("reader", {
        fps: 10,
        qrbox: getQrBoxSize()
    }, false);

    scanner.render(onScanSuccess, onScanFailure);
</script>


</html>