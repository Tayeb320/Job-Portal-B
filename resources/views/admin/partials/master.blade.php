<!DOCTYPE html>
<html lang="en">
@include('admin.partials.header-assets')
<body>
  <!-- ======= Header ======= -->
	@include('admin.partials.header')
  <!-- End Header -->
  <!-- ======= Sidebar ======= -->
	@include('admin.partials.sidebar')
  <!-- End Sidebar-->
  <main id="main" class="main">
	@yield('main-content')
  </main><!-- End #main -->
@include('admin.partials.footer-assets')
@include('admin.partials.message')
</body>
</html>
