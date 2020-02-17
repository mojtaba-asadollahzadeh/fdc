@extends('layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="/css/json-viewer.css">
<style type="text/css">
	li.message.error{
		border:2px dashed red !important;
	}
	li.message{
		background: #fff !important;
		border:2px dashed green;
	}
	span.required{
		color: red;
	}
	
	.curl{
		font-size: 15px;
	    font-weight: 600;
	}
</style>
@stop

@section('main')
<?php 
	$body = [];
	foreach ($doc->body() as $bd) {
		$body[$bd->name] = $bd->sample;
	}

	$paths = [];
	foreach ($doc->paths() as $path) {
		$paths[$path->name] = $path->sample;
	}

	$headers = [];
	foreach ($doc->headers() as $header) {
		$headers[$header->name] = $header->sample;
	}

	$responses = [];
	foreach ($doc->responses() as $response) {
		$responses[$response->name] = $response->sample;
	}
?>
<div class="card" id="print">
  <div class="card-body">
    <h3 class="card-title">{{$doc->title}}</h3>
    <p class="card-text desc">
    	{{$doc->description}}
    </p>
    <hr>
    <div class="col-xs-12 text-left monospace document" dir="ltr">
		<div class="endpoint">
			<a class="endpoint-icon"><span><i class="fas fa-link"></i></span></a>
			<a class="endpoint-method"><span>{{$doc->method}}</span></a>
			<a class="endpoint-url"><span>{{$doc->endpoint}}</span></a>
		</div>
    	<hr>
    	<div class="col-xs-12 element curl">
    		<h6>Curl</h6>
    		curl --header "Content-Type: application/json" \<br>
			  --request {{$doc->method}} \<br>
			  @if($doc->method != 'GET')
			  --data '{{json_encode($body)}}' \<br>
			  @endif
			  https://{HOST}/{{$doc->endpoint}}
    	</div>
    	@if($doc->method == 'GET')
    	<hr>
    	<div class="col-xs-12 element">
	    	<h6>Path</h6>
	    	<div id="json-path"></div>
	    	<div>
	    		@foreach($doc->paths() as $path)
	    			<li>
	    				<span>
	    						{{$path->name}}<span class="required">*</span> :
	    				</span>
	    				<span>
	    						required|{{$path->type}}
	    				</span>
	    			</li>
	    		@endforeach
	    	</div>
    	</div>
    	@else
    	<hr>
    	<div class="col-xs-12 element">
	    	<h6>Body</h6>
	    	<div id="json-body"></div>
	    	<div>
	    		@foreach($doc->body() as $bd)
	    			<li>
	    				<span>
	    					@if($bd->required)
	    						{{$bd->name}}<span class="required">*</span> :
	    					@else
	    						{{$bd->name}} :
	    					@endif 
	    				</span>
	    				<span>
	    					@if($bd->required)
	    						required|{{$bd->type}}|{{$bd->validation}}
	    					@else
	    						sometimes|{{$bd->type}}|{{$bd->validation}}
	    					@endif
	    				</span>
	    			</li>
	    		@endforeach
	    	</div>
    	</div>
    	@endif
    	<div class="col-xs-12 element">
	    	<h6>Headers</h6>
	    	<div id="json-header" style="border:0;"></div>
		</div>
		<div class="col-xs-12 element">
	    	<h6>Response</h6>
	    	<div id="json-header"></div>
	    	<div>
	    		@foreach($doc->messages() as $message)
	    			<li class="message 
	    							@if($message->error)
				    					error
		    						@endif
		    						">
		    			<div class="p-text"> 
							@if($message->error)
		    					<label class="badge badge-danger">Response : {{$message->status}}</label>
							@else
								<label class="badge badge-success">Response : {{$message->status}}</label>
							@endif	
							<div id="json-view-{{$message->id}}"></div>
						</div>
	    			</li>
	    		@endforeach
	    	</div>
    	</div>
    </div>
  </div>
</div>
@stop

@section('script')
<script type="text/javascript" src="/js/json-viewer.js"></script>
<script type="text/javascript">
	
	@if($doc->method == 'GET')
		var jsonPathViewer = new JSONViewer();
		var jsonPath = JSON.parse('<?= json_encode($paths) ?>');
		document.querySelector("#json-path")
			.appendChild(jsonPathViewer.getContainer());
		jsonPathViewer.showJSON(jsonPath);
	@else
		var jsonBodyViewer = new JSONViewer();
		var jsonBody = JSON.parse('<?= json_encode($body) ?>');
		document.querySelector("#json-body")
			.appendChild(jsonBodyViewer.getContainer());
		jsonBodyViewer.showJSON(jsonBody);
	@endif


	var jsonHeaderViewer = new JSONViewer();
	var jsonHeader = JSON.parse('<?= json_encode($headers) ?>');
	document.querySelector("#json-header").appendChild(jsonHeaderViewer.getContainer());
	jsonHeaderViewer.showJSON(jsonHeader);


	@foreach($doc->messages() as $msg)
		<?php 
			if($msg->error){
				if($message->code){
					$data = [
						'Custom code' => $message->code
					];
				}else{
					$data = null;
				}

				$res = [
					'message' => $msg->message,
					'data' => $data
				];
			}else{
				$res = [
					'message' => $msg->message,
					'data' => $responses
				];
			}
		?>
		var jsonHeaderViewer = new JSONViewer();
		var jsonHeader = JSON.parse('<?= json_encode($res) ?>');
		document.querySelector("#json-view-{{$msg->id}}").appendChild(jsonHeaderViewer.getContainer());
		jsonHeaderViewer.showJSON(jsonHeader);		
	@endforeach
</script>
@stop
