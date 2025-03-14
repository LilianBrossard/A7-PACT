<?php

/** @var $this \app\core\View */

use app\controllers\OfferController;
use app\core\Application;
use app\models\account\UserAccount;

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->title ?> | PACT</title>

    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/dist/output.css">

    <?php if ($this->leaflet) { ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
              integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
              crossorigin=""/>
    <?php } ?>

    <?php if ($this->cssFile): ?>
        <link rel="stylesheet"
              href="/css/pages/<?php echo $this->cssFile ?>.css">
    <?php endif; ?>
</head>

<body class="<?php echo Application::$app->user?->isProfessional() ? 'professional-mode' : '' ?>">

<input type="hidden" class="app-environment" value="<?php echo $_ENV['APP_ENVIRONMENT'] ?>">

<div class="height-top"></div>

<!-- Loader -->
<div class="loader">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
         viewBox="0 0 24 24" fill="none" stroke="rgb(var(--color-purple-primary))"
         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
         class="lucide lucide-loader-circle">
        <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
    </svg>
</div>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-left">
        <a href="/dashboard" class="mr-4">
            <img id="logo" src="/assets/images/logoPro.svg" alt="" width="100">
        </a>

        <!-- For dev -->
        <?php if (Application::$app->isAuthenticated() && $_ENV['APP_ENVIRONMENT'] === 'dev') { ?>
            <div class="flex gap-1">
                <?php if (Application::$app->user->isPrivateProfessional()) { ?>
                    <p>private</p>
                <?php } else { ?>
                    <p>public</p>
                <?php } ?>
                <p><?php echo Application::$app->userType ?></p>
                <p>connecté</p>
            </div>
        <?php } ?>
    </div>
    <div class="navbar-right">
        <!--        <a href="/recherche">-->
        <!--            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"-->
        <!--                 viewBox="0 0 24 24" fill="none" stroke="currentColor"-->
        <!--                 stroke-width="1" stroke-linecap="round" stroke-linejoin="round"-->
        <!--                 class="lucide lucide-search">-->
        <!--                <circle cx="11" cy="11" r="8"/>-->
        <!--                <path d="m21 21-4.3-4.3"/>-->
        <!--            </svg>-->
        <!--        </a>-->

        <a href="/dashboard" class="button gray icon-left icon-right no-border">
            <span>Dashboard</span>
            <i data-lucide="layout-dashboard"></i>
        </a>

<!--        <a href="/dashboard" class="link pro">Mon dashboard</a>-->

        <?php if (Application::$app->isAuthenticated()) { ?>
            <a href="/dashboard/messages" class="chat-trigger button gray icon-left icon-right no-border">
                <span>Messages</span>
                <i data-lucide="message-circle"></i>
            </a>

            <!-- Notifications -->
            <div class="notification">
                <div class="notification-icon button gray icon-left icon-right no-border hidden md:flex">
                    <p>Notifications</p>
                    <svg id="icon-alert" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell-dot"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M13.916 2.314A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.74 7.327A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673 9 9 0 0 1-.585-.665"/><circle cx="18" cy="8" r="3" fill="red" stroke="red"/></svg>
                    <svg id="icon-default" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/></svg>
                </div>
                <div class="notification-container"></div>
            </div>

            <!-- Avatar -->
            <div class="avatar">
                <div class="image-container">
                    <img src="<?php echo Application::$app->user->avatar_url ?>"
                         alt="<?php echo Application::$app->user->mail ?>">
                </div>

                <div class="avatar-options">
                    <a href="/comptes/modification">Mon compte</a>
                    <a href="/deconnexion">
                        Déconnexion
                        <i data-lucide="log-out" width="18"></i>
                    </a>
                </div>
            </div>
        <?php } else { ?>
            <a href="/connexion" class="button">Connexion</a>
        <?php } ?>

        <div class="nav-burger" id="nav-burger">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

<!-- Menu of the navbar -->
<div id="menu" class="menu-hidden">
    <ul>
        <li><a href="/">Accueil</a></li>
        <li><a href="/">Rechercher</a></li>
        <li><a href="/login">Connexion</a></li>
    </ul>
</div>

