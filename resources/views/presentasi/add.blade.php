@extends('_partials.main')
@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Form Tambah</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h5><i class="icon fas fa-exclamation-triangle"></i> Fail!</h5>
      {{ session('error') }}
    </div>
    @endif
    <form action="{{ url($button->formAdd($title)) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label class="col-md-4 col-lg-3 col-form-label">Nomor Presentasi</label>
          <div class="col-md-12 col-lg-12">
            <input name="nomor_presentasi" type="text" class="form-control @error('nomor_presentasi') is-invalid @enderror" value="{{ old('nomor_presentasi') }}">
            @error('nomor_presentasi')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Topik Presentasi</label>
          <div class="col-md-12 col-lg-12">
            <select name="id_topik" class="form-select @error('id_topik') is-invalid @enderror" aria-label="Default select example">
              <option>--Pilih Topik--</option>
              @foreach($topik as $top)
              <option {{ old('id_topik') == $top['id'] ? 'selected' : '' }} value="{{ $top['id'] }}">{{ $top['nama'] }}</option>
              @endforeach
            </select>
            @error('id_topik')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 col-lg-3 col-form-label">Keterangan Topik</label>
          <div class="col-md-12 col-lg-12">
            <textarea name="keterangan_topik" class="form-control @error('keterangan_topik') is-invalid @enderror">{{ old('keterangan_topik') }}</textarea>
            @error('keterangan_topik')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Dibuat Oleh</label>
          <div class="col-md-12 col-lg-12">
            <select name="id_user" class="form-select @error('id_user') is-invalid @enderror" aria-label="Default select example">
              <option>--Pilih Pegawai--</option>
              @foreach($user as $usr)
              <option {{ $usr['id'] == old('id_user') ? 'selected' : '' }} value="{{ $usr['id'] }}">{{ $usr['name'].' - '.$usr->jabatan->nama.' '.$usr->departemen->nama }}</option>
              @endforeach
            </select>
            @error('id_user')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 col-lg-3 col-form-label">Tanggal Pembuatan</label>
          <div class="col-md-12 col-lg-12">
            <input name="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
            @error('tanggal')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <!-- <div class="form-group">
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Status SE</label>
          <div class="col-md-12 col-lg-12">
            <select name="status_se" class="form-select @error('status_se') is-invalid @enderror" aria-label="Default select example">
              <option>--Pilih Status SE--</option>
              @if($cont->jenis == 'umum')
              <option {{ old('status_se') == '0' ? 'selected' : '' }} value="0">Internal General</option>
              <option {{ old('status_se') == '1' ? 'selected' : '' }} value="1">External General</option>
              @else
              <option {{ old('status_se') == '0' ? 'selected' : '' }} value="0">Departemen</option>
              <option {{ old('status_se') == '1' ? 'selected' : '' }} value="1">External Pelanggan</option>
              @endif
            </select>
            @error('status_se')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div> -->
        <!-- <div class="form-group">
        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Ditujukan Untuk</label>
        <div class="col-md-12 col-lg-12">
          <select name="ditujukan" class="form-select @error('ditujukan') is-invalid @enderror" aria-label="Default select example">
            <option>--Pilih Departemen/Divisi--</option>
            <option value="0">Semua / Umum</option>
            @foreach($departemen as $dep)
            <option {{ $dep['id'] == old('ditujukan') ? 'selected' : '' }} value="{{ $dep['id'] }}">{{ $dep->nama }}</option>
            @endforeach
          </select>
          @error('ditujukan')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div> -->
        <div class="form-group">
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Ditujukan Untuk</label>
          <div class="col-md-12 col-lg-12">
            <div class="form-check">
              <input class="form-check-input" id="checkAll" type="checkbox" value="1" name="semua">
              <label class="form-check-label" for="checkAll">
                Semua
              </label>
            </div>
            @foreach($departemen as $dep)
            <div class="form-check">
              <input class="form-check-input checkDep" type="checkbox" value="{{ $dep['id'] }}" id="{{ $dep['id'] }}" name="ditujukan[]">
              <label class="form-check-label" for="{{ $dep['id'] }}">
                {{ $dep->nama }}
              </label>
            </div>
            @endforeach
            @error('ditujukan')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <label for="Job" class="col-md-4 col-lg-3 col-form-label">Status Reminder</label>
          <div class="col-md-12 col-lg-12">
            <select name="reminder" class="form-select @error('reminder') is-invalid @enderror" aria-label="Default select example">
              <option>--Pilih Jangka Waktu--</option>
              <option {{ old('reminder') == 1 ? 'selected' : '' }} value="1">1 Bulan</option>
              <option {{ old('reminder') == 3 ? 'selected' : '' }} value="3">3 Bulan</option>
              <option {{ old('reminder') == 6 ? 'selected' : '' }} value="6">6 Bulan</option>
              <option {{ old('reminder') == 12 ? 'selected' : '' }} value="12">12 Bulan</option>
            </select>
            @error('reminder')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <!-- <div class="form-group">
          <label class="col-md-4 col-lg-3 col-form-label">Upload Surat</label>
          <div class="col-md-12 col-lg-12">
            <input name="file_surat" type="file" accept=".pdf" class="form-control @error('file_surat') is-invalid @enderror" id="file_surat" value="{{ old('file_surat') }}" onchange="return suratValidation()">
            @error('file_surat')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div> -->
        <div class="form-group">
          <label class="col-md-4 col-lg-3 col-form-label">Upload Presentasi</label>
          <div class="col-md-12 col-lg-12">
            <input name="file_presentasi" type="file" accept=".pdf" class="form-control @error('file_presentasi') is-invalid @enderror" id="file_presentasi" value="{{ old('file_presentasi') }}" onchange="return presentasiValidation()">
            @error('file_presentasi')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>

      </div>
      <div class="card-footer">
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </div>
    </form><!-- End Profile Edit Form -->
  </div>
</section>
@endsection
@section('footlib_req')
<script>
  $("#checkAll").change(function() {
    var status = this.checked;
    $('.checkDep').each(function() {
      this.checked = status;
    });
  });

  $('.checkDep').change(function() {
    if (this.checked == false) {
      $("#checkAll")[0].checked = false;
    }
    if ($('.checkDep:checked').length == $('.checkDep').length) {
      $("#checkAll")[0].checked = true;
    }
  });

  function suratValidation() {
    var fileInput = document.getElementById('file_surat');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.pdf)$/i;
    if (!allowedExtensions.exec(filePath)) {
      alert('Maaf, format file hanya berupa .pdf.');
      fileInput.value = '';
      return false;
    }
  }

  function presentasiValidation() {
    var fileInput = document.getElementById('file_presentasi');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.pdf)$/i;
    if (!allowedExtensions.exec(filePath)) {
      alert('Maaf, format file hanya berupa .pdf.');
      fileInput.value = '';
      return false;
    }
  }
</script>
@endsection