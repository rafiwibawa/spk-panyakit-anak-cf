@extends('main.layout')

@section('content')
<div class="main">
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="card custom-radius shadow pb-3" style="border: none">
                <div class="text-center mt-2">
                    <img src="{{ asset('img/banner.png') }}" width="400px">
                </div>
                <hr>
                <div class="how-to px-4">
                    <h5>Petunjuk Pengisian</h5>
                    <p>
                        Di bawah ini terdapat  pernyataan yang berisi tentang kondisi-kondisi tertentu.
                        Anda diminta untuk memilih pada salah satu kolom yang telah disediakan.
                        Pilihlah salah satu jawaban yang paling sesuai dengan kondisi Anda dalam satu minggu terakhir.
                    </p>
                </div>
                <div class="how-to ml-4">
                    <h5>Bobot Angka</h5>
                    <p>
                        0 = Pasti tidak <br>
                        0.2 = Tidak tahu <br>
                        0.4 = Mungkin <br>
                        0.6 = Kemungkinan besar <br>
                        0.8 = Hampir pasti
                    </p>
                    <p class="text-danger">* Wajib</p>
                </div>
                <hr>
                <div class="text-center">
                    <p class="mt-2 mx-5">Terima kasih, selamat mengisi<br>
                        Salam Bahagia
                    </p>
                </div>
            </div>

            <form action="{{url('/test')}}" method="POST">
                @csrf
                <div class="card custom-radius shadow mt-5" style="border: none">
                    <h5 class="mt-4 ml-3">Bagian Pertama</h5>
                    <hr>
                    <div class="card-body">
                        @foreach ($questions as $key => $question)
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                {{$key + 1}}. {{$question->name}} <span class="text-danger">*</span>
                                <center>
                                    <table>
                                        <tr>
                                            <td class="pr-4 text-muted">
                                                Tidak Pernah
                                            </td>
                                            <td>
                                                <div class="text-center mt-3">
                                                    @for ($i = 0; $i <= 0.8; $i+=0.2)
                                                        @php
                                                            $checked = false;
                                                            if(isset($data[$question->id])){
                                                                if($i == (int)$data[$question->id]){
                                                                    $checked = true;
                                                                }
                                                            }
                                                        @endphp
                                                        <div class="form-check form-check-inline">
                                                            <label class="label-top" for="{{$question->id}}{{$i}}">{{$i}}<br>
                                                                <input class="form-check-input ml-1"
                                                                    type="radio"
                                                                    id="{{$question->id}}{{$i}}"
                                                                    name="{{$question->id}}" @if ($i == 0.4) {{'checked'}} @endif
                                                                    value="{{$i}}"
                                                                    required
                                                                />
                                                            </label>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </td>
                                            <td class="pl-2 text-muted">
                                                Hampir Selalu
                                            </td>
                                        </tr>
                                    </table>
                                </center>
                            </li>
                        </ul>
                        @endforeach
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3 mx-3">
                        <a href="{{url('/')}}" class="btn btn-secondary custom-radius px-4">Kembali</a>
                        <button class="btn btn-green custom-radius px-4" type="submit">Berikutnya</button>
                    </div>
                </div> 
            </form>
        </div>
    </section>
</div>
@endsection
