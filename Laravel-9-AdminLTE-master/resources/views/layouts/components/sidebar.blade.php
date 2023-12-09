@php
$linksUser = [
[
"href" => route('home'),
"text" => "Dasboard",
"icon" => "fas fa-home",
"is_multi" => false
],
[
"href" => route('transaksi.add'),
"text" => "Tambah Transaksi",
"icon" => "fas fa-money-bill",
"is_multi" => false
],
[
"text" => "Kelola Data Cavling",
"icon" => "fa fa-cubes",
"is_multi" => true,
"href" => [
[
"section_text" => "Data Cavling",
"section_icon" => "far fa-circle",
"section_href" => route('kavling.index')
],
[
"section_text" => "Tambah Cavling",
"section_icon" => "far fa-circle",
"section_href" => route('kavling.add')
]
]
],
[
"text" => "Kelola Data Fasilitas",
"icon" => "fa fa-bath",
"is_multi" => true,
"href" => [
[
"section_text" => "Data Fasilitas",
"section_icon" => "far fa-circle",
"section_href" => route('fasilitas.index')
], [
"section_text" => "Tambah Fasilitas",
"section_icon" => "far fa-circle",
"section_href" => route('fasilitas.add')
]
]
],
[
"text" => "Kelola Data Feedback",
"icon" => "fa fa-comments",
"is_multi" => true,
"href" => [
[
"section_text" => "Data Feedback",
"section_icon" => "far fa-circle",
"section_href" => route('feedback.index')
], [
"section_text" => "Tambah Feedback",
"section_icon" => "far fa-circle",
"section_href" => route('feedback.add')
]
]
],
[
"href" => route('transaksi.index'),
"text" => "Kelola Data Transaksi",
"icon" => "fas fa-list",
"is_multi" => false
],
];

$linksAdmin = [
[
"text" => "Kelola Data Akun",
"icon" => "fa fa-cubes",
"is_multi" => true,
"href" => [
[
"section_text" => "Data Akun",
"section_icon" => "far fa-circle",
"section_href" => route('akun.index')
],
[
"section_text" => "Tambah Akun",
"section_icon" => "far fa-circle",
"section_href" => route('akun.add')
]
]
],
];

$user = auth()->user();
// Cek dan dapatkan role
if ($user) {
$role = $user->role; // Sesuaikan dengan nama properti role pada model User Anda
// Sekarang $role berisi nilai role dari pengguna yang sudah login
if($role == 1){
$links = $linksAdmin;
}else{
$links = $linksUser;
}
}
$navigation_links = json_decode(json_encode($links));
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/dashboard/admin" class="brand-link d-flex justify-content-center align-items-center">
    <i class="fas fa-campground" style="color: #d6d8d9;"></i>
    <span class="brand-text font-weight-light">CampEase</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        @foreach ($navigation_links as $link)
        @if (!$link->is_multi)
        <li class="nav-item">
          @if ($link->text == "Tambah Transaksi")
          <a href="{{ (url()->current() == $link->href) ? '#' : $link->href }}" class="nav-link {{ (url()->current() == $link->href) ? 'active' : '' }}">
            <i class="nav-icon {{ $link->icon }}"></i>
            <p>
              {{ $link->text }}
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
          @else
          <a href="{{ (url()->current() == $link->href) ? '#' : $link->href }}" class="nav-link {{ (url()->current() == $link->href) ? 'active' : '' }}">
            <i class="nav-icon {{ $link->icon }}"></i>
            <p>
              {{ $link->text }}
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
          @endif
        </li>
        @else
        @php
        foreach($link->href as $section){
        if (url()->current() == $section->section_href) {
        $open = 'menu-open';
        $status = 'active';
        break; // Put this here
        } else {
        $open ='';
        $status = '';
        }
        }
        @endphp
        <li class="nav-item {{$open}}">
          <a href="#" class="nav-link {{$status}}">
            <i class="nav-icon {{ $link->icon }}"></i>
            <p>
              {{ $link->text }}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @foreach ($link->href as $section)
            <li class="nav-item">
              <a href="{{ (url()->current() == $section->section_href) ? '#' : $section->section_href }}" class="nav-link {{ (url()->current() == $section->section_href) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ $section->section_text }}</p>
              </a>
            </li>
            @endforeach
          </ul>
        </li>
        @endif
        @endforeach
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>