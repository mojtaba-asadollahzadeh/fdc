@extends('layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="/css/json-viewer.css">
@stop

@section('main')
<div class="card">
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
    	<div class="col-xs-12 body">
	    	<h6>Body</h6>
	    	<div id="json-body"></div>
	    	<div>
	    		@foreach($doc->body() as $body)
	    			<li>
	    				<span>{{$body->name}} : </span>
	    				<span>{{$body->validation}}</span>
	    			</li>
	    		@endforeach
	    	</div>
    	</div>
    	<div class="col-xs-12 headers">
	    	<h6>Headers</h6>
	    	<div id="json-header"></div>
	    	<div>
	    		@foreach($doc->headers() as $header)
	    			<li>
	    				<span>{{$header->name}} : </span>
	    				<span>{{$header->validation}}</span>
	    			</li>
	    		@endforeach
	    	</div>
		</div>
		<div class="col-xs-12 headers">
	    	<h6>Messages</h6>
	    	<div id="json-header"></div>
	    	<div>
	    		@foreach($doc->messages() as $message)
	    			<li class="message">
						<span>Code : </span>
						<span>{{$message->code}}</span><br>
						<span>Custom Code : </span>
						<span>{{$message->custom_code}}</span>
						<p class="p-text">
							<label class="badge badge-info">response</label> 
							{{$message->response}}
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
</script>
@stop
