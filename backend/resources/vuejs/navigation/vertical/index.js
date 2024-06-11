export default [
    {
        title: 'Home',
        route: 'home',
        icon: 'HomeIcon',
    },

    {
        title: 'Effectifs',
        icon: 'UsersIcon',
        children: [
            {
                title: 'Enrolement',
                route: {name: 'Agents-a-valider'},
            },
            {
                title: 'salariés ',
                route: {name: 'Agents-valider', params: {id: 4987}},
            },
            {
                title: 'ONE',
                route: {name: 'Agents-One'},
            },
        ],
    },
    {
        title: 'Entreprises',
        icon: 'UsersIcon',
        children: [
            {
                title: 'Directions',
                route: {name: 'Directions', params: {type: 'brute'}},
            },
            {
                title: 'Services',
                route: {name: 'Services'},
            },
            {
                title: 'Fonctions',
                route: {name: 'Fonctions', params: {id: 4987}},
            },
            {
                title: 'Clients',
                route: {name: 'Clients', params: {type: 'brute'}},
            },
            {
                title: 'Postes',
                route: 'Postes',
                icon: 'UserIcon',
            },
        ],
    },
    {
        title: 'Calendriers',
        icon: 'UsersIcon',
        children: [

            {
                title: 'Types abscences',
                route: 'Typesabscences',
                icon: 'HomeIcon',
            },
            {
                title: 'Listes abscences',
                route:{ name: 'Abscences', params: { id: 4987 } },
            },
            {
                title: 'Listes Conges',
                route:{ name: 'Conges', params: { id: 4987 } },
            },
            {
                title: 'Listes Jours feries',
                route:{ name: 'Joursferies', params: { id: 4987 } },
            },
        ],
    },
    {
        title: 'Pointages',
        icon: 'FileTextIcon',
        route:{ name: 'Journals', params: { type: 'journal' } },
    },
    // {
    //     title: 'Programmations',
    //     icon: 'UsersIcon',
    //     children: [
    //
    //         {
    //             title: 'Taches',
    //             route: 'Taches',
    //             icon: 'ListIcon',
    //         },
    //         {
    //             title: 'Programmes',
    //             route: 'Programmations',
    //             icon: 'BookOpenIcon',
    //         },
    //         {
    //             title: 'Exceptions',
    //             route:{ name: 'Pointages-exception', params: { type: 'exception' } },
    //         },
    //         {
    //             title: 'Abscences',
    //             route:{ name: 'Pointages-abscence', params: { type: 'abscence' } },
    //         },
    //         {
    //             title: 'Ventilations',
    //             route:{ name: 'Ventilations', params: { type: 'abscence' } },
    //         },
    //     ],
    // },
    // {
    //     title: 'Rapports',
    //     route: 'Rapports',
    //     icon: 'ListIcon',
    // },
    {
        title: 'Listings',
        icon: 'FileTextIcon',
        children: [
            {
                title: 'Planifications',
                route: {name: 'Modelslistings', params: {type: 'brute'}},
            },
            {
                title: ' Déclaratif',
                route: {name: 'ListingsjoursManuel', params: {type: 'brute'}},
            },
            {
                title: ' Automatique',
                route: {name: 'ListingsjoursAutomatique', params: {type: 'brute'}},
            },
        ],
    },
    {
        title: 'Configurations',
        icon: 'FileTextIcon',
        children: [
            {
                title: 'Zones',
                route: {name: 'Zones', params: {type: 'brute'}},
            },
            {
                title: 'Sites',
                route: {name: 'Sites', params: {type: 'brute'}},
            },
            {
                title: 'Categories',
                route: {name: 'Categories', params: {type: 'brute'}},
            },
            {
                title: 'Nationalites',
                route: {name: 'Nationalites', params: {type: 'brute'}},
            },
            {
                title: 'Contrats',
                route: {name: 'Contrats', params: {type: 'brute'}},
            },
            {
                title: 'Villes',
                route: {name: 'Villes', params: {type: 'brute'}},
            },
            {
                title: 'Situations',
                route: {name: 'Situations', params: {type: 'brute'}},
            },
            {
                title: 'Pointeuses',
                route: {name: 'Pointeuses', params: {type: 'brute'}},
            },
            // {
            //     title: 'Variables',
            //     route: {name: 'Variables', params: {type: 'brute'}},
            // },
            // {
            //     title: 'Soldables',
            //     route: {name: 'Soldables', params: {type: 'brute'}},
            // },
        ],
    },
    {
        title: 'Les users',
        route: 'Users',
        icon: 'UserIcon',
    },
    {
        title: 'Securites',
        icon: 'FileTextIcon',
        children: [
            {
                title: 'Permissions',
                route: {name: 'Permissions', params: {type: 'brute'}},
            },
            {
                title: 'Logs',
                route: {name: 'Logs', params: {type: 'brute'}},
            },
            {
                title: 'Activite recente',
                route: 'Cruds',
                icon: 'UserIcon',
            },
        ],
    },
]
