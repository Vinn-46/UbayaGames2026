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
        .alert-danger {
            color: #ff6b6b;
            background: rgba(50, 0, 0, 0.5);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #ff6b6b;
        }

        .custom-bg-responsive {
            background-image: url("{{ asset('assets/bgvertical.png') }}");
            background-attachment: fixed; 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        @media (min-width: 768px) {
            .custom-bg-responsive {
                background-image: url("{{ asset('assets/bghorizontal.png') }}");
            }
        }
    </style>
</head>
<body class="text-[#CBDCC1] font-['Georgia'] min-h-screen custom-bg-responsive">

    <div id="loginModal" class="modal-overlay show">

        <div class="modal-card">

            <h2 class="modal-title font-heading">Login</h2>

            <form method="POST" action="{{ route('login.action') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div style="margin-bottom:16px;">
                    <label style="font-size:18px;opacity:1;">Username</label><br>
                    <input type="text" name="username" class="form-input h40" value="{{ old('username') }}" required autofocus>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="font-size:18px;opacity:1;">Password</label><br>
                    <input type="password" name="password" class="form-input h40" required>
                </div>

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