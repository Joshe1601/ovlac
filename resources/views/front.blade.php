



{{-- <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My first three.js app</title>
		<style> --}}


		</style>
		<link rel="stylesheet" href="{{ relative_path() }}/public/css/front.css" >
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
{{-- 	</head>
	<body> --}}
        <style>{!! include (base_path() . '/public/css/ovlac.css') !!}</style>
		<script src="{{ relative_path() }}/public/js/threejs/build/three.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/controls/OrbitControls.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/OBJLoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/GLTFLoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/DRACOLoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/FBXLoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/RGBELoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/libs/fflate.min.js"></script>


        <script type="text/javascript"
            src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>


    <form style="display: none;">
        <input type="hidden" id="input_product_id" name="input_product_id" value="{{ $product->id }}">
        <input type="hidden" id="input_product_title" name="input_product_title" value="{{ $product->title }}">
        <input type="hidden" id="input_product_price" name="input_product_price" value="{{ $product->price }}">
        <input type="hidden" id="input_submit_url" name="input_submit_url" value="{{ config('app.submit_url') }}">
        <input type="hidden" id="input_submit_url_default" name="input_submit_url_default" value="{{ controller_path() }}{{ controller_sep() }}md=product&product_id={{$product->id}}&action=submit_form"">
    </form>

    <div id="main" class="visor3d d-flex flex-row background-gray">


        <div class="wizard-menu">

            <div style="width:100px: height: auto;">
                <a href="{{ relative_path() }}">
                    <img src="{{ relative_path() }}/public/images/ovlac/logo_banner.png"
                         alt="logo banner ovlac"
                         style="max-width:200px; height: auto;"
                    />
                </a>

            </div>

            <div id="wizard_title_mbl" class="wizard_title">
                {!! $product->get_red_title() !!}
            </div>

            <div id="wizard">
                @if ($cam_debug)
                    <div id="camera-vectors">
                        <span>{{ tra("Free Camera Vectors:") }}</span><br>
                        <span id="position"></span><br>
                        <span id="lookingAt"></span>
                    </div>
                @endif

                <div id="wizard_title_dsk" class="ml-5">
                    <h4 class="ml-3 my-0 visor-title">{!! $product->get_red_title() !!}</h4>
                    <h5 class="ml-3 font-weight-normal visor-description">{{ $product->description }}</h5>
                    <span id="boton_option_menu">
                        <img src="{{ relative_path() }}/public/images/ovlac/opciones.png"
                             class="boton_opciones"
                             id="menu_options_toggle"
                             alt="Menu Opciones">
                    </span>
                </div>


                <div id="new_accordion" class="menu-visor d-block">
                    <x-frontend.categories :categories="$variable_parts" :collapsed="false" />
                </div>

                <div>
                    <h2 id="message-selection"></h2>
                </div>

            </div>
        </div>

        <div id="canvas_3d" class="background-gray"></div>

        <div class="extra-icons">
            <div class="icon-vista" id="resetAxis">
                <img
                    src="{{ relative_path() }}/public/images/ovlac/vista.png"
                    style="width:32px"
                    alt="">
            </div>
            <div class="icon-vista" id="info-lateral-icon">
                <img
                    src="{{ relative_path() }}/public/images/ovlac/infomenu.png"
                    style="width:32px"
                    alt="">
            </div>
            <div class="icon-vista">
                <img
                    src="{{ relative_path() }}/public/images/ovlac/descarga.png"
                    style="width:32px"
                    onclick="submit_form(false)"
                    alt="">
            </div>
            <div class="icon-vista" id="openPopup">
                <img
                    src="{{ relative_path() }}/public/images/ovlac/mail.png"
                    style="width:32px"
                    onclick="send_email(false)"

                    alt="">
            </div>
            <div class="icon-vista" id="fullScreen">
                <img
                    src="{{ relative_path() }}/public/images/ovlac/maximizar.png"
                    style="width:32px"
                    alt="">
            </div>

        </div>

    </div>


