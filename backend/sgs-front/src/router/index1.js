import Vue from 'vue'
import VueRouter from 'vue-router'
import { isUserLoggedIn, getUserData, getHomeRouteForLoggedInUser } from '@/auth/utils'
import { glob, globSync, globStream, globStreamSync, Glob } from 'glob'

Vue.use(VueRouter)
const router = new VueRouter({
mode: 'history',
base: process.env.BASE_URL,
scrollBehavior() {
return { x: 0, y: 0 }
},
routes: [

{
path: '/',
name: 'home',
component: () => import('@/views/Home.vue'),
meta: {
pageTitle: 'Home',
breadcrumb: [
{
text: 'Home',
active: true,
},
],
},
},
{
path: '/login',
name: 'login',
component: () => import('@/views/content/Logins/LoginsView.vue'),
meta: {
layout: 'full',
},
},
{
path: '/abscences',
name: 'abscences',
component: () => import('@/views/content/Abscences/AbscencesView.vue'),
meta: {
pageTitle: 'Abscences',
breadcrumb: [
{
text: 'Abscences',
active: true,
},
],
},
},
{
path: '/actions',
name: 'actions',
component: () => import('@/views/content/Actions/ActionsView.vue'),
meta: {
pageTitle: 'Actions',
breadcrumb: [
{
text: 'Actions',
active: true,
},
],
},
},
{
path: '/agentsrapports',
name: 'agentsrapports',
component: () => import('@/views/content/Agentsrapports/AgentsrapportsView.vue'),
meta: {
pageTitle: 'Agentsrapports',
breadcrumb: [
{
text: 'Agentsrapports',
active: true,
},
],
},
},
{
path: '/alarms',
name: 'alarms',
component: () => import('@/views/content/Alarms/AlarmsView.vue'),
meta: {
pageTitle: 'Alarms',
breadcrumb: [
{
text: 'Alarms',
active: true,
},
],
},
},
{
path: '/alldatas',
name: 'alldatas',
component: () => import('@/views/content/Alldatas/AlldatasView.vue'),
meta: {
pageTitle: 'Alldatas',
breadcrumb: [
{
text: 'Alldatas',
active: true,
},
],
},
},
{
path: '/analysespointeuses',
name: 'analysespointeuses',
component: () => import('@/views/content/Analysespointeuses/AnalysespointeusesView.vue'),
meta: {
pageTitle: 'Analysespointeuses',
breadcrumb: [
{
text: 'Analysespointeuses',
active: true,
},
],
},
},
{
path: '/approvisionementdetails',
name: 'approvisionementdetails',
component: () => import('@/views/content/Approvisionementdetails/ApprovisionementdetailsView.vue'),
meta: {
pageTitle: 'Approvisionementdetails',
breadcrumb: [
{
text: 'Approvisionementdetails',
active: true,
},
],
},
},
{
path: '/architectures',
name: 'architectures',
component: () => import('@/views/content/Architectures/ArchitecturesView.vue'),
meta: {
pageTitle: 'Architectures',
breadcrumb: [
{
text: 'Architectures',
active: true,
},
],
},
},
{
path: '/assignations',
name: 'assignations',
component: () => import('@/views/content/Assignations/AssignationsView.vue'),
meta: {
pageTitle: 'Assignations',
breadcrumb: [
{
text: 'Assignations',
active: true,
},
],
},
},
{
path: '/backends',
name: 'backends',
component: () => import('@/views/content/Backends/BackendsView.vue'),
meta: {
pageTitle: 'Backends',
breadcrumb: [
{
text: 'Backends',
active: true,
},
],
},
},
{
path: '/badges',
name: 'badges',
component: () => import('@/views/content/Badges/BadgesView.vue'),
meta: {
pageTitle: 'Badges',
breadcrumb: [
{
text: 'Badges',
active: true,
},
],
},
},
{
path: '/balises',
name: 'balises',
component: () => import('@/views/content/Balises/BalisesView.vue'),
meta: {
pageTitle: 'Balises',
breadcrumb: [
{
text: 'Balises',
active: true,
},
],
},
},
{
path: '/basesdedonnees',
name: 'basesdedonnees',
component: () => import('@/views/content/Basesdedonnees/BasesdedonneesView.vue'),
meta: {
pageTitle: 'Basesdedonnees',
breadcrumb: [
{
text: 'Basesdedonnees',
active: true,
},
],
},
},
{
path: '/besoinsfonctionels',
name: 'besoinsfonctionels',
component: () => import('@/views/content/Besoinsfonctionels/BesoinsfonctionelsView.vue'),
meta: {
pageTitle: 'Besoinsfonctionels',
breadcrumb: [
{
text: 'Besoinsfonctionels',
active: true,
},
],
},
},
{
path: '/besoinstechniques',
name: 'besoinstechniques',
component: () => import('@/views/content/Besoinstechniques/BesoinstechniquesView.vue'),
meta: {
pageTitle: 'Besoinstechniques',
breadcrumb: [
{
text: 'Besoinstechniques',
active: true,
},
],
},
},
{
path: '/cartes',
name: 'cartes',
component: () => import('@/views/content/Cartes/CartesView.vue'),
meta: {
pageTitle: 'Cartes',
breadcrumb: [
{
text: 'Cartes',
active: true,
},
],
},
},
{
path: '/categories',
name: 'categories',
component: () => import('@/views/content/Categories/CategoriesView.vue'),
meta: {
pageTitle: 'Categories',
breadcrumb: [
{
text: 'Categories',
active: true,
},
],
},
},
{
path: '/clients',
name: 'clients',
component: () => import('@/views/content/Clients/ClientsView.vue'),
meta: {
pageTitle: 'Clients',
breadcrumb: [
{
text: 'Clients',
active: true,
},
],
},
},
{
path: '/configurations',
name: 'configurations',
component: () => import('@/views/content/Configurations/ConfigurationsView.vue'),
meta: {
pageTitle: 'Configurations',
breadcrumb: [
{
text: 'Configurations',
active: true,
},
],
},
},
{
path: '/conges',
name: 'conges',
component: () => import('@/views/content/Conges/CongesView.vue'),
meta: {
pageTitle: 'Conges',
breadcrumb: [
{
text: 'Conges',
active: true,
},
],
},
},
{
path: '/contrats',
name: 'contrats',
component: () => import('@/views/content/Contrats/ContratsView.vue'),
meta: {
pageTitle: 'Contrats',
breadcrumb: [
{
text: 'Contrats',
active: true,
},
],
},
},
{
path: '/contratsclients',
name: 'contratsclients',
component: () => import('@/views/content/Contratsclients/ContratsclientsView.vue'),
meta: {
pageTitle: 'Contratsclients',
breadcrumb: [
{
text: 'Contratsclients',
active: true,
},
],
},
},
{
path: '/contributions',
name: 'contributions',
component: () => import('@/views/content/Contributions/ContributionsView.vue'),
meta: {
pageTitle: 'Contributions',
breadcrumb: [
{
text: 'Contributions',
active: true,
},
],
},
},
{
path: '/controlleursacces',
name: 'controlleursacces',
component: () => import('@/views/content/Controlleursacces/ControlleursaccesView.vue'),
meta: {
pageTitle: 'Controlleursacces',
breadcrumb: [
{
text: 'Controlleursacces',
active: true,
},
],
},
},
{
path: '/credits',
name: 'credits',
component: () => import('@/views/content/Credits/CreditsView.vue'),
meta: {
pageTitle: 'Credits',
breadcrumb: [
{
text: 'Credits',
active: true,
},
],
},
},
{
path: '/cruds',
name: 'cruds',
component: () => import('@/views/content/Cruds/CrudsView.vue'),
meta: {
pageTitle: 'Cruds',
breadcrumb: [
{
text: 'Cruds',
active: true,
},
],
},
},
{
path: '/debits',
name: 'debits',
component: () => import('@/views/content/Debits/DebitsView.vue'),
meta: {
pageTitle: 'Debits',
breadcrumb: [
{
text: 'Debits',
active: true,
},
],
},
},
{
path: '/dependances',
name: 'dependances',
component: () => import('@/views/content/Dependances/DependancesView.vue'),
meta: {
pageTitle: 'Dependances',
breadcrumb: [
{
text: 'Dependances',
active: true,
},
],
},
},
{
path: '/deplacements',
name: 'deplacements',
component: () => import('@/views/content/Deplacements/DeplacementsView.vue'),
meta: {
pageTitle: 'Deplacements',
breadcrumb: [
{
text: 'Deplacements',
active: true,
},
],
},
},
{
path: '/deploiementspointeusesmoyenstransports',
name: 'deploiementspointeusesmoyenstransports',
component: () => import('@/views/content/Deploiementspointeusesmoyenstransports/DeploiementspointeusesmoyenstransportsView.vue'),
meta: {
pageTitle: 'Deploiementspointeusesmoyenstransports',
breadcrumb: [
{
text: 'Deploiementspointeusesmoyenstransports',
active: true,
},
],
},
},
{
path: '/deploiments',
name: 'deploiments',
component: () => import('@/views/content/Deploiments/DeploimentsView.vue'),
meta: {
pageTitle: 'Deploiments',
breadcrumb: [
{
text: 'Deploiments',
active: true,
},
],
},
},
{
path: '/directions',
name: 'directions',
component: () => import('@/views/content/Directions/DirectionsView.vue'),
meta: {
pageTitle: 'Directions',
breadcrumb: [
{
text: 'Directions',
active: true,
},
],
},
},
{
path: '/echelons',
name: 'echelons',
component: () => import('@/views/content/Echelons/EchelonsView.vue'),
meta: {
pageTitle: 'Echelons',
breadcrumb: [
{
text: 'Echelons',
active: true,
},
],
},
},
{
path: '/entreprises',
name: 'entreprises',
component: () => import('@/views/content/Entreprises/EntreprisesView.vue'),
meta: {
pageTitle: 'Entreprises',
breadcrumb: [
{
text: 'Entreprises',
active: true,
},
],
},
},
{
path: '/etapes',
name: 'etapes',
component: () => import('@/views/content/Etapes/EtapesView.vue'),
meta: {
pageTitle: 'Etapes',
breadcrumb: [
{
text: 'Etapes',
active: true,
},
],
},
},
{
path: '/exports',
name: 'exports',
component: () => import('@/views/content/Exports/ExportsView.vue'),
meta: {
pageTitle: 'Exports',
breadcrumb: [
{
text: 'Exports',
active: true,
},
],
},
},
{
path: '/exportsdetails',
name: 'exportsdetails',
component: () => import('@/views/content/Exportsdetails/ExportsdetailsView.vue'),
meta: {
pageTitle: 'Exportsdetails',
breadcrumb: [
{
text: 'Exportsdetails',
active: true,
},
],
},
},
{
path: '/extrasdatas',
name: 'extrasdatas',
component: () => import('@/views/content/Extrasdatas/ExtrasdatasView.vue'),
meta: {
pageTitle: 'Extrasdatas',
breadcrumb: [
{
text: 'Extrasdatas',
active: true,
},
],
},
},
{
path: '/files',
name: 'files',
component: () => import('@/views/content/Files/FilesView.vue'),
meta: {
pageTitle: 'Files',
breadcrumb: [
{
text: 'Files',
active: true,
},
],
},
},
{
path: '/fonctions',
name: 'fonctions',
component: () => import('@/views/content/Fonctions/FonctionsView.vue'),
meta: {
pageTitle: 'Fonctions',
breadcrumb: [
{
text: 'Fonctions',
active: true,
},
],
},
},
{
path: '/graphiques',
name: 'graphiques',
component: () => import('@/views/content/Graphiques/GraphiquesView.vue'),
meta: {
pageTitle: 'Graphiques',
breadcrumb: [
{
text: 'Graphiques',
active: true,
},
],
},
},
{
path: '/groupedirections',
name: 'groupedirections',
component: () => import('@/views/content/Groupedirections/GroupedirectionsView.vue'),
meta: {
pageTitle: 'Groupedirections',
breadcrumb: [
{
text: 'Groupedirections',
active: true,
},
],
},
},
{
path: '/groupepermissions',
name: 'groupepermissions',
component: () => import('@/views/content/Groupepermissions/GroupepermissionsView.vue'),
meta: {
pageTitle: 'Groupepermissions',
breadcrumb: [
{
text: 'Groupepermissions',
active: true,
},
],
},
},
{
path: '/headselements',
name: 'headselements',
component: () => import('@/views/content/Headselements/HeadselementsView.vue'),
meta: {
pageTitle: 'Headselements',
breadcrumb: [
{
text: 'Headselements',
active: true,
},
],
},
},
{
path: '/historiquemodelslistings',
name: 'historiquemodelslistings',
component: () => import('@/views/content/Historiquemodelslistings/HistoriquemodelslistingsView.vue'),
meta: {
pageTitle: 'Historiquemodelslistings',
breadcrumb: [
{
text: 'Historiquemodelslistings',
active: true,
},
],
},
},
{
path: '/historiques',
name: 'historiques',
component: () => import('@/views/content/Historiques/HistoriquesView.vue'),
meta: {
pageTitle: 'Historiques',
breadcrumb: [
{
text: 'Historiques',
active: true,
},
],
},
},
{
path: '/homes',
name: 'homes',
component: () => import('@/views/content/Homes/HomesView.vue'),
meta: {
pageTitle: 'Homes',
breadcrumb: [
{
text: 'Homes',
active: true,
},
],
},
},
{
path: '/homezones',
name: 'homezones',
component: () => import('@/views/content/Homezones/HomezonesView.vue'),
meta: {
pageTitle: 'Homezones',
breadcrumb: [
{
text: 'Homezones',
active: true,
},
],
},
},
{
path: '/horaireagents',
name: 'horaireagents',
component: () => import('@/views/content/Horaireagents/HoraireagentsView.vue'),
meta: {
pageTitle: 'Horaireagents',
breadcrumb: [
{
text: 'Horaireagents',
active: true,
},
],
},
},
{
path: '/horaires',
name: 'horaires',
component: () => import('@/views/content/Horaires/HorairesView.vue'),
meta: {
pageTitle: 'Horaires',
breadcrumb: [
{
text: 'Horaires',
active: true,
},
],
},
},
{
path: '/horairesglobalspostes',
name: 'horairesglobalspostes',
component: () => import('@/views/content/Horairesglobalspostes/HorairesglobalspostesView.vue'),
meta: {
pageTitle: 'Horairesglobalspostes',
breadcrumb: [
{
text: 'Horairesglobalspostes',
active: true,
},
],
},
},
{
path: '/horairestypespostes',
name: 'horairestypespostes',
component: () => import('@/views/content/Horairestypespostes/HorairestypespostesView.vue'),
meta: {
pageTitle: 'Horairestypespostes',
breadcrumb: [
{
text: 'Horairestypespostes',
active: true,
},
],
},
},
{
path: '/horairestypessites',
name: 'horairestypessites',
component: () => import('@/views/content/Horairestypessites/HorairestypessitesView.vue'),
meta: {
pageTitle: 'Horairestypessites',
breadcrumb: [
{
text: 'Horairestypessites',
active: true,
},
],
},
},
{
path: '/identifications',
name: 'identifications',
component: () => import('@/views/content/Identifications/IdentificationsView.vue'),
meta: {
pageTitle: 'Identifications',
breadcrumb: [
{
text: 'Identifications',
active: true,
},
],
},
},
{
path: '/imports',
name: 'imports',
component: () => import('@/views/content/Imports/ImportsView.vue'),
meta: {
pageTitle: 'Imports',
breadcrumb: [
{
text: 'Imports',
active: true,
},
],
},
},
{
path: '/initialisations',
name: 'initialisations',
component: () => import('@/views/content/Initialisations/InitialisationsView.vue'),
meta: {
pageTitle: 'Initialisations',
breadcrumb: [
{
text: 'Initialisations',
active: true,
},
],
},
},
{
path: '/introductions',
name: 'introductions',
component: () => import('@/views/content/Introductions/IntroductionsView.vue'),
meta: {
pageTitle: 'Introductions',
breadcrumb: [
{
text: 'Introductions',
active: true,
},
],
},
},
{
path: '/jobs',
name: 'jobs',
component: () => import('@/views/content/Jobs/JobsView.vue'),
meta: {
pageTitle: 'Jobs',
breadcrumb: [
{
text: 'Jobs',
active: true,
},
],
},
},
{
path: '/joursferies',
name: 'joursferies',
component: () => import('@/views/content/Joursferies/JoursferiesView.vue'),
meta: {
pageTitle: 'Joursferies',
breadcrumb: [
{
text: 'Joursferies',
active: true,
},
],
},
},
{
path: '/lignes',
name: 'lignes',
component: () => import('@/views/content/Lignes/LignesView.vue'),
meta: {
pageTitle: 'Lignes',
breadcrumb: [
{
text: 'Lignes',
active: true,
},
],
},
},
{
path: '/lignesmoyenstransports',
name: 'lignesmoyenstransports',
component: () => import('@/views/content/Lignesmoyenstransports/LignesmoyenstransportsView.vue'),
meta: {
pageTitle: 'Lignesmoyenstransports',
breadcrumb: [
{
text: 'Lignesmoyenstransports',
active: true,
},
],
},
},
{
path: '/listesjours',
name: 'listesjours',
component: () => import('@/views/content/Listesjours/ListesjoursView.vue'),
meta: {
pageTitle: 'Listesjours',
breadcrumb: [
{
text: 'Listesjours',
active: true,
},
],
},
},
{
path: '/listingsetats',
name: 'listingsetats',
component: () => import('@/views/content/Listingsetats/ListingsetatsView.vue'),
meta: {
pageTitle: 'Listingsetats',
breadcrumb: [
{
text: 'Listingsetats',
active: true,
},
],
},
},
{
path: '/logins',
name: 'logins',
component: () => import('@/views/content/Logins/LoginsView.vue'),
meta: {
pageTitle: 'Logins',
breadcrumb: [
{
text: 'Logins',
active: true,
},
],
},
},
{
path: '/logs',
name: 'logs',
component: () => import('@/views/content/Logs/LogsView.vue'),
meta: {
pageTitle: 'Logs',
breadcrumb: [
{
text: 'Logs',
active: true,
},
],
},
},
{
path: '/matrimoniales',
name: 'matrimoniales',
component: () => import('@/views/content/Matrimoniales/MatrimonialesView.vue'),
meta: {
pageTitle: 'Matrimoniales',
breadcrumb: [
{
text: 'Matrimoniales',
active: true,
},
],
},
},
{
path: '/menus',
name: 'menus',
component: () => import('@/views/content/Menus/MenusView.vue'),
meta: {
pageTitle: 'Menus',
breadcrumb: [
{
text: 'Menus',
active: true,
},
],
},
},
{
path: '/model_has_permissions',
name: 'model_has_permissions',
component: () => import('@/views/content/Model_has_permissions/Model_has_permissionsView.vue'),
meta: {
pageTitle: 'Model_has_permissions',
breadcrumb: [
{
text: 'Model_has_permissions',
active: true,
},
],
},
},
{
path: '/modelslistings',
name: 'modelslistings',
component: () => import('@/views/content/Modelslistings/ModelslistingsView.vue'),
meta: {
pageTitle: 'Modelslistings',
breadcrumb: [
{
text: 'Modelslistings',
active: true,
},
],
},
},
{
path: '/moyenstransports',
name: 'moyenstransports',
component: () => import('@/views/content/Moyenstransports/MoyenstransportsView.vue'),
meta: {
pageTitle: 'Moyenstransports',
breadcrumb: [
{
text: 'Moyenstransports',
active: true,
},
],
},
},
{
path: '/nationalites',
name: 'nationalites',
component: () => import('@/views/content/Nationalites/NationalitesView.vue'),
meta: {
pageTitle: 'Nationalites',
breadcrumb: [
{
text: 'Nationalites',
active: true,
},
],
},
},
{
path: '/oauth_access_tokens',
name: 'oauth_access_tokens',
component: () => import('@/views/content/Oauth_access_tokens/Oauth_access_tokensView.vue'),
meta: {
pageTitle: 'Oauth_access_tokens',
breadcrumb: [
{
text: 'Oauth_access_tokens',
active: true,
},
],
},
},
{
path: '/oauth_auth_codes',
name: 'oauth_auth_codes',
component: () => import('@/views/content/Oauth_auth_codes/Oauth_auth_codesView.vue'),
meta: {
pageTitle: 'Oauth_auth_codes',
breadcrumb: [
{
text: 'Oauth_auth_codes',
active: true,
},
],
},
},
{
path: '/oauth_clients',
name: 'oauth_clients',
component: () => import('@/views/content/Oauth_clients/Oauth_clientsView.vue'),
meta: {
pageTitle: 'Oauth_clients',
breadcrumb: [
{
text: 'Oauth_clients',
active: true,
},
],
},
},
{
path: '/oauth_personal_access_clients',
name: 'oauth_personal_access_clients',
component: () => import('@/views/content/Oauth_personal_access_clients/Oauth_personal_access_clientsView.vue'),
meta: {
pageTitle: 'Oauth_personal_access_clients',
breadcrumb: [
{
text: 'Oauth_personal_access_clients',
active: true,
},
],
},
},
{
path: '/oauth_refresh_tokens',
name: 'oauth_refresh_tokens',
component: () => import('@/views/content/Oauth_refresh_tokens/Oauth_refresh_tokensView.vue'),
meta: {
pageTitle: 'Oauth_refresh_tokens',
breadcrumb: [
{
text: 'Oauth_refresh_tokens',
active: true,
},
],
},
},
{
path: '/passagesrondes',
name: 'passagesrondes',
component: () => import('@/views/content/Passagesrondes/PassagesrondesView.vue'),
meta: {
pageTitle: 'Passagesrondes',
breadcrumb: [
{
text: 'Passagesrondes',
active: true,
},
],
},
},
{
path: '/pastilles',
name: 'pastilles',
component: () => import('@/views/content/Pastilles/PastillesView.vue'),
meta: {
pageTitle: 'Pastilles',
breadcrumb: [
{
text: 'Pastilles',
active: true,
},
],
},
},
{
path: '/permissions',
name: 'permissions',
component: () => import('@/views/content/Permissions/PermissionsView.vue'),
meta: {
pageTitle: 'Permissions',
breadcrumb: [
{
text: 'Permissions',
active: true,
},
],
},
},
{
path: '/perms',
name: 'perms',
component: () => import('@/views/content/Perms/PermsView.vue'),
meta: {
pageTitle: 'Perms',
breadcrumb: [
{
text: 'Perms',
active: true,
},
],
},
},
{
path: '/pointages',
name: 'pointages',
component: () => import('@/views/content/Pointages/PointagesView.vue'),
meta: {
pageTitle: 'Pointages',
breadcrumb: [
{
text: 'Pointages',
active: true,
},
],
},
},
{
path: '/pointeuses',
name: 'pointeuses',
component: () => import('@/views/content/Pointeuses/PointeusesView.vue'),
meta: {
pageTitle: 'Pointeuses',
breadcrumb: [
{
text: 'Pointeuses',
active: true,
},
],
},
},
{
path: '/pointeusestransactions',
name: 'pointeusestransactions',
component: () => import('@/views/content/Pointeusestransactions/PointeusestransactionsView.vue'),
meta: {
pageTitle: 'Pointeusestransactions',
breadcrumb: [
{
text: 'Pointeusestransactions',
active: true,
},
],
},
},
{
path: '/points',
name: 'points',
component: () => import('@/views/content/Points/PointsView.vue'),
meta: {
pageTitle: 'Points',
breadcrumb: [
{
text: 'Points',
active: true,
},
],
},
},
{
path: '/positions',
name: 'positions',
component: () => import('@/views/content/Positions/PositionsView.vue'),
meta: {
pageTitle: 'Positions',
breadcrumb: [
{
text: 'Positions',
active: true,
},
],
},
},
{
path: '/postes',
name: 'postes',
component: () => import('@/views/content/Postes/PostesView.vue'),
meta: {
pageTitle: 'Postes',
breadcrumb: [
{
text: 'Postes',
active: true,
},
],
},
},
{
path: '/postesarticles',
name: 'postesarticles',
component: () => import('@/views/content/Postesarticles/PostesarticlesView.vue'),
meta: {
pageTitle: 'Postesarticles',
breadcrumb: [
{
text: 'Postesarticles',
active: true,
},
],
},
},
{
path: '/postespointeuses',
name: 'postespointeuses',
component: () => import('@/views/content/Postespointeuses/PostespointeusesView.vue'),
meta: {
pageTitle: 'Postespointeuses',
breadcrumb: [
{
text: 'Postespointeuses',
active: true,
},
],
},
},
{
path: '/presences',
name: 'presences',
component: () => import('@/views/content/Presences/PresencesView.vue'),
meta: {
pageTitle: 'Presences',
breadcrumb: [
{
text: 'Presences',
active: true,
},
],
},
},
{
path: '/preuves',
name: 'preuves',
component: () => import('@/views/content/Preuves/PreuvesView.vue'),
meta: {
pageTitle: 'Preuves',
breadcrumb: [
{
text: 'Preuves',
active: true,
},
],
},
},
{
path: '/programmations',
name: 'programmations',
component: () => import('@/views/content/Programmations/ProgrammationsView.vue'),
meta: {
pageTitle: 'Programmations',
breadcrumb: [
{
text: 'Programmations',
active: true,
},
],
},
},
{
path: '/programmationsdetails',
name: 'programmationsdetails',
component: () => import('@/views/content/Programmationsdetails/ProgrammationsdetailsView.vue'),
meta: {
pageTitle: 'Programmationsdetails',
breadcrumb: [
{
text: 'Programmationsdetails',
active: true,
},
],
},
},
{
path: '/programmes',
name: 'programmes',
component: () => import('@/views/content/Programmes/ProgrammesView.vue'),
meta: {
pageTitle: 'Programmes',
breadcrumb: [
{
text: 'Programmes',
active: true,
},
],
},
},
{
path: '/projets',
name: 'projets',
component: () => import('@/views/content/Projets/ProjetsView.vue'),
meta: {
pageTitle: 'Projets',
breadcrumb: [
{
text: 'Projets',
active: true,
},
],
},
},
{
path: '/provinces',
name: 'provinces',
component: () => import('@/views/content/Provinces/ProvincesView.vue'),
meta: {
pageTitle: 'Provinces',
breadcrumb: [
{
text: 'Provinces',
active: true,
},
],
},
},
{
path: '/rapportpostes',
name: 'rapportpostes',
component: () => import('@/views/content/Rapportpostes/RapportpostesView.vue'),
meta: {
pageTitle: 'Rapportpostes',
breadcrumb: [
{
text: 'Rapportpostes',
active: true,
},
],
},
},
{
path: '/rapports',
name: 'rapports',
component: () => import('@/views/content/Rapports/RapportsView.vue'),
meta: {
pageTitle: 'Rapports',
breadcrumb: [
{
text: 'Rapports',
active: true,
},
],
},
},
{
path: '/role_has_permission',
name: 'role_has_permission',
component: () => import('@/views/content/Role_has_permission/Role_has_permissionView.vue'),
meta: {
pageTitle: 'Role_has_permission',
breadcrumb: [
{
text: 'Role_has_permission',
active: true,
},
],
},
},
{
path: '/role_has_permissions',
name: 'role_has_permissions',
component: () => import('@/views/content/Role_has_permissions/Role_has_permissionsView.vue'),
meta: {
pageTitle: 'Role_has_permissions',
breadcrumb: [
{
text: 'Role_has_permissions',
active: true,
},
],
},
},
{
path: '/roles',
name: 'roles',
component: () => import('@/views/content/Roles/RolesView.vue'),
meta: {
pageTitle: 'Roles',
breadcrumb: [
{
text: 'Roles',
active: true,
},
],
},
},
{
path: '/services',
name: 'services',
component: () => import('@/views/content/Services/ServicesView.vue'),
meta: {
pageTitle: 'Services',
breadcrumb: [
{
text: 'Services',
active: true,
},
],
},
},
{
path: '/sexes',
name: 'sexes',
component: () => import('@/views/content/Sexes/SexesView.vue'),
meta: {
pageTitle: 'Sexes',
breadcrumb: [
{
text: 'Sexes',
active: true,
},
],
},
},
{
path: '/sites',
name: 'sites',
component: () => import('@/views/content/Sites/SitesView.vue'),
meta: {
pageTitle: 'Sites',
breadcrumb: [
{
text: 'Sites',
active: true,
},
],
},
},
{
path: '/sitespointeuses',
name: 'sitespointeuses',
component: () => import('@/views/content/Sitespointeuses/SitespointeusesView.vue'),
meta: {
pageTitle: 'Sitespointeuses',
breadcrumb: [
{
text: 'Sitespointeuses',
active: true,
},
],
},
},
{
path: '/sitessdeplacements',
name: 'sitessdeplacements',
component: () => import('@/views/content/Sitessdeplacements/SitessdeplacementsView.vue'),
meta: {
pageTitle: 'Sitessdeplacements',
breadcrumb: [
{
text: 'Sitessdeplacements',
active: true,
},
],
},
},
{
path: '/situations',
name: 'situations',
component: () => import('@/views/content/Situations/SituationsView.vue'),
meta: {
pageTitle: 'Situations',
breadcrumb: [
{
text: 'Situations',
active: true,
},
],
},
},
{
path: '/soldables',
name: 'soldables',
component: () => import('@/views/content/Soldables/SoldablesView.vue'),
meta: {
pageTitle: 'Soldables',
breadcrumb: [
{
text: 'Soldables',
active: true,
},
],
},
},
{
path: '/statszones',
name: 'statszones',
component: () => import('@/views/content/Statszones/StatszonesView.vue'),
meta: {
pageTitle: 'Statszones',
breadcrumb: [
{
text: 'Statszones',
active: true,
},
],
},
},
{
path: '/structures',
name: 'structures',
component: () => import('@/views/content/Structures/StructuresView.vue'),
meta: {
pageTitle: 'Structures',
breadcrumb: [
{
text: 'Structures',
active: true,
},
],
},
},
{
path: '/surveillances',
name: 'surveillances',
component: () => import('@/views/content/Surveillances/SurveillancesView.vue'),
meta: {
pageTitle: 'Surveillances',
breadcrumb: [
{
text: 'Surveillances',
active: true,
},
],
},
},
{
path: '/switchsusers',
name: 'switchsusers',
component: () => import('@/views/content/Switchsusers/SwitchsusersView.vue'),
meta: {
pageTitle: 'Switchsusers',
breadcrumb: [
{
text: 'Switchsusers',
active: true,
},
],
},
},
{
path: '/technologies',
name: 'technologies',
component: () => import('@/views/content/Technologies/TechnologiesView.vue'),
meta: {
pageTitle: 'Technologies',
breadcrumb: [
{
text: 'Technologies',
active: true,
},
],
},
},
{
path: '/terminals',
name: 'terminals',
component: () => import('@/views/content/Terminals/TerminalsView.vue'),
meta: {
pageTitle: 'Terminals',
breadcrumb: [
{
text: 'Terminals',
active: true,
},
],
},
},
{
path: '/trackings',
name: 'trackings',
component: () => import('@/views/content/Trackings/TrackingsView.vue'),
meta: {
pageTitle: 'Trackings',
breadcrumb: [
{
text: 'Trackings',
active: true,
},
],
},
},
{
path: '/traitements',
name: 'traitements',
component: () => import('@/views/content/Traitements/TraitementsView.vue'),
meta: {
pageTitle: 'Traitements',
breadcrumb: [
{
text: 'Traitements',
active: true,
},
],
},
},
{
path: '/trajets',
name: 'trajets',
component: () => import('@/views/content/Trajets/TrajetsView.vue'),
meta: {
pageTitle: 'Trajets',
breadcrumb: [
{
text: 'Trajets',
active: true,
},
],
},
},
{
path: '/transactions',
name: 'transactions',
component: () => import('@/views/content/Transactions/TransactionsView.vue'),
meta: {
pageTitle: 'Transactions',
breadcrumb: [
{
text: 'Transactions',
active: true,
},
],
},
},
{
path: '/types',
name: 'types',
component: () => import('@/views/content/Types/TypesView.vue'),
meta: {
pageTitle: 'Types',
breadcrumb: [
{
text: 'Types',
active: true,
},
],
},
},
{
path: '/typesabscences',
name: 'typesabscences',
component: () => import('@/views/content/Typesabscences/TypesabscencesView.vue'),
meta: {
pageTitle: 'Typesabscences',
breadcrumb: [
{
text: 'Typesabscences',
active: true,
},
],
},
},
{
path: '/typesagentshoraires',
name: 'typesagentshoraires',
component: () => import('@/views/content/Typesagentshoraires/TypesagentshorairesView.vue'),
meta: {
pageTitle: 'Typesagentshoraires',
breadcrumb: [
{
text: 'Typesagentshoraires',
active: true,
},
],
},
},
{
path: '/typeseffectifs',
name: 'typeseffectifs',
component: () => import('@/views/content/Typeseffectifs/TypeseffectifsView.vue'),
meta: {
pageTitle: 'Typeseffectifs',
breadcrumb: [
{
text: 'Typeseffectifs',
active: true,
},
],
},
},
{
path: '/typesheures',
name: 'typesheures',
component: () => import('@/views/content/Typesheures/TypesheuresView.vue'),
meta: {
pageTitle: 'Typesheures',
breadcrumb: [
{
text: 'Typesheures',
active: true,
},
],
},
},
{
path: '/typesmoyenstransports',
name: 'typesmoyenstransports',
component: () => import('@/views/content/Typesmoyenstransports/TypesmoyenstransportsView.vue'),
meta: {
pageTitle: 'Typesmoyenstransports',
breadcrumb: [
{
text: 'Typesmoyenstransports',
active: true,
},
],
},
},
{
path: '/typespointages',
name: 'typespointages',
component: () => import('@/views/content/Typespointages/TypespointagesView.vue'),
meta: {
pageTitle: 'Typespointages',
breadcrumb: [
{
text: 'Typespointages',
active: true,
},
],
},
},
{
path: '/typespostes',
name: 'typespostes',
component: () => import('@/views/content/Typespostes/TypespostesView.vue'),
meta: {
pageTitle: 'Typespostes',
breadcrumb: [
{
text: 'Typespostes',
active: true,
},
],
},
},
{
path: '/typessites',
name: 'typessites',
component: () => import('@/views/content/Typessites/TypessitesView.vue'),
meta: {
pageTitle: 'Typessites',
breadcrumb: [
{
text: 'Typessites',
active: true,
},
],
},
},
{
path: '/typesventilations',
name: 'typesventilations',
component: () => import('@/views/content/Typesventilations/TypesventilationsView.vue'),
meta: {
pageTitle: 'Typesventilations',
breadcrumb: [
{
text: 'Typesventilations',
active: true,
},
],
},
},
{
path: '/users',
name: 'users',
component: () => import('@/views/content/Users/UsersView.vue'),
meta: {
pageTitle: 'Users',
breadcrumb: [
{
text: 'Users',
active: true,
},
],
},
},
{
path: '/userszones',
name: 'userszones',
component: () => import('@/views/content/Userszones/UserszonesView.vue'),
meta: {
pageTitle: 'Userszones',
breadcrumb: [
{
text: 'Userszones',
active: true,
},
],
},
},
{
path: '/vacationspostes',
name: 'vacationspostes',
component: () => import('@/views/content/Vacationspostes/VacationspostesView.vue'),
meta: {
pageTitle: 'Vacationspostes',
breadcrumb: [
{
text: 'Vacationspostes',
active: true,
},
],
},
},
{
path: '/validations',
name: 'validations',
component: () => import('@/views/content/Validations/ValidationsView.vue'),
meta: {
pageTitle: 'Validations',
breadcrumb: [
{
text: 'Validations',
active: true,
},
],
},
},
{
path: '/variables',
name: 'variables',
component: () => import('@/views/content/Variables/VariablesView.vue'),
meta: {
pageTitle: 'Variables',
breadcrumb: [
{
text: 'Variables',
active: true,
},
],
},
},
{
path: '/vehicules',
name: 'vehicules',
component: () => import('@/views/content/Vehicules/VehiculesView.vue'),
meta: {
pageTitle: 'Vehicules',
breadcrumb: [
{
text: 'Vehicules',
active: true,
},
],
},
},
{
path: '/ventilations',
name: 'ventilations',
component: () => import('@/views/content/Ventilations/VentilationsView.vue'),
meta: {
pageTitle: 'Ventilations',
breadcrumb: [
{
text: 'Ventilations',
active: true,
},
],
},
},
{
path: '/villes',
name: 'villes',
component: () => import('@/views/content/Villes/VillesView.vue'),
meta: {
pageTitle: 'Villes',
breadcrumb: [
{
text: 'Villes',
active: true,
},
],
},
},
{
path: '/villeszones',
name: 'villeszones',
component: () => import('@/views/content/Villeszones/VilleszonesView.vue'),
meta: {
pageTitle: 'Villeszones',
breadcrumb: [
{
text: 'Villeszones',
active: true,
},
],
},
},
{
path: '/websockets_statistics_entries',
name: 'websockets_statistics_entries',
component: () => import('@/views/content/Websockets_statistics_entries/Websockets_statistics_entriesView.vue'),
meta: {
pageTitle: 'Websockets_statistics_entries',
breadcrumb: [
{
text: 'Websockets_statistics_entries',
active: true,
},
],
},
},
{
path: '/works',
name: 'works',
component: () => import('@/views/content/Works/WorksView.vue'),
meta: {
pageTitle: 'Works',
breadcrumb: [
{
text: 'Works',
active: true,
},
],
},
},
{
path: '/zones',
name: 'zones',
component: () => import('@/views/content/Zones/ZonesView.vue'),
meta: {
pageTitle: 'Zones',
breadcrumb: [
{
text: 'Zones',
active: true,
},
],
},
},

],
})


router.beforeEach((to, _, next) => {
const userData = getUserData()
let attributes=Object.keys(userData)
let isAuth=attributes.includes('token') && attributes.includes('verification') && attributes['verification']
if( !isAuth && to.name!='login'){
return next({ name: 'login' })
}

console.log('verification ',isAuth,to)
return next()

})

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
console.log('Router init')
// Remove initial loading
const appLoading = document.getElementById('loading-bg')
if (appLoading) {
appLoading.style.display = 'none'
}
})

export default router
