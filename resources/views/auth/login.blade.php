<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Schoolify</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-schoolify { background-color: #1e56f3; } /* Warna biru utama dari logo Schoolify */
        .text-schoolify { color: #1e56f3; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-xl border border-gray-100">
        <!-- Logo & Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-schoolify text-white rounded-2xl mb-4 shadow-lg shadow-blue-200">
                <i class="fas fa-user-graduate text-3xl"></i> <!-- Ikon topi sekolah seperti di dashboard -->
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Schoolify</h1>
            <p class="text-gray-500 text-sm">School Management System</p>
        </div>

        <!-- Form Login -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <!-- Email -->
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" required 
                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition duration-200"
                        placeholder="admin@schoolify.com">
                </div>
            </div>

            <!-- Password -->
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

            <!-- Remember Me -->
            <div class="flex items-center mb-8">
                <input type="checkbox" id="remember" class="w-4 h-4 text-schoolify border-gray-300 rounded focus:ring-blue-500">
                <label for="remember" class="ml-2 text-sm text-gray-600">Remember this device</label>
            </div>

            <!-- Login Button -->
            <button type="submit" 
                class="w-full bg-schoolify hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-blue-200 transition duration-300 flex items-center justify-center">
                <span>Login Dashboard</span>
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">
                Don't have an account? <a href="#" class="font-semibold text-schoolify hover:underline">Contact Admin</a>
            </p>
        </div>
    </div>

</body>
</html>