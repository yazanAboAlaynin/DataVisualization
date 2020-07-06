<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function uploadFile(){
        return view('uploadFile');
    }

    public function store(Request $request){
        $request->validate([
                'file' => 'required|file',
            ]);

        $file = $request->file('file');

        $path = $file->storeAs('csv', \Str::random(40) . '.' . $file->getClientOriginalExtension());
        $file = fopen(storage_path('app/'.$path), 'r');
        $all_data = array();
        while ( ($data = fgetcsv($file, 200, ",")) !==FALSE ){

            $array = $data;
           // dd($data);
            array_push($all_data, $array);
        }
        fclose($file);
        //dd($all_data);
        $all_data = \GuzzleHttp\json_encode($all_data);

        Session::push('all', $all_data);
        return redirect()->route('circle');
    }

    public function circle(){

        $all = Session::get('all');
        $all = $all[0];

        return view('circle',compact('all'));
    }

    public function bar(){

        $all = Session::get('all');
        $all = $all[0];

        return view('bar',compact('all'));
    }

    public function coordinate(){

        $all = Session::get('all');
        $all = $all[0];

        return view('coordinate',compact('all'));
    }
}
