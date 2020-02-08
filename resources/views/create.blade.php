@extends('layouts.app')


@section('main')
<div class="card" id="app">
  <div class="card-body">
    <h3 class="card-title">افزودن سند جدید</h3>
    <p class="card-text">
    	در این بخش میتوانید سند نرم افزار خود رل با استفاده از فرم زیر اضافه کنید.
    </p>
    	@csrf
	    <div class="col-xs-12">
	    	<div class="form-group">
	    		<label>عنوان سند</label>
	    		<input type="text"class="form-control" placeholder="برای مثال : افزون کاربر" v-model="title">
	    	</div>
	    	<!-------- Description -------->
	    	<div class="form-group">
	    		<label>شرح مختصر این سند</label>
	    		<textarea class="form-control" rows="3" 
	    				placeholder="برای مثال: با استفاده از این لینک میتوانید کاربران لخواه را اضافه کنید ..."
	    				v-model="description">
	    		</textarea>
	    	</div>
	    	<!-------- Endpoint Configuration -------->
	    	<div class="form-group" style="direction: ltr;">
	    		<label>مسیر کامل</label>
	    		<div class="input-group">
				  <div class="input-group-prepend">
				    <select class="form-control method" v-model="method">
				    	<option value="GET">GET</option>
					  	<option value="POST">POST</option>
					  	<option value="DELETE">DELETE</option>
					  	<option value="PUT">PUT</option>
					  	<option value="PATCH">PATCH</option>
					</select>
				  </div>
				  <input type="text" class="form-control endpoint" placeholder="users/add" v-model="endpoint" @keyup="handlePathVariables">
				</div>
	    	</div>
	    	<hr>
	    	<!-------- Add Bodies -------->
	    	<div class="form-group">
	    		<div class="row" v-if="method != 'POST'">
	    			<label>پارامتر های آدرس درخواست
		    			<small class="text-muted">
		    				<a href="">
		    					مشاهده راهنما	
		    				</a>
		    			</small>
		    		</label>
	    			<div class="element col-xs-12" dir="ltr" v-for="(path,i) in paths">
	    				<div class="input-group">
							  <input type="text" class="form-control monospace" placeholder="(name)" v-model="path.name">
							  <select class="form-control" v-model="path.type">
								<option value="integer">integer</option>
								<option value="long">long</option>
								<option value="string">string</option>
							</select>
							  <input type="text" class="form-control monospace" placeholder="(sample) e.g. a1cbe5a370" v-model="path.sample">
						</div>
	    			</div>
    			</div>
	    		<div class="row" v-if="method == 'POST' || method == 'PUT' || method == 'PATCH'">
	    			<label>
	    				افزودن پارامتر
		    			<small class="text-muted">
		    				<a href="">
		    					مشاهده راهنما	
		    				</a>
		    			</small>
		    		</label>
					<div class="element col-xs-12" dir="ltr" v-for="(body,i) in bodies">
							<div class="input-group">
								  <div class="input-group-prepend">
										<span class="input-group-text" @click="moveBodyUp(i)">
											<i class="fas fa-angle-up"></i>
										</span>
										<span class="input-group-text" @click="moveBodyDown(i)">
											<i class="fas fa-angle-down"></i>
										</span>
										<span class="input-group-text" @click="removeBody(i)">
											<i class="fas fa-trash"></i>
										</span>
								  </div>
								  <input type="text" class="form-control monospace" placeholder="(name)" v-model="body.name">
								  <select class="form-control" v-model="body.type">
									  <option value="integer">integer</option>
									  <option value="long">long</option>
									  <option value="string">string</option>
								  </select>
								  <input type="text" class="form-control monospace" placeholder="(validation)" v-model="body.validation">
								  <input type="text" class="form-control monospace" placeholder="(sample)" v-model="body.sample">
									  
								  <label class="switch">
									<input type="checkbox" v-model="body.required">
									<span class="slider"></span>
								  </label>
								  <span class="switch-label">required?</span>
								  <input type="text" class="form-control monospace default-value-input" placeholder="(default)" v-model="body.deafult" v-if="!body.required">
							</div>
					</div>
					<div class="row">
		    			<div class="col-xs-12" dir="ltr">
							<button type="button" class="btn btn-sm btn-info" @click="copyBody">
									کپی کردن این پارامتر ها
									&nbsp&nbsp<i class="fas fa-copy"></i>	
							</button>
							<button type="button" class="btn btn-sm btn-success" @click="addBody">
			    				<i class="fas fa-plus"></i>
							</button>						
		    			</div>
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
	    		<div class="row">
	    			<div class="element col-xs-12" dir="ltr" v-for="(header,i) in headers">
	    				<div class="input-group">
							  <div class="input-group-prepend">
							    <span class="input-group-text" @click="removeHeader(i)">
									<i class="fas fa-trash"></i>
							    </span>
							  </div>
							  <input type="text" class="form-control monospace" placeholder="(name) e.g. token" v-model="header.name">
							  <select class="form-control" v-model="header.type">
								<option value="integer">integer</option>
								<option value="long">long</option>
								<option value="string">string</option>
							</select>
							  <input type="text" class="form-control monospace" placeholder="(sample) e.g. a1cbe5a370" v-model="header.sample">
						</div>
	    			</div>
    			</div>
    			<div class="row">
    				<div class="col-xs-12" dir="ltr">
	    				<button type="button" class="btn btn-sm btn-success" @click="addHeader">
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
					<div class="row">
						<div class="element col-xs-12" dir="ltr" v-for="(response,i) in responses">
								<div class="input-group">
									  <div class="input-group-prepend">
											<span class="input-group-text" @click="moveResponseUp(i)">
												<i class="fas fa-angle-up"></i>
											</span>
											<span class="input-group-text" @click="moveResponseDown(i)">
												<i class="fas fa-angle-down"></i>
											</span>
											<span class="input-group-text" @click="removeResponse(i)">
												<i class="fas fa-trash"></i>
											</span>
									  </div>
									  <input type="text" class="form-control monospace" placeholder="(name)" v-model="response.name">
									  <select class="form-control" v-model="response.type">
										  <option value="integer">integer</option>
										  <option value="long">long</option>
										  <option value="string">string</option>
									  </select>
									  <input type="text" class="form-control monospace" placeholder="(sample)" v-model="response.sample">												  
								</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12" dir="ltr">
							<button type="button" class="btn btn-sm btn-success" @click="addResponse">
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
				<div class="row">
	    			<div class="element col-xs-12" dir="ltr" v-for="(message,i) in messages">
	    				<div class="input-group" dir="ltr">
	    					<div class="input-group-prepend">
							    <span class="input-group-text" @click="removeMessage(i)">
									<i class="fas fa-trash"></i>
							    </span>
							</div>
							<input type="text" class="form-control monospace" 	placeholder="Https Satus" v-model="message.status">
							<input type="text" class="form-control monospace" placeholder="Custom Code" v-model="message.code">
							<label class="switch">
								<input type="checkbox" v-model="message.error">
								<span class="slider"></span>
							</label>
							<span class="switch-label">Error?</span>
						</div>
						<textarea class="form-control" placeholder="‍توضیحات" rows="2" v-model="message.message"></textarea>
	    			</div>
    			</div>
    			<div class="row">
    				<div class="col-xs-12">
    					<button type="button" class="btn btn-sm btn-success" @click="addMessage">
			    			<i class="fas fa-plus"></i>
			    		</button>
    				</div>	
    			</div>
	    		
	    	</div>
	    </div>
	<button class="btn btn-sm btn-primary" @click="save" style="width: 100%;">ذخیره این سند</button>
  </div>
