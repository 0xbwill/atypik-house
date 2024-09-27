<x-app-layout>
    <div class="flex">
    <!-- Sidebar -->
    <div class="p-4 bg-white shadow-lg fixed hidden sm:block">
        <nav class="space-y-2">
            <a href="#user" class="block" aria-label="client">Client</a>
            <a href="#hote" class="block" aria-label="hote">Hôte</a>
        </nav>
    </div>

    <!-- Main content -->
    <div class="p-4 w-3/4 mx-auto">
        <h1 class="text-2xl font-bold mb-6">Guide d'Utilisation</h1>

        <!-- User Section -->
        <section id="user" class="mb-12">
            <h1 class="text-xl font-bold mb-4">Règle générale : </h1>
            <h3 class="text-xs font-bold mb-4">Toute mention d'une page "entre guillemets", sauf indication, fait référence aux accès rapides disponibles situé dans le menu déroulant en haut à droite !</h3>
            <h2 class="text-xl font-bold mb-4">Rôle : Client</h2>

            <div class="mb-6">
                <p>1. <strong>Connexion</strong> : Connectez-vous à votre compte en utilisant vos identifiants.</p>
                <p>2. <strong>Page Profil</strong> : Accédez à votre profil pour consulter vos informations personnelles, vos réservations et vos avis ("Mon profil").</p>
                <p>3. <strong>Acces à un Profil (Hôte)</strong> : Tout hôte voit son profil publique, accessible en cliquant simplement sur son profil.</p>
            </div>
            
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Consultation et Réservation des Logements</h3>
                <p>1. <strong>Consulter les Logements</strong> : Accédez à la page des logements en cliquant sur "Nos logements" sur la navbar située en haut de page.</p>
                <p>1. <strong>Accéder à une page logement</strong> : Accédez à la page du logement souhaité en cliquant simplement sur le bouton en vert "Décourvrir" du logement correspondant</p>
                <p>2. <strong>Voir le Planning</strong> : Consultez le planning du logement en cliquant sur "Reserver" (toujours en vert) pour vérifier les créneaux disponibles.</p>
                <p>3. <strong>Faire une Réservation</strong> : Sélectionnez un créneau disponible et validez-le. Votre réservation apparaîtra ensuite dans votre page "Mes réservations".</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Consultation des Réservations</h3>
                <p>1. <strong>Voir les Réservations</strong> : Depuis votre page "Mes réservations", vous pouvez consulter toutes vos réservations actuelles, passées, futures et annulées.</p>
                <p>2. <strong>Détails des Réservations</strong> : Cliquez sur une réservation pour voir les détails, y compris les dates, le logement, et les avis laissés.</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Poster un Avis</h3>
                <p>1. <strong>Accéder aux réservations passées</strong> : Depuis votre page "mes reservations", via la section réservations passées, vous pouvez poster un avis.</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Astuces pour les Clients</h3>
                <p>Devenez hôte en remplissant le formulaire prévu à cet effet disponible dans l'onglet "Devenir Hôte". (Une fois connecté)</p>
            </div>

        </section>

        <!-- Hôte Section -->
        <section id="hote" class="mb-12">
            <h2 class="text-xl font-bold mb-4">Rôle : Hôte</h2>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Accès au Profil et Fonctions Utilisateur</h3>
                <p>1. <strong>Connexion</strong> : Connectez-vous à votre compte en utilisant vos identifiants.</p>
                <p>2. <strong>Page Profil</strong> : En plus des fonctionnalités utilisateur, les hôtes peuvent accéder à des options supplémentaires spécifiques à la gestion des logements.</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Gestion des Locations</h3>
                <p>1. <strong>Voir les Locations</strong> : Accédez à vos locations en cours, passées et à venir depuis la section "Mes logements" de votre profil.</p>
                <p>2. <strong>Détails des Locations</strong> : Cliquez sur une location pour voir les détails, y compris les réservations, les avis des utilisateurs, et les informations sur les locataires.</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Gestion des Logements</h3>
                <p>1. <strong>Voir les Logements</strong> : Accédez à la section "Mes Logements" pour voir tous vos logements, qu'ils soient en ligne ou non publiés.</p>
                <p>2. <strong>Ajouter des Logements</strong> : Cliquer sur Ajouter un nouveau logement une fois sur la page submentionné et remplissez toutes les informations nécessaires avant de sauvegarder.</p>
                <p>3. <strong>Modifier les Logements</strong> : Mettez à jour les informations de vos logements existants, y compris les descriptions, les photos et les équipements disponibles en cliquant sur Modifier.</p>
                <p>4. <strong>Gestion des Disponibilités</strong> : (Section 'Gestion des créneaux' en bas de la page de Modification)</p>
                <ul class="list-disc ml-6">
                    <li><strong>Ajout de Créneaux</strong> : Ajoutez des créneaux de disponibilité pour chaque logement. Par défaut, aucun créneau n'est disponible, c'est à vous de les ajouter pour permettre les réservations.</li>
                    <li><strong>Supprimer des Créneaux</strong> : Retirez des créneaux de disponibilité si nécessaire.</li>
                </ul>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Conseils pour les Hôtes</h3>
                <p>Optimisez vos annonces, gérez vos disponibilités et interagissez avec les locataires pour améliorer leur expérience.</p>
            </div>
        </section>
    </div>
</div></x-app-layout>
