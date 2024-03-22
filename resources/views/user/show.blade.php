@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token])
@endif

@section('content')
    <h1>Show User</h1>
@endsection
