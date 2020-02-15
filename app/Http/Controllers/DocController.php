<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doc as Doc;
use App\Body as Body;
use App\Header as Header;
use App\Response as Response;

class DocController extends Controller
{
    public function index()
    {
        $docs = Doc::where('deleted',0)->get();
        return view('docs')->with([
            'docs' => $docs
        ]);
    }

    public function new()
    {
    	return view('create');
    }

    
    public function edit($id)
    {
        $doc = Doc::find($id);
        
        if($doc == null){
            return redirect('/docs')->with('error','سند مورد نظر یافت نشد!');
        }

        return view('edit')->with([
            'doc' => $doc
        ]);
    }

    // function to show document
    public function show($id)
    {
    	$doc = Doc::find($id);
    	if($doc == null){
    		return redirect('/docs/new')->with('error','سند مورد نظر یافت نشد!');
    	}
    	return view('doc')->with([
    		'doc' => $doc
    	]);
    }
}