</div>
@stop

@section('script')
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script>
var app = new Vue({
  el: '#app',
  data: {
  	title : '',
  	method: 'GET',
  	description: '',
  	endpoint: '',
  	tmpPaths: [],
  	paths: [],
    bodies : [
		{
			name : '',
			type: 'integer',
			validation: '',
			sample: '',
			required: 0,
			default: ''
		}
	],
	headers: [
		{
			name : '',
			type: 'integer',
			sample: '',
		}
	],
	responses : [
		{
			name : '',
			type: 'integer',
			sample: '',
		}
	],
	messages : [
		{
			status : '',
			code: '',
			message: '',
			error: 0
		}
	]
  },

  methods : {
	  addBody : function(){
			this.bodies.push({
				name : '',
				type: 'integer',
				validation: '',
				sample: '',
				required: 0,
				default: ''
			});
	  },
	  addHeader : function(){
			this.headers.push({
				name : '',
				type: 'integer',
				sample: ''
			});
	  },
	  addResponse : function(){
			this.responses.push({
				name : '',
				type: 'integer',
				sample: ''
			});
	  },
	  addMessage : function(){
			this.messages.push({
				status : '',
				code: '',
				message: '',
				error: 0
			});
	  },
	  copyBody : function(){
		  this.bodies.forEach(body => {
			  this.responses.push({
				  name: body.name,
				  type: body.type,
				  sample: body.sample
			  });
		  });
	  },
	  removeBody: function(index){
			this.bodies.splice(index,1);
	  },
	  removeHeader: function(index){
			this.headers.splice(index,1);
	  },
	  removeResponse: function(index){
			this.responses.splice(index,1);
	  },
	  removeMessage: function(index){
			this.messages.splice(index,1);
	  },
	  moveBodyUp: function(index){
	  		if(index == 0) return;
	  		var tmp = this.bodies[index - 1];
	  		this.bodies[index -1] = this.bodies[index];
	  		this.bodies[index] = tmp;
	  		this.bodies.push({});
	  		this.bodies.splice(this.bodies.length -1,1);
	  },
	  moveBodyDown: function(index){
	  		if(index == this.bodies.length - 1) return;
	  		var tmp = this.bodies[index + 1];
	  		this.bodies[index + 1] = this.bodies[index];
	  		this.bodies[index] = tmp;
	  		this.bodies.push({});
	  		this.bodies.splice(this.bodies.length -1,1);
	  },
	  moveResponseUp: function(index){
	  		if(index == 0) return;
	  		console.log(index);
	  		var tmp = this.responses[index - 1];
	  		this.responses[index -1] = this.responses[index];
	  		this.responses[index] = tmp;
	  		console.log(this.responses);
	  		this.responses.push({});
	  		this.responses.splice(this.responses.length -1,1);
	  },
	  moveResponseDown: function(index){
	  		if(index == this.responses.length - 1) return;
	  		var tmp = this.responses[index + 1];
	  		this.responses[index + 1] = this.responses[index];
	  		this.responses[index] = tmp;
	  		this.responses.push({});
	  		this.responses.splice(this.responses.length -1,1);
	  },
	  handlePathVariables: function(){
	  	if(this.method == 'POST') return;
	  	if(this.endpoint.length < 1){
	  		this.paths = [];
	  		this.tmpPaths = [];
	  	}
		var matches = this.endpoint.match(/{(.*?)}/g);
		if(matches != null){
			var self = this;
			this.tmpPaths = [];
			this.paths = [];
			matches.map(function(val){
				if (!self.tmpPaths.includes(val)) {
					if(val != '{}'){
						self.tmpPaths.push(val);
						self.paths.push({
							name: val.slice(1,-1),
							type: 'integer',
							sample: ''
						});
					}
				}   
			});	
		}
		
	  },
	  save: function(){
	  	
	  }
  }
})
</script>
@stop
