<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        // Simpan ke database
        $scan = new Scan();
        $scan->code = $request->code;
        $scan->save();

        return response()->json(['message' => 'Scan saved']);
    }

    public function index()
    {
        $scan = DB::table('scans')->get();

        return view('index', ['scans' => $scan]);
    }
}
