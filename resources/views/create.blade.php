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
	    			<div class="append-body">
							<div class="col-xs-12 body-item body">
									<div class="input-group">
										  <div class="input-group-prepend">
												<span class="input-group-text up-body">
													<i class="fas fa-angle-up"></i>
												</span>
												<span class="input-group-text down-body">
													<i class="fas fa-angle-down"></i>
												</span>
												<span class="input-group-text remove-body">
													<i class="fas fa-trash"></i>
												</span>
										  </div>
										  <input type="text" class="form-control monospace" placeholder="(name)" name="body_name[]">
										  <select class="form-control" name="body_type[]">
											  <option value="integer">integer</option>
											  <option value="long">long</option>
											  <option value="string">string</option>
										  </select>
										  <input type="text" class="form-control monospace" placeholder="(validation)" name="body_validation[]">
										  <input type="text" class="form-control monospace" placeholder="(sample)" name="body_sample[]">
											  
										  <label class="switch">
											<input type="checkbox" name="body_required[]">
											<span class="slider"></span>
										  </label>
										  <span class="switch-label">required?</span>
										  <input type="text" class="form-control monospace default-value-input" placeholder="(default)" name="body_default[]">
									</div>
							</div>
					</div>
	    			<div class="col-xs-12" dir="ltr">
						<button type="button" class="btn btn-sm btn-info copy-body">
								کپی کردن این پارامتر ها
								&nbsp&nbsp<i class="fas fa-copy"></i>	
						</button>
						<button type="button" class="btn btn-sm btn-success add-body">
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
	    				<button type="button" class="btn btn-sm btn-success add-header">
		    				<i class="fas fa-plus"></i>
		    			</button>
	    			</div>
	    		</div>
	    	</div>
			<hr>
			
			<!-------- Add Responses -------->
	    	<div class="form-group">
					<label>افزودن پارامتر های Response 
						<small class="text-muted">
							<a href="">
								مشاهده راهنما
							</a>
						</small>
					</label>
					<div class="row" dir="ltr">
						<div class="append-response">
								<div class="col-xs-12 body response">
										<div class="input-group">
											  <div class="input-group-prepend">
													<span class="input-group-text up-body">
														<i class="fas fa-angle-up"></i>
													</span>
													<span class="input-group-text down-body">
														<i class="fas fa-angle-down"></i>
													</span>
													<span class="input-group-text remove-body">
														<i class="fas fa-trash"></i>
													</span>
											  </div>
											  <input type="text" class="form-control monospace" placeholder="(name)" name="body_name[]">
											  <select class="form-control" name="body_type[]">
												  <option value="integer">integer</option>
												  <option value="long">long</option>
												  <option value="string">string</option>
											  </select>
											  <input type="text" class="form-control monospace" placeholder="(sample)" name="body_sample[]">												  
										</div>
								</div>
						</div>
						<div class="col-xs-12" dir="ltr">
							<button type="button" class="btn btn-sm btn-success add-response">
								<i class="fas fa-plus"></i>
							</button>
						</div>
					</div>
				</div>
				<hr>
			
				<!-------- Add Message -------->
	    	<div class="form-group">
	    		<label>
					افزودن پیغام های Response
						<small class="text-muted">
							<a href="">
								مشاهده راهنما
							</a>
						</small>
				</label>
	    		<div class="errors">
	    			<div class="error">
	    				<div class="input-group" dir="ltr">
	    					<div class="input-group-prepend">
							    <span class="input-group-text remove-error">
									<i class="fas fa-trash"></i>
							    </span>
							</div>
							<input type="text" class="form-control monospace" 	placeholder="Https Satus" name="message_code[]">
							<input type="text" class="form-control monospace" placeholder="Custom Code" name="message_custom_code[]">
						</div>
						<textarea class="form-control" placeholder="‍توضیحات" rows="2" name="message_response[]"></textarea>
	    			</div>
	    		</div>
	    		 <button type="button" class="btn btn-sm btn-success add-error">
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
						<span class="input-group-text up-body">
							<i class="fas fa-angle-up"></i>
						</span>
						<span class="input-group-text down-body">
							<i class="fas fa-angle-down"></i>
						</span>
						<span class="input-group-text remove-body">
							<i class="fas fa-trash"></i>
						</span>
					</div>
					<input type="text" class="form-control monospace" placeholder="(name)" name="body_name[]">
					<select class="form-control" name="body_type[]">
					<option value="integer">integer</option>
					<option value="long">long</option>
					<option value="string">string</option>
					</select>
					<input type="text" class="form-control monospace" placeholder="(validation)" name="body_validation[]">
					<input type="text" class="form-control monospace" placeholder="(sample)" name="body_sample[]">
						
					<label class="switch">
					<input type="checkbox" name="body_required[]">
					<span class="slider"></span>
					</label>
					<span class="switch-label">required?</span>
					<input type="text" class="form-control monospace default-value-input" placeholder="(default)" name="body_default[]">
			</div>
		</div>
		`;
		$('.append-body').append(html);
	});

	$('.copy-body').click(function(){
		var html = '';
		$('.body-item').each(function(index,node) {
			var html = $(this);
			html = html.find('.default-value-input').remove();
			html = html.find('.switch-label').remove();
			html = html.find('.switch').remove();
			html = html.find('input[name="body_sample[]"]').remove();
			$(".append-response").append(html);
		});
	});

	$('body').on('click', '.up-body', function(){
		var prev = $(this).parent().parent().parent().prev();
		var current = $(this).parent().parent().parent();
		current.insertBefore(prev.get());
	});

	$('body').on('click', '.down-body', function(){
		var next = $(this).parent().parent().parent().next();
		var current = $(this).parent().parent().parent();
		next.insertBefore(current.get());
	});

	$('body').on('click', '.remove-body', function(){
		$(this).parent().parent().parent().remove();
	});

	$('body').on('change', 'input[name="body_required[]"]', function(){
		var default_input = $(this).parent().parent().find('.default-value-input');
		if(!$(this).is(':checked')){
			default_input.fadeIn();
		}else{
			default_input.fadeOut();
		}
	});

	/*---------- Header DOM ---------*/

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
