@extends('layouts.app')

@section('content')
  
<!-- Content Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2>{{$data->name}}</h2>
                <p> Waktu test {{$data->created_at}} </p>
                <p> Hasil dari diagnosa penyakit anak sebagai berikut</p>
            </div> 
        </div> 
    </div> 
</div> 

    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
        @for ($i = 0; $i < (count($hasil)); $i++) 
            <div class="feature col">
                <div
                    class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3">
                    <img width="200px" @if ($hasil[$i]['img']) src=" {{asset($hasil[$i]['img'])}}" @else
                        src=" {{asset("img/list.png")}}" @endif>
                </div>
                <h3 class="fs-2">{{$hasil[$i]['name']}} {{$hasil[$i]['nilai']}}%</h3>
                
                <a href="/test/detail/{{$hasil[$i]['id']}}" class="btn"
                    style="background-color: #32c4c1; color: white; width: 100%; height: auto;">
                    Detail
                </a>
            </div>
        @endfor
    </div> 
@endsection
