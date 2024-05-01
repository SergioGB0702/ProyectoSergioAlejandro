<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\DataTables\UsersDataTable;
use App\Mail\CorreoPrueba;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    public function correo()
    {
        return view('users.correo');
    }

    public function import(Request $request)
    {
//        $request->validate([
//            'name' => 'required',
//            'email' => 'required',
//        ]);
//
//        User::create($request->all());
        User::truncate();
        $file = $request->file('import_file');

        Excel::import(new UsersImport, $file);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }
    public function cargarImport() {
      return view('users.import-excel');
    }


    public function pruebaCorreo() {
        Mail::to('alejandrocbt@hotmail.com')->send(new CorreoPrueba());
        return redirect()->route('user.correo');
    }
}
