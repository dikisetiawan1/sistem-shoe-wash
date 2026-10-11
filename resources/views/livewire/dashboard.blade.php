<div>
    
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Dashboard' }} | ShoeWash</title>

    <link rel="stylesheet"
          href="{{ asset('assets/css/adminlte.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/bootstrap-icons/bootstrap-icons.min.css') }}">

    @livewireStyles
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        @include('layouts.navbar')
        @include('layouts.sidebar')

        <main class="app-main">
            <div class="app-content">
                <div class="container-fluid py-3">
                    {{ $slot }}
                </div>
            </div>
        </main>

        

    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>

    @livewireScripts
</body>
</html>

</div>
