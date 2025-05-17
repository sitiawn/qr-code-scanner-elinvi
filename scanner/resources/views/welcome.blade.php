<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    <!-- CSRF Token untuk AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        html,
        body {
            width: 1000px;
            height: 100%;
            margin: auto;
            background-color: #f9fafb;
            justify-content: center;
            align-items: center;
            align-content: center;
        }

        #reader {
            width: 300px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div style="text-align: center;">
        <h2>The Wedding of</h2>
        <h1>Misha & Pasha</h1>
        <p>Silahkan scan QR Code Anda</p>
    </div>

    <div id="reader"></div>
    <div style="text-align: right; margin-top: 30px;">
        <a href="/daftar-tamu" class="btn btn-primary btn-sm" style=" text-align: right; background-color: blue; color: #fff; padding: 10px;">Lihat Daftar Tamu</a>

    </div>

</body>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let scanner; // buat di luar agar bisa dipanggil ulang

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code matched = ${decodedText}`, decodedResult);

        // Hentikan scanner sementara
        scanner.clear().then(() => {
            // Kirim ke Laravel pakai fetch
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
                    alert("Selamat Datang " + decodedText);
                    console.log(data);
                    // Mulai lagi setelah jeda 3 detik
                    setTimeout(() => {
                        scanner.render(onScanSuccess, onScanFailure);
                    }, 3000);
                })
                .catch(error => {
                    alert("QR Tidak Valid");
                    console.error("Error:", error);
                    // Mulai lagi setelah error
                    setTimeout(() => {
                        scanner.render(onScanSuccess, onScanFailure);
                    }, 3000);
                });
        });
    }

    function onScanFailure(error) {
        // Tidak perlu apa-apa, bisa biarkan terus scanning
        // console.warn(`Code scan error = ${error}`);
    }

    // Inisialisasi scanner
    scanner = new Html5QrcodeScanner("reader", {
        fps: 10,
        qrbox: {
            width: 250,
            height: 250
        }
    }, false);

    scanner.render(onScanSuccess, onScanFailure);
</script>

</html>