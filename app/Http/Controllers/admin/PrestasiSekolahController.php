<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrestasiSekolahModel;
use App\Models\TahunModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PrestasiSekolahController extends Controller
{
    function index()
    {     
        $data['title'] = 'Prestasi Sekolah';
        $data['data'] = PrestasiSekolahModel::with('tahun')->latest()->get();
        return view('admin.prestasi_sekolah.index', $data);
    }

    function tambah_prestasi_sekolah()
    {     
        $data['title'] = 'Tambah Prestasi Sekolah';
        $data['tahun'] = TahunModel::orderBy('tahun', 'desc')->get();
        return view('admin.prestasi_sekolah.form_tambah', $data);
    }

    function simpan_prestasi_sekolah(Request $request)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'tingkat' => 'required|numeric',
            'keterangan' => 'max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $nama_gambar = '';
        $gambar = $request->file('gambar');
        if($gambar != '')
        {
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/prestasi_sekolah'), $nama_gambar);
        }

        $data = array_merge($request->all(), ['gambar' => $nama_gambar]);
        $q = PrestasiSekolahModel::create($data);
        if($q)
        {
            return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Disimpan!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    function edit_prestasi_sekolah($id)
    {   
        $prestasi = PrestasiSekolahModel::findOrFail($id); 
        $data['title'] = 'Edit Prestasi Sekolah';
        $data['data'] = $prestasi;
        $data['tahun'] = TahunModel::orderBy('tahun', 'desc')->get();
        return view('admin.prestasi_sekolah.form_edit', $data);
    }

    function update_prestasi_sekolah(Request $request, $id)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'tingkat' => 'required|numeric',
            'keterangan' => 'max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $get = PrestasiSekolahModel::select('id', 'gambar')->findOrFail($id);
        $nama_gambar = '';
        $gambar = $request->file('gambar');
        if($gambar != '')
        {
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/prestasi_sekolah'), $nama_gambar);
            File::delete("img/prestasi_sekolah/$get->gambar");
        }else
        {
            $nama_gambar = $get->gambar;
        }
        
        $prestasi = PrestasiSekolahModel::findOrFail($id);
        $data = array_merge($request->all(), ['gambar' => $nama_gambar]);
        $q = $prestasi->update($data);
        if($q)
        {
            return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    function hapus_prestasi_sekolah($id)
    {   
        $data = PrestasiSekolahModel::select('id', 'gambar')->findOrFail($id);
        File::delete("img/prestasi_sekolah/$data->gambar");
        $q = $data->delete();
        if($q)
        {
            return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            return redirect()->route('backend/prestasi-sekolah')->with(['errors' => 'Data Gagal Dihapus!']);
        }
    }

}