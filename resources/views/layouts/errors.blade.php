@if(session('message'))
    <div class="row">
        <div class="col-md-12" >
            <div class="alert alert-card alert-success text-left" role="alert">
                {{ session('message') }}
            </div>
        </div>
    </div>
@endif
@if($errors->count() > 0)
    <div class="row">
        <div class="col-md-12" >
            <div class="alert alert-card alert-danger text-left" role="alert">
                <ul class="list-unstyled">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
