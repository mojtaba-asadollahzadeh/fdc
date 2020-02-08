<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Doc as Doc;
use App\Body as Body;
use App\Header as Header;
use App\Response as Response;
use App\Message as Message;
use App\Path as Path;

class DocumentController extends Controller
{
    public function create(Request $request)
    {

    	$validation = Validator::make($request->all(),[ 
	        'title' => 'required|string|min:3',
    		'description' => 'required|string|min:3',
    		'method' => 'required|string|in:POST,GET,DELETE,PUT,PATCH',
    		'endpoint' => 'required|string',
    		'bodies' => 'required|array',
            'headers' => 'required|array',
    		'responses' => 'required|array',
    		'messages' => 'required|array',
	    ]);

	    if($validation->fails()){
	    	return response()->json([
	    		'success' => false,
	    		'message' => 'validation failed on some of your data!',
	    		'data' => [
	    			$validation->errors()
	    		]
	    	]);
	    }

	    $doc = new Doc;
		$doc->title = $request->input('title');
		$doc->description = $request->input('description');
		$doc->method = $request->input('method');
		$doc->endpoint = $request->input('endpoint');
		$doc->save();
	    
	    if($request->input('method') != 'GET'){
	    	
	    	foreach ($request->input('bodies') as $bd) {
    			$body = new Body;
    			$body->doc_id = $doc->id; 
    			$body->name = $bd['name'];
    			$body->type = $bd['type'];
    			$body->validation = $bd['validation'];
    			$body->sample = $bd['sample'];
    			$body->required = $bd['required'];
    			if($bd['required']){
    				$body->default = $bd['default'];	
    			}
    			$body->save();
    		}

	    }else{
	    	foreach ($request->input('paths') as $pth) {
    			$path = new Path;
    			$path->doc_id = $doc->id; 
    			$path->name = $bd['name'];
    			$path->type = $bd['type'];
    			$path->sample = $bd['sample'];
    			$path->save();
    		}
	    }

	    foreach ($request->input('headers') as $head) {
			$header = new Header;
			$header->doc_id = $doc->id; 
			$header->name = $head['name'];
			$header->type = $head['type'];
			$header->sample = $head['sample'];
			$header->save();
		}

		foreach ($request->input('responses') as $res) {
			$response = new Response;
			$response->doc_id = $doc->id; 
			$response->name = $res['name'];
			$response->type = $res['type'];
			$response->sample = $res['sample'];
			$response->save();
		}

		foreach ($request->input('messages') as $msg) {
			$message = new Message;
			$message->doc_id = $doc->id; 
			$message->status = $msg['status'];
			$message->code = $msg['code'];
			$message->message = $msg['message'];
			$message->error = $msg['error'];
			$message->save();
		}
    	
    	return response()->json([
    		'success' => true,
    		'message' => 'document created successfully!',
    		'data' => [
    			'document' => $doc,
    			'paths' => $request->input('paths'),
    			'bodies' => $request->input('bodies'),
    			'headers' => $request->input('headers'),
    			'responses' => $request->input('responses'),
    			'messages' => $request->input('messages')
    		]
    	],201);
    }


    public function update(Request $request)
    {
    	# code...
    }


    public function delete(Request $request)
    {
    	# code...
    }


    public function show(Request $request)
    {
    	# code...
    }


    public function list(Request $request)
    {
    	# code...
    }
}
