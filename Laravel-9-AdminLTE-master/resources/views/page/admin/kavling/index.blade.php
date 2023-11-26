@extends('layouts.base_admin.base_dashboard')@section('judul', 'List Kavling')
@section('script_head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Kavling</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Kavling</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0" style="margin: 20px">
            <table id="previewKavling" class="table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>Area kavling</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
@endsection @section('script_footer')

<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // jika mencoba edit saat kavling sudah dipesan
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}'
            });
        @endif

        $('#previewKavling').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "{{ route('kavling.dataTable') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{csrf_token()}}"
                }
            },
            "columns": [{
                "data": "area_kavling"
            }, {
                "data": "harga"
            }, {
                "data": "status"
            }, {
                "data": "options"
            }],
            "language": {
                "decimal": "",
                "emptyTable": "Tak ada data yang tersedia pada tabel ini",
                "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                "infoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
                "infoFiltered": "(difilter dari _MAX_ total entri)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Tampilkan _MENU_ entri",
                "loadingRecords": "Loading...",
                "processing": "Sedang Mengambil Data...",
                "search": "Pencarian:",
                "zeroRecords": "Tidak ada data yang cocok ditemukan",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
                "aria": {
                    "sortAscending": ": aktifkan untuk mengurutkan kolom ascending",
                    "sortDescending": ": aktifkan untuk mengurutkan kolom descending"
                }
            }

        });
        
        // hapus data
        $('#previewKavling').on('click', '.hapusData', function() {
            var id = $(this).data("id");
            var url = $(this).data("url");
            
            // Periksa status kavling
            var kavlingStatus = $(this).closest('tr').find('td:eq(2)').text().trim().toLowerCase(); // Ubah index kolom sesuai dengan urutan kolom status

            if (kavlingStatus === 'booked') {
                // Kavling sudah dipesan, langsung ada peringatan
                console.log("booked dahulu");
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Kavling tidak dapat dihapus karena sudah ada yang memesan.'
                });
            } else {
                // Tampilkan konfirmasi hapus
                Swal.fire({
                    title: 'Apa kamu yakin?',
                    text: "Kamu tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        // Hapus data setelah konfirmasi
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                "id": id,
                                "_token": "{{csrf_token()}}"
                            },
                            success: function(response) {
                                Swal.fire('Terhapus!', response.msg, 'success');
                                $('#previewKavling').DataTable().ajax.reload();
                            }
                        });
                    }
                });
            }
        });
    });
</script>
@endsection