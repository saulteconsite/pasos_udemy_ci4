<!-- EXTENDEMOS EL LAYOUT PRINCIPAL PARA HEREDAR LA ESTRUCTURA HTML -->
<?= $this->extend('layout/main') ?>

<!-- DEFINIMOS LA SECCIÓN DE CONTENIDO QUE SE INYECTA EN EL LAYOUT -->
<?= $this->section('contenido') ?>

<!-- CENTRAMOS EL FORMULARIO EN LA PÁGINA CON UNA COLUMNA DE ANCHO MEDIO -->
<div class="row justify-content-center">
    <div class="col-md-6">
        <!-- TARJETA DE BOOTSTRAP CON SOMBRA PARA EL FORMULARIO DE LOGIN -->
        <div class="card shadow mt-4">
            <!-- CABECERA DE LA TARJETA CON FONDO OSCURO Y TEXTO BLANCO -->
            <div class="card-header bg-dark text-white text-center">
                <!-- ÍCONO DE USUARIO Y TÍTULO -->
                <h3><i class="fa fa-user-lock"></i> Iniciar Sesión</h3>
            </div>
            <!-- CUERPO DE LA TARJETA CON EL FORMULARIO -->
            <div class="card-body">

                <!-- SI HAY UN ERROR GENERAL (CREDENCIALES INCORRECTAS), LO MOSTRAMOS -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <!-- MOSTRAMOS EL MENSAJE DE ERROR -->
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- SI HAY ERRORES DE VALIDACIÓN EN LA SESIÓN FLASH, LOS MOSTRAMOS -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <!-- RECORREMOS CADA ERROR Y LO MOSTRAMOS EN UNA LISTA -->
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- FORMULARIO QUE ENVÍA LOS DATOS POR POST A LA RUTA DE PROCESAMIENTO DE LOGIN -->
                <form action="<?= base_url('/auth/loginPost') ?>" method="POST">
                    <!-- TOKEN CSRF PARA PROTEGER CONTRA ATAQUES DE FALSIFICACIÓN DE PETICIONES -->
                    <?= csrf_field() ?>

                    <!-- CAMPO DE TEXTO PARA EL EMAIL DEL USUARIO -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <!-- old('email') MANTIENE EL VALOR SI HAY ERROR DE VALIDACIÓN -->
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="tu@email.com" required>
                    </div>

                    <!-- CAMPO DE CONTRASEÑA (type=password PARA QUE NO SE VEA LO QUE SE ESCRIBE) -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Tu contraseña" required>
                    </div>

                    <!-- BOTÓN PARA ENVIAR EL FORMULARIO -->
                    <div class="d-grid">
                        <!-- d-grid HACE QUE EL BOTÓN OCUPE TODO EL ANCHO -->
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-sign-in-alt"></i> Entrar
                        </button>
                    </div>
                </form>
            </div>
            <!-- PIE DE LA TARJETA CON ENLACE AL REGISTRO -->
            <div class="card-footer text-center">
                <!-- ENLACE PARA IR AL FORMULARIO DE REGISTRO SI NO TIENES CUENTA -->
                ¿No tienes cuenta? <a href="<?= base_url('/auth/registro') ?>">Regístrate aquí</a>
            </div>
        </div>
    </div>
</div>

<!-- CERRAMOS LA SECCIÓN DE CONTENIDO -->
<?= $this->endSection() ?>
