<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ubaya Games 2026</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/Logo_UG.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <style>
        @font-face {
            font-family: 'GameofThrones';
            src: url("{{ asset('assets/fonts/GameofThrones.ttf') }}") format('truetype');
            font-weight: normal ;
            font-style: normal;
        }
        .font-heading {
            font-family: 'GameofThrones', serif !important;
        }
    </style>
</head>
<body 
    class="text-[#CBDCC1] font-['Georgia'] min-h-screen"
    style="
        background-image: url('{{ asset('assets/bg.jpg') }}');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;"
>

    <div id="loginModal" class="modal-overlay show">

        <div class="modal-card">

            <!-- TITLE -->
            <h2 class="modal-title">Login</h2>

            <!-- FORM -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username -->
                <div style="margin-bottom:16px;">
                    <label style="font-size:18px;opacity:1;">
                        Username
                    </label><br>

                    <input type="text" name="username" class="form-input h40" required>
                </div>

                <!-- Password -->
                <div style="margin-bottom:20px;">
                    <label style="font-size:18px;opacity:1;">
                        Password
                    </label><br>

                    <input type="password" name="password" class="form-input h40" required>
                </div>

                {{-- REMEMBER ME --}}
                <div style="margin-bottom:20px;">
                    <label style="font-size:16px;opacity:1;">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                </div>

                <!-- BUTTONS -->
                <div class="modal-actions">
                    <button type="button" id="closeModal" class="btn btn-cancel">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                </div>

            </form>

        </div>
    </div>

    
    <script>
        const cancelBtn = document.getElementById('closeModal');

        cancelBtn.onclick = () => window.location.href = "/"; 
    </script>

</body>
</html>
