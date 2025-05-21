<!DOCTYPE html>
<html lang="en" data-theme="corporate">

<head>
    @vite('resources/css/app.css')

    <title>Data Tamu Undangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: white !important;
        }

        table {
            border-collapse: separate;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="w-full max-w-6xl mx-auto sm:px-5">
        <h2 class="text-4xl font-bold font-[Poppins] text-center mb-10">Data Tamu Undangan</h2>

        <div class="overflow-x-auto sm:px-10">
            <table class="w-full table-auto border-collapse text-sm">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Waktu Checkin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($scans as $i => $scan)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="break-words">{{ $scan->code }}</td>
                        <td>{{ \Carbon\Carbon::parse($scan->created_at)->format('d-m-Y H:i:s') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">Belum ada data scan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 sm:px-10">
            <a href="/" class="bg-[#114681] text-white px-4 py-2 inline-block">Kembali</a>
        </div>
    </div>
</body>

</html>