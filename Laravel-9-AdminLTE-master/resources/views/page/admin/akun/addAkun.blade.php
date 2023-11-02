@extends('layouts.base_admin.base_dashboard') @section('judul', 'Tambah Akun')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Akun</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Akun</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content container">
    @if(session('status'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        {{ session('status') }}
      </div>
    @endif
    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col d-flex justify-content-center">
                <div class="card card-primary w-100 h-100">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Data Diri</h3>

                        <div class="card-tools">
                            <button
                                type="button"
                                class="btn btn-tool"
                                data-card-widget="collapse"
                                title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputAreaKavling">Area Kavling</label>
                            <input
                                type="text"
                                id="inputAreaKavling"
                                name="area_kavling"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan Nama"
                                value="{{ old('area_kavling') }}"
                                required="required"
                                autocomplete="area_kavling">
                            @error('area_kavling')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputHarga">Harga</label>
                            <input
                                type="number"
                                id="inputHarga"
                                name="harga"
                                class="form-control @error('harga') is-invalid @enderror"
                                placeholder="Masukkan Harga"
                                value="{{ old('harga') }}"
                                required="required"
                                autocomplete="harga">
                            @error('harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">Status</label>
                            <select
                                id="inputStatus"
                                name="status"
                                class="form-control @error('status') is-invalid @enderror"
                                required="required"
                                value = "{{ old('status') }}"
                                autocomplete="status">
                                <option hidden>Pilih Status</option>
                                <option value="available">Available</option>
                                <option value="booked">Booked</option>
                                <!-- Tambahkan pilihan lainnya sesuai kebutuhan -->
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div> 
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Tambah Kavling" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
<!-- /.content -->

@endsection @section('script_footer')
@endsection
