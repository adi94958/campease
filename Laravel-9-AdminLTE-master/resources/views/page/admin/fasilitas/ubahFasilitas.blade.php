@extends('layouts.base_admin.base_dashboard') @section('judul', 'Ubah Akun')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Ubah Fasilitas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Ubah Fasilitas</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
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
                        <h3 class="card-title">Informasi Fasilitas</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputFasilitas">Nama Fasilitas</label>
                            <input type="text" id="inputNamaFasilitas" name="nama_fasilitas" class="form-control @error('nama_fasilitas') is-invalid @enderror" placeholder="Masukkan Nama" value="{{ $usr -> nama_fasilitas }}" required="required" autocomplete="nama_fasilitas">
                            @error('nama_fasilitas')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputJumlah">Jumlah</label>
                            <input type="number" id="inputJumlah" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" placeholder="Masukkan Jumlah" value="{{ $usr -> jumlah }}" required="required" autocomplete="jumlah">
                            @error('jumlah')
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
                <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Ubah Fasilitas" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
<!-- /.content -->

@endsection @section('script_footer')
<script>
    inputFoto.onchange = evt => {
        const [file] = inputFoto.files
        if (file) {
            prevImg.src = URL.createObjectURL(file)
        }
    }
</script>
@endsection