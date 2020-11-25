<!DOCTYPE html>
<html lang="en">

<head>

  <!--===============================================================================================-->
  <link rel="stylesheet" href="{{url('vendor/thor/css/util.css')}}">
  <link rel="stylesheet" href="{{url('vendor/thor/css/login.css')}}">
  <link rel="stylesheet" href="{{url('vendor/thor/fonts/fontAwesome/css/font-awesome.min.css')}}">

  <!--===============================================================================================-->

  <style>
    .login-background {
      background: url('https://cdn.hipwallpaper.com/i/75/64/JQoSuN.jpg') no-repeat bottom center fixed;
    }

    .footer-copyright {
      position: absolute;
      right: 0;
      bottom: 0;
      left: 10%;
      padding: 10px;
      background-color: #0275d8;
      color: white;
      text-align: center;
      width: 80%;

      border-top-left-radius: 80px;
      border-top-right-radius: 80px;
    }

    .login-form {
      min-height: 100%;
      position: relative;
      overflow: hidden;
      overflow-wrap: break-word;
    }

    .login100-form {
      background: white;
      margin-bottom: 80px;
      margin-top: -80px;
    }

    .wrap-input100 {
      background: white;
      overflow: hidden;
    }

    .wrapper-input {
      margin-bottom: 10px;
    }

    .error-text {
      font-size: 12px;
      margin-left: 25px;
      color: red;
    }

    .wrap-input100.error {
      border: 1px solid red;
    }

    .wrap-input100.error .label-input100 {
      color: red
    }

    .wrap-login100 {
      justify-content: center;
    }
  </style>
</head>

<body>
  <div class="">
    <div class="">
      <div class="wrap-login100">

        <div class="login-form size1 ">
          <form class="login100-form" action="{{url('/login')}}" method="post">
            {!! csrf_field() !!}
            <span class="login100-form-title p-b-43">
              SAC
            </span>
            <?php
            $username = old('username') ?? null;
            $username_class = $username != null ? 'has-val' : '';
            $error_username_class = $errors->has('username') ? 'error' : '';
            $error_password_class = $errors->has('password') ? 'error' : '';
            ?>
            <div class="wrapper-input">
              <div class="wrap-input100 {{ $error_username_class }}">
                <input type="text" name="username" class="input100 {{ $username_class }}" value=" {{  old('username') }}">
                <span class="focus-input100"></span>
                <span class="label-input100">Username</span>
              </div>
              @if($errors->has('username'))
              <span class="error-text">{{ $errors->first('username') }}</span>
              @endif
            </div>

            <div class="wrapper-input">
              <div class="wrap-input100 {{ $error_password_class }}">
                <input type="password" name="password" class="input100">
                <span class="focus-input100"></span>
                <span class="label-input100">Password</span>
              </div>
              @if($errors->has('password'))
              <span class="error-text">{{ $errors->first('password') }}</span>
              @endif
            </div>

            <div class="flex-sb-m w-full p-t-3 p-b-32">
              <div class="contact100-form-checkbox">
                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
                <label class="label-checkbox100" for="ckb1">
                  Remember me
                </label>
              </div>

              <div>
                <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}" class="text-center">
                  Forgot Password ?
                </a>
              </div>
            </div>

            <div class="container-login100-form-btn">
              <!-- <p id="display_geo_coordinate" style="position:left;"></p> -->
              <input type="hidden" name="coordinate" id="geo_coordinate"></p>
              <button class="login100-form-btn" id='btnLogin' style="background:#0275d8">
                Login
              </button>
              <button type='button' id='btnGeo' class="login100-form-btn">Please Allow Geolocation</button><br />
              <p id="geo_status"></p>
            </div>

          </form>

          <div class="footer-copyright">
            © SAC Insurnace v2.0
          </div>
        </div>



        <div class="login100-more login-background size2"></div>



      </div>
    </div>
  </div>
</body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>


<script>
  $(function() {
    //setTimeout(function(){ alert("Hello"); }, 3000);
    $('.input100').blur();
    $('.input100').on('blur', function() {
      if ($(this).val() != "") {
        $(this).addClass('has-val');
      } else {
        $(this).removeClass('has-val');
      }
    })
  })
</script>
<script>
  var geo_permission = false;
  var user_denied = false;
  var latitude;
  var longitude;

  $(function() {
    displayButton();
    checkGeoStatus();
    $("#btnGeo").click(function() {
      checkGeoStatus();
    })
  });

  function displayButton() {
    //if (geo_permission) {
    if (true) {
      $('#geo_status').html('');
      $('#display_geo_coordinate').html('Your Coordinate:' + latitude + ',' + longitude);
      $('#btnLogin').show();
      $('#btnGeo').hide();
    } else {
      $('#geo_status').html('Please Allow Your Browser Geo Location Permission Before Login.');
      $('#btnLogin').hide();
      $('#btnGeo').show();
    }
  }

  function checkGeoStatus() {
    navigator.geolocation.watchPosition(function(position) {
        geo_permission = true;
      },
      function(error) {
        if (error.code == error.PERMISSION_DENIED) {
          geo_permission = false;
        }
      });


    if (!navigator.geolocation) {
      status.textContent = 'Geolocation is not supported by your browser';
    } else {
      status.textContent = 'Locating…';
      navigator.geolocation.getCurrentPosition(success, error);
    }
    displayButton();

  }

  function success(position) {
    geo_permission = true;
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;
    $('#geo_coordinate').val(latitude + ',' + longitude);
    displayButton();
  }

  function error() {
    geo_permission = true;
    user_denied = true;
    latitude = null;
    longitude = null;
    displayButton();
  }
</script>

</html>