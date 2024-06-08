<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>EVTL INDIA CRM</title>

  <link rel="stylesheet" href="{{ url('public/assets/css/app.min.css') }}">
  <link rel="stylesheet" href="{{ url('public/assets/bundles/bootstrap-social/bootstrap-social.css') }}">

  <link rel="stylesheet" href="{{ url('public/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ url('public/assets/css/components.css') }}">

  <link rel="stylesheet" href="{{ url('public/assets/css/custom.css') }}">
  <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/img/logo.svg') }}" />

  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ url('public/assets/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/bundles/izitoast/css/iziToast.min.css') }}">
</head>

<style>
  .hello {
    background-image: url('public/img/img-2.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    /* opacity: 0.3; */
  }

  .card-body2 {
    padding-top: 20px;
    padding-bottom: 374px;
  }

  .card {
    background-color: #fff;
    border-radius: 0px !important;
  }

  body {
    background-color: #0cb4b3a3;
  }
</style>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section" style="margin-left: 28%; margin-top:8%;">
      <div class="container mt-5">

        <div class="row">
          <!-- First Card -->

          <!-- Second Card -->
          <div class="col-12 col-sm-6 offset-sm-3 col-md-6 offset-md-0 col-lg-6 offset-lg-0 col-xl-4 offset-xl-0 pr-0">
            <div class="card">
              <div class="card-header d-flex justify-content-center">
                <img src="{{ asset('public/img/logo.svg') }}" alt="">
              </div>
              <div class="card-body">
                <form id="form_submit">
                  @csrf
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>

                    <div class="d-block mt-2">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                      <div class="float-right">
                        <a href="{{ route('register') }}" style="color: #007bff !important;" class="text-small">
                          Register
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 offset-sm-3 col-md-6 offset-md-0 col-lg-6 offset-lg-0 col-xl-4 offset-xl-0 pl-0">
            <div class="card hello">

              <div class="card-body2 class">
                <!-- Content for the first card -->
              </div>
            </div>
          </div>
        </div>


      </div>
    </section>
  </div>
  <script src="{{ url('public/assets/js/app.min.js') }}"></script>
  <script src="{{ url('public/assets/js/scripts.js') }}"></script>
  <script src="{{ url('public/assets/js/custom.js') }}"></script>

  <script src="{{ asset('public/assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
  <script src="{{ asset('public/assets/js/page/toastr.js') }}"></script>

  <script>
    $(function() {
      $('#form_submit').on('submit', function(e) {
        e.preventDefault();
        let fd = new FormData(this);
        fd.append('_token', "{{ csrf_token() }}");
        $.ajax({
          url: "{{ route('login_submit') }}",
          type: "POST",
          data: fd,
          dataType: 'json',
          processData: false,
          contentType: false,
          beforeSend: function() {
            $("#load").show();
          },
          success: function(result) {
            console.log(result);
            if (result.status) {
              iziToast.success({
                message: result.msg,
                position: 'topRight'
              });

              setTimeout(function() {
                window.location.href = result.location;
              }, 500);

            } else {
              iziToast.error({
                message: result.msg,
                position: 'topRight'
              });
            }
          },
          complete: function() {
            $("#load").hide();
          },
          error: function(jqXHR, exception) {}
        });
      })
    });
  </script>
</body>

</html>