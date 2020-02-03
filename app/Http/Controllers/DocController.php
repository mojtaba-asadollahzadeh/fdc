<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doc as Doc;
use App\Body as Body;
use App\Header as Header;
use App\Error as Error;

class DocController extends Controller
{
    public function new()
    {
    	return view('create');
    }

    public function save(Request $request)
    {
    	$request->validate([
    		'title' => 'required|string|min:3',
    		'description' => 'required|string|min:3',
    		'method' => 'required|string|in:POST,GET,DELETE,PUT,PATCH',
    		'endpoint' => 'required|string',
    		'body_name' => 'required|array',
    		'body_validation' => 'required|array',
    		'body_sample' => 'required|array',
    		'header_name' => 'required|array',
    		'header_validation' => 'required|array',
    		'header_sample' => 'required|array',
    		'error_code' => 'required|array',
    		'error_custom_code' => 'required|array',
    		'error_description' => 'required|array'
    	]);
    	// create the document
    	$doc = new Doc;
    	$doc->title = $request->input('title');
    	$doc->description = $request->input('description');
    	$doc->endpoint = $request->input('endpoint');
    	$doc->method = $request->input('method');
    	$doc->save();
    	// create the body
    	for ($i=0; $i < sizeof($request->input('body_name')); $i++) { 
    		$body = new Body;
    		$body->doc_id = $doc->id;
    		$body->name = $request->input('body_name')[$i];
    		$body->validation = $request->input('body_validation')[$i];
    		$body->sample = $request->input('body_sample')[$i];
    		$body->save();
    	}

    	// create the headers
    	for ($i=0; $i < sizeof($request->input('header_name')); $i++) { 
    		$header = new Header;
    		$header->doc_id = $doc->id;
    		$header->name = $request->input('header_name')[$i];
    		$header->validation = $request->input('header_validation')[$i];
    		$header->sample = $request->input('header_sample')[$i];
    		$header->save();
    	}

    	// create the errors
    	for ($i=0; $i < sizeof($request->input('error_code')); $i++) { 
    		$error = new Error;
    		$error->doc_id = $doc->id;
    		$error->code = $request->input('error_code')[$i];
    		$error->custom_code = $request->input('error_custom_code')[$i];
    		$error->description = $request->input('error_description')[$i];
    		$error->save();
    	}
    	
    	return redirect()->back()->with('success','مستند با موفقیت ایجاد شد!');

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
