@extends('layouts.app')

@section('main')
<div class="card">
  <div class="card-body">
    <h3 class="card-title">افزودن سند جدید</h3>
    <p class="card-text">
    	در این بخش میتوانید سند نرم افزار خود رل با استفاده از فرم زیر اضافه کنید.
    </p>
    <form method="post" accept="/docs/new">
    	@csrf
	    <div class="col-xs-12">
	    	<div class="form-group">
	    		<label>عنوان سند</label>
	    		<input type="text" name="title" class="form-control" placeholder="برای مثال : افزون کاربر" value="{{old('title')}}">
	    	</div>
	    	<!-------- Description -------->
	    	<div class="form-group">
	    		<label>شرح مختصر این سند</label>
	    		<textarea name="description" class="form-control" rows="3" placeholder="برای مثال: با استفاده از این لینک میتوانید کاربران لخواه را اضافه کنید ...">{{old('description')}}</textarea>
	    	</div>
	    	<!-------- Endpoint Configuration -------->
	    	<div class="form-group" style="direction: ltr;">
	    		<label>مسیر کامل</label>
	    		<div class="input-group">
				  <div class="input-group-prepend">
				    <select class="form-control method" name="method">
					  	<option value="GET">GET</option>
					  	<option value="POST">POST</option>
					  	<option value="DELETE">DELETE</option>
					  	<option value="PUT">PUT</option>
					  	<option value="PATCH">PATCH</option>
					</select>
				  </div>
				  <input type="text" class="form-control endpoint" placeholder="users/add" name="endpoint" value="{{old('endpoint')}}">
				</div>
	    	</div>
	    	<hr>
	    	<!-------- Add Bodies -------->
	    	<div class="form-group">
	    		<label>افزودن پارامتر های body 
	    			<small class="text-muted">
	    				<a href="">
	    					مشاهده راهنما
	    				</a>
	    			</small>
	    		</label>
	    		<div class="row" dir="ltr">
	    			<div class="col-xs-12 body">
	    				<div class="input-group">
							  <div class="input-group-prepend">
							    <span class="input-group-text remove-body">
									<i class="fas fa-trash"></i>
							    </span>
							  </div>
							  <input type="text" class="form-control monospace" placeholder="(name) e.g. username" name="body_name[]">
							  <input type="text" class="form-control monospace" placeholder="(validation) e.g. required|string" name="body_validation[]">
							  <input type="text" class="form-control monospace" placeholder="(sample) e.g. mojtaba_asdl" name="body_sample[]">
						</div>
	    			</div>
	    			<div class="append-body"></div>
	    			<div class="col-xs-12" dir="ltr">
	    				<button type="button" class="btn btn-sm btn-info add-body">
		    				<i class="fas fa-plus"></i>
		    			</button>
	    			</div>
	    		</div>
	    	</div>
			<hr>
			<!-------- Add Headres -------->
	    	<div class="form-group">
	    		<label>افزودن پارامتر های header 
	    			<small class="text-muted">
	    				<a href="">
	    					مشاهده راهنما
	    				</a>
	    			</small>
	    		</label>
	    		<div class="row" dir="ltr">
	    			<div class="col-xs-12 header">
	    				<div class="input-group">
							  <div class="input-group-prepend">
							    <span class="input-group-text remove-header">
									<i class="fas fa-trash"></i>
							    </span>
							  </div>
							  <input type="text" class="form-control monospace" placeholder="(name) e.g. token" name="header_name[]">
							  <input type="text" class="form-control monospace" placeholder="(validation) e.g. required|string" name="header_validation[]">
							  <input type="text" class="form-control monospace" placeholder="(sample) e.g. a1cbe5a370" name="header_sample[]">
						</div>
	    			</div>
	    			<div class="append-header"></div>
	    			<div class="col-xs-12" dir="ltr">
	    				<button type="button" class="btn btn-sm btn-warning add-header">
		    				<i class="fas fa-plus"></i>
		    			</button>
	    			</div>
	    		</div>
	    	</div>
	    	<hr>
	    	<!-------- Add Message -------->
	    	<div class="form-group">
	    		<label>خطاها</label>
	    		<div class="errors">
	    			<div class="error">
	    				<div class="input-group" dir="ltr">
	    					<div class="input-group-prepend">
							    <span class="input-group-text remove-error">
									<i class="fas fa-trash"></i>
							    </span>
							</div>
							<input type="text" class="form-control monospace" 	placeholder="Message Code" name="message_code[]">
							<input type="text" class="form-control monospace" placeholder="Message Custom Code" name="message_custom_code[]">
						</div>
						<textarea class="form-control" placeholder="توضیحات خطا" rows="2" name="message_response[]"></textarea>
	    			</div>
	    		</div>
	    		 <button type="button" class="btn btn-sm btn-dark add-error">
	    			<i class="fas fa-plus"></i>
	    		</button>
	    	</div>
	    </div>
	    <button class="btn btn-sm btn-primary" style="width: 100%;">ذخیره این سند</button>
	</form>
  </div>
</div>
@stop

@section('script')
<script type="text/javascript">
	/*---------- Body DOM ---------*/

	$('.add-body').click(function(){
		var html = 
		`
			<div class="col-xs-12 body">
				<div class="input-group">
					  <div class="input-group-prepend">
					    <span class="input-group-text remove-body">
							<i class="fas fa-trash"></i>
					    </span>
					  </div>
					  <input type="text" class="form-control monospace" placeholder="name (e.g. username)" name="body_name[]">
					  <input type="text" class="form-control monospace" placeholder="validation (e.g. required|string|min:3)" name="body_validation[]">
					  <input type="text" class="form-control monospace" placeholder="sample (e.g. mojtaba_asdl)" name="body_sample[]">
					</div>
			</div>
		`;
		$('.append-body').append(html);
	});

	$('body').on('click', '.remove-body', function(){
		$(this).parent().parent().parent().remove();
	})

	/*---------- Body DOM ---------*/

	$('.add-header').click(function(){
		var html = 
		`
			<div class="col-xs-12 body">
				<div class="input-group">
					  <div class="input-group-prepend">
					    <span class="input-group-text remove-body">
							<i class="fas fa-trash"></i>
					    </span>
					  </div>
					  <input type="text" class="form-control monospace" placeholder="name (e.g. token)" name="header_name[]">
					  <input type="text" class="form-control monospace" placeholder="validation (e.g. required|string|min:3)" name="header_validation[]">
					  <input type="text" class="form-control monospace" placeholder="sample (e.g. 6hH8j93K)" name="header_sample[]">
					</div>
			</div>
		`;
		$('.append-header').append(html);
	});

	$('body').on('click', '.remove-header', function(){
		$(this).parent().parent().parent().remove();
	})

	/*---------- Message DOM ---------*/

	$('.add-error').click(function(){
		var html = 
		`
			<div class="error">
				<div class="input-group" dir="ltr">
					<div class="input-group-prepend">
					    <span class="input-group-text remove-error">
							<i class="fas fa-trash"></i>
					    </span>
					</div>
					<input type="text" class="form-control monospace" 	placeholder="Message Code" name="message_code[]">
					<input type="text" class="form-control monospace" placeholder="Message Custom Code" name="message_custom_code[]">
				</div>
				<textarea class="form-control" placeholder="توضیحات خطا" rows="2" name="message_response[]"></textarea>
			</div>
		`;
		$('.errors').append(html);
	});

	$('body').on('click', '.remove-error', function(){
		$(this).parent().parent().parent().remove();
	})
</script>
@stop
