<?php

use App\Lib\GetProfilWeb;

$profil = new GetProfilWeb;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ $profil->getProfil()['nama']->nama }} | Log in</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ url('/assets/img/favicon.png')}}" rel="icon">
  <link href="{{ url('/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ url('/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ url('/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ url('/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ url('/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{ url('/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{ url('/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{ url('/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ url('/assets/css/style.css')}}" rel="stylesheet">

  {!! htmlScriptTagJsApi() !!}
</head>

<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-4">
                <a href="" class="logo d-flex align-items-center w-auto">
                  <img src="{{ url('upload/image/logo/'.$profil->getProfil()['logo']->logo) }}" alt="">
                  <span class="d-none d-lg-block">SJS Intranet</span>
                </a>
              </div><!-- End Logo -->
              <div class="card">
                <form action="{{ url('/reset') }}" method="post">
                @csrf
                  <div class="card-body">
                    <div class="pt-4 pb-2">
                      <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                      <p class="text-center small">Masukkan password baru untuk melanjutkan.</p>
                    </div>
                    @if(session()->has('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Fail!</strong>{{ session('loginError') }}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
                      <input name="username" type="hidden" value="{{ $username }}">
                      @error('password')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Ulangi Password</label>
                      <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                      @error('password_confirmation')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror
                    </div>

                    <div class="card-footer">
                      <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Reset</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="credits d-flex justify-content-center">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Develop by <a href="https://www.instagram.com/yusuf_mirzaman/">&nbsp;JR</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ url('/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{ url('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ url('/assets/vendor/chart.js/chart.min.js')}}"></script>
  <script src="{{ url('/assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{ url('/assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{ url('/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{ url('/assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{ url('/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ url('/assets/js/main.js')}}"></script>
  <script type="text/javascript">
    // $('#reload').click(function() {
    //   $.ajax({
    //     type: 'GET',
    //     url: 'reload-captcha',
    //     success: function(data) {
    //       $(".captcha span").html(data.captcha);
    //     }
    //   });
    // });
  </script>
</body>

</html>