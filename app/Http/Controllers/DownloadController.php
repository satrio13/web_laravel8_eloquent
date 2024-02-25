<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DownloadModel;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    function index()
    {
        $data['titleweb'] = 'Download - '.title();
		$data['title'] = 'Download';
        $data['data'] = DownloadModel::where('is_active', 1)->latest()->get();
        return view('download/index', $data);
    }

    function hits($file)
    {
        $cek = DownloadModel::where('is_active', 1)->where('file', $file)->first();
        if($cek)
        {
            $download = $cek;
            $upd = [
                'hits' => $cek->hits + 1
            ];

            $download->update($upd);
            $path = "file/$cek->file";
            if(!file_exists($path))
            {
                return abort(404, 'File not found');
            }else
            {
                return response()->download($path);
            }
        }else
        {
            abort(404);
        }
    }

}