<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfilController extends Controller
{
    function index()
    {     
        $data['title'] = 'Profil Website';
        $data['data'] = ProfilModel::where('id', 1)->first();
        return view('admin.profil.index', $data);
    }

    function edit_profil_web()
    {
        $data['title'] = 'Edit Profil Website';
        $data['data'] = ProfilModel::where('id', 1)->first();
        return view('admin.profil.form_profil', $data);
    }

    function update_profil_web(Request $request)
    {
        $request->validate([
            'nama_web' => 'required|max:100',
            'jenjang' => 'required|numeric',
            'meta_description' => 'required|max:300',
            'meta_keyword' => 'required|max:200',
            'alamat' => 'required|max:300',
            'email' => 'required|email|max:100',
            'telp' => 'required|max:20',
            'fax' => 'required|max:20',
            'whatsapp' => 'max:20',
            'akreditasi' => 'max:5',
            'kurikulum' => 'required|max:30',
            'nama_kepsek' => 'required|max:100',
            'nama_operator' => 'required|max:100',
            'instagram' => 'nullable|url|max:200',
            'facebook' => 'nullable|url|max:200',
            'twitter' => 'nullable|url|max:200',
            'youtube' => 'nullable|url|max:200'
        ]);
        
        $profil = ProfilModel::where('id', 1)->first();
        $q = $profil->update($request->all());
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Disimpan!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    function logo_web()
    {
        $data['title'] = 'Edit Logo Website';
        $data['data'] = ProfilModel::select('logo_web')->where('id', 1)->first();
        return view('admin.profil.form_logo_web', $data);
    }

    function update_logo_web(Request $request)
    {
        $request->validate([
            'logo_web' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
        
        $get = ProfilModel::select('logo_web')->where('id', 1)->first();
        $gambar = $request->file('logo_web');
        $nama_gambar = '';
        if($gambar != '')
        {
            $nama_gambar = time().'_'.$gambar->getClientOriginalName();
            $gambar->move(public_path('img/logo'), $nama_gambar);
            File::delete("img/logo/$get->logo_web");
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Anda belum memilih file yang akan diupload!']);
        }

        $profil = ProfilModel::where('id', 1)->first();
        $data = ['logo_web' => $nama_gambar];
        $q = $profil->update($data);
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'File Gagal Diupdate, silahkan coba lagi!']);
        }
    }

    function favicon()
    {
        $data['title'] = 'Edit Favicon';
        $data['data'] = ProfilModel::select('favicon')->where('id', 1)->first();
        return view('admin.profil.form_favicon', $data);
    }

    function update_favicon(Request $request)
    {
        $request->validate([
            'favicon' => 'max:100'
        ]);
        
        $get = ProfilModel::select('favicon')->where('id', 1)->first();
        $gambar = $request->file('favicon');
        $nama_gambar = '';
        if($gambar != '')
        {
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/logo'), $nama_gambar);
            File::delete("img/logo/$get->favicon");            
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Anda belum memilih file yang akan diupload!']);
        }

        $profil = ProfilModel::where('id', 1)->first();
        $data = ['favicon' => $nama_gambar];
        $q = $profil->update($data);
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'File Gagal Diupdate, silahkan coba lagi!']);
        }
    }

    function logo_admin()
    {
        $data['title'] = 'Edit Logo Login Admin';
        $data['data'] = ProfilModel::select('logo_admin')->where('id', 1)->first();
        return view('admin.profil.form_logo_admin', $data);
    }

    function update_logo_admin(Request $request)
    {
        $request->validate([
            'logo_admin' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
        
        $get = ProfilModel::select('logo_admin')->where('id', 1)->first();
        $gambar = $request->file('logo_admin');
        $nama_gambar = '';
        if($gambar != '')
        {
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/logo'), $nama_gambar);
            File::delete("img/logo/$get->logo_admin");
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Anda belum memilih file yang akan diupload!']);
        }

        $profil = ProfilModel::where('id', 1)->first();
        $data = ['logo_admin' => $nama_gambar];
        $q = $profil->update($data);
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'File Gagal Diupdate, silahkan coba lagi!']);
        }
    }

    function gambar_profil()
    {
        $data['title'] = 'Edit Gambar Profil';
        $data['data'] = ProfilModel::select('gambar')->where('id', 1)->first();
        return view('admin.profil.form_gambar_profil', $data);
    }

    function update_gambar_profil(Request $request)
    {
        $request->validate([
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
        
        $get = ProfilModel::select('gambar')->where('id', 1)->first();
        $gambar = $request->file('gambar');
        $nama_gambar = '';
        if($gambar != '')
        {
            $nama_gambar = time().'_'.$gambar->getClientOriginalName();
            $gambar->move(public_path('img/profil'), $nama_gambar);
            File::delete("img/profil/$get->gambar");
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Anda belum memilih file yang akan diupload!']);
        }

        $profil = ProfilModel::where('id', 1)->first();
        $data = ['gambar' => $nama_gambar];
        $q = $profil->update($data);
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'File Gagal Diupdate, silahkan coba lagi!']);
        }
    }

    function file()
    {
        $data['title'] = 'Edit File';
        $data['data'] = ProfilModel::select('file')->where('id', 1)->first();
        return view('admin.profil.form_file', $data);
    }

    function update_file(Request $request)
    {
        $request->validate([
            'file' => 'mimes:pdf|max:5120'
        ]);
        
        $get = ProfilModel::select('file')->where('id', 1)->first();
        $file = $request->file('file');
        $nama_file = '';
        if($file != '')
        {
            $nama_file = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('file'), $nama_file);
            File::delete("file/$get->file");
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Anda belum memilih file yang akan diupload!']);
        }

        $profil = ProfilModel::where('id', 1)->first();
        $data = ['file' => $nama_file];
        $q = $profil->update($data);
        if($q)
        {
            return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'File Gagal Diupdate, silahkan coba lagi!']);
        }
    }

}
