<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventor+</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#C8DEEF] lg:bg-gray-100 h-screen flex">

    <div class="hidden lg:flex w-[58%] bg-[#C8DEEF] shadow-[9px_0px_6px_rgba(0,0,0,0.3)] z-10"></div>

    <div class="w-full lg:w-[42%] flex items-center justify-center p-6">
        <div class="bg-white p-8 rounded-2xl shadow-[9px_9px_6px_rgba(0,0,0,0.3)] w-full max-w-sm">

            <h1 class="font-nunito text-xl font-bold mb-1 drop-shadow-[0_4px_3px_rgba(0,0,0,0.3)]">
                Inventor<span class="text-[#D4AF37]">+</span>
            </h1>

            <h2 class="font-lexend text-2xl font-bold mb-1 text-[#006EC4]">Welcome !</h2>
            <p class="font-lexend text-gray-500 mb-6">Please login here</p>

            <form id="loginForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm text-[#006EC4] mb-1">Email Address</label>
                    <input type="email" id="email" required
                        class="w-full px-4 py-2 border rounded-lg bg-blue-50 focus:ring-2 focus:ring-yellow-400 outline-none">
                </div>

                <div class="mb-4 relative">
                    <label class="block text-sm text-[#006EC4] mb-1">Password</label>
                    <div class="relative">
                        <input type="password" id="password" required
                            class="w-full px-4 py-2 border rounded-lg bg-blue-50 focus:ring-2 focus:ring-yellow-400 outline-none pr-10">

                        <button type="button" id="togglePassword" tabindex="0"
                            class="absolute right-3 top-2.5 text-gray-400 hover:text-[#006EC4] focus:outline-none">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center mb-6">
                    <input type="checkbox" id="remember" class="mr-2"
                        onkeydown="if(event.key === 'Enter') { event.preventDefault(); this.checked = !this.checked; }">
                    <label for="remember" class="text-sm text-gray-600">Remember Me</label>
                </div>

                <button type="submit"
                    class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-3 rounded-lg transition">
                    Login
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            // 1. Matikan refresh tradisional bawaan browser
            e.preventDefault();

            // 2. Antisipasi jika user menekan Enter tepat di Checkbox
            if (document.activeElement && document.activeElement.id === 'remember') {
                return;
            }

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const tokenElement = document.querySelector('input[name="_token"]');

            try {
                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': tokenElement ? tokenElement.value : ''
                    },
                    body: JSON.stringify({
                        email,
                        password
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    // Jika sukses, lempar ke dashboard
                    window.location.href = '/dashboard';
                } else {
                    // Jika password/email salah, munculkan pesan dari backend
                    alert(data.message || 'Login Gagal, periksa kembali data Anda.');
                }
            } catch (error) {
                console.error('Error detail:', error);
                alert('Gagal terhubung ke server. Pastikan server Laravel menyala.');
            }
        });

        const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });

    // Tambahkan event agar tombol mata bisa diklik dengan Enter
    togglePassword.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            togglePassword.click();
        }
    });
    </script>
</body>

</html>
