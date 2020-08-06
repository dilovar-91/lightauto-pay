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
        //dd($request); 
        $fio = $request->fio;
        $phone = $request->phone;
        $transport = $request->transport;
        $images = $request->image;
        $files = $request->file;
        
        Mail::to('dilovar09@gmail.com')->send(new SendMail($fio, $phone, $transport, $images, $files));
        //Mail::to('info@pilot-auto77.ru')->send(new SendMail($fio, $phone, $transport, $images, $files));
        return  response()->json($request, 201);
    }
}
