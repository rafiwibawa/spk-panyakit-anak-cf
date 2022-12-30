<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Penaykit Anak</title>

    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body style="background: url('{{asset('assets/images/login/login_bg.jpg')}}')">

    <div class="container my-5">
        <div class="row justify-content-md-center">
            <div class="col-10">
                <div class="card custom-radius">
                    <div class="text-center mt-2">
                        <img width="400px" src="{{asset("img/list.png")}}" alt="">
                    </div>
 
                        <hr> 
                        <div class="ml-2 mr-2">  
                            {!!$penyakit->desc!!}  
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
