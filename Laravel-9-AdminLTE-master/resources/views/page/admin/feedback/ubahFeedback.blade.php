@extends('layouts.base_admin.base_dashboard') @section('judul', 'Ubah Akun')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Ubah Feedback</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Ubah Feedback</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    @if(session('rating'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        {{ session('rating') }}
    </div>
    @endif
    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col d-flex justify-content-center">
                <div class="card card-primary w-100 h-100">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Data Feedback</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputIdPengirim">Id Pengirim</label>
                            <input type="number" id="inputIdPengirim" name="id_pengirim" class="form-control @error('id_pengirim') is-invalid @enderror" placeholder="Masukkan Id Pengirim" value="{{ $usr -> id_pengirim }}" required="required" autocomplete="id_pengirim">
                            @error('id_pengirim')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputIsiFeedback">Isi Feedback</label>
                            <input type="text" id="inputIsiFeedback" name="isi_feedback" class="form-control @error('isi_feedback') is-invalid @enderror" placeholder="Masukkan Feedback" value="{{ $usr -> isi_feedback }}" required="required" autocomplete="isi_feedback">
                            @error('isi_feedback')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputRating">Rating</label>
                            <select id="inputRating" name="rating" class="form-control @error('rating') is-invalid @enderror" required="required" autocomplete="rating">
                                <option hidden>Pilih Rating</option>
                                <option value="1" {{ $usr->rating === '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $usr->rating === '2' ? 'selected' : '' }}>2</option>
                                <option value="3" {{ $usr->rating === '3' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ $usr->rating === '4' ? 'selected' : '' }}>4</option>
                                <option value="5" {{ $usr->rating === '5' ? 'selected' : '' }}>5</option>
                            </select>
                            @error('rating')
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
                <input type="submit" value="Ubah Feedback" class="btn btn-success float-right">
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