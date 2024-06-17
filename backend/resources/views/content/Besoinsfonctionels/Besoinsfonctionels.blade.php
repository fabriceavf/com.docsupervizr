@extends('layouts/contentLayoutMaster')

@section('title', 'Besoinsfonctionels')

@section('content')
    <!-- Page layout -->
    <div id="app"></div>
    <!--/ Page layout -->

<div class="container">
    <div>
        <p>Cette section de la documentation technique détaille les besoins fonctionnels de notre application, couvrant divers aspects tels que la gestion des absences, des congés, des postes de travail, des horaires, ainsi que la génération des programmes de travail et la validation des heures supplémentaires</p>

        <p><strong>3. Fonctionnalités :</strong></p>
        <p><strong>3.1. Gestion des Absences des Salariés</strong></p>
        <ul>
            <li><strong>Saisie des absences :</strong><ul>
                    <li>Les gestionnaires peuvent ajouter une absence pour un salarié en spécifiant la date de début, la date de fin, et le motif de l&#39;absence.</li>
                </ul>
            </li>
            <li><strong>Modification des absences :</strong><ul>
                    <li>Les gestionnaires peuvent modifier les informations des absences existantes, telles que les dates et les motifs.</li>
                </ul>
            </li>
            <li><strong>Consultation des absences :</strong><ul>
                    <li>Les gestionnaires peuvent consulter l&#39;historique des absences d&#39;un salarié, filtrer par période, type d&#39;absence, ou par salarié spécifique.</li>
                </ul>
            </li>
            <li><strong>Notifications (si applicable) :</strong><ul>
                    <li>Envoi automatique de notifications aux gestionnaires et aux salariés concernés lorsque des absences sont ajoutées, modifiées, ou supprimées.</li>
                </ul>
            </li>
            <li><strong>Rapports :</strong><ul>
                    <li>Génération de rapports sur les absences, incluant les totaux par type d&#39;absence, par département, et par période de temps.</li>
                </ul>
            </li>
        </ul>
        <p><strong>3.2. Définition et Gestion des Congés des Agents</strong></p>
        <ul>
            <li><strong>Définition des types de congés :</strong><ul>
                    <li>Les gestionnaires peuvent créer et gérer différents types de congés (congés annuels, congés maternité/paternité, congés sans solde, etc.).</li>
                </ul>
            </li>
            <li><strong>Soumission des demandes de congés :</strong><ul>
                    <li>Les agents peuvent soumettre des demandes de congés en spécifiant le type de congé, la date de début, la date de fin, et toute information pertinente (comme le motif).</li>
                </ul>
            </li>
            <li><strong>Approbation et refus des demandes :</strong><ul>
                    <li>Les gestionnaires peuvent approuver ou refuser les demandes de congés. Les agents sont informés automatiquement de la décision.</li>
                </ul>
            </li>
            <li><strong>Historique des congés :</strong><ul>
                    <li>Les agents et les gestionnaires peuvent consulter l&#39;historique des congés pris, y compris les détails sur les dates et les types de congés.</li>
                </ul>
            </li>
            <li><strong>Calendrier des congés :</strong><ul>
                    <li>Visualisation d&#39;un calendrier des congés pour voir les périodes de congés approuvées et planifiées pour l&#39;ensemble des agents.</li>
                </ul>
            </li>
            <li><strong>Règles de congés :</strong><ul>
                    <li>Mise en place de règles et de politiques de congés (par exemple, le nombre maximum de jours de congé consécutifs, les périodes de blackout où les congés ne sont pas autorisés, etc.).</li>
                </ul>
            </li>
        </ul>
        <p><strong>3.3. Gestion des Postes de Travail</strong></p>
        <ul>
            <li><strong>Définition des postes de travail :</strong><ul>
                    <li>Les gestionnaires peuvent créer et gérer des postes de travail, qu&#39;ils soient physiques (dans un bureau) ou virtuels (télétravail).</li>
                </ul>
            </li>
            <li><strong>Catégorisation des postes de travail par sites :</strong><ul>
                    <li>Les postes de travail doivent être catégorisés par sites (bâtiments). Chaque site est associé à un client (entreprise) pour lequel les agents sont affectés.</li>
                </ul>
            </li>
            <li><strong>Assignation des postes de travail :</strong><ul>
                    <li>Les gestionnaires peuvent assigner des postes de travail spécifiques aux agents en fonction de leurs rôles et responsabilités, en tenant compte du site et du client associé.</li>
                </ul>
            </li>
            <li><strong>Modification des postes de travail :</strong><ul>
                    <li>Les gestionnaires peuvent modifier les informations des postes de travail existants, telles que la localisation, l&#39;équipement nécessaire, et les responsabilités associées.</li>
                </ul>
            </li>
            <li><strong>Consultation des postes de travail :</strong><ul>
                    <li>Les gestionnaires et les agents peuvent consulter les informations sur les postes de travail, y compris les détails sur la localisation (pour les postes physiques) et les exigences technologiques (pour les postes virtuels).</li>
                </ul>
            </li>
            <li><strong>Notifications (si applicable) :</strong><ul>
                    <li>Envoi automatique de notifications aux agents lorsqu&#39;il y a des changements dans leurs postes de travail (par exemple, changement de localisation ou de modalité de travail).</li>
                </ul>
            </li>
        </ul>
        <p><strong>3.4. Gestion des Horaires de Travail</strong></p>
        <ul>
            <li><strong>Définition des horaires de travail :</strong><ul>
                    <li>Les gestionnaires peuvent définir les horaires de travail pour chaque poste en spécifiant les heures de début et de fin de travail, ainsi que les jours de la semaine.</li>
                </ul>
            </li>
            <li><strong>Assignation des horaires aux agents :</strong><ul>
                    <li>Les gestionnaires peuvent assigner des horaires de travail spécifiques aux agents en fonction de leur poste de travail.</li>
                </ul>
            </li>
            <li><strong>Modification des horaires de travail :</strong><ul>
                    <li>Les gestionnaires peuvent modifier les horaires de travail existants en cas de besoin, par exemple pour accommoder des changements dans la planification ou dans les besoins opérationnels.</li>
                </ul>
            </li>
            <li><strong>Consultation des horaires de travail :</strong><ul>
                    <li>Les gestionnaires et les agents peuvent consulter les horaires de travail assignés, ainsi que les horaires planifiés pour une période donnée.</li>
                </ul>
            </li>
            <li><strong>Notifications (si applicable) :</strong><ul>
                    <li>Envoi automatique de notifications aux agents pour leur rappeler leurs horaires de travail, ainsi que pour toute modification apportée aux horaires.</li>
                </ul>
            </li>
        </ul>
        <p><strong>3.5. Génération Automatique des Programmes de Travail</strong></p>
        <ul>
            <li><strong>Automatisation de la génération :</strong><ul>
                    <li>L&#39;application doit générer automatiquement les programmes de travail des agents en fonction des horaires définis pour chaque poste. Cette fonctionnalité doit prendre en compte les horaires disponibles, les préférences des agents (le cas échéant), ainsi que les règles de gestion des horaires.</li>
                </ul>
            </li>
        </ul>
        <p><strong>3.6. Intégration du Système de Pointage par Badge MYFARE</strong></p>
        <ul>
            <li><strong>Utilisation de services tiers :</strong><ul>
                    <li>Intégration avec des services tiers comme Teleric pour la gestion des pointeuses mobiles développées spécifiquement pour le système de pointage par badge MYFARE.</li>
                </ul>
            </li>
            <li><strong>Enregistrement des pointages :</strong><ul>
                    <li>Les pointages des agents (heures de début et de fin de service) doivent être enregistrés à l&#39;aide des badges MYFARE sur les pointeuses mobiles.</li>
                </ul>
            </li>
            <li><strong>Synchronisation avec le serveur principal :</strong><ul>
                    <li>Les données de pointage doivent être synchronisées en temps réel avec le serveur principal de l&#39;application.</li>
                </ul>
            </li>
            <li><strong>Vérification de la présence :</strong><ul>
                    <li>Les données de pointage doivent être utilisées pour vérifier la présence des agents à leurs postes de travail selon les horaires planifiés.</li>
                </ul>
            </li>
        </ul>
        <p><strong>3.7. Validation Automatique des Heures Supplémentaires et Gestion des Anomalies de Pointage</strong></p>
        <ul>
            <li><strong>Détection des heures supplémentaires :</strong><ul>
                    <li>L&#39;application analyse les horaires programmés pour chaque agent et les données de pointage collectées pour détecter automatiquement les heures supplémentaires en comparant les heures de début et de fin de service avec les horaires prévus.</li>
                </ul>
            </li>
            <li><strong>Identification des anomalies de pointage :</strong><ul>
                    <li>En cas de pointage manquant, l&#39;application identifie cette anomalie et la signale pour vérification par les superviseurs. Cela inclut la gestion des cas où un agent ne badge pas à son arrivée ou à son départ prévu.</li>
                </ul>
            </li>
            <li><strong>Gestion des ajustements :</strong><ul>
                    <li>Les superviseurs peuvent ajuster manuellement les heures supplémentaires détectées ou les anomalies de pointage, en approuvant les ajustements nécessaires ou en rejetant les demandes non conformes aux règles établies.</li>
                </ul>
            </li>
        </ul>
        <p><strong>3.8. Gestion des Agents et Impression des Badges</strong></p>
        <ul>
            <li><strong>Gestion des Informations des Agents :</strong><ul>
                    <li>Permettre aux administrateurs de saisir et de gérer les informations personnelles et professionnelles des agents, facilitant la génération de rapports précis sur leur activité.</li>
                </ul>
            </li>
            <li><strong>Impression des Badges :</strong><ul>
                    <li>Intégrer un module permettant de générer et d&#39;imprimer les badges des agents directement à partir de l&#39;application, en utilisant les informations enregistrées dans leur profil.</li>
                </ul>
            </li>
        </ul>


    </div>
</div>
@endsection
