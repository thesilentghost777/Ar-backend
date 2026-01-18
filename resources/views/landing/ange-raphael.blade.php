<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Auto-École Ange Raphael - Obtenez votre permis A & B gratuitement grâce au parrainage">
    <title>Ange Raphael | Auto-École Intelligente</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ange: {
                            primary: '#1e3a5f',
                            secondary: '#2d5a87',
                            accent: '#f59e0b',
                            gold: '#fbbf24',
                            light: '#e0f2fe',
                            dark: '#0c1929'
                        }
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Poppins', sans-serif; }
        
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 50%, #fcd34d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #1e3a5f 100%);
        }
        
        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .card-hover:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(245, 158, 11, 0.3);
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }
        
        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite;
        }
        
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(245, 158, 11, 0.4); }
            50% { box-shadow: 0 0 40px rgba(245, 158, 11, 0.8); }
        }
        
        .road-line {
            background: repeating-linear-gradient(
                90deg,
                #fbbf24,
                #fbbf24 30px,
                transparent 30px,
                transparent 60px
            );
            height: 4px;
            animation: roadMove 1s linear infinite;
        }
        
        @keyframes roadMove {
            0% { background-position: 0 0; }
            100% { background-position: 60px 0; }
        }
        
        .level-card {
            position: relative;
            overflow: hidden;
        }
        
        .level-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(245, 158, 11, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }
    </style>
