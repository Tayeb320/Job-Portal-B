<!DOCTYPE html>
<html lang="en">
@include('auth.header')
<body>
<main>
    <div class="container">
        @yield('main-content')
    </div>
</main>
@include('auth.footer')
@include('admin.partials.message')
</body>
</html>