<!-- Waves -->
<?php if ($this->waves) { ?>
    <div class="waves">
        <!-- Orange wave -->
        <svg width="100%" height="432" preserveAspectRatio="none" viewBox="0 0 1456 432" fill="none"
             xmlns="http://www.w3.org/2000/svg" class="orange">
            <path
                d="M453.577 267C265.617 254.436 0 431.5 0 431.5V0H1455.04V369.5C1455.04 369.5 1337.89 299.429 1253.95 285.5C1080.26 256.677 1003.04 442.381 827.317 431.5C668.207 421.648 612.638 277.633 453.577 267Z"
                fill="url(#paint0_linear_2930_6089)"/>
            <defs>
                <linearGradient id="paint0_linear_2930_6089" x1="727.52" y1="431.5" x2="727.52"
                                y2="0" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#FFD884" stop-opacity="0"/>
                    <stop offset="1" stop-color="#FFC14E"/>
                </linearGradient>
            </defs>
        </svg>

        <!-- White wave -->
        <svg width="100%" height="448" preserveAspectRatio="none" viewBox="0 0 1457 448" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M817.338 447.5C658.227 437.648 602.658 293.633 443.598 283C277.783 271.916 51.532 408.409 0.520264 440.726V0H1456.52V381.252C1425.35 365.868 1315.4 313.354 1243.97 301.5C1070.28 272.677 993.061 458.381 817.338 447.5Z"
                fill="white"/>
        </svg>

        <!-- Purple wave -->
        <svg width="100%" height="432" preserveAspectRatio="none" viewBox="0 0 1456 432"
             fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M453.577 267C265.617 254.436 0 431.5 0 431.5V0H1455.04V369.5C1455.04 369.5 1337.89 299.429 1253.95 285.5C1080.26 256.677 1003.04 442.381 827.317 431.5C668.207 421.648 612.638 277.633 453.577 267Z"
                fill="url(#paint0_linear_2930_6091)"/>
            <defs>
                <linearGradient id="paint0_linear_2930_6091" x1="727.52" y1="431.5" x2="727.52"
                                y2="0" gradientUnits="userSpaceOnUse">
                    <stop stop-color="rgb(var(--color-purple-primary))" stop-opacity="0.1"/>
                    <stop offset="1" stop-color="rgb(var(--color-purple-primary))"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
<?php } ?>


<main class="main-container">
    <!-- Show alert -->
    <?php if (Application::$app->session->getFlash('success')): ?>
        <div class="alert success">
            <?php echo Application::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <!-- Content of the view-->
    {{content}}
</main>


<footer>
    <div class="footer-parts">
        <div>
            <p>À propos</p>
            <a href="">À propos de PACT</a>
            <a href="">Règlements</a>
        </div>
        <div>
            <p>Explorez</p>
            <a href="/recherche">Voir des offres</a>
            <a href="/inscription">S'inscrire</a>
        </div>
        <div>
            <p>Utilisez nos solutions</p>
            <a href="">Professionnel</a>
        </div>
    </div>
    <nav>
        <div class="footer-conditions">
            <img id="logo" src="/assets/images/logoSmallPro.svg"
                 alt="Logo PACT">
            <div class="flex flex-col gap-1">
                <p>@ 2024 PACT Tous droits réservés.</p>
                <div id="links">
                    <a class="link small pro" href="/termofuse">Conditions d'utilisation</a>
                    <a class="link small pro" href="/termofuse">Conditions de ventes</a>
                    <a class="link small pro" href="/mentions">mentions légales</a>
                    <a class="link small pro" href="">Plan du site</a>
                    <a class="link small pro" href="/conditions">Contactez-nous</a>
                </div>
            </div>
        </div>
        <div class="footer-networks">
            <a href="https://www.instagram.com/"
               target="_blank"
               class="button gray only-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                     height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1"
                     stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-instagram">
                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                    <path
                        d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                </svg>
            </a>
            <a href="https://www.facebook.com/"
               target="_blank"
               class="button gray only-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                     height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1"
                     stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-facebook">
                    <path
                        d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                </svg>
            </a>
        </div>
    </nav>
    <div class="footer-trip">
        <img id="tripenarvor" src="/assets/images/TripEnArvorLogo.svg"
             alt="Logo TripEnArvor">
        <p>Plateforme proposée par <b>TripEnArvor</b></p>
    </div>
    <div class="footer-finance">
        <p>Projet financé par la <a>Région Bretagne</a> et par le <a>Conseil
                général des Côtes d'Armor</a>.</p>
    </div>
</footer>


<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

<?php if ($this->leaflet) { ?>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
<?php } ?>

<script type="module" src="/js/main.js"></script>

<?php if ($this->jsFile) ?>
<script type="module" src="/js/pages/<?php echo $this->jsFile ?>.js"></script>
</body>

</html>