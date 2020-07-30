<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
   
    public function imageUpload(Request $request)
    {
        dd($request);
        $imageName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('images'), $imageName);         
    	return response()->json(['imageName'=>$imageName]);
    }
    public function addrequest(Request $request)
    {
        //$images = $request->file('file');
        //$count = count($images);
       // dd($count); 
        $fio = $request->fio;
        $phone = $request->phone;
        $transport = $request->transport;
        $images = $request->image;
        Mail::to('dilovar09@gmail.com')->send(new SendMail($fio, $phone, $transport, $images ));
        return  response()->json($images, 201);
    }
}
