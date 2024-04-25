@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token])
@endif


@section('content')
    <div class="container mx-auto px-4 py-2">
        <div>
            <h1 class="h-2 mx-auto py-4">{{ tra('Users') }}</h1>
        </div>


        <div class="px-3 py-2 mb-3">
            <div class="d-flex flex-wrap justify-content-center">


                @if(isset($api_token))
                    <div class="row">
                        <a
                            href="{{ controller_path() }}{{ controller_sep() }}md=user&action=create&api_token={{$api_token}}"
                            type="button"
                            class="ovlac-button col align-self-end">
                            {{ tra("New User") }}
                        </a>
                    </div>
                @endif

            </div>
        </div>


        <div class="relative">
            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{ tra("Email") }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ tra("Role") }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ tra("Actions") }}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr class="border-b py-6">
                        <th class="py-4">
                            <p class="fw-bold mb 1">{{ $user->email }}</p>
                        </th>
                        <td class="py-4">
                            <p class="fw-bold mb 1">@if ($user->is_admin ) Admin @endif</p>
                        </td>
                        <td>
                            <a
                                href="{{ controller_path() }}{{ controller_sep() }}action=edit&module=user&id={{ $user->id }}&api_token={{$api_token}}"
                                type="button"
                                class="rounded-xl px-6 py-3 text-bold mr-2 hover:underline hover:text-green-500 hover:bg-green-50 hover:rounded-xl"
                                data-mdb-ripple-color="dark"
                            >
                                {{ tra("Edit") }}
                            </a>
                            <a
                                href="{{ controller_path() }}{{ controller_sep() }}action=destroy&module=user&id={{ $user->id }}&api_token={{$api_token}}"
                                type="button"
{{--                                class="btn btn-danger btn-rounded btn-sm fw-bold mr-2 hover:underline hover:text-red-500"--}}
                                class="rounded-xl px-6 py-3 text-bold mr-2 hover:underline hover:text-red-500 hover:bg-red-50 hover:rounded-xl"
                                data-mdb-ripple-color="dark"
                            >
                                {{ tra("Delete") }}
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>


    </div>






@endsection
