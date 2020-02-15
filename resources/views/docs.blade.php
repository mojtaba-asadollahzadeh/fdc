@extends('layouts.app')


@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@stop

@section('main')
<div class="card" id="app">
  <div class="card-body">
    <h3 class="card-title">مدیریت اسناد</h3>
    <p class="card-text">
    	در این بخش میتوانید اسناد خود را مدیریت کنید.
    </p>
    <a class="btn btn-sm btn-primary" href="/docs/new" target="_blank">
    	افزودن سند جدید
    </a>
    <hr>
    <table class="table table-striped table-bordered">
    	<thead>
    		<tr>
    			<th class="text-center">نام سند</th>
    			<th class="text-center">تاریخ انتشار</th>
    			<th class="text-center">تاریخ آخرین ویرایش</th>
    			<th class="text-center">ابزار</th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($docs as $doc)
    			<tr>
    				<?php 
    					$created = Verta($doc->created_at);
    					$updated = Verta($doc->created_at);
    				?>
    				<td class="text-center">{{$doc->title}}</td>
    				<td class="text-center" dir="ltr">{{$created}}</td>
    				<td class="text-center" dir="ltr">{{$updated}}</td>
    				<td class="text-center">
    					<i class="fas fa-trash" data="{{$doc->id}}" style="cursor: pointer;color: #d63031;"></i>
    					&nbsp
    					<a href="/docs/{{$doc->id}}" target="_blank">
    						<i class="fas fa-eye"></i>
    					</a>
    					&nbsp
    					<a href="/docs/edit/{{$doc->id}}" target="_blank">
    						<i class="fas fa-pen"></i>
    					</a>
    				</td>
    			</tr>
    		@endforeach
    	</tbody>
    </table>
   </div>
 </div> 	
@stop

@section('script')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready( function () {
    	$('table').DataTable({
		  "language": {
		  	"infoEmpty":      "نتیجه ای یافت نشد.",
		  	"zeroRecords":    "هیچ نتیجه ای پیدا نشد",
		  	"info":           "نمایش _START_ الی _END_ صفحه از _TOTAL_ صفحه",
		  	"lengthMenu":     "نمایش _MENU_ ردیف",
		    "search": "جست و جو در نتایج  ",
		    "paginate": {
		      "previous": "قبلی",
		      "next": "بعدی"
		    }
		  }
		});
		$('.fa-trash').click(function(){ 
			var data = $(this).attr('data');
			var parent = $(this).parent().parent();
			Swal.fire({
			  title: 'آیا اطمینان دارید؟',
			  text: "شما در حال حذف این سند هستید و بعد از حذف تیغییرات قابل بازگشت نمی باشد!",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  cancelButtonText: 'انصراف',
			  confirmButtonText: 'بله, حذف شود'
			}).then((result) => {
			  if (result.value) {
			  	fetch('/api/document/' + data, {
				  method: 'delete',
				  headers: {
				    'Accept': 'application/json',
				    'Content-Type': 'application/json'
				  },
				  body: JSON.stringify({
				  	id: data
				  })
				}).then(res => res.json())
				  .then(res => {
			  		if(res.success){
			  			parent.slideUp('slow');
			  			Swal.fire({
						    icon: 'success',
						    title: 'با موفقیت حذف شد!',
						    text: 'سند مورد نظر با موفقیت حذف شد.',
						    showConfirmButton: false
						});
			  		}else{
			  			Swal.fire({
						    icon: 'error',
						    title: 'مشکلی به وجود آمده!',
						    text: 'عملیات شما به مشکلی برخورد, دوباره تلاش کنید.',
						    showConfirmButton: false
						});
			  		}
				  });
			  }
			})
		});
	});
</script>
@stop
