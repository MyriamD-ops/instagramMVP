<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram - LUNARE DRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #fafafa;
        }
        
        /* Couleurs LUNARE DRESS */
        .lunare-primary {
            background-color: #2d3748; /* Gris foncé élégant */
        }
        
        .lunare-secondary {
            background-color: #e2e8f0; /* Gris clair doux */
        }
        
        .text-lunare-primary {
            color: #2d3748;
        }
        
        .text-lunare-secondary {
            color: #e2e8f0;
        }
        
        .bg-instagram-gradient {
            background: linear-gradient(45deg, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D);
        }
        
        /* Style pour les stories */
        .story-ring {
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888) border-box;
        }
        
        /* Style pour la barre de navigation fixe */
        .navbar-fixed {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
        }
        
        /* Espacement pour la barre fixe */
        .content-with-fixed-nav {
            padding-top: 60px;
        }
        
        /* Style pour les posts */
        .post-rectangle {
            aspect-ratio: 4 / 3;
        }
        
        /* Footer fixe en bas */
        .footer-fixed {
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 100;
        }
        
        /* Espacement pour le footer fixe */
        .content-with-fixed-footer {
            padding-bottom: 60px;
        }
        
        /* Style pour la card unique */
        .single-post-card {
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Style pour le cadre de profil */
        .profile-frame {
            height: 88px; /* Même hauteur que les stories */
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888) border-box;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Barre de navigation fixe modifiée -->
    <nav class="navbar-fixed bg-white border-b border-gray-300">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-12">
                <!-- Bouton "Plus" à gauche -->
                <div class="flex items-center">
                    <button class="text-gray-800 hover:text-lunare-primary transition-colors">
                        <i class="fas fa-plus text-xl"></i>
                    </button>
                </div>
                
                <!-- Logo Instagram centré -->
                <div class="flex items-center absolute left-1/2 transform -translate-x-1/2">
                    <a href="#" class="text-2xl font-bold bg-instagram-gradient bg-clip-text text-transparent">
                        <i class="fab fa-instagram mr-2"></i>
                        Instagram
                    </a>
                </div>
                
                <!-- Icônes Cœur et Menu à droite -->
                <div class="flex items-center space-x-4">
                    <button class="text-gray-800 hover:text-red-500 transition-colors">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                    <button class="text-gray-800 hover:text-lunare-primary transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="content-with-fixed-nav content-with-fixed-footer">
        <div class="container mx-auto px-4 py-6">
            <!-- Stories -->
            <div class="bg-white rounded-lg border border-gray-300 p-4 mb-6 single-post-card">
                <div class="flex space-x-6 overflow-x-auto pb-2">
                    <!-- Votre story -->
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-16 h-16 rounded-full p-0.5 story-ring mb-2">
                            <div class="w-full h-full rounded-full lunare-secondary flex items-center justify-center">
                                <i class="fas fa-plus text-lunare-primary"></i>
                            </div>
                        </div>
                        <span class="text-xs font-medium">Your story</span>
                    </div>
                    
                    <!-- Stories des utilisateurs -->
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-16 h-16 rounded-full p-0.5 story-ring mb-2">
                            <div class="w-full h-full rounded-full lunare-secondary"></div>
                        </div>
                        <span class="text-xs">super_santi_73</span>
                    </div>
                    
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-16 h-16 rounded-full p-0.5 story-ring mb-2">
                            <div class="w-full h-full rounded-full lunare-secondary"></div>
                        </div>
                        <span class="text-xs">lil_wyatt838</span>
                    </div>
                    
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-16 h-16 rounded-full p-0.5 story-ring mb-2">
                            <div class="w-full h-full rounded-full lunare-secondary"></div>
                        </div>
                        <span class="text-xs">liam_bean25</span>
                    </div>
                    
                    <div class="flex flex-col items-center flex-shrink-0">
                        <div class="w-16 h-16 rounded-full p-0.5 story-ring mb-2">
                            <div class="w-full h-full rounded-full lunare-secondary"></div>
                        </div>
                        <span class="text-xs">sprinkles_bby19</span>
                    </div>
                </div>
            </div>
            
            <!-- Section profil lunare_dress -->
            <div class="bg-white rounded-lg border border-gray-300 p-6 mb-6 single-post-card">
                <div class="flex items-center">
                    <!-- Photo de profil -->
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-20 h-20 rounded-full lunare-secondary flex items-center justify-center">
                            <i class="fas fa-moon text-lunare-primary text-2xl"></i>
                        </div>
                    </div>
                    
                    <!-- Informations du profil -->
                    <div class="flex-grow">
                        <div class="flex items-center mb-2">
                            <h2 class="text-xl font-bold text-lunare-primary mr-3">lunare_dress</h2>
                            <button class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-4 rounded-lg transition-colors">
                                Suivre
                            </button>
                        </div>
                        
                        <!-- Statistiques -->
                        <div class="flex space-x-6 mb-3">
                            <div class="text-center">
                                <p class="font-bold text-lunare-primary">125</p>
                                <p class="text-gray-600 text-sm">posts</p>
                            </div>
                            <div class="text-center">
                                <p class="font-bold text-lunare-primary">1.2K</p>
                                <p class="text-gray-600 text-sm">followers</p>
                            </div>
                            <div class="text-center">
                                <p class="font-bold text-lunare-primary">356</p>
                                <p class="text-gray-600 text-sm">following</p>
                            </div>
                        </div>
                        
                        <!-- Bio -->
                        <div class="mb-3">
                            <p class="font-semibold text-lunare-primary">LUNARE DRESS</p>
                            <p class="text-gray-700">Marque de mode parisienne • Élégance nocturne</p>
                            <p class="text-gray-700">Nouvelle collection Automne-Hiver 2023 disponible</p>
                            <a href="#" class="text-blue-500 hover:text-blue-600 text-sm">lunare-dress.com</a>
                        </div>
                    </div>
                </div>
                
                <!-- Boutons d'action -->
                <div class="flex space-x-2 mt-4">
                    <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 rounded-lg transition-colors">
                        Message
                    </button>
                    <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 rounded-lg transition-colors">
                        <i class="fas fa-chevron-down mr-1"></i>
                        Plus
                    </button>
                </div>
            </div>
            
            <!-- Posts - Une seule card par ligne -->
            <div class="space-y-6">
                <!-- Post 1 -->
                <div class="bg-white rounded-lg border border-gray-300 overflow-hidden single-post-card">
                    <!-- En-tête du post -->
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full lunare-secondary mr-3"></div>
                            <div>
                                <span class="font-medium text-lunare-primary">super_santi_73</span>
                                <p class="text-gray-500 text-sm">Paris, France • Il y a 2 heures</p>
                            </div>
                        </div>
                        <button class="text-gray-500 hover:text-lunare-primary">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                    
                    <!-- Image du post -->
                    <div class="post-rectangle lunare-primary flex items-center justify-center">
                        <div class="text-center p-6">
                            <i class="fas fa-image text-lunare-secondary text-6xl mb-4"></i>
                            <p class="text-lunare-secondary font-semibold text-xl">Post by super_santi_73</p>
                            <p class="text-lunare-secondary mt-2">Une journée magnifique à Paris #paris #vie #moment</p>
                        </div>
                    </div>
                    
                    <!-- Actions et statistiques -->
                    <div class="p-4">
                        <div class="flex justify-between mb-3">
                            <div class="flex space-x-4">
                                <button class="text-gray-800 hover:text-red-500 transition-colors">
                                    <i class="far fa-heart text-2xl"></i>
                                </button>
                                <button class="text-gray-800 hover:text-blue-500 transition-colors">
                                    <i class="far fa-comment text-2xl"></i>
                                </button>
                                <button class="text-gray-800 hover:text-green-500 transition-colors">
                                    <i class="far fa-paper-plane text-2xl"></i>
                                </button>
                            </div>
                            <button class="text-gray-800 hover:text-lunare-primary transition-colors">
                                <i class="far fa-bookmark text-2xl"></i>
                            </button>
                        </div>
                        
                        <!-- Likes -->
                        <p class="font-semibold text-lunare-primary mb-2">Liked by <span class="text-lunare-primary">liam_bean25</span> and <span class="text-lunare-primary">235 others</span></p>
                        
                        <!-- Description -->
                        <div class="mb-3">
                            <p><span class="font-semibold text-lunare-primary">super_santi_73</span> Profitez de chaque moment comme si c'était le dernier. La vie est trop courte pour ne pas être heureux. ✨</p>
                        </div>
                        
                        <!-- Statistiques en bas -->
                        <div class="flex text-gray-500 text-sm space-x-6 pt-3 border-t border-gray-100">
                            <span><span class="font-semibold text-lunare-primary">1.2K</span> likes</span>
                            <span><span class="font-semibold text-lunare-primary">57</span> comments</span>
                            <span><span class="font-semibold text-lunare-primary">24</span> shares</span>
                            <span><span class="font-semibold text-lunare-primary">6</span> saves</span>
                        </div>
                    </div>
                </div>
                
                <!-- Post 2 -->
                <div class="bg-white rounded-lg border border-gray-300 overflow-hidden single-post-card">
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full lunare-secondary mr-3"></div>
                            <div>
                                <span class="font-medium text-lunare-primary">lil_wyatt838</span>
                                <p class="text-gray-500 text-sm">New York, USA • Il y a 5 heures</p>
                            </div>
                        </div>
                        <button class="text-gray-500 hover:text-lunare-primary">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                    
                    <div class="post-rectangle lunare-secondary flex items-center justify-center">
                        <div class="text-center p-6">
                            <i class="fas fa-tshirt text-lunare-primary text-6xl mb-4"></i>
                            <p class="text-lunare-primary font-semibold text-xl">Street Style</p>
                            <p class="text-lunare-primary mt-2">Nouvelle tenue, nouvelles énergies #style #fashion #ootd</p>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex justify-between mb-3">
                            <div class="flex space-x-4">
                                <button class="text-gray-800 hover:text-red-500 transition-colors">
                                    <i class="far fa-heart text-2xl"></i>
                                </button>
                                <button class="text-gray-800 hover:text-blue-500 transition-colors">
                                    <i class="far fa-comment text-2xl"></i>
                                </button>
                            </div>
                            <button class="text-gray-800 hover:text-lunare-primary transition-colors">
                                <i class="far fa-bookmark text-2xl"></i>
                            </button>
                        </div>
                        
                        <p class="font-semibold text-lunare-primary mb-2">Liked by <span class="text-lunare-primary">super_santi_73</span> and <span class="text-lunare-primary">189 others</span></p>
                        
                        <div class="mb-3">
                            <p><span class="font-semibold text-lunare-primary">lil_wyatt838</span> Parfois, il suffit d'une nouvelle tenue pour changer d'humeur. Le style comme thérapie. 👕👖</p>
                        </div>
                        
                        <div class="flex text-gray-500 text-sm space-x-6 pt-3 border-t border-gray-100">
                            <span><span class="font-semibold text-lunare-primary">845</span> likes</span>
                            <span><span class="font-semibold text-lunare-primary">42</span> comments</span>
                            <span><span class="font-semibold text-lunare-primary">18</span> shares</span>
                            <span><span class="font-semibold text-lunare-primary">3</span> saves</span>
                        </div>
                    </div>
                </div>
                
                <!-- Post 3 -->
                <div class="bg-white rounded-lg border border-gray-300 overflow-hidden single-post-card">
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full lunare-secondary mr-3"></div>
                            <div>
                                <span class="font-medium text-lunare-primary">liam_bean25</span>
                                <p class="text-gray-500 text-sm">Londres, UK • Il y a 1 jour</p>
                            </div>
                        </div>
                        <button class="text-gray-500 hover:text-lunare-primary">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                    
                    <div class="post-rectangle lunare-primary flex items-center justify-center">
                        <div class="text-center p-6">
                            <i class="fas fa-camera text-lunare-secondary text-6xl mb-4"></i>
                            <p class="text-lunare-secondary font-semibold text-xl">Photo du jour</p>
                            <p class="text-lunare-secondary mt-2">Capturer la beauté du quotidien #photography #london #life</p>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex justify-between mb-3">
                            <div class="flex space-x-4">
                                <button class="text-gray-800 hover:text-red-500 transition-colors">
                                    <i class="far fa-heart text-2xl"></i>
                                </button>
                                <button class="text-gray-800 hover:text-blue-500 transition-colors">
                                    <i class="far fa-comment text-2xl"></i>
                                </button>
                            </div>
                            <button class="text-gray-800 hover:text-lunare-primary transition-colors">
                                <i class="far fa-bookmark text-2xl"></i>
                            </button>
                        </div>
                        
                        <p class="font-semibold text-lunare-primary mb-2">Liked by <span class="text-lunare-primary">sprinkles_bby19</span> and <span class="text-lunare-primary">312 others</span></p>
                        
                        <div class="mb-3">
                            <p><span class="font-semibold text-lunare-primary">liam_bean25</span> La photographie, c'est arrêter le temps. Chaque cliché raconte une histoire. 📸</p>
                        </div>
                        
                        <div class="flex text-gray-500 text-sm space-x-6 pt-3 border-t border-gray-100">
                            <span><span class="font-semibold text-lunare-primary">1.5K</span> likes</span>
                            <span><span class="font-semibold text-lunare-primary">68</span> comments</span>
                            <span><span class="font-semibold text-lunare-primary">31</span> shares</span>
                            <span><span class="font-semibold text-lunare-primary">9</span> saves</span>
                        </div>
                    </div>
                </div>
                
                <!-- Post 4 -->
                <div class="bg-white rounded-lg border border-gray-300 overflow-hidden single-post-card">
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full lunare-secondary mr-3"></div>
                            <div>
                                <span class="font-medium text-lunare-primary">sprinkles_bby19</span>
                                <p class="text-gray-500 text-sm">Tokyo, Japon • Il y a 2 jours</p>
                            </div>
                        </div>
                        <button class="text-gray-500 hover:text-lunare-primary">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                    
                    <div class="post-rectangle lunare-secondary flex items-center justify-center">
                        <div class="text-center p-6">
                            <i class="fas fa-heart text-lunare-primary text-6xl mb-4"></i>
                            <p class="text-lunare-primary font-semibold text-xl">Life moments</p>
                            <p class="text-lunare-primary mt-2">Les petits bonheurs de la vie #happy #life #joy</p>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex justify-between mb-3">
                            <div class="flex space-x-4">
                                <button class="text-gray-800 hover:text-red-500 transition-colors">
                                    <i class="far fa-heart text-2xl"></i>
                                </button>
                                <button class="text-gray-800 hover:text-blue-500 transition-colors">
                                    <i class="far fa-comment text-2xl"></i>
                                </button>
                            </div>
                            <button class="text-gray-800 hover:text-lunare-primary transition-colors">
                                <i class="far fa-bookmark text-2xl"></i>
                            </button>
                        </div>
                        
                        <p class="font-semibold text-lunare-primary mb-2">Liked by <span class="text-lunare-primary">lil_wyatt838</span> and <span class="text-lunare-primary">127 others</span></p>
                        
                        <div class="mb-3">
                            <p><span class="font-semibold text-lunare-primary">sprinkles_bby19</span> Le bonheur est dans les petites choses. Un sourire, un café, un rayon de soleil. Cherchez-les, ils sont partout. ☕️✨</p>
                        </div>
                        
                        <div class="flex text-gray-500 text-sm space-x-6 pt-3 border-t border-gray-100">
                            <span><span class="font-semibold text-lunare-primary">721</span> likes</span>
                            <span><span class="font-semibold text-lunare-primary">35</span> comments</span>
                            <span><span class="font-semibold text-lunare-primary">12</span> shares</span>
                            <span><span class="font-semibold text-lunare-primary">4</span> saves</span>
                        </div>
                    </div>
                </div>
                
                <!-- Post 5 - LUNARE DRESS -->
                <div class="bg-white rounded-lg border border-gray-300 overflow-hidden single-post-card">
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full lunare-secondary mr-3 flex items-center justify-center">
                                <i class="fas fa-moon text-lunare-primary text-lg"></i>
                            </div>
                            <div>
                                <span class="font-medium text-lunare-primary">lunare_dress</span>
                                <p class="text-gray-500 text-sm">Paris, France • Il y a 3 jours</p>
                            </div>
                        </div>
                        <button class="text-gray-500 hover:text-lunare-primary">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                    
                    <div class="post-rectangle lunare-primary flex items-center justify-center">
                        <div class="text-center p-6">
                            <i class="fas fa-star text-lunare-secondary text-6xl mb-4"></i>
                            <p class="text-lunare-secondary font-semibold text-xl">LUNARE DRESS</p>
                            <p class="text-lunare-secondary text-lg mt-2">Nouvelle collection Automne-Hiver 2023</p>
                            <p class="text-lunare-secondary mt-1">Élégance nocturne et style lunaire</p>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex justify-between mb-3">
                            <div class="flex space-x-4">
                                <button class="text-gray-800 hover:text-red-500 transition-colors">
                                    <i class="far fa-heart text-2xl"></i>
                                </button>
                                <button class="text-gray-800 hover:text-blue-500 transition-colors">
                                    <i class="far fa-comment text-2xl"></i>
                                </button>
                            </div>
                            <button class="text-gray-800 hover:text-lunare-primary transition-colors">
                                <i class="far fa-bookmark text-2xl"></i>
                            </button>
                        </div>
                        
                        <p class="font-semibold text-lunare-primary mb-2">Liked by <span class="text-lunare-primary">liam_bean25</span> and <span class="text-lunare-primary">542 others</span></p>
                        
                        <div class="mb-3">
                            <p><span class="font-semibold text-lunare-primary">lunare_dress</span> Découvrez notre nouvelle collection inspirée par la magie des nuits d'automne. Des matières nobles, des coupes élégantes, une silhouette qui célèbre la féminité. Disponible en boutique et en ligne. #LUNARE #automne2023 #mode #paris #collection #fashion</p>
                        </div>
                        
                        <div class="flex text-gray-500 text-sm space-x-6 pt-3 border-t border-gray-100">
                            <span><span class="font-semibold text-lunare-primary">2.1K</span> likes</span>
                            <span><span class="font-semibold text-lunare-primary">89</span> comments</span>
                            <span><span class="font-semibold text-lunare-primary">42</span> shares</span>
                            <span><span class="font-semibold text-lunare-primary">15</span> saves</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer fixe avec les 6 icônes -->
    <footer class="footer-fixed bg-white border-t border-gray-300">
        <div class="container mx-auto px-4">
            <div class="flex justify-around items-center h-14">
                <!-- Les 6 icônes de navigation -->
                <a href="#" class="text-gray-800 hover:text-lunare-primary transition-colors">
                    <i class="fas fa-home text-xl"></i>
                </a>
                <a href="#" class="text-gray-800 hover:text-lunare-primary transition-colors">
                    <i class="fas fa-search text-xl"></i>
                </a>
                <a href="#" class="text-gray-800 hover:text-lunare-primary transition-colors">
                    <i class="far fa-plus-square text-xl"></i>
                </a>
                <a href="#" class="text-gray-800 hover:text-lunare-primary transition-colors">
                    <i class="far fa-heart text-xl"></i>
                </a>
                <a href="#" class="text-gray-800 hover:text-lunare-primary transition-colors">
                    <i class="far fa-compass text-xl"></i>
                </a>
                <a href="#" class="text-gray-800 hover:text-lunare-primary transition-colors">
                    <div class="w-7 h-7 rounded-full lunare-secondary flex items-center justify-center">
                        <i class="fas fa-user text-xs text-lunare-primary"></i>
                    </div>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>