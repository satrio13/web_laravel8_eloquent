<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SiswaModel;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    function __construct()
    {
        $this->siswa_model = new SiswaModel();
    }

    function index()
    {     
        $data['titleweb'] = 'Peserta Didik - '.title();
		$data['title'] = 'Peserta Didik';
        $data['data'] = $this->siswa_model->list_siswa();
        return view('siswa.index', $data);
    }

}