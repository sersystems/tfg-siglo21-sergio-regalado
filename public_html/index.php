<?php

  session_start();   
  $_SESSION['RAIZ'] = $_SERVER['DOCUMENT_ROOT'].'/';

?>

<!doctype html>
<html lang="es-AR">
  <head>
    <title>Biblioteca Popular Sur</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Biblioteca Popular Sur - San Juan - Argentina."/>
    <meta name="keywords" content="biblioteca, popular, sur, rawson, villa krause, san juan, talleres, eventos, charlas"/>
    <meta name="author" content="Sergio Regalado Alessi"/>
    <link rel="icon" href="img/favicon.png" type="image/x-icon"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="css/app.css" rel="stylesheet">
    <link href="css/cmxform.css" rel="stylesheet">
  </head>
  <body class="bg-light">

    <!-- ==================== PANEL: MENÚ GENERAL ==================== -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" id="menu_ppal">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div>
          <a class="text-secondary mx-4" href="#" id="menu_0"><i class="bi bi-house"></i></a>
        </div>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item"><a class="nav-link" href="#" id="menu_1" <?php echo (isset($_SESSION['ROL']) && $_SESSION['ROL'] != 'ADMINISTRADOR')? '':'disabled hidden';?>><i class="bi bi-wrench"></i> Mis Talleres</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="menu_2" <?php echo (isset($_SESSION['ROL']) && $_SESSION['ROL'] != 'ADMINISTRADOR')? '':'disabled hidden';?>><i class="bi bi-credit-card-2-front"></i> Mis Suscripciones</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="menu_3" <?php echo (isset($_SESSION['ROL']) && $_SESSION['ROL'] != 'ADMINISTRADOR')? '':'disabled hidden';?>><i class="bi bi-person"></i> Mi Usuario</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="menu_4" <?php echo (isset($_SESSION['ROL']) && $_SESSION['ROL'] != 'ADMINISTRADOR')? '':'disabled hidden';?>><i class="bi bi-upc-scan"></i> Mi Código QR</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="menu_5" <?php echo (isset($_SESSION['ROL']) && $_SESSION['ROL'] == 'ADMINISTRADOR')? '':'disabled hidden';?>><i class="bi bi-building"></i> Institución</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="menu_6" <?php echo (isset($_SESSION['ROL']) && $_SESSION['ROL'] == 'ADMINISTRADOR')? '':'disabled hidden';?>><i class="bi bi-person"></i> Usuarios</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="menu_7" <?php echo (isset($_SESSION['ROL']) && $_SESSION['ROL'] == 'ADMINISTRADOR')? '':'disabled hidden';?>><i class="bi bi-wrench"></i> Talleres</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="menu_8" <?php echo (isset($_SESSION['ROL']) && $_SESSION['ROL'] == 'ADMINISTRADOR')? '':'disabled hidden';?>><i class="bi bi-receipt"></i> Inscripciones</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="menu_9" <?php echo (isset($_SESSION['ROL']) && $_SESSION['ROL'] == 'ADMINISTRADOR')? '':'disabled hidden';?>><i class="bi bi-door-open"></i> Control De Acceso</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="menu_10" <?php echo (isset($_SESSION['ROL']) && $_SESSION['ROL'] == 'ADMINISTRADOR')? '':'disabled hidden';?>><i class="bi bi-wallet-fill"></i> Copias De Seguridad</a></li>
            <li><hr class="dropdown-divider text-white"></li>
            <li class="nav-item"><a class="nav-link" href="#" id="menu_11"><i class="bi bi-file-earmark-check"></i> Verificación De Diploma</a></li>
            <li><hr class="dropdown-divider text-white"></li>
            <li class="nav-item"><a class="nav-link" href="#" id="menu_X" <?php echo (isset($_SESSION['ROL']))? '':'disabled hidden';?>><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- ==================== PANEL: TITULO PPAL. ===================== -->
    <div class="row shadow py-3 mb-2" style="background-image: url('img/img_title.jpg'); width: 100;">
      <div class="col-md-12">
          <h1 class="h1 text-white text-center" style="text-shadow: 0.05em 0.05em 0.3em gray">Biblioteca Popular Sur</h1>
      </div>
    </div>

    <!-- ===================== PANEL: CONTENEDOR ===================== -->
    <div class="container mt-3" id="container">
      <form <?php echo (isset($_SESSION['ROL']))? 'disabled hidden':'';?>>
        <div class="row g-3">
                
          <div class="col-md-4 offset-md-4">
              <label for="correo_electronico" class="form-label">Correo Electrónico</label>
              <input type="email" class="form-control form-control-sm" id="correo_electronico" maxlength="70" required>
          </div>
              
          <div class="col-md-4 offset-md-4">
              <label for="contrasenia" class="form-label">Contraseña</label>
              <input type="password" class="form-control form-control-sm" id="contrasenia" minlength="8" maxlength="12" required>
          </div>

          <div class="col-md-4 offset-md-4">
              <label for="codigo_captcha" class="form-label">Código Captcha</label>
              <div class="input-group mb-3">
                  <div class="input-group-prepend border border-1 me-2">
                    <canvas class="img-fluid pt-1 px-2" id="canvas" width="110" height="22"><img id="laImagen" src="img/img_captcha.jpg"></canvas>
                  </div>
                  <input type="text" class="form-control form-control-sm" id="codigo_captcha" minlength="5" maxlength="5" required>
              </div>
          </div>

          <!-- ============ BOTONES ============ -->
          <div class="col-md-4 offset-md-4 my-3">
              <div class="d-grid gap-2 mb-2"><button type="submit" class="btn btn-sm btn-dark" id="btnAcceder">Acceder</button></div>
              <div class="d-grid gap-2"><button type="button" class="btn btn-sm btn-link" id="btnRegistrar">Registrarse en el sistema</button></div>
          </div>

        </div>
      </form>
    </div>

    <!-- ======================= PANEL: FOOTER ======================= -->
    <div class="footer" id="footer">
      <footer class="my-5 pt-5 text-muted text-center text-small">
        <small>Desarrollado por Sergio Regalado Alessi</small><br>
        <p class="mb-1">&copy; 2017–2021 Todos los Derechos Reservados</p>
      </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/6.1.4/adapter.min.js" integrity="sha512-FZkQmTcqSzV2aNpWszYA/pPUISx6QjI60lKGwnIsfNFCGqUB7gcobQ9StH3hQCKFN92md3fCaXLzzSpoFat57A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> <!-- Escaner de códigos QR - 1er complemento -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> <!-- Escaner de códigos QR - 2do complemento -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> <!-- Validación de formulario - 1er complemento -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js" integrity="sha512-XZEy8UQ9rngkxQVugAdOuBRDmJ5N4vCuNXCh8KlniZgDKTvf7zl75QBtaVG1lEhMFe2a2DuA22nZYY+qsI2/xA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> <!-- Validación de formulario - 2do complemento -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/localization/messages_es_AR.min.js" integrity="sha512-IeJBPMkrv1HBLwIVpXQ2kEh24ocSZGuSXx6Jl5SIbeLoOtkXnEBghoSVmeJQerm3cRK9uKb1xxuHAEdxuVsBxg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> <!-- Validación de formulario - 3er complemento -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.3.4/web3.min.js" integrity="sha512-TTGImODeszogiro9DUvleC9NJVnxO6M0+69nbM3YE9SYcVe4wZp2XYpELtcikuFZO9vjXNPyeoHAhS5DHzX1ZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/app.js"></script>
    <script src="js/web3.js"></script>
    <script>$(document).ready( (e) => {

        var captchaGenerada = generarCaptcha();
        dibujarCaptcha(captchaGenerada);
        
        $('#menu_0').click( (e) => { location.reload(); });
        $('#menu_1').click( (e) => { direccionarMenu('v_user_inscripcion.phtml', 1); });
        $('#menu_2').click( (e) => { direccionarMenu('v_user_suscripcion.phtml', 2); });
        $('#menu_3').click( (e) => { direccionarMenu('v_user_usuario.phtml', 3); });
        $('#menu_4').click( (e) => { direccionarMenu('v_user_codigoQR.phtml', 4); });
        $('#menu_5').click( (e) => { direccionarMenu('v_admin_institucion.phtml', 5); });
        $('#menu_6').click( (e) => { direccionarMenu('v_admin_usuario.phtml', 6); });
        $('#menu_7').click( (e) => { direccionarMenu('v_admin_taller.phtml', 7); });
        $('#menu_8').click( (e) => { direccionarMenu('v_admin_inscripcion.phtml', 8); });
        $('#menu_9').click( (e) => { direccionarMenu('v_admin_controlDeAcceso.phtml', 9); });
        $('#menu_10').click( (e) => { direccionarMenu('v_admin_copiaSeguridad.phtml', 10); });
        $('#menu_11').click( (e) => { direccionarMenu('v_admin_verificacionDiploma.phtml', 11); });
      
        $('#menu_X').click( (e) => {
          $.ajax({
            method: 'GET',
            dataType: 'JSON',
            url: '/controlador/c_usuario.php/?operacion=cerrarSesion'
          }).done( (res) => { 
            location.reload();
          });
        });

        $('#btnAcceder').click( (e) => {
          if (validarCaptcha(captchaGenerada, $('#codigo_captcha').val())){
            $.ajax({
                method: "POST",
                dataType: 'JSON',
                url: '/controlador/c_usuario.php/?operacion=iniciarSesion',
                data: { 
                    'correo_electronico' : $("#correo_electronico").val().trim(),
                    'contrasenia' : $("#contrasenia").val().trim() }
            }).done( (res) => { 
                alert(res.mensaje);
                if (res.estado) { location.reload(); }
            });
          }else{
            e.preventDefault();
          }
        });

        $('#btnRegistrar').click( (e) => {
          $.ajax({
            method: 'GET',
            url: 'vista/v_user_usuario.phtml',
          }).done( (res) => {
            resetearMenu(res);
            $('#menu_0').addClass('active');
          }); 
        });

        function direccionarMenu(archivoPHP, indice) {
          $.ajax({
            method: 'GET',
            url: 'vista/' + archivoPHP,
          }).done( (res) => { 
            resetearMenu(res);
            $('#menu_' + indice).addClass('active');
            // ========= APAGALA CAMARA DEL SCANNER ========= //
            if(indice != 9 && typeof(escaner) != "undefined") { 
              escaner.stop();
              delete escaner;
            }
          });
        }
        
        function resetearMenu(res) {
          $('#menu_0').removeClass('active');
          $('#menu_1').removeClass('active');
          $('#menu_2').removeClass('active');    
          $('#menu_3').removeClass('active');    
          $('#menu_4').removeClass('active');
          $('#menu_5').removeClass('active');
          $('#menu_6').removeClass('active');    
          $('#menu_7').removeClass('active'); 
          $('#menu_8').removeClass('active');
          $('#menu_9').removeClass('active');
          $('#menu_10').removeClass('active');    
          $('#menu_11').removeClass('active');    
            $('#menu_ppal').click();
            $('#container').empty().append(res); 
        }

        //Acción: Auto-concreta la operacion de un pago realiazado si existiera
        var parametroURl = new URLSearchParams(location.search);
        if (parametroURl.has('status')){
          let usuario_id = 0;
          $.ajax({
            method: 'GET',
            dataType: 'JSON',
            url: '/controlador/c_usuario.php/?operacion=obtenerSesion'
          }).done( async (res) => {
            usuario_id = await res.id;
          }).then( (e) => {
            if (parametroURl.has('status')){
              let mensaje = '¡Opps! No pudimos procesar tu pago. Verifica tu medio de pago e intenta nuevamente.';
              switch (parametroURl.get('status')) {
                case 'approved':
                  if (parametroURl.get('payment_type') == 'credit_card'){ mensaje = '¡Listo! Se acreditó tu pago. En tu resumen verás el cargo correspondiente.'; }          
                    $.ajax({
                      method: "POST",
                      dataType: 'JSON',
                      url: '/controlador/c_suscripcion.php/?operacion=actualizar',
                      data: { 
                        'id' : parametroURl.get('external_reference'),
                        'usuario_id' : usuario_id,
                        'fecha_vto' : new Date().getFullYear() + '-' + (new Date().getMonth()+4) + '-' + new Date().getDate(),
                        'importe' : 150.00,
                        'estado' : 'VIGENTE' }
                    });
                  break;
                case 'pending':
                  if (parametroURl.get('payment_type') == 'ticket'){ mensaje = '¡Listo! En menos de 3 días hábiles te avisaremos por e-mail si se acreditó.'; }          
                  break;
              }
              alert(mensaje);
              window.location.href = 'index.php';
            }
          });
        }

    });</script>
  </body>
</html>