<!-- Popup div -->
<div id="popup" class="popup">
    <div class="popup-header">
        <span id="closePopup" class="close-btn">&times;</span>
        <h4 class="popup-title">{{ tra('Receive a quote by Email') }}</h4>
    </div>
    <form
        action="{{ controller_path() }}{{ controller_sep() }}md=product&action=send_email"
        method="POST"
        id="emailForm"
        class="popup-form">
        <div class="form-group">
            <label for="inputFullname">{{ tra('Full Name') }}</label>
            <input type="text" class="form-control bg-gray-input" id="inputFullname" name="inputFullname" required>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <label for="inputProvince">{{ tra('Province') }}</label>
                <input type="text" class="form-control bg-gray-input" id="inputProvince" name="inputProvince" required>
            </div>
            <div class="col-sm-6">
                <label for="inputEmail">{{ tra('Email') }}</label>
                <input type="text" class="form-control bg-gray-input" id="inputEmail" name="inputEmail" required>
            </div>
        </div>
        <!-- HIDDEN ATTRIBUTRES -->
        <input type="hidden" id="input_product_id" name="input_product_id" value="{{ $product->id }}">
        <input type="hidden" id="input_selected_models_id" name="input_selected_models_id" value="">
        <input type="hidden" id="input_total_price" name="input_total_price" value="">
        <button type="submit" class="popup-send-button" id="send_email_quote">{{ tra('Send') }}</button>
        <div class="form-group policy-note">
            <input type="checkbox" class="form-check-input popup-checkbox" id="privacyPolicy" name="privatePolicy">
            <label for="privacyPolicy">
                {{ tra('I have read and accept the privacy policy.') }}
            </label>
        </div>
    </form>
</div>

<div id="detail-lateral-panel">

    <div class="detail-panel-title text-center">
        Información del modelo
        <span id="detail-lateral-panel-close">x</span>
    </div>
    <div class="detail-panel-image">
        <img src="/Configurador3D/storage/app/images/phpBA3A.tmp.png" alt="" style="width:245px;">
    </div>
    <div class="detail-panel-description text-center">
        Combinando las ventajas de cada una de las opciones anteriores, la preparación del suelo y el desmenuzamiento del mismo, mediante el rodillo.
    </div>

</div>

{{--                <div id="wizard_footer">--}}
{{--                    <div id="steps">--}}
{{--                        {{ tra("Price") }}: <span id="price_total"></span> €--}}
{{--                    </div>--}}
{{--                    <button id="cta_button" class="next_button"--}}
{{--                            @if (config('app.custom_submit', false)) onclick="submit_form(true)"--}}
{{--                            @else onclick="submit_form(false)"--}}
{{--                        @endif>--}}
{{--                        <div class="next_button_inner">--}}
{{--                            <div id="finish_button">{{ tra("Finish") }}</div>--}}
{{--                            <span class="">--}}
{{--                                <svg role="img" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"--}}
{{--                                     fill="currentColor">--}}
{{--                                    <path d="m15.99 5.377-.887.99a80.64 80.64 0 0 1 4.782 4.635H1.991v1.33h17.877a88.117 88.117 0 0 1-4.764 4.583l.886.99c.06-.054 6-5.386 6-6.239 0-.876-5.94-6.235-6-6.289z"></path>--}}
{{--                                </svg>--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                    </button>--}}
{{--                    <form method="POST" enctype="multipart/form-data" action="save.php" id="myForm">--}}
{{--                        <input type="hidden" name="img_val" id="img_val" value="" />--}}
{{--                    </form>--}}
{{--                </div>--}}
<!-- Overlay for the popup -->
<div id="layer" class="layer"></div>

		<script>
            window.onload = function () {
                var input = document.getElementById('light_checkbox');
                const light = new THREE.AmbientLight( 0x606060);
                function switchAmbientLight() {
                    if (input.checked) {
                        scene.add( light );
                    } else {
                        scene.remove( light );
                    }
                }
                input.onchange = switchAmbientLight;
                switchAmbientLight();
            }
            var relative_path = '{{ relative_path() }}';

			var init_items = [];

			var magnify = {!! json_encode($magnify) !!};

			var camera_x = {{ $product->camera_x }};
			var camera_y = {{ $product->camera_y }};
			var camera_z = {{ $product->camera_z }};

			var minPolarAngle = {{ $product->camera_limit_x * -1 }};
			var maxPolarAngle =  {{ $product->camera_limit_x }};

			var minAzimuthAngle = {{ $product->camera_limit_y * -1}};
			var maxAzimuthAngle =  {{ $product->camera_limit_y }};

			var maxZoom = {{ $product->camera_max_zoom }};
			var minZoom = {{ $product->camera_min_zoom }};

            var has_light = {{ $product->has_light }};
            var has_shadow = {{ $product->has_shadow }};


            var selected_models_collection = [];

            @if ($variable_parts)
                var product_parts_menu = 'hola'; //{{ $variable_parts }}
            @endif

			@foreach ($product->fixed_parts as $part)
				init_items.push(['{!! $part->model !!}', '{!! $part->color !!}']);
			@endforeach

        </script>
		<script src="{{ relative_path() }}/public/js/front.js"></script>
		<script defer src="{{ relative_path() }}/public/js/ui.js"></script>

{{-- 	</body>
</html> --}}
