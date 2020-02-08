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

	$headers = [];
	foreach ($doc->headers() as $header) {
		$headers[$header->name] = $header->sample;
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
			  --request POST \<br>
			  --data '{{json_encode($body)}}' \<br>
			  https://{HOST}/{{$doc->endpoint}}
    	</div>
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
		    			<p class="p-text"> 
						@if($message->error)
	    					<label class="badge badge-danger">Error Response</label>
						@else
							<label class="badge badge-success">Success Response</label>
						@endif	
						<span>Code : </span>
						<span>{{$message->status}}</span><br>
						<span>Custom Code : </span>
						<span>{{$message->code}}</span>
							<div id="json-view-{{$message->id}}"></div>
						</p>
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
	var jsonBodyViewer = new JSONViewer();
	var jsonBody = JSON.parse('<?= json_encode($body) ?>');
	document.querySelector("#json-body")
		.appendChild(jsonBodyViewer.getContainer());
	jsonBodyViewer.showJSON(jsonBody);

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
					'data' => $doc->responses()
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
