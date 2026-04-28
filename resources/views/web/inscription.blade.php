<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Inscription — Auto-École</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #2352F5;
            --primary-dark: #1a3fd4;
            --primary-light: #EEF2FF;
            --dark: #0F172A;
            --surface: #FFFFFF;
            --surface2: #F8FAFC;
            --border: #E2E8F0;
            --border-focus: #2352F5;
            --text: #0F172A;
            --text-secondary: #64748B;
            --muted: #94A3B8;
            --success: #10B981;
            --error: #EF4444;
            --radius: 14px;
            --radius-sm: 10px;
            --radius-full: 100px;
        }

        html, body {
            min-height: 100vh;
            background: #F1F5F9;
            color: var(--text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 15px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Layout ── */
        .page {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ── Left panel ── */
        .left-panel {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: hidden;
            background: var(--primary);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 30% 70%, rgba(255,255,255,0.08) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 80% 20%, rgba(255,255,255,0.06) 0%, transparent 60%);
            pointer-events: none;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-icon svg { width: 24px; height: 24px; fill: white; }

        .brand-name {
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: -0.02em;
            color: white;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.15);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: var(--radius-full);
            margin-bottom: 28px;
        }

        .hero-title {
            font-weight: 800;
            font-size: clamp(2rem, 3.5vw, 3rem);
            line-height: 1.1;
            letter-spacing: -0.03em;
            color: white;
            margin-bottom: 20px;
        }

        .hero-desc {
            color: rgba(255,255,255,0.7);
            font-size: 0.95rem;
            max-width: 340px;
            line-height: 1.7;
            margin-bottom: 40px;
        }

        .stats-row {
            display: flex;
            gap: 32px;
        }

        .stat { display: flex; flex-direction: column; }

        .stat-value {
            font-weight: 800;
            font-size: 1.8rem;
            color: white;
            letter-spacing: -0.04em;
        }

        .stat-label {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.6);
            margin-top: 2px;
        }

        .left-bottom {
            position: relative;
            z-index: 1;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.5);
        }

        /* ── Right panel ── */
        .right-panel {
            background: #F1F5F9;
            padding: 48px 52px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        /* ── Mobile card wrapper ── */
        .mobile-card {
            background: white;
            border-radius: 24px;
            padding: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-inner {
            padding: 32px 28px 28px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-header {
            margin-bottom: 28px;
        }

        .form-header h2 {
            font-weight: 800;
            font-size: 1.75rem;
            letter-spacing: -0.03em;
            margin-bottom: 6px;
            color: var(--text);
            line-height: 1.2;
        }

        .form-header p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 400;
        }

        /* ── Step indicator ── */
        .steps {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 28px;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--muted);
            transition: color 0.3s;
        }

        .step.active { color: var(--text); }
        .step.done { color: var(--success); }

        .step-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 1.5px solid currentColor;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .step.active .step-num {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .step.done .step-num {
            background: var(--success);
            border-color: var(--success);
            color: white;
        }

        .step-line {
            flex: 1;
            height: 1.5px;
            background: var(--border);
        }

        /* ── Form ── */
        .form-section { display: none; }
        .form-section.active { display: block; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-grid .full { grid-column: 1 / -1; }

        .field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .field label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
            letter-spacing: 0em;
        }

        .field-wrap {
            position: relative;
        }

        .field-wrap .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            pointer-events: none;
            line-height: 0;
        }

        .field input,
        .field select {
            width: 100%;
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 14px 14px 42px;
            color: var(--text);
            font-family: inherit;
            font-size: 0.92rem;
            font-weight: 400;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            appearance: none;
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(35,82,245,0.08);
        }

        .field input.error,
        .field select.error {
            border-color: var(--error);
        }

        .field input::placeholder { color: var(--muted); font-weight: 400; }

        .field select option { background: white; color: var(--text); }

        .field .err-msg {
            font-size: 0.75rem;
            color: var(--error);
            display: none;
            font-weight: 500;
        }

        .field .err-msg.show { display: block; }

        /* Password toggle */
        .toggle-pass {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 0;
            line-height: 0;
        }

        /* ── Security section ── */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0 16px;
        }

        .section-divider-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .section-divider-label {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            white-space: nowrap;
        }

        /* ── Security options ── */
        .security-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 4px;
        }

        .security-option {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            background: var(--primary-light);
            border: 1.5px solid transparent;
            border-radius: var(--radius);
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
            text-align: left;
            text-decoration: none;
        }

        .security-option:hover {
            border-color: var(--primary);
            background: #E8EDFF;
        }

        .security-option.google {
            background: white;
            border-color: var(--border);
        }

        .security-option.google:hover {
            border-color: #4285F4;
            background: #F8FAFF;
        }

        .security-option-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: var(--primary);
        }

        .security-option.google .security-option-icon {
            background: transparent;
        }

        .security-option-text {
            flex: 1;
        }

        .security-option-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text);
            display: block;
        }

        .security-option-sub {
            font-size: 0.78rem;
            color: var(--text-secondary);
            display: block;
            margin-top: 1px;
        }

        .security-option-arrow {
            color: var(--text-secondary);
            line-height: 0;
        }

        /* ── Checkbox ── */
        .checkbox-wrap {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
            margin-top: 4px;
        }

        .checkbox-wrap input[type="checkbox"] { display: none; }

        .checkbox-box {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 1.5px solid var(--border);
            background: var(--surface2);
            flex-shrink: 0;
            margin-top: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .checkbox-wrap input:checked + .checkbox-box {
            background: var(--primary);
            border-color: var(--primary);
        }

        .checkbox-box svg { display: none; }
        .checkbox-wrap input:checked + .checkbox-box svg { display: block; }

        .checkbox-label {
            font-size: 0.83rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .checkbox-label a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        /* ── Buttons ── */
        .btn-primary {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0em;
            border: none;
            border-radius: var(--radius-full);
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 8px 24px rgba(35,82,245,0.3);
        }

        .btn-primary:active { transform: scale(0.98); }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-back {
            background: none;
            border: 1.5px solid var(--border);
            color: var(--text-secondary);
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: var(--radius-full);
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s;
            margin-top: 12px;
        }

        .btn-back:hover { border-color: var(--muted); color: var(--text); }

        /* Footer login link */
        .form-footer {
            text-align: center;
            margin-top: 16px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .form-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        /* ── Alert ── */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius);
            font-size: 0.85rem;
            margin-bottom: 16px;
            display: none;
            align-items: flex-start;
            gap: 10px;
        }

        .alert.show { display: flex; }
        .alert.error { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #DC2626; }
        .alert.success { background: rgba(16,185,129,0.08); border: 1px solid rgba(16,185,129,0.2); color: #059669; }

        /* ── OTP ── */
        .otp-wrap {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 24px 0;
        }

        .otp-wrap input {
            width: 52px;
            height: 60px;
            text-align: center;
            font-family: 'Inter', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            color: var(--text);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .otp-wrap input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(35,82,245,0.08);
        }

        .otp-info {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.88rem;
        }

        .otp-info strong { color: var(--text); font-weight: 600; }

        .resend-btn {
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0;
            font-family: inherit;
            margin-top: 8px;
        }

        .resend-btn:disabled { opacity: 0.4; cursor: not-allowed; }

        /* ── Success state ── */
        .success-panel {
            text-align: center;
            padding: 20px 0;
        }

        .success-icon {
            width: 72px;
            height: 72px;
            background: rgba(16,185,129,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .success-panel h3 {
            font-weight: 800;
            font-size: 1.4rem;
            margin-bottom: 10px;
            letter-spacing: -0.02em;
        }

        .success-panel p {
            color: var(--text-secondary);
            font-size: 0.88rem;
            margin-bottom: 32px;
        }

        .store-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .store-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 22px;
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            color: var(--text);
            text-decoration: none;
            font-size: 0.88rem;
            transition: border-color 0.2s, transform 0.15s;
        }

        .store-btn:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .store-btn-sub {
            font-size: 0.68rem;
            color: var(--text-secondary);
            display: block;
        }

        .store-btn-name {
            font-weight: 700;
            display: block;
        }

        /* ── Loader ── */
        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Fade ── */
        .fade-in {
            animation: fadeUp 0.35s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Mobile back button top ── */
        .mobile-header {
            display: none;
            align-items: center;
            gap: 12px;
            padding: 20px 28px 0;
        }

        .mobile-back-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text);
            transition: border-color 0.2s;
        }

        .mobile-back-btn:hover { border-color: var(--primary); }

        .mobile-header-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
        }

        /* ── Responsive ── */
        @media (max-width: 860px) {
            body { background: white; }
            .page { grid-template-columns: 1fr; background: white; min-height: 100vh; }
            .left-panel { display: none; }
            .right-panel {
                padding: 0;
                background: white;
                min-height: 100vh;
            }
            .mobile-card {
                background: white;
                border-radius: 0;
                min-height: 100vh;
            }
            .card-inner {
                padding: 24px 20px 32px;
            }
            .mobile-header {
                display: flex;
            }
            .form-header h2 {
                font-size: 1.6rem;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-grid .full { grid-column: 1; }
            .otp-wrap input { width: 44px; height: 54px; font-size: 1.3rem; }
        }

        @media (min-width: 861px) {
            .mobile-card {
                box-shadow: none;
                border-radius: 0;
                background: transparent;
            }
            .card-inner {
                padding: 0;
            }
        }

        /* Google SVG inline */
        .google-logo {
            width: 22px;
            height: 22px;
        }
    </style>
</head>
<body>

<div class="page">

    {{-- LEFT PANEL --}}
    <div class="left-panel">
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/></svg>
            </div>
            <span class="brand-name">AutoÉcole Ange Raphael</span>
        </div>

        <div class="hero-content">
            <div class="hero-tag">
                <svg width="8" height="8" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4" fill="currentColor"/></svg>
                Inscription en ligne
            </div>
            <h1 class="hero-title">Votre permis<br>de conduire<br>commence ici</h1>
            <p class="hero-desc">Inscrivez-vous en 2 minutes, accédez à vos cours et suivez votre progression depuis notre application mobile.</p>
            <div class="stats-row">
                <div class="stat">
                    <span class="stat-value">2 min</span>
                    <span class="stat-label">Pour s'inscrire</span>
                </div>
                <div class="stat">
                    <span class="stat-value">100%</span>
                    <span class="stat-label">En ligne</span>
                </div>
                <div class="stat">
                    <span class="stat-value">24/7</span>
                    <span class="stat-label">Accès cours</span>
                </div>
            </div>
        </div>

        <div class="left-bottom">
            © {{ date('Y') }} AutoÉcole Pro. Tous droits réservés.
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="mobile-card">

            {{-- Mobile top bar --}}
            <div class="mobile-header">
                <button class="mobile-back-btn" onclick="history.back()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <span class="mobile-header-title">Inscription</span>
            </div>

            <div class="card-inner">

                <div class="form-header">
                    <h2>Créer un compte</h2>
                    <p>Veuillez remplir vos informations personnelles pour continuer votre aventure.</p>
                </div>

                {{-- Steps --}}
                <div class="steps" id="stepsBar">
                    <div class="step active" id="step-ind-1">
                        <div class="step-num">1</div>
                        <span>Informations</span>
                    </div>
                    <div class="step-line"></div>
                    <div class="step" id="step-ind-2">
                        <div class="step-num">2</div>
                        <span>Vérification</span>
                    </div>
                    <div class="step-line"></div>
                    <div class="step" id="step-ind-3">
                        <div class="step-num">3</div>
                        <span>Télécharger</span>
                    </div>
                </div>

                {{-- Global alert --}}
                <div class="alert" id="globalAlert" role="alert"></div>

                {{-- ════ STEP 1: Registration form ════ --}}
                <div class="form-section active fade-in" id="section-1">
                    <div class="form-grid">

                        {{-- Prénom --}}
                        <div class="field">
                            <label>Prénom</label>
                            <div class="field-wrap">
                                <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
                                <input type="text" id="prenom" placeholder="Ex: Wilfried" autocomplete="given-name">
                            </div>
                            <span class="err-msg" id="err-prenom"></span>
                        </div>

                        {{-- Nom --}}
                        <div class="field">
                            <label>Nom</label>
                            <div class="field-wrap">
                                <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span>
                                <input type="text" id="nom" placeholder="Ex: SIGNE" autocomplete="family-name">
                            </div>
                            <span class="err-msg" id="err-nom"></span>
                        </div>

                        {{-- Téléphone --}}
                        <div class="field full">
                            <label>Téléphone</label>
                            <div class="field-wrap">
                                <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span>
                                <input type="tel" id="telephone" placeholder="+33 6 12 34 56 78" autocomplete="tel">
                            </div>
                            <span class="err-msg" id="err-telephone"></span>
                        </div>

                        {{-- Mot de passe --}}
                        <div class="field">
                            <label>Mot de passe</label>
                            <div class="field-wrap">
                                <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                                <input type="password" id="password" placeholder="Min. 6 caractères" autocomplete="new-password">
                                <button type="button" class="toggle-pass" onclick="togglePass('password', this)">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <span class="err-msg" id="err-password"></span>
                        </div>

                        {{-- Confirmation --}}
                        <div class="field">
                            <label>Confirmer</label>
                            <div class="field-wrap">
                                <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>
                                <input type="password" id="password_confirmation" placeholder="Répéter" autocomplete="new-password">
                                <button type="button" class="toggle-pass" onclick="togglePass('password_confirmation', this)">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <span class="err-msg" id="err-password_confirmation"></span>
                        </div>

                        {{-- Date de naissance --}}
                        <div class="field">
                            <label>Date de naissance</label>
                            <div class="field-wrap">
                                <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
                                <input type="date" id="date_naissance">
                            </div>
                        </div>

                        {{-- Type permis --}}
                        <div class="field">
                            <label>Type de permis</label>
                            <div class="field-wrap">
                                <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></span>
                                <select id="type_permis">
                                    <option value="">— Choisir —</option>
                                    <option value="permis_a">Permis A (Moto)</option>
                                    <option value="permis_b">Permis B (Voiture)</option>
                                    <option value="permis_t">Permis T (Transport)</option>
                                </select>
                            </div>
                            <span class="err-msg" id="err-type_permis"></span>
                        </div>

                        {{-- Code parrainage --}}
                        <div class="field full">
                            <label>Code de parrainage</label>
                            <div class="field-wrap">
                                <span class="icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></span>
                                <input type="text" id="code_parrainage" placeholder="Code de parrainage" value="{{ request('ref', '') }}" style="text-transform:uppercase" autocomplete="off">
                            </div>
                            <span class="err-msg" id="err-code_parrainage"></span>
                        </div>

                    </div>

                    {{-- Security section divider --}}
                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <span class="section-divider-label">Options de sécurité</span>
                        <div class="section-divider-line"></div>
                    </div>

                  

                    {{-- Politique de confidentialité --}}
                    <div class="field full" style="margin-top:16px">
                        <label class="checkbox-wrap" for="politique">
                            <input type="checkbox" id="politique">
                            <span class="checkbox-box">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><polyline points="2,6 5,9 10,3" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <span class="checkbox-label">
                                J'ai lu et j'approuve la
                                <a href="https://ange-raphael.supahuman.site/politique.html" target="_blank" rel="noopener">politique de confidentialité</a>
                            </span>
                        </label>
                        <span class="err-msg" id="err-politique"></span>
                    </div>

                    <button class="btn-primary" id="btnInscription" onclick="submitInscription()">
                        <span id="btnInscriptionText">Continuer</span>
                        <div class="spinner" id="spinnerInscription"></div>
                        <svg id="arrowIcon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>

                   
                </div>

                {{-- ════ STEP 2: OTP ════ --}}
                <div class="form-section fade-in" id="section-2">
                    <div class="otp-info">
                        <p>Un code de vérification a été envoyé par SMS au</p>
                        <strong id="otpPhone"></strong>
                        <p style="margin-top:6px; font-size:0.8rem;">Entrez le code à 6 chiffres ci-dessous</p>
                    </div>

                    <div class="otp-wrap">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-digit" inputmode="numeric" pattern="[0-9]">
                    </div>

                    <div style="text-align:center; margin-bottom: 8px;">
                        <span class="err-msg show" id="err-otp" style="display:none"></span>
                    </div>

                    <button class="btn-primary" id="btnOtp" onclick="submitOtp()">
                        <span id="btnOtpText">Vérifier le code</span>
                        <div class="spinner" id="spinnerOtp"></div>
                    </button>

                    <div style="text-align:center; margin-top:16px">
                        <button class="resend-btn" id="resendBtn" onclick="resendOtp()">Renvoyer le code</button>
                        <span id="resendTimer" style="color:var(--muted); font-size:0.82rem; display:none"></span>
                    </div>

                    <button class="btn-back" onclick="goToStep(1)">← Retour</button>
                </div>

                {{-- ════ STEP 3: Success + store links ════ --}}
                <div class="form-section fade-in" id="section-3">
                    <div class="success-panel">
                        <div class="success-icon">
                            <svg width="36" height="36" fill="none" stroke="#10B981" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <h3>Inscription réussie ! 🎉</h3>
                        <p>Votre compte a été créé et vérifié. Téléchargez notre application pour commencer votre formation.</p>

                        <div class="store-buttons">
                            <a href="{{ config('app.playstore_url', 'https://play.google.com/store/apps/details?id=com.anonymous.angeraphael') }}" target="_blank" class="store-btn">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M3.18 23.76c.34.19.72.24 1.08.15l11.36-11.36L12 9l-8.82 14.76zM20.5 10.5L17.88 9l-2.83 2.83 2.83 2.83L20.52 13.5c.72-.41.72-1.59-.02-2zM4.26.09C3.9.27 3.6.6 3.6 1.08v21.84c0 .36.18.66.42.84L15.36 12 4.26.09zM12 15l3.62 3.62L4.26 23.91c.24.12.48.09.72-.03L12 15z"/></svg>
                                <span>
                                    <span class="store-btn-sub">Disponible sur</span>
                                    <span class="store-btn-name">Google Play</span>
                                </span>
                            </a>
                            <a href="{{ config('app.appstore_url', 'https://apps.apple.com') }}" target="_blank" class="store-btn">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                                <span>
                                    <span class="store-btn-sub">Télécharger sur</span>
                                    <span class="store-btn-name">App Store</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>{{-- /right-panel --}}
</div>

<script>
// ── State ──────────────────────────────────────────────────────────────────
const API_BASE = 'https://ange-raphael.supahuman.site/api';
let registeredPhone = '';
let resendCountdown = null;

// ── Utilities ──────────────────────────────────────────────────────────────
function showAlert(msg, type = 'error') {
    const el = document.getElementById('globalAlert');
    el.className = 'alert ' + type + ' show';
    el.innerHTML = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0; margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg><span>${msg}</span>`;
    setTimeout(() => el.className = 'alert', 6000);
}

function clearAlert() {
    document.getElementById('globalAlert').className = 'alert';
}

function setLoading(section, loading) {
    const suffix = section === 1 ? 'Inscription' : 'Otp';
    document.getElementById('btn' + suffix).disabled = loading;
    document.getElementById('spinner' + suffix).style.display = loading ? 'block' : 'none';
    if (section === 1) {
        document.getElementById('btnInscriptionText').textContent = loading ? 'Envoi…' : 'Continuer';
        document.getElementById('arrowIcon').style.display = loading ? 'none' : 'block';
    } else {
        document.getElementById('btnOtpText').textContent = loading ? 'Vérification…' : 'Vérifier le code';
    }
}

function goToStep(step) {
    [1, 2, 3].forEach(s => {
        document.getElementById('section-' + s).classList.remove('active');
        const ind = document.getElementById('step-ind-' + s);
        if (ind) ind.className = 'step' + (s < step ? ' done' : s === step ? ' active' : '');
    });
    document.getElementById('section-' + step).classList.add('active');
    clearAlert();
}

function setFieldError(id, msg) {
    const el = document.getElementById(id);
    const errEl = document.getElementById('err-' + id);
    if (el) el.classList.toggle('error', !!msg);
    if (errEl) { errEl.textContent = msg || ''; errEl.classList.toggle('show', !!msg); }
}

function clearErrors() {
    ['nom','prenom','telephone','password','password_confirmation','type_permis','code_parrainage','politique','otp'].forEach(f => setFieldError(f, ''));
}

function togglePass(id, btn) {
    const input = document.getElementById(id);
    const isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    btn.innerHTML = isPass
        ? `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
        : `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}

// ── OTP input navigation ───────────────────────────────────────────────────
document.querySelectorAll('.otp-digit').forEach((input, i, all) => {
    input.addEventListener('input', () => {
        input.value = input.value.replace(/\D/g, '');
        if (input.value && i < all.length - 1) all[i + 1].focus();
    });
    input.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !input.value && i > 0) all[i - 1].focus();
    });
    input.addEventListener('paste', e => {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
        paste.split('').forEach((c, j) => { if (all[j]) all[j].value = c; });
        if (all[paste.length - 1]) all[paste.length - 1].focus();
    });
});

// ── Step 1 – Registration ──────────────────────────────────────────────────
async function submitInscription() {
    clearErrors(); clearAlert();

    const nom       = document.getElementById('nom').value.trim();
    const prenom    = document.getElementById('prenom').value.trim();
    const telephone = document.getElementById('telephone').value.trim();
    const password  = document.getElementById('password').value;
    const confirm   = document.getElementById('password_confirmation').value;
    const naissance = document.getElementById('date_naissance').value;
    const permis    = document.getElementById('type_permis').value;
    const parrain   = document.getElementById('code_parrainage').value.trim().toUpperCase();
    const politique = document.getElementById('politique').checked;

    let hasError = false;
    if (!nom)       { setFieldError('nom', 'Le nom est requis'); hasError = true; }
    if (!prenom)    { setFieldError('prenom', 'Le prénom est requis'); hasError = true; }
    if (!telephone) { setFieldError('telephone', 'Le téléphone est requis'); hasError = true; }
    if (!password)  { setFieldError('password', 'Le mot de passe est requis'); hasError = true; }
    if (password.length < 6) { setFieldError('password', 'Min. 6 caractères'); hasError = true; }
    if (password !== confirm) { setFieldError('password_confirmation', 'Les mots de passe ne correspondent pas'); hasError = true; }
    if (!permis)    { setFieldError('type_permis', 'Sélectionnez un type de permis'); hasError = true; }
    if (!parrain)   { setFieldError('code_parrainage', 'Le code de parrainage est requis'); hasError = true; }
    if (!politique) { setFieldError('politique', 'Vous devez accepter la politique de confidentialité'); hasError = true; }
    if (hasError) return;

    setLoading(1, true);

    try {
        const res = await fetch(`${API_BASE}/inscription`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({
                nom, prenom, telephone,
                password, password_confirmation: confirm,
                date_naissance: naissance || undefined,
                type_permis: permis,
                code_parrainage: parrain,
            })
        });

        const data = await res.json();

        if (data.success) {
            registeredPhone = telephone;
            document.getElementById('otpPhone').textContent = telephone;
            goToStep(2);
            startResendTimer(60);
        } else {
            if (data.errors) {
                Object.entries(data.errors).forEach(([field, msgs]) => {
                    const key = field.replace('.', '_');
                    setFieldError(key, Array.isArray(msgs) ? msgs[0] : msgs);
                });
            }
            showAlert(data.message || 'Une erreur est survenue.');
        }
    } catch (e) {
        showAlert('Impossible de contacter le serveur. Vérifiez votre connexion.');
    } finally {
        setLoading(1, false);
    }
}

// ── Step 2 – OTP ───────────────────────────────────────────────────────────
async function submitOtp() {
    clearErrors(); clearAlert();

    const digits = [...document.querySelectorAll('.otp-digit')].map(i => i.value).join('');
    if (digits.length < 6) { setFieldError('otp', 'Entrez les 6 chiffres du code'); return; }

    setLoading(2, true);

    try {
        const res = await fetch(`${API_BASE}/otp/verifier`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ telephone: registeredPhone, code: digits })
        });

        const data = await res.json();

        if (data.success) {
            goToStep(3);
        } else {
            setFieldError('otp', data.message || 'Code incorrect');
            showAlert(data.message || 'Code incorrect.');
        }
    } catch (e) {
        showAlert('Erreur réseau. Réessayez.');
    } finally {
        setLoading(2, false);
    }
}

async function resendOtp() {
    if (!registeredPhone) return;
    document.getElementById('resendBtn').disabled = true;

    try {
        await fetch(`${API_BASE}/envoyer-otp`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ telephone: registeredPhone })
        });
        showAlert('Code renvoyé !', 'success');
        startResendTimer(60);
    } catch (e) {
        document.getElementById('resendBtn').disabled = false;
    }
}

function startResendTimer(seconds) {
    const btn   = document.getElementById('resendBtn');
    const timer = document.getElementById('resendTimer');
    btn.style.display = 'none';
    timer.style.display = 'inline';
    let s = seconds;
    clearInterval(resendCountdown);
    resendCountdown = setInterval(() => {
        timer.textContent = `Renvoyer dans ${s}s`;
        s--;
        if (s < 0) {
            clearInterval(resendCountdown);
            btn.style.display = 'inline';
            btn.disabled = false;
            timer.style.display = 'none';
        }
    }, 1000);
}

// ── Auto uppercase parrainage ──────────────────────────────────────────────
document.getElementById('code_parrainage').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
});
</script>
</body>
</html>