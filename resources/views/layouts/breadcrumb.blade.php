<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>{{isset($title) ? $title : 'Resilience Report'}}</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{url('admin/dashboard')}}"> <i data-feather="home"></i></a>
                    </li>
                    @foreach ($navigator as $item)
                    <li class="breadcrumb-item">{!!$item['title']!!}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
