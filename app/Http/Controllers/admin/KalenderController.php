<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KalenderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KalenderController extends Controller
{
    function index()
    {     
        $data['title'] = 'Kalender';
        $data['data'] = KalenderModel::where('id', 1)->first();
        return view('admin.kalender.index', $data);
    }

    function update_kalender(Request $request)
    {   
        $request->validate([
            'file' => 'max:5120'
        ]);
            
        $get = KalenderModel::where('id', 1)->first();
        $nama_gambar = '';
        $gambar = $request->file('file');
        if($gambar != '')
        {
            $nama_gambar = time().'_'.$gambar->getClientOriginalName();
            $gambar->move(public_path('img/kalender'), $nama_gambar);
            File::delete("img/kalender/$get->kalender");
        }else
        {
            $nama_gambar = $get->kalender;
        }
        
        $kalender = KalenderModel::where('id', 1)->first();
        $data = ['kalender' => $nama_gambar];
        $q = $kalender->update($data);
        if($q)
        {
            return redirect()->route('backend/kalender')->with(['success' => 'Data Berhasil Diupdate!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
}