@if(isset($api_token))
    @extends('layouts.main', ['api_token' => $api_token])
@endif


@section('content')
    <div class="container mx-auto px-4 py-2">
        <div>
            <h2 class="flex text-center mx-auto text-6xl px-8 py-4">Users</h2>
        </div>


        <div class="px-3 py-2 mb-3">
            <div class="container d-flex flex-wrap justify-content-center">
                <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
                    {{-- <input type="search" class="form-control" placeholder="Search..." aria-label="Search"> --}}
                </form>

                @if(isset($api_token))
                    <div class="text-end">
                        <a
                            href="{{ controller_path() }}{{ controller_sep() }}md=user&action=create&api_token={{$api_token}}"
                            type="button"
                            class="bg-red-ovlac px-6 py-3 m-4 rounded rounded-xl text-white hover:bg-red-700">
                            {{ tra("New User") }}
                        </a>
                    </div>
                @endif

            </div>
        </div>


        <div class="relative">
            <table class="w-full text-md text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
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
                                class="btn btn-primary btn-rounded btn-sm fw-bold mr-2 hover:underline hover:text-green-500"
                                data-mdb-ripple-color="dark"
                            >
                                {{ tra("Edit") }}
                            </a>
                            <a
                                href="{{ controller_path() }}{{ controller_sep() }}action=destroy&module=user&id={{ $user->id }}&api_token={{$api_token}}"
                                type="button"
                                class="btn btn-danger btn-rounded btn-sm fw-bold mr-2 hover:underline hover:text-red-500"
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


        </table>
    </div>






@endsection
