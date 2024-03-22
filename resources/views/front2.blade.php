<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My first three.js app</title>
		<style>
			body, #main { 
				margin: 0;
				height: 100vh;
			}

			#main {
				display: flex;
				flex-direction: row;
			}

			#wizard {
				/* width: 40%; */
				height: 100%;
				flex: 0 0 40%;
				display: flex;
				flex-direction: column;
			}

			#wizard_footer {
				background-color: rgb(0, 30, 80);
				width: 100%;
				display: flex;
				flex-direction: row;
				justify-content: space-between;
				place-items: center;
				padding: 2px 16px;
				
			}

			#wizard_title {
				background-color: rgb(0, 30, 80);
				width: 100%;
				padding: 8px 16px;	
				color: white;
				font-size: 150%;
			}

			#accordion {
				flex: 1;
			}
			
			#canvas_3d {
				height: 100% !important;
				flex: 1 1 auto;
				/* width: auto; */
			}

			#accordion .btn-link {
				color: rgb(0, 30, 80);
			}

			.variation_list {
				padding-left: 0;
				margin-left:0;
			}

			.variation_list>li {
				list-style-type: none;
				margin-bottom: .5em;

				padding: 0.6rem;
				border: 1px solid #999;
				border-radius: 0.5rem;
			}

			.variation_list>li input[type=radio] {
				display: -moz-inline-box;
				display: inline-block;
				vertical-align: middle;
				margin: 0 0.2rem;
			}

			.variation_list>li label {
				display: -moz-inline-box;
				display: inline-block;
				vertical-align: middle;
				margin: 0 !important;
				position: relative;
				display: block;
			}

			.variation_text {
				margin-left: 35px;
			}

			.variation_title {
				color: #666;
				font-weight: bolder;
				font-size: 110%;
			}

			.variation_description {
				color: #666;
				font-style: italic;
			}

			.variation_price {
				color: #666;
				float: right;
				margin-top: 2.7%;
			}


			.variation_list>li input {
				appearance: none;
				-webkit-appearance: none;
				-moz-appearance: none;
			}
			
			.variation_list>li input {
				visibility: hidden;
				position: absolute;
				right: 0;
			}


			.variation_list>li label i:before{
				content: '';
				display: block;
				height: 18px;
				width: 18px;
				background: red;
				border-radius: 100%;
				position: absolute;
				z-index: 1;
				top: 4px;
				left: 4px;
				background:#2AC176;
				transition: all 0.25s ease; /* Todas las propiedades | tiempo | tipo movimiento */
				transform: scale(0) /* Lo reducimos a 0*/ ;
				opacity: 0; /* Lo ocultamos*/
			}

			.variation_list>li label i {
				background: #f0f0f0;
				border:2px solid rgba(0,0,0,0.2);
				position: absolute; 
				left: 0;
				top: 50%;
				transform: translateY(-50%);
			}

			.variation_list>li input[type=radio]:checked + label i:before{
				transform: scale(1);
				opacity: 1;
			}

			.variation_list>li:hover input[type=radio]:not(:checked) + i{
				background: #B1E8CD;
			}
			
			/* Estas reglas se aplicarán a todos los i despues de un input de tipo radio*/
			.variation_list>li label i {
				height: 30px;
				width: 30px;
				border-radius: 100%;
			}

			#steps {
				color: white;
				font-size: 120%;
			}

			.next_button {
				font-size: 120%;
				text-align: center;
				margin-top: 8px;
				margin-bottom: 8px;

				border-color: white;
				appearance: button;
				position: relative;
				display: inline-flex;
				text-align: center;
				-webkit-box-pack: center;
				justify-content: center;
				-webkit-box-align: center;
				align-items: center;
				min-height: 44px;
				min-width: 44px;
				padding-top: 0px;
				padding-right: 16px;
				padding-left: 16px;
				border-top-width: 2px;
				border-right-width: 2px;
				border-bottom-width: 2px;
				border-left-width: 2px;
				border-top-style: solid;
				border-right-style: solid;
				border-bottom-style: solid;
				border-left-style: solid;
				border-image-source: initial;
				border-image-slice: initial;
				border-image-width: initial;
				border-image-outset: initial;
				border-image-repeat: initial;
				border-top-left-radius: 500px;
				border-top-right-radius: 500px;
				border-bottom-right-radius: 500px;
				border-bottom-left-radius: 500px;
				transition-duration: 0.2s;
				transition-timing-function: ease-in-out;
				transition-delay: 0s;
				transition-property: all;
				text-decoration-line: none;
				cursor: pointer;
				background-image: initial;
				background-position-x: initial;
				background-position-y: initial;
				background-size: initial;
				background-repeat-x: initial;
				background-repeat-y: initial;
				background-attachment: initial;
				background-origin: initial;
				background-clip: initial;
				background-color: rgb(255, 255, 255);
				border-top-color: rgb(255, 255, 255);
				color: rgb(0, 30, 80);
			}

			.next_button_inner {
				-webkit-box-align: center;
				align-items: center;
				display: inline-grid;
				grid-template-columns: repeat(1, auto) max-content;
				column-gap: 8px;
			}

			.card .btn.btn-link {
				font-size: 100%;

			}



		</style>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</head>
	<body>
		<script src="{{ relative_path() }}/public/js/threejs/build/three.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/controls/OrbitControls.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/GLTFLoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/DRACOLoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/loaders/FBXLoader.js"></script>
		<script src="{{ relative_path() }}/public/js/threejs/examples/js/libs/fflate.min.js"></script>


		<div id="main">
			<div id="canvas_3d">

			</div>
			<div id="wizard">
				<div id="wizard_title">
					Customize your {$productName}
				</div>
				<div id="accordion">
					<div class="card">
					  <div class="card-header" id="headingOne">
						<h5 class="mb-0">
						  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							Choose a {$partName}
						  </button>
						</h5>
					  </div>
				  
					  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" >
						<div class="card-body">
							<fieldset>
								<!-- <legend>Radio Buttons</legend> -->
								<ul class="variation_list">
									<li>
										<input name="color1" type="radio" id="x1">
										<label for="x1">
											<i></i>
											<div class="variation_price">+19.99€</div>
											<div class="variation_text">
												<div class="variation_title">Title</div>
												<div class="variation_description">Description</div>
											</div>
											
											
										</label>
									</li>
									<li>
										<input name="color1" type="radio" id="x2">
										<label for="x2">
											<i></i>
											<div class="variation_price">+29.99€</div>
											<div class="variation_text">
												<div class="variation_title">Title</div>
												<div class="variation_description">Description</div>
											</div>
											
										</label>
									</li>
									<li>
										<input name="color1" type="radio" id="x3">
										<label for="x3">
											<i></i>
											<div class="variation_price">+39.99€</div>
											<div class="variation_text">
												<div class="variation_title">Title</div>
												<div class="variation_description">Description</div>
											</div>
											
										</label>
									</li>
								</ul>
							</fieldset>
						</div>
					  </div>
					</div>
					<div class="card">
					  <div class="card-header" id="headingTwo">
						<h5 class="mb-0">
						  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
							Choose a {$partName}
						  </button>
						</h5>
					  </div>
					  <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" >
						<div class="card-body">
							<fieldset>
								<!-- <legend>Radio Buttons</legend> -->
								<ul class="variation_list">
									<li>
										<input name="color2" type="radio" id="x4">
										<label for="x4">
											<i></i>
											<div class="variation_text">
												<div class="variation_title">Title</div>
												<div class="variation_description">Description</div>
											</div>
											
										</label>
									</li>
									<li>
										<input name="color2" type="radio" id="x5">
										<label for="x5">
											<i></i>
											<div class="variation_text">
												<div class="variation_title">Title</div>
												<div class="variation_description">Description</div>
											</div>
											
										</label>
									</li>
									
								</ul>
							</fieldset>
						</div>
					  </div>
					</div>
					<div class="card">
					  <div class="card-header" id="headingThree">
						<h5 class="mb-0">
						  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
							Choose a {$partName}
						  </button>
						</h5>
					  </div>
					  <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" >
						<div class="card-body">
							<fieldset>
								<!-- <legend>Radio Buttons</legend> -->
								<ul class="variation_list">
									<li>
										<input name="color3" type="radio" id="x6">
										<label for="x6">
											<i></i>
											<div class="variation_price">+199.99€</div>
											<div class="variation_text">
												<div class="variation_title">Title</div>
												<div class="variation_description">Description</div>
											</div>
											
										</label>
									</li>
									<li>
										<input name="color3" type="radio" id="x7">
										<label for="x7">
											<i></i>
											<div class="variation_price">+199.99€</div>
											<div class="variation_text">
												<div class="variation_title">Title</div>
												<div class="variation_description">Description</div>
											</div>
											
										</label>
									</li>

								</ul>
							</fieldset>
						</div>
					  </div>
					</div>
				</div>
				<div id="wizard_footer">
					<div id="steps">
						Step 1/5
					</div>
					<button class="next_button">
						<div class="next_button_inner">
							<div class="">Next</div>
							<span class="">
								<svg role="img" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="m15.99 5.377-.887.99a80.64 80.64 0 0 1 4.782 4.635H1.991v1.33h17.877a88.117 88.117 0 0 1-4.764 4.583l.886.99c.06-.054 6-5.386 6-6.239 0-.876-5.94-6.235-6-6.289z"></path></svg>
							</span>
						</div>
					</button>
				</div>
			</div>
		</div>

		<script>
            var relative_path = '{{ relative_path() }}';
        </script>
		<script src="{{ relative_path() }}/public/js/front.js"></script>
	</body>
</html>