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
                        <img width="400px" src="{{asset("img/hasil.png")}}" alt="">
                    </div>

                    <div class="container px-4 py-5" id="featured-3">
                        {{-- <h2 class="pb-2 border-bottom">Hasil dari penyakit anda</h2> --}}
                        <hr>
                        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                            @for ($i = 0; $i < (count($hasil)); $i++)
                                <div class="feature col">
                                    <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3">
                                    <img width="200px" 
                                        @if ($hasil[$i]['img'])
                                            src=" {{asset($hasil[$i]['img'])}}"
                                        @else
                                            src=" {{asset("img/list.png")}}"
                                        @endif>
                                    </div>
                                    <h3 class="fs-2">{{$hasil[$i]['name']}} {{$hasil[$i]['nilai']}}%</h3>
                                    {{-- @if ($hasil[$i]['desc'])
                                        <p>{!! substr($hasil[$i]['desc'], 0, 50)!!}</p>
                                    @else
                                        <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another sentence and probably just keep going until we run out of words.</p>
                                    @endif --}}
                                    <a href="/test/detail/{{$hasil[$i]['id']}}" class="btn btn-block" style="background-color: #32c4c1; color: white">
                                        Detail
                                    </a>
                                </div> 
                            @endfor 
                        </div>
                      </div>

                    <a href="{{url('/test')}}" class="btn btn-green custom-radius">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
