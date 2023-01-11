<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SPK Penyakit Anak</title>

    <link rel="icon" href="{{asset('images/logo.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Slab&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body style="background: url('{{asset('assets/images/login/login_bg.jpg')}}')">

    @yield('content')

    <footer class="container">
        <div class="text-center py-4"> 
            <p class="text-muted">Powered by Rizal 2022</p>
        </div>
    </footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        statusCode: {
            403: function(){
                window.location = '{{url('admin/login')}}';
            },
            419: function(){
                window.location = '{{url('admin/login')}}';
            }
        }
    });
</script>

@stack('script')

</body>

</html>
