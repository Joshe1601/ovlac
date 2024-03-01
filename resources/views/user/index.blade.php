@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token])
@endif


@section('content')


    <h1>Users</h1>
    <div class="text-end col-md-11">
        @if(isset($api_token))
            <a href="{{ controller_path() }}{{ controller_sep() }}md=user&action=create&api_token={{$api_token}}" type="button" class="btn btn-success">{{ tra("New User") }}</a>
        @endif
    </div>
    <br>

    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
        <tr>
            <th>{{ tra("Email") }}</th>
            <th>{{ tra("Role") }}</th>
            <th>{{ tra("Actions") }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>
                    <p class="fw-bold mb 1">{{ $user->email }}</p>
                </td>
                <td>
                    <p class="fw-bold mb 1">@if ($user->is_admin ) Admin @endif</p>
                </td>
                <td>
{{--                    <a--}}
{{--                        href="{{ controller_path() }}{{ controller_sep() }}action=show&module=user&id={{ $user->id }}"--}}
{{--                        target="_blank"--}}
{{--                        type="button"--}}
{{--                        class="btn btn-success btn-rounded btn-sm fw-bold mr-2"--}}
{{--                        data-mdb-ripple-color="dark"--}}
{{--                    >--}}
{{--                        {{ tra("View") }}--}}
{{--                    </a>--}}
                    <a
                        href="{{ controller_path() }}{{ controller_sep() }}action=edit&module=user&id={{ $user->id }}&api_token={{$api_token}}"
                        type="button"
                        class="btn btn-primary btn-rounded btn-sm fw-bold mr-2"
                        data-mdb-ripple-color="dark"
                    >
                        {{ tra("Edit") }}
                    </a>
                    <a
                        href="{{ controller_path() }}{{ controller_sep() }}action=destroy&module=user&id={{ $user->id }}&api_token={{$api_token}}"
                        type="button"
                        class="btn btn-danger btn-rounded btn-sm fw-bold mr-2"
                        data-mdb-ripple-color="dark"
                    >
                        {{ tra("Delete") }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>




@endsection
