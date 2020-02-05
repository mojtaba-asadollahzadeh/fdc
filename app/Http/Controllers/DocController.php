<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doc as Doc;
use App\Body as Body;
use App\Header as Header;
use App\Response as Response;

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
    		'body_type' => 'required|array',
            'body_validation' => 'required|array',
            'body_required' => 'required|array',
    		'body_sample' => 'required|array',
            'body_default' => 'required|array',
    		
            'header_name' => 'required|array',
    		'header_type' => 'required|array',
    		'header_sample' => 'required|array',
            'header_required' => 'required|array',

    		'response_status' => 'required|array',
    		'response_code' => 'required|array',
    		'response_body' => 'required|array',
            'response_error' => 'required|array'
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
            $body->type = $request->input('body_type')[$i];
    		$body->validation = $request->input('body_validation')[$i];
    		$body->sample = $request->input('body_sample')[$i];
            $body->required = $request->input('body_required')[$i];
            $body->default = $request->input('body_default')[$i];
    		$body->save();
    	}

    	// create the headers
    	for ($i=0; $i < sizeof($request->input('header_name')); $i++) { 
    		$header = new Header;
    		$header->doc_id = $doc->id;
    		$header->name = $request->input('header_name')[$i];
    		$header->type = $request->input('header_type')[$i];
    		$header->sample = $request->input('header_sample')[$i];
            $header->required = $request->input('header_required')[$i];
    		$header->save();
    	}

    	// create the Responses
    	for ($i=0; $i < sizeof($request->input('http_status')); $i++) { 
    		$response = new Response;
    		$response->doc_id = $doc->id;
    		$response->status = $request->input('response_status')[$i];
    		$response->code = $request->input('response_code')[$i];
    		$response->response = $request->input('response_body')[$i];
            $response->error = $request->input('response_error')[$i];
    		$response->save();
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
