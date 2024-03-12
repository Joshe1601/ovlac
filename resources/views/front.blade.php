



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
		<script src="{{ relative_path() }}/public/js/threejs/build/three.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/controls/OrbitControls.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/OBJLoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/GLTFLoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/DRACOLoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/FBXLoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/RGBELoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/libs/fflate.min.js"></script>


		<form style="display: none;">
			<input type="hidden" id="input_product_id" name="input_product_id" value="{{ $product->id }}">
			<input type="hidden" id="input_product_title" name="input_product_title" value="{{ $product->title }}">
			<input type="hidden" id="input_product_price" name="input_product_price" value="{{ $product->price }}">
			<input type="hidden" id="input_submit_url" name="input_submit_url" value="{{ config('app.submit_url') }}">
			<input type="hidden" id="input_submit_url_default" name="input_submit_url_default" value="{{ controller_path() }}{{ controller_sep() }}md=product&product_id={{$product->id}}&action=submit_form"">
		</form>

		<div id="main">
			<div id="wizard_title_mbl" class="wizard_title">
				{{ tra("Customize your") }} {{ $product->title }}
			</div>
			<div id="canvas_3d">

			</div>
			<div id="wizard">

				@if ($cam_debug)
					<div id="camera-vectors">
						<span>{{ tra("Free Camera Vectors:") }}</span><br>
						<span id="position"></span><br>
						<span id="lookingAt"></span>
					</div>
				@endif

				<div id="wizard_title_dsk" class="wizard_title">
					{{ tra("Customize your") }} {{ $product->title }}
				</div>
				<div id="accordion">
					@foreach ($product->variable_parts as $index => $part)
						<div class="card">
							<div class="part-header {{-- card-header --}}" id="heading{{ $index }}">
								<h5 class="mb-0">
								<button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
									{{ tra("Choose a") }} {{ $part->title }}
								</button>
								</h5>
							</div>
							<div id="collapse{{ $index }}" class="collapse show" aria-labelledby="heading{{ $index }}" >
								<div class="card-body">
									<fieldset>
										<ul class="variation_list">
											@foreach ($part->subparts as $kpart => $subpart)
												{{-- <x-frontend.product_part :part="$subpart" :kpart="$kpart" :first="$loop->first"/> --}}
													@include('components.frontend.product_part', ['product' => $product, 'product_part' => $subpart, 'group' => $part->id])
											@endforeach
										</ul>
									</fieldset>
								</div>
							</div>
						</div>
					@endforeach

				</div>

                    <div>hola</div>
                    <h2>Cambio de prueba</h2>

                    <div>fin</div>
				<div id="wizard_footer">
					<div id="steps">
						Price: <span id="price_total"></span> €
					</div>
					<button id="cta_button" class="next_button" @if (config('app.custom_submit', false)) onclick="submit_form(true)" @else onclick="submit_form(false)" @endif>
						<div class="next_button_inner">
							<div id="">{{ tra("Finish") }}</div>
							<span class="">
								<svg role="img" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="m15.99 5.377-.887.99a80.64 80.64 0 0 1 4.782 4.635H1.991v1.33h17.877a88.117 88.117 0 0 1-4.764 4.583l.886.99c.06-.054 6-5.386 6-6.239 0-.876-5.94-6.235-6-6.289z"></path></svg>
							</span>
						</div>
					</button>
				</div>
			</div>

		</div>

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

            var variable_parts = {{ $variable_parts }}

			@foreach ($product->fixed_parts as $part)
				init_items.push(['{!! $part->model !!}', '{!! $part->color !!}']);
			@endforeach

        </script>
		<script src="{{ relative_path() }}/public/js/front.js"></script>
		<script defer src="{{ relative_path() }}/public/js/ui.js"></script>
{{-- 	</body>
</html> --}}
