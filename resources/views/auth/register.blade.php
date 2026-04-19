<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
        }

        @keyframes moveBackground {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* === VUE PUBLIQUE : message seul === */
        .public-message {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 60px 50px;
            max-width: 520px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .public-message .icon {
            font-size: 52px;
            margin-bottom: 24px;
            display: block;
        }

        .public-message h2 {
            font-size: 20px;
            font-weight: 600;
            color: #444;
            line-height: 1.6;
        }

        /* === FORMULAIRE CACHÉ === */
        .register-container {
            display: none;
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 50px 60px;
            max-width: 600px;
            width: 100%;
            animation: fadeInUp 0.8s ease-out;
        }

        .register-container.visible {
            display: block;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        h2 {
            font-size: 30px;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            color: #333;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .required {
            color: #e74c3c;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #667eea;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 20px 14px 50px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            background: #f8f9ff;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .password-strength {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .password-strength-bar.weak   { width: 33%; background: #e74c3c; }
        .password-strength-bar.medium { width: 66%; background: #f39c12; }
        .password-strength-bar.strong { width: 100%; background: #27ae60; }

        .password-hint {
            font-size: 11px;
            color: #999;
            margin-top: 5px;
        }

        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }

        .btn-register:active  { transform: translateY(0); }
        .btn-register:disabled { opacity: 0.6; cursor: not-allowed; }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 15px;
            color: #999;
            font-size: 13px;
            position: relative;
            z-index: 1;
        }

        .login-link {
            text-align: center;
            color: #555;
            font-size: 14px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .back-home {
            position: fixed;
            top: 30px;
            left: 30px;
            background: rgba(255, 255, 255, 0.9);
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            color: #667eea;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .back-home:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .role-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 8px;
        }

        @media (max-width: 768px) {
            .register-container { padding: 40px 30px; }
            .form-grid { grid-template-columns: 1fr; }
            h2 { font-size: 26px; }
            .back-home { top: 20px; left: 20px; padding: 10px 20px; font-size: 14px; }
        }
    </style>
</head>
<body>

    <!-- VUE PUBLIQUE PAR DÉFAUT -->
    <div class="public-message" id="publicView">
        <span class="icon">🔒</span>
        <h2>Vous n'avez pas l'autorisation de vous inscrire.<br>Veuillez contacter l'administration du CFPAM.</h2>
    </div>

    <!-- FORMULAIRE CACHÉ -->
    <a href="{{ route('welcome') }}" class="back-home" id="backBtn" style="display:none;">← Retour</a>

    <div class="register-container" id="registerContainer">
        <div class="logo-container">
            <div class="logo">🚗</div>
            <h2>Créer un compte <span class="role-badge">ADMIN</span></h2>
            <p class="subtitle">Rejoignez l'équipe administrative d'Ange Raphael</p>
        </div>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nom complet <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <span class="input-icon">👤</span>
                        <input type="text" id="name" name="name" placeholder="Ex: Jean Dupont" value="{{ old('name') }}" required>
                    </div>
                    @error('name')<div class="error-message show">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="email">Adresse email <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <span class="input-icon">📧</span>
                        <input type="email" id="email" name="email" placeholder="admin@example.com" value="{{ old('email') }}" required>
                    </div>
                    @error('email')<div class="error-message show">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe <span class="required">*</span></label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="password-strength">
                    <div class="password-strength-bar" id="strengthBar"></div>
                </div>
                <div class="password-hint">Le mot de passe doit contenir au moins 8 caractères</div>
                @error('password')<div class="error-message show">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe <span class="required">*</span></label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                </div>
                <div class="error-message" id="passwordMatchError">Les mots de passe ne correspondent pas</div>
            </div>

            <button type="submit" class="btn-register" id="submitBtn">Créer mon compte</button>

            @if (session('error'))
                <div class="error-message show" style="text-align: center; margin-top: 15px;">{{ session('error') }}</div>
            @endif
        </form>

        <div class="divider"><span>ou</span></div>

        <div class="login-link">
            Vous avez déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </div>

    <script>
        // ─── MÉCANISME DE DÉVERROUILLAGE SILENCIEUX ───────────────────────────────
        // L'utilisateur tape "cfpam" n'importe où sur la page (hors champs de saisie).
        // Aucun indicateur visuel, aucun champ visible. La frappe est interceptée
        // sur le document entier et comparée lettre par lettre au mot clé.

        (function () {
            var _k = 'cfpam';
            var _b = '';
            var _t = null;

            document.addEventListener('keydown', function (e) {
                // Ignorer si l'utilisateur est dans un input/textarea (formulaire déjà ouvert)
                var tag = document.activeElement ? document.activeElement.tagName.toLowerCase() : '';
                if (tag === 'input' || tag === 'textarea' || tag === 'select') return;

                // Réinitialiser après 3 secondes d'inactivité
                clearTimeout(_t);
                _t = setTimeout(function () { _b = ''; }, 3000);

                // N'accepter que les lettres
                if (e.key.length === 1 && /[a-zA-Z]/.test(e.key)) {
                    _b += e.key.toLowerCase();

                    // Garder uniquement les N derniers caractères (N = longueur du mot clé)
                    if (_b.length > _k.length) {
                        _b = _b.slice(_b.length - _k.length);
                    }

                    // Déverrouillage si correspondance exacte
                    if (_b === _k) {
                        _b = '';
                        _unlock();
                    }
                } else {
                    // Une touche non-lettre réinitialise la séquence
                    _b = '';
                }
            });

            function _unlock() {
                var pub = document.getElementById('publicView');
                var reg = document.getElementById('registerContainer');
                var btn = document.getElementById('backBtn');

                if (pub) pub.style.display = 'none';
                if (reg) reg.classList.add('visible');
                if (btn) btn.style.display = 'block';
            }
        })();

        // ─── FORCE DU MOT DE PASSE ────────────────────────────────────────────────
        var passwordInput = document.getElementById('password');
        var strengthBar   = document.getElementById('strengthBar');

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                var pwd = this.value;
                var s = 0;
                if (pwd.length >= 8) s++;
                if (pwd.match(/[a-z]/) && pwd.match(/[A-Z]/)) s++;
                if (pwd.match(/[0-9]/)) s++;
                if (pwd.match(/[^a-zA-Z0-9]/)) s++;

                strengthBar.className = 'password-strength-bar';
                if (s <= 1)      strengthBar.classList.add('weak');
                else if (s <= 3) strengthBar.classList.add('medium');
                else             strengthBar.classList.add('strong');
            });
        }

        // ─── CORRESPONDANCE DES MOTS DE PASSE ────────────────────────────────────
        var passwordConfirmation = document.getElementById('password_confirmation');
        var passwordMatchError   = document.getElementById('passwordMatchError');
        var submitBtn            = document.getElementById('submitBtn');

        function checkPasswordMatch() {
            if (!passwordConfirmation || !passwordInput) return;
            if (passwordConfirmation.value !== '') {
                if (passwordInput.value !== passwordConfirmation.value) {
                    passwordMatchError.classList.add('show');
                    submitBtn.disabled = true;
                } else {
                    passwordMatchError.classList.remove('show');
                    submitBtn.disabled = false;
                }
            }
        }

        if (passwordInput)        passwordInput.addEventListener('input', checkPasswordMatch);
        if (passwordConfirmation) passwordConfirmation.addEventListener('input', checkPasswordMatch);

        // ─── VALIDATION FINALE ────────────────────────────────────────────────────
        var registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', function (e) {
                var name     = document.getElementById('name').value.trim();
                var email    = document.getElementById('email').value.trim();
                var password = passwordInput.value;
                var pwdConf  = passwordConfirmation.value;
                var hasError = false;

                if (name.length < 3) {
                    alert('Le nom doit contenir au moins 3 caractères');
                    hasError = true;
                }

                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert('Veuillez entrer une adresse email valide');
                    hasError = true;
                }

                if (password.length < 8) {
                    alert('Le mot de passe doit contenir au moins 8 caractères');
                    hasError = true;
                }

                if (password !== pwdConf) {
                    alert('Les mots de passe ne correspondent pas');
                    hasError = true;
                }

                if (hasError) e.preventDefault();
            });
        }
    </script>
</body>
</html>