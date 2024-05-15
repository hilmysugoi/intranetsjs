@extends('_partials.main')
@section('container')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
</div>
<section class="section">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Form Edit</h3>
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
    <form action="{{ url($button->formEdit('Kpi'), ['id' => $data->id_kpi]) }}" method="post">
      @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Tanggal</label>
          <input type="hidden" name="id_users" value="{{ $data->id_users }}">
          <input type="hidden" name="id" value="{{ $data->id_kpi }}">
          <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" required value="{{ $data->tanggal }}">
          @error('tanggal')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Tahun</label>
          <select name="tahun" class="form-control" required>
            <option value="">--Pilih Tahun--</option>
            @for($i=2022; $i<=2030; $i++)
            <option {{ $data->tahun == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Nilai</label>
          <input type="number" name="nilai" class="form-control @error('nilai') is-invalid @enderror" required min="0" max="100" value="{{ $data->nilai }}">
          @error('nilai')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Keterangan</label>
          <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" required>{{ $data->keterangan }}</textarea>
          @error('keterangan')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @enderror
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</section>
@endsection
