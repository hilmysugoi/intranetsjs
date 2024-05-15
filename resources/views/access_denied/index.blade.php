@extends('_partials.main')
@section('container')
<section class="section">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>403 Error Page</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">403 Error Page</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="error-page">
    <h2 class="headline text-warning"> 403</h2>

    <div class="error-content">
      <h3><i class="fas fa-exclamation-triangle text-warning"></i> Access Denied!</h3>

      <p>
        Anda tidak berkenan mengakses halaman ini. <br>Silakan hubungi admin.<br><a class="btn btn-primary" onclick="history.back()">Kembali</a>
      </p>

    </div>
    <!-- /.error-content -->
  </div>
  <!-- /.error-page -->
</section>
@endsection