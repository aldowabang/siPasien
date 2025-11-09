<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
    {
        $data = [
            'title' => 'Web Simpus',
            'heading' => 'Tambah Data',
            'subheading' => 'Cek Halaman ini',
            'content' => 'Ini adalah halaman utama dari aplikasi Simpus.'
        ];
        return view('welcome', $data);
    }
}
