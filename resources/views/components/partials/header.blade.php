<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WoStock Admin - Tableau de Bord</title>

    <!-- 1. Tailwind pour le design -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- 2. Lucide pour les icônes -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- 3. SweetAlert2 pour les messages et formulaires popup -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* CSS Fixe pour les animations de menu */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .submenu.open {
            max-height: 400px;
        }

        /* Augmenté pour laisser de la place */
        .rotate-icon {
            transition: transform 0.3s ease;
        }

        .rotate-icon.active {
            transform: rotate(180deg);
        }

        .swal2-popup {
            border-radius: 1.5rem !important;
        }
    </style>
</head>