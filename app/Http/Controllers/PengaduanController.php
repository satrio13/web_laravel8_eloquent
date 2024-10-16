<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PengaduanModel;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    function __construct()
    {
        $this->pengaduan_model = new PengaduanModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['titleweb'] = 'Layanan Pengaduan - '.title();
        $data['title'] = 'Layanan Pengaduan';
        return view('pengaduan.index', $data);
    }

    function simpan_pengaduan(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'status' => 'required',
            'isi' => 'required'
        ],
        [
            'nama.required' => 'Kolom nama pengaduan harus diisi.',
            'nama.max:50' => 'Kolom nama pengaduan harus kurang dari atau sama dengan :value karakter.'
        ]);

        $q = PengaduanModel::create($request->all());
        if($q)
        {
            return redirect()->route('pengaduan')->with(['success' => 'TERIMAKASIH, DATA BERHASIL DIKIRIM']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Disimpan, silahkan coba lagi!']);
        }
    }

}