</head>
<body class="bg-ange-dark text-white overflow-x-hidden">

    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 z-[100] flex items-center justify-center hero-gradient transition-opacity duration-500">
        <div class="text-center">
            <div class="relative w-32 h-32 mx-auto mb-6">
                <div class="absolute inset-0 border-4 border-ange-accent/30 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-t-ange-accent rounded-full animate-spin"></div>
                <div class="absolute inset-4 flex items-center justify-center">
                    <span class="text-4xl">🚗</span>
                </div>
            </div>
            <p class="text-ange-accent font-semibold text-xl">Ange Raphael</p>
        </div>
    </div>

    <!-- Navbar -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <a href="#" class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-ange-accent to-ange-gold rounded-xl flex items-center justify-center shadow-lg pulse-glow">
                        <span class="text-2xl">🚗</span>
                    </div>
                    <p class="text-xl font-bold">Ange Raphael</p>
                </a>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#accueil" class="text-white/80 hover:text-ange-accent transition-colors">Accueil</a>
                    <a href="#fonctionnalites" class="text-white/80 hover:text-ange-accent transition-colors">Fonctionnalités</a>
                    <a href="#parrainage" class="text-white/80 hover:text-ange-accent transition-colors">Parrainage</a>
                    <a href="#tarifs" class="text-white/80 hover:text-ange-accent transition-colors">Tarifs</a>
                </div>
                <a href="https://play.google.com/store/apps/details?id=com.anonymous.angeraphael" target="_blank" class="bg-gradient-to-r from-ange-accent to-ange-gold text-ange-dark px-6 py-3 rounded-full font-semibold hover:shadow-lg hover:shadow-ange-accent/30 transition-all">
                    Télécharger
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="accueil" class="min-h-screen hero-gradient relative flex items-center overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-20 right-10 w-72 h-72 bg-ange-accent/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-ange-gold/5 rounded-full blur-3xl"></div>
        
        <!-- Road decoration -->
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gray-800">
            <div class="road-line absolute top-1/2 left-0 right-0 -translate-y-1/2"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right">
                    <div class="inline-flex items-center gap-2 glass px-4 py-2 rounded-full mb-6">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-sm">Permis A & B disponibles</span>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight">
                        Votre permis<br>
                        <span class="gradient-text">GRATUITEMENT</span>
                    </h1>
                    <p class="text-xl text-white/70 mb-8 leading-relaxed">
                        La première auto-école camerounaise avec un système de parrainage révolutionnaire. 
                        Parrainez et obtenez votre permis sans débourser un seul franc!
                    </p>
                    <div class="flex flex-wrap gap-4 mb-10">
                        <a href="https://play.google.com/store/apps/details?id=com.anonymous.angeraphael" target="_blank" class="group bg-gradient-to-r from-ange-accent to-ange-gold text-ange-dark px-8 py-4 rounded-full font-bold text-lg hover:shadow-2xl hover:shadow-ange-accent/40 transition-all flex items-center gap-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.5,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/></svg>
                            Télécharger l'app
                            <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>
                    <div class="flex items-center gap-8">
                        <div class="text-center">
                            <p class="text-3xl font-bold gradient-text">4</p>
                            <p class="text-white/60 text-sm">Niveaux de parrainage</p>
                        </div>
                        <div class="w-px h-12 bg-white/20"></div>
                        <div class="text-center">
                            <p class="text-3xl font-bold gradient-text">100%</p>
                            <p class="text-white/60 text-sm">Gratuit possible</p>
                        </div>
                        <div class="w-px h-12 bg-white/20"></div>
                        <div class="text-center">
                            <p class="text-3xl font-bold gradient-text">A & B</p>
                            <p class="text-white/60 text-sm">Permis disponibles</p>
                        </div>
                    </div>
                </div>
                <div data-aos="fade-left" class="relative">
                    <div class="float-animation">
                        <div class="glass rounded-3xl p-8 relative">
                            <div class="absolute -top-6 -right-6 w-20 h-20 bg-gradient-to-br from-ange-accent to-ange-gold rounded-2xl flex items-center justify-center text-4xl shadow-xl">
                                🚗
                            </div>
                            <div class="space-y-6">
                                <div class="flex items-center gap-4 p-4 bg-white/5 rounded-xl">
                                    <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                                        <span class="text-green-400 text-xl">✓</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Cours théoriques</p>
                                        <p class="text-white/60 text-sm">Interactifs et dynamiques</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 p-4 bg-white/5 rounded-xl">
                                    <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                                        <span class="text-blue-400 text-xl">🎥</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Cours pratiques vidéo</p>
                                        <p class="text-white/60 text-sm">Apprenez à votre rythme</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 p-4 bg-white/5 rounded-xl">
                                    <div class="w-12 h-12 bg-ange-accent/20 rounded-full flex items-center justify-center">
                                        <span class="text-ange-accent text-xl">👥</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Système de parrainage</p>
                                        <p class="text-white/60 text-sm">Gagnez en parrainant</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fonctionnalites" class="py-24 bg-gradient-to-b from-ange-dark to-ange-primary/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-ange-accent font-semibold">Fonctionnalités</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-3">Tout pour réussir votre permis</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        📚
                    </div>
                    <h3 class="text-xl font-bold mb-3">Cours Théoriques</h3>
                    <p class="text-white/70">Cours interactifs avec images et animations. Accédez via WebView à du contenu riche et dynamique.</p>
                </div>

                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        🎬
                    </div>
                    <h3 class="text-xl font-bold mb-3">Cours Pratiques Vidéo</h3>
                    <p class="text-white/70">Vidéos explicatives avec lecteur natif intégré. Apprenez les techniques de conduite pas à pas.</p>
                </div>

                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        ✅
                    </div>
                    <h3 class="text-xl font-bold mb-3">Quiz Évaluatifs</h3>
                    <p class="text-white/70">QCM et Vrai/Faux à la fin de chaque chapitre. Obtenez 12/20 minimum pour progresser.</p>
                </div>

                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 bg-gradient-to-br from-ange-accent to-ange-gold rounded-2xl flex items-center justify-center text-3xl mb-6">
                        👥
                    </div>
                    <h3 class="text-xl font-bold mb-3">Parrainage Multi-niveaux</h3>
                    <p class="text-white/70">4 niveaux de parrainage pour réduire progressivement vos frais jusqu'à 0 FCFA!</p>
                </div>

                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        💳
                    </div>
                    <h3 class="text-xl font-bold mb-3">Paiement Flexible</h3>
                    <p class="text-white/70">Mobile Money, code caisse ou transfert entre utilisateurs. Payez à votre rythme!</p>
                </div>

                <div class="glass rounded-2xl p-8 card-hover" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl flex items-center justify-center text-3xl mb-6">
                        📊
                    </div>
                    <h3 class="text-xl font-bold mb-3">Suivi de Progression</h3>
                    <p class="text-white/70">Visualisez votre avancement, les deadlines et votre préparation à l'examen en temps réel.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Referral System Section -->
    <section id="parrainage" class="py-24 hero-gradient relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 20% 50%, rgba(245,158,11,0.3) 0%, transparent 50%);"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-ange-accent font-semibold">Système révolutionnaire</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-3">Parrainez et économisez!</h2>
                <p class="text-white/70 mt-4 max-w-2xl mx-auto">Chaque niveau atteint vous fait économiser sur vos frais. Atteignez le niveau 3 et obtenez votre permis gratuitement!</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Level 0 -->
                <div class="level-card glass rounded-2xl p-6 border-2 border-white/10 hover:border-ange-accent/50 transition-all" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl flex items-center justify-center text-2xl font-bold mb-4">0</div>
                    <h3 class="text-lg font-bold mb-2">Niveau 0</h3>
                    <p class="text-white/60 text-sm mb-4">3 filleuls inscrits</p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-green-400">✓</span>
                            <span class="line-through text-white/40">40 000 FCFA Formation</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-white/70">
                            <span class="text-ange-accent">→</span>
                            <span>Reste: 52 500 FCFA</span>
                        </div>
                    </div>
                </div>

                <!-- Level 1 -->
                <div class="level-card glass rounded-2xl p-6 border-2 border-white/10 hover:border-ange-accent/50 transition-all" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-2xl font-bold mb-4">1</div>
                    <h3 class="text-lg font-bold mb-2">Niveau 1</h3>
                    <p class="text-white/60 text-sm mb-4">3 filleuls avec dépôt</p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-green-400">✓</span>
                            <span class="line-through text-white/40">40 000 + 10 000 FCFA</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-white/70">
                            <span class="text-ange-accent">→</span>
                            <span>Reste: 42 500 FCFA</span>
                        </div>
                    </div>
                </div>

                <!-- Level 2 -->
                <div class="level-card glass rounded-2xl p-6 border-2 border-white/10 hover:border-ange-accent/50 transition-all" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center text-2xl font-bold mb-4">2</div>
                    <h3 class="text-lg font-bold mb-2">Niveau 2</h3>
                    <p class="text-white/60 text-sm mb-4">3 filleuls niveau 1+</p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-green-400">✓</span>
                            <span class="line-through text-white/40">+ 12 500 FCFA Examen blanc</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-white/70">
                            <span class="text-ange-accent">→</span>
                            <span>Reste: 30 000 FCFA</span>
                        </div>
                    </div>
                </div>

                <!-- Level 3 -->
                <div class="level-card glass rounded-2xl p-6 border-2 border-ange-accent/50 bg-ange-accent/5" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-14 h-14 bg-gradient-to-br from-ange-accent to-ange-gold rounded-xl flex items-center justify-center text-2xl font-bold text-ange-dark mb-4">3</div>
                    <h3 class="text-lg font-bold mb-2 gradient-text">Niveau 3</h3>
                    <p class="text-white/60 text-sm mb-4">3 filleuls niveau 2+</p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-green-400">✓</span>
                            <span class="text-green-400 font-bold">TOUT GRATUIT!</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-ange-accent font-bold">
                            <span>🎉</span>
                            <span>Reste: 0 FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 glass rounded-2xl p-6 max-w-2xl mx-auto text-center" data-aos="fade-up">
                <p class="text-white/80">
                    <span class="text-ange-accent font-bold">💡 Astuce:</span> 
                    Partagez votre code de parrainage à vos amis et famille. Plus ils progressent, plus vous économisez!
                </p>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="tarifs" class="py-24 bg-ange-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-ange-accent font-semibold">Tarifs</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-3">Structure des frais</h2>
                <p class="text-white/70 mt-4">Tous les frais peuvent être réduits ou annulés via le parrainage!</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass rounded-2xl p-8 text-center card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl mb-4">📖</div>
                    <p class="text-3xl font-bold gradient-text">40 000</p>
                    <p class="text-white/60">FCFA</p>
                    <p class="font-semibold mt-4">Frais de Formation</p>
                    <p class="text-white/50 text-sm mt-2">Accès complet aux cours</p>
                </div>

                <div class="glass rounded-2xl p-8 text-center card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-4xl mb-4">📝</div>
                    <p class="text-3xl font-bold gradient-text">10 000</p>
                    <p class="text-white/60">FCFA</p>
                    <p class="font-semibold mt-4">Inscription</p>
                    <p class="text-white/50 text-sm mt-2">Frais d'inscription officielle</p>
                </div>

                <div class="glass rounded-2xl p-8 text-center card-hover" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-4xl mb-4">🎯</div>
                    <p class="text-3xl font-bold gradient-text">12 500</p>
                    <p class="text-white/60">FCFA</p>
                    <p class="font-semibold mt-4">Examen Blanc</p>
                    <p class="text-white/50 text-sm mt-2">Préparation à l'examen</p>
                </div>

                <div class="glass rounded-2xl p-8 text-center card-hover" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-4xl mb-4">🏆</div>
                    <p class="text-3xl font-bold gradient-text">30 000</p>
                    <p class="text-white/60">FCFA</p>
                    <p class="font-semibold mt-4">Frais d'Examen</p>
                    <p class="text-white/50 text-sm mt-2">Examen officiel national</p>
                </div>
            </div>

            <div class="mt-12 text-center" data-aos="fade-up">
                <div class="inline-flex items-center gap-3 glass px-6 py-3 rounded-full">
                    <span class="text-2xl">💰</span>
                    <span class="font-semibold">Total standard: <span class="gradient-text">92 500 FCFA</span></span>
                    <span class="text-white/40">|</span>
                    <span class="font-semibold">Avec parrainage niveau 3: <span class="text-green-400">0 FCFA</span></span>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 hero-gradient relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-ange-accent/5 rounded-full blur-3xl"></div>
        </div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Prêt à prendre le volant?</h2>
            <p class="text-xl text-white/70 mb-10">Rejoignez Ange Raphael et obtenez votre permis de conduire facilement!</p>
            
            <a href="https://play.google.com/store/apps/details?id=com.anonymous.angeraphael" target="_blank" class="inline-flex items-center gap-3 bg-gradient-to-r from-ange-accent to-ange-gold text-ange-dark px-10 py-5 rounded-full font-bold text-xl hover:shadow-2xl hover:shadow-ange-accent/40 transition-all pulse-glow">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.5,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/></svg>
                Télécharger l'application
            </a>

            <div class="mt-12 flex flex-wrap justify-center gap-8">
                <a href="https://wa.me/237696087354" class="glass rounded-2xl p-6 hover:bg-ange-accent/10 transition-colors">
                    <span class="text-2xl">📱</span>
                    <p class="font-semibold mt-2">+237 696 087 354</p>
                </a>
                <a href="mailto:tsf237@gmail.com" class="glass rounded-2xl p-6 hover:bg-ange-accent/10 transition-colors">
                    <span class="text-2xl">✉️</span>
                    <p class="font-semibold mt-2">tsf237@gmail.com</p>
                </a>
                <a href="https://techforgesolution237.site" target="_blank" class="glass rounded-2xl p-6 hover:bg-ange-accent/10 transition-colors">
                    <span class="text-2xl">🌐</span>
                    <p class="font-semibold mt-2">techforgesolution237.site</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 bg-ange-dark border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-ange-accent to-ange-gold rounded-xl flex items-center justify-center">
                    <span class="text-xl">🚗</span>
                </div>
                <span class="font-bold text-xl">Ange Raphael</span>
            </div>
            <p class="text-white/60">© 2026 Auto-École Ange Raphael. Powered By <a href="https://techforgesolution237.site" target="_blank" class="text-ange-accent hover:underline">TFS237</a></p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        window.addEventListener('load', () => { 
            document.getElementById('preloader').style.opacity = '0'; 
            setTimeout(() => document.getElementById('preloader').style.display = 'none', 500); 
        });
        AOS.init({ duration: 800, once: true, offset: 100 });
        window.addEventListener('scroll', () => { 
            document.getElementById('navbar').classList.toggle('bg-ange-primary/95', window.pageYOffset > 100); 
            document.getElementById('navbar').classList.toggle('backdrop-blur-xl', window.pageYOffset > 100); 
        });
    </script>
</body>
</html>
