@if ($errors->any())
@foreach ( $errors->all() as $error )
    <div class="alert alert-danger">{{$error}}</div>
@endforeach
@endif