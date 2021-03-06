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
        $this->validateRequest($request); 
	    $doc = new Doc;
		$doc->title = $request->input('title');
		$doc->description = $request->input('description');
		$doc->method = $request->input('method');
		$doc->endpoint = $request->input('endpoint');
		$doc->save();
	    
	    if($request->input('method') != 'GET'){
	    	
            $currentParent = null;
	    	foreach ($request->input('bodies') as $bd) {
    			$body = new Body;
    			$body->doc_id = $doc->id; 
    			
                if($currentParent != null && $bd['child'] == true){
                    $body->parent_id = $currentParent;
                }
                
                $body->name = $bd['name'];
    			$body->type = $bd['type'];
    			$body->validation = $bd['validation'];
    			$body->sample = $bd['sample'];
    			$body->required = $bd['required'];
    			
                if(!$bd['required']){
    				$body->default = $bd['default'];	
    			}

    			$body->save();
                
                if($bd['type'] == 'Array'){
                    $currentParent = $body->id;
                }

    		}

	    }
        if($request->input('method') != 'POST'){
	    	foreach ($request->input('paths') as $pth) {
    			$path = new Path;
    			$path->doc_id = $doc->id; 
    			$path->name = $pth['name'];
    			$path->type = $pth['type'];
                $path->required = $pth['required'];
    			$path->sample = $pth['sample'];
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

        $currentParent = null;
		foreach ($request->input('responses') as $res) {
			$response = new Response;
			$response->doc_id = $doc->id;

            if($currentParent != null && $res['child'] == true){
                $response->parent_id = $currentParent;
            }
             
			$response->name = $res['name'];
			$response->type = $res['type'];
			$response->sample = $res['sample'];
			$response->save();

            if($res['type'] == 'Array'){
                $currentParent = $response->id;
            }
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


    public function update(Request $request,$id)
    {

        $this->validateRequest($request);
        $doc = Doc::find($id);

        if(!$doc){
            return response()->json([
                'success' => false,
                'message' => 'document not found!',
                'data' => null
            ]);
        }

        $doc->title = $request->input('title');
        $doc->description = $request->input('description');
        $doc->method = $request->input('method');
        $doc->endpoint = $request->input('endpoint');
        $doc->save();
        
        if($request->input('method') != 'GET'){
            
            foreach ($doc->bodies() as $body) {
                $body->delete();
            }

            foreach ($request->input('bodies') as $bd) {
                $body = new Body;
                $body->doc_id = $doc->id; 
                $body->name = $bd['name'];
                $body->type = $bd['type'];
                $body->validation = $bd['validation'];
                $body->sample = $bd['sample'];
                $body->required = $bd['required'];
                if(!$bd['required']){
                    $body->default = $bd['default'];    
                }
                $body->save();
            }

        }

        if($request->input('method') != 'POST'){
            foreach ($doc->paths() as $path) {
                $path->delete();
            }
            foreach ($request->input('paths') as $pth) {
                $path = new Path;
                $path->doc_id = $doc->id; 
                $path->name = $pth['name'];
                $path->type = $pth['type'];
                $path->required = $pth['required'];
                $path->sample = $pth['sample'];
                $path->save();
            }
        }



        foreach ($doc->headers() as $header) {
            $header->delete();
        }

        foreach ($request->input('headers') as $head) {
            $header = new Header;
            $header->doc_id = $doc->id; 
            $header->name = $head['name'];
            $header->type = $head['type'];
            $header->sample = $head['sample'];
            $header->save();
        }

        foreach ($doc->responses() as $response) {
            $response->delete();
        }

        foreach ($request->input('responses') as $res) {
            $response = new Response;
            $response->doc_id = $doc->id; 
            $response->name = $res['name'];
            $response->type = $res['type'];
            $response->sample = $res['sample'];
            $response->save();
        }

        foreach ($doc->messages() as $message) {
            $message->delete();
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
            'message' => 'document updated successfully!',
            'data' => [
                'document' => $doc,
                'paths' => $request->input('paths'),
                'bodies' => $request->input('bodies'),
                'headers' => $request->input('headers'),
                'responses' => $request->input('responses'),
                'messages' => $request->input('messages')
            ]
        ],200);
    }

    public function delete($id)
    {

        $doc = Doc::find($id);

        if(!$doc){
            return response()->json([
                'success' => false,
                'message' => 'document not found!',
                'data' => null
            ]);
        }

        $doc->deleted = true;
        $doc->save();

        return response()->json([
            'success' => true,
            'message' => 'document deleted successfully!',
            'data' => 1
        ],200);
    }


    public function show(Request $request)
    {
    	# code...
    }


    public function list(Request $request)
    {
    	# code...
    }

    public function validateRequest($request)
    {
        $validation = Validator::make($request->all(),[ 
            'title' => 'required|string|min:1',
            'description' => 'required|string|min:1',
            'method' => 'required|string|in:POST,GET,DELETE,PUT,PATCH',
            'endpoint' => 'required|string',
            'bodies' => 'required|array',
            'headers' => 'required|array',
            'responses' => 'required|array',
            'messages' => 'required|array',
        ]);

        $errors = [];

        if($validation->fails()){
            $errors['definition'] = $validation->errors();
        }

        /* paths validation */
        if($request->input('method') == 'GET'){
            /* path validation */
            foreach ($request->input('paths') as $key => $path) {
                
                $validation = Validator::make($path,[ 
                    'name' => 'required|string|min:1',
                    'type' => 'required|string|min:1',
                    'required' => 'required|boolean',
                    'sample' => 'required|string',
                ]);

                if($validation->fails()){
                    $errors['paths'][$key] = $validation->errors();
                }        
            }
        }else{
            if($request->input('method') != 'POST'){
                /* path validation */
                foreach ($request->input('paths') as $key => $path) {
                    
                    $validation = Validator::make($path,[ 
                        'name' => 'required|string|min:1',
                        'type' => 'required|string|min:1',
                        'required' => 'required|boolean',
                        'sample' => 'required|string',
                    ]);

                    if($validation->fails()){
                        $errors['paths'][$key] = $validation->errors();
                    }        
                }
            }

            if($request->input('method') != 'DELETE'){
                /* body validation */
                foreach ($request->input('bodies') as $key => $body) {
                    
                    $validation = Validator::make($body,[ 
                        'name' => 'required|string|min:1',
                        'type' => 'required|string|min:1',
                        'sample' => 'required|string',
                        'required' => 'sometimes||boolean'
                    ]);

                    if($validation->fails()){
                        $errors['bodies'][$key] = $validation->errors();
                    }        
                }    
            }
            
        }
        

        /* headers validation */
        foreach ($request->input('headers') as $key => $header) {
            $validation = Validator::make($header,[ 
                'name' => 'required|string|min:1',
                'type' => 'required|string|min:1',
                'sample' => 'required|string'
            ]);

            if($validation->fails()){
                $errors['headers'][$key] = $validation->errors();
            }
        }

        
        

        /* headers validation */
        foreach ($request->input('responses') as $key => $response) {
            $validation = Validator::make($response,[ 
                'name' => 'required|string|min:1',
                'type' => 'required|string|min:1',
                'sample' => 'required|string'
            ]);

            if($validation->fails()){
                $errors['responses'][$key] = $validation->errors();
            }
        }
        
        
        /* messages validation */
        foreach ($request->input('messages') as $key => $message) {
            $validation = Validator::make($message,[ 
                'status' => 'required|string|min:1',
                'required' => 'sometimes|boolean',
                'message' => 'required|string',
            ]);

            if($validation->fails()){
                $errors['messages'][$key] = $validation->errors();
            }
        }


        if(sizeof($errors) > 0){
            return response()->json([
                'success' => false,
                'message' => 'validation failed on some of your data!',
                'errors' => $errors
            ]);
        }
    }
}
