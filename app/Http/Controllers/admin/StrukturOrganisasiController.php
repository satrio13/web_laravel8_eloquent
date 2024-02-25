<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StrukturOrganisasiController extends Controller
{
    function index()
    {     
        $data['title'] = 'Struktur Organisasi';
        $data['data'] = StrukturOrganisasiModel::where('id', 1)->first();
        return view('admin.struktur_organisasi.index', $data);
    }

    function edit_struktur_organisasi()
    {     
        $data['title'] = 'Edit Struktur Organisasi';
        $data['data'] = StrukturOrganisasiModel::where('id', 1)->first();
        return view('admin.struktur_organisasi.form_struktur_organisasi', $data);
    }

    function update_struktur_organisasi(Request $request)
    {   
        $request->validate([
            'struktur' => 'image|mimes:jpeg,jpg,png|max:3072|required'
        ]);
            
        $get = StrukturOrganisasiModel::select('id', 'isi')->where('id', 1)->first();
        $nama_gambar = '';
        $gambar = $request->file('struktur');
        if($gambar != '')
        {
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/struktur'), $nama_gambar);
            File::delete("img/struktur/$get->isi");
        }else
        {
            $nama_gambar = $get->isi;
        }
        
        $struktur = StrukturOrganisasiModel::where('id', 1)->first();
        $data = ['isi' => $nama_gambar];
        $q = $struktur->update($data);
        if($q)
        {
            return redirect()->route('backend/struktur-organisasi')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

}