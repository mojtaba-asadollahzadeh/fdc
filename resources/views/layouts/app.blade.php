<!DOCTYPE html>
<html>
<head>
	<title>Fanap Document Creator</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
	<link rel="stylesheet" type="text/css" href="/css/main.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	@yield('style')
</head>
<body>

<div class="container">
	@yield('main')
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@if(Session::has('error'))
<script type="text/javascript">
  Swal.fire({
    icon: 'error',
    title: 'خطا!',
    text: '{{Session("error")}}',
    showConfirmButton: false
  })
</script>
@endif

@if(Session::has('success'))
<script type="text/javascript">
  Swal.fire({
    icon: 'success',
    title: 'موفق!',
    text: '{{Session("success")}}',
    showConfirmButton: false
  })
</script>
@endif
@yield('script')
</body>
</html>