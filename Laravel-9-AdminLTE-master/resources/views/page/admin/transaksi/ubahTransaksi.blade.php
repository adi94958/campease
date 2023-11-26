@extends('layouts.base_admin.base_dashboard')
@section('judul', 'Ubah Transaksi')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Ubah Transaksi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Ubah Transaksi</li>
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
                        <h3 class="card-title">Informasi Data Transaksi</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputNamaPenyewa">Nama Penyewa</label>
                            <input type="text" id="inputNamaPenyewa" name="nama_penyewa" class="form-control @error('nama_penyewa') is-invalid @enderror" placeholder="Masukkan Nama" value="{{ $usr -> nama_penyewa }}" required autocomplete="nama_penyewa">
                            @error('nama_penyewa')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputNoHandphone">No. Handphone</label>
                            <input type="text" id="inputNoHandphone" name="no_handphone" class="form-control @error('no_handphone') is-invalid @enderror" placeholder="Masukkan No. Handphone" value="{{ $usr -> no_handphone }}" required autocomplete="no_handphone">
                            @error('no_handphone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputAreaKavling">Area Kavling</label>
                            <select id="inputAreaKavling" name="area_kavling" class="form-control @error('area_kavling') is-invalid @enderror" required autocomplete="area_kavling">
                                <option hidden>Pilih Area Kavling</option>
                                <!-- Loop through available kavlings to populate the dropdown -->
                                @foreach($availableKavlings as $kavling)
                                    <option value="{{ $kavling->area_kavling }}" {{ $usr->area_kavling == $kavling->area_kavling ? 'selected' : '' }}>{{ $kavling->area_kavling }}</option>
                                @endforeach
                            </select>
                            @error('area_kavling')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputHarga">Harga</label>
                            <input type="text" id="inputHarga" name="harga" class="form-control" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="inputTanggalCheckIn">Tanggal Check-in</label>
                            <div class="input-group date" id="reservationdateCheckIn" data-target-input="nearest">
                                <input type="text" id="inputTanggalCheckIn" name="tanggal_check_in" class="form-control datetimepicker-input @error('tanggal_check_in') is-invalid @enderror" placeholder="TTTT-BB-HH" value="{{ $usr -> tanggal_check_in }}" required autocomplete="tanggal_check_in" data-target="#reservationdateCheckIn"/>
                                <div class="input-group-append" data-target="#reservationdateCheckIn" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            @error('tanggal_check_in')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputTanggalCheckOut">Tanggal Check-out</label>
                            <div class="input-group date" id="reservationdateCheckOut" data-target-input="nearest">
                                <input type="text" id="inputTanggalCheckOut" name="tanggal_check_out" class="form-control datetimepicker-input @error('tanggal_check_out') is-invalid @enderror" placeholder="TTTT-BB-HH" value="{{ $usr -> tanggal_check_out }}" required autocomplete="tanggal_check_out" data-target="#reservationdateCheckOut"/>
                                <div class="input-group-append" data-target="#reservationdateCheckOut" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            @error('tanggal_check_out')
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
                <input type="submit" value="Ubah Transaksi" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
<!-- /.content -->

@endsection

@section('script_footer')
<script>
    // Add a script to update the harga field when the area_kavling is changed
    $(document).ready(function () {
        // Initial call to update harga when the page loads
        updateHarga();

        $('#inputAreaKavling').change(function () {
            updateHarga();
        });

        function updateHarga() {
            var selectedAreaKavling = $('#inputAreaKavling').val();
            // Perform an AJAX request to get the harga for the selected kavling
            $.ajax({
                url: "{{ route('transaksi.getHargaByAreaKavling') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    area_kavling: selectedAreaKavling
                },
                success: function (response) {
                    // Update the harga field with the received data
                    $('#inputHarga').val(response.harga);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });
</script>
@endsection
