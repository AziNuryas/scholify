<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Schoolify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-schoolify { background-color: #1e56f3; }
        .text-schoolify { color: #1e56f3; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-schoolify text-white rounded-2xl mb-4 shadow-lg shadow-blue-200">
                <i class="fas fa-user-graduate text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Schoolify</h1>
            <p class="text-gray-500 text-sm">School Management System</p>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-xl text-sm border border-red-200">
                <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" required 
                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition duration-200"
                        placeholder="admin@school.com">
                </div>
            </div>

            <div class="mb-6">
                <div class="flex justify-between mb-2">
                    <label class="text-sm font-semibold text-gray-700">Password</label>
                    <a href="#" class="text-xs font-medium text-schoolify hover:underline">Forgot Password?</a>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" required 
                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition duration-200"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-schoolify hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-blue-200 transition duration-300 flex items-center justify-center">
                <span>Login Dashboard</span>
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </button>
        </form>

        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <div class="text-xs text-gray-600 bg-blue-50 p-4 rounded-xl text-left inline-block w-full border border-blue-100 shadow-sm">
                <p class="font-bold mb-2 text-schoolify"><i class="fas fa-info-circle mr-1"></i> Mode Demo Aktif (Gunakan akun ini):</p>
                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div class="bg-white p-2 rounded border border-gray-100">
                        <span class="font-bold text-gray-700 text-[10px] uppercase shadow-sm px-1.5 py-0.5 bg-gray-100 rounded mr-1">ADMIN</span>
                        <br>admin@school.com<br><span class="text-gray-400">admin123</span>
                    </div>
                    <div class="bg-white p-2 rounded border border-gray-100">
                        <span class="font-bold text-schoolify text-[10px] uppercase shadow-sm px-1.5 py-0.5 bg-blue-100 rounded mr-1">SISWA</span>
                        <br>siswa@school.com<br><span class="text-gray-400">siswa123</span>
                    </div>
                </div>

                {{-- Guru Mapel --}}
                <div class="mb-2">
                    <p class="text-[10px] font-bold text-indigo-600 mb-1">GURU MAPEL:</p>
                    <div class="bg-white p-2 rounded border border-indigo-100 bg-indigo-50/20">
                        <span class="font-bold text-indigo-600 text-[10px] uppercase px-1.5 py-0.5 bg-indigo-100 rounded mr-1">GURU</span>
                        guru@school.com | <span class="text-gray-400">guru123</span>
                    </div>
                </div>

                {{-- Guru BK --}}
                <div>
                    <p class="text-[10px] font-bold text-teal-600 mb-1">GURU BK:</p>
                    <div class="bg-white p-2 rounded border border-teal-100">
                        <span class="font-bold text-teal-700 text-[10px] uppercase px-1.5 py-0.5 bg-teal-100 rounded mr-1">BK</span>
                        azibk@gmail.com | <span class="text-gray-400">bk123</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>