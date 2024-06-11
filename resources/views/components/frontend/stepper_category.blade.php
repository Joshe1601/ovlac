@php
    if(!isset($models)) $models = '';
    if(!isset($categoryId)) {
        dd('algo');
    }

@endphp
@php
    if ($category->model !== '') {
        $data_model = json_encode(array($category->model, $category->price, $category->color, $category->id));
        $models = $models . ':' . $data_model;
    }
@endphp
<form action="#" class="form">
      <h4 class="text-center">Seleccione un componente</h4>

      <!-- Barra de Progreso-->
      <div class="progressbar">
        <div class="progress" id="progress"></div>

        <div
          class="progress-step progress-step-active"
          data-title="¿Rodillo?"
        ></div>
        <div class="progress-step" data-title="Segundo Paso"></div>
        <div class="progress-step" data-title="Tercer Paso"></div>
      </div>

      <!-- Pasos -->
      <div class="form-step form-step-active">
        <div class="input-group">
          <label for="username">{{$category->product_part_id}}</label>
          <input type="text" name="username" id="username" />
          <span class="error-message"></span>

        </div>
          <div class="input-group">
              <label for="email">Correo Electrónico</label>
              <input type="email" name="email" id="email" />
              <span class="error-message"></span>

          </div>
        <div class="">
          <a href="#" class="btn btn-next width-50 ml-auto">Siguiente</a>
        </div>
      </div>
      <div class="form-step">
        <div class="input-group">
          <label for="phone">Número de Teléfono</label>
          <input type="text" name="phone" id="phone" />
          <span class="error-message"></span>

        </div>
        <div class="input-group">
            <label for="dob">Fecha de Nacimiento</label>
            <input type="date" name="dob" id="dob" />
            <span class="error-message"></span>

          </div>
        <div class="btns-group">
          <a href="#" class="btn btn-prev">Anterior</a>
          <a href="#" class="btn btn-next">Siguiente</a>
        </div>
      </div>
      <div class="form-step">
        <div class="input-group">
          <label for="password">Contraseña</label>
          <input type="password" name="password" id="password" />
          <span class="error-message"></span>

        </div>
        <div class="input-group">
          <label for="confirmPassword">Confirmar Contraseña</label>

          <input
            type="password"
            name="confirmPassword"
            id="confirmPassword"
          />
          <span class="error-message"></span>

        </div>
        <div class="btns-group">
          <a href="#" class="btn btn-prev">Anterior</a>
          <input type="submit" value="Enviar" class="btn" />
        </div>
      </div>
    </form>
