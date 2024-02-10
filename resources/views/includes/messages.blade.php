@if(count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="alert alert-primary alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">x</button>
            {{$error}}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">x</button>
        {{session('success')}}
    </div>
@endif

@if(session('danger'))
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">x</button>
        {{session('danger')}}
    </div>
@endif