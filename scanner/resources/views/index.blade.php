<!DOCTYPE html>
<html>

<head>
    <title>Data Tamu Undangan</title>
    <style>
        body {
            width: 1000px;
            margin: auto;
        }

        table {
            border-collapse: collapse;
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
    <div>
        <h2 style="text-align: center;">Data Tamu Undangan</h2>

        <table>
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
                    <td>{{ $scan->code }}</td>
                    <td>{{ \Carbon\Carbon::parse($scan->created_at)->format('d-m-Y H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">Belum ada data scan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 30px;">
            <a href="/" class="btn btn-primary btn-sm" style="background-color: blue; color: #fff; padding: 10px;">Kembali</a>
        </div>


    </div>



</body>

</html>