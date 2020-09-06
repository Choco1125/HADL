<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo URL?>/"><?echo APPNAME?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item <?php echo ($this->active == 'home')?'active':'' ?>">
        <a class="nav-link" href="<?php echo URL?>/">Inico</a>
      </li>
      <li class="nav-item dropdown <?php echo ($this->active == 'cotizacion')?'active':'' ?>">
        <a class="nav-link dropdown-toggle" href="<?php echo URL?>/" id="dropdownCotizacion" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cotización
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownCotizacion">
          <a class="dropdown-item" href="<?php echo URL?>/cotizaciones/crear">Crear</a>
          <a class="dropdown-item" href="<?php echo URL?>/cotizaciones">Listar</a>
        </div>
      </li>
      <li class="nav-item dropdown <?php echo ($this->active == 'servicios')?'active':'' ?>">
        <a class="nav-link dropdown-toggle" href="<?php echo URL?>/" id="dropdownSolicitudes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Solicitud de servicios
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownSolicitudes">
          <a class="dropdown-item" href="<?php echo URL?>/servicios/nueva_solicitud">Crear</a>
          <a class="dropdown-item" href="<?php echo URL?>/servicios/solicitud">Listar</a>
        </div>
      </li>
			<li class="nav-item dropdown <?php echo ($this->active == 'cuenta')?'active':'' ?>">
        <a class="nav-link dropdown-toggle" href="<?php echo URL?>/" id="dropdownCuenta" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         	Cuenta 
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownCuenta">
          <a class="dropdown-item" href="<?php echo URL?>/cuenta">Configuraciones</a>
          <a class="dropdown-item" href="<?php echo URL?>/cuenta/contrasena">Cambiar contraseña</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo URL?>/main/salir">Cerrar sesión</a>
      </li>
    </ul>
  </div>
</nav>
