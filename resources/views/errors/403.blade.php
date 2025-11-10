<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - SIMPUS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center">
            <!-- Icon -->
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>

            <!-- Content -->
            <h1 class="text-xl font-semibold text-gray-900 mb-2">Akses Ditolak</h1>
            <p class="text-gray-600 mb-6 max-w-sm">
                Anda tidak memiliki izin untuk mengakses halaman ini.
            </p>

            <!-- Actions -->
            <div class="space-x-3">
                <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Kembali
                </a>
                <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Beranda
                </a>
            </div>

            <!-- User info -->
            @auth
            <div class="mt-6 text-sm text-gray-500">
                Logged in as <span class="font-medium">{{ Auth::user()->name }}</span>
            </div>
            @endauth
        </div>
    </div>
</body>
</html>