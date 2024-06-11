<template>
    <div class="row col-sm-12" style="display: flex;justify-content: space-around">
        <div class="col-sm-12 card">
            <div class="card-body" style="display: flex;flex-wrap: wrap;gap:10px">

                <span v-b-tooltip.hover :style="actualPage == 'Villes' ? 'border: 3px solid  green' : ''"
                      class="pageTitre"
                      style="" @click.prevent="togglePage('Villes')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> Villes
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Zones' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Zones')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Zones </span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Typesites' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Typesites')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Type site</span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Sites' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Sites')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Sites </span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Directions' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style="" @click.prevent="togglePage('Directions')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> Directions
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Services' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style="" @click.prevent="togglePage('Services')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> Services
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Fonctions' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style="" @click.prevent="togglePage('Fonctions')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Fonctions </span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Categories' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Categories')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Categories </span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Contrats' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style="" @click.prevent="togglePage('Contrats')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> Contrats
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Nationalites' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style="" @click.prevent="togglePage('Nationalites')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Nationalites </span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Situations' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Situations')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Situations </span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Cartes' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Cartes')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Cartes </span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Typesabscences' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style="" @click.prevent="togglePage('Typesabscences')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> Types abscences
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Typeseffectifs' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Typeseffectifs')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Type effectifs</span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Typespostes' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Typespostes')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Type postes</span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Typesheures' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Typesheures')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Type heures</span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Typespointages' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Typespointages')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Type pointages</span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Typesventilations' ? 'border:3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Typesventilations')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Type ventilations</span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Typesagentshoraires' ? 'border:3px solid  green' : ''"
                      class="pageTitre"
                      style=""
                      @click.prevent="togglePage('Typesagentshoraires')">
                    <div class="">

                        <span> <i class="fa-solid fa-filter"></i> Type agentshoraires</span>

                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Joursferies' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style="" @click.prevent="togglePage('Joursferies')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> jour ferie
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Clients' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Clients')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> Clients
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Clients_interne' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Clients_interne')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> Clients internes
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'imports' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('imports')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> imports agents
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'importspostes' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('importspostes')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> imports postes
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'importspointages' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('importspointages')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> imports pointages
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'typesmoyenstransport' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('typesmoyenstransport')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> type de transport
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'moyenstransport' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('moyenstransport')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> Moyens de transport
                        </span>
                    </div>
                </span>
                <span v-b-tooltip.hover :style="actualPage == 'Lignes' ? 'border: 3px solid  green' : ''"
                      class="pageTitre" style=""
                      @click.prevent="togglePage('Lignes')">
                    <div class="">
                        <span> <i class="fa-solid fa-filter"></i> Lignes
                        </span>
                    </div>
                </span>
            </div>

        </div>
        <div class="col-sm-12 card">
            <div class="card-body">
                <Zones v-if="actualPage == 'Zones'"/>
                <Directions v-if="actualPage == 'Directions'"/>
                <Sites v-if="actualPage == 'Sites'"/>
                <TypessitesView v-if="actualPage == 'Typesites'"/>
                <TypeseffectifsView v-if="actualPage == 'Typeseffectifs'"/>
                <TypespostesView v-if="actualPage == 'Typespostes'"/>
                <TypesheuresView v-if="actualPage == 'Typesheures'"/>
                <TypespointagesView v-if="actualPage == 'Typespointages'"/>
                <Services v-if="actualPage == 'Services'"/>
                <Fonctions v-if="actualPage == 'Fonctions'"/>
                <Categories v-if="actualPage == 'Categories'"/>
                <Joursferies v-if="actualPage == 'Joursferies'"/>
                <Contrats v-if="actualPage == 'Contrats'"/>
                <Nationalites v-if="actualPage == 'Nationalites'"/>
                <Villes v-if="actualPage == 'Villes'"/>
                <Situations v-if="actualPage == 'Situations'"/>
                <Typestaches v-if="actualPage == 'Typestaches'"/>
                <Typesabscences v-if="actualPage == 'Typesabscences'"/>
                <TypesventilationsView v-if="actualPage == 'Typesventilations'"/>
                <TypesagentshorairesView v-if="actualPage == 'Typesagentshoraires'"/>
                <Clients v-if="actualPage == 'Clients'" :type="type"/>
                <Clients v-if="actualPage == 'Clients_interne'" :type="type"/>
                <ImportsView v-if="actualPage == 'imports'"/>
                <ImportsView v-if="actualPage == 'importspostes'" :type="type"/>
                <ImportsView v-if="actualPage == 'importspointages'" :type="type"/>
                <TypesmoyenstransportsView v-if="actualPage == 'typesmoyenstransport'"/>
                <MoyenstransportsView v-if="actualPage == 'moyenstransport'"/>
                <CartesView v-if="actualPage == 'Cartes'"/>
                <LignesView v-if="actualPage == 'Lignes'"/>
            </div>
        </div>


    </div>
</template>
<script>
import AgGridTable from "@/components/AgGridTable.vue"
import DataModal from '@/components/DataModal.vue'
import Directions from '../Directions/DirectionsView.vue'
import Sites from '../Sites/SitesView.vue'
import Services from '../Services/ServicesView.vue'
import Fonctions from '../Fonctions/FonctionsView.vue'
import Zones from '../Zones/ZonesView.vue'
import Categories from '../Categories/CategoriesView.vue'
import Clients from '../Clients/ClientsView.vue'
import Contrats from '../Contrats/ContratsView.vue'
import Nationalites from '../Nationalites/NationalitesView.vue'
import Villes from '../Villes/VillesView.vue'
import Situations from '../Situations/SituationsView.vue'
import Typestaches from '../Typestaches/TypestachesView.vue'
import Typesabscences from '../Typesabscences/TypesabscencesView.vue'
import Joursferies from '../Joursferies/JoursferiesView.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import TypessitesView from "../Typessites/TypessitesView.vue"
import TypeseffectifsView from "../Typeseffectifs/TypeseffectifsView.vue"
import TypespostesView from "../Typespostes/TypespostesView.vue"
import TypesheuresView from "../Typesheures/TypesheuresView.vue"
import TypespointagesView from "../Typespointages/TypespointagesView.vue"
import TypesventilationsView from "../Typesventilations/TypesventilationsView.vue"
import TypesagentshorairesView from "../Typesagentshoraires/TypesagentshorairesView.vue"
import ImportsView from "../Imports/ImportsView.vue"
import TypesmoyenstransportsView from "../Typesmoyenstransports/TypesmoyenstransportsView.vue"
import MoyenstransportsView from "../Moyenstransports/MoyenstransportsView.vue"
import CartesView from "../Cartes/CartesView.vue"
import LignesView from "../Lignes/LignesView.vue"

export default {
    name: 'ConfigurationsView',

    components: {
        AgGridTable,
        DataModal,
        Directions,
        Zones,
        Sites,
        Services,
        Fonctions,
        Categories,
        Contrats,
        Nationalites,
        Villes,
        Situations,
        Joursferies,
        Typestaches,
        Typesabscences,
        TypesmoyenstransportsView,
        MoyenstransportsView,
        Clients,
        TypessitesView,
        TypeseffectifsView,
        TypespostesView,
        TypesheuresView,
        TypespointagesView,
        TypesventilationsView,
        TypesagentshorairesView,
        ImportsView,
        CartesView,
        LignesView,
        AgGridBtnClicked
    },

    data() {
        return {
            formId: "configurations",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: 'http://127.0.0.1:8000/api/configurations-Aggrid',
            table: 'configurations',
            usersData: [],
            requette: 2,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            actualPage: '',
            maxBlocksInCache: 1,
            type: '',

        }
    },

    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != "undefined") {
                    router = window.routeData;
                }
            } catch (e) {
            }
            return router;
        },
        taille: function () {
            let result = 'col-sm-12'
            if (this.filtre) {
                result = 'col-sm-9'
            }
            return result
        },
    },
    watch: {
        '$route': {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null)
                this.gridApi.refreshServerSide()
                this.tableKey++
            },
            deep: true
        },
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/configurations-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;

    },
    beforeMount() {


    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }
        // this.getusers();
        this.actualPage = 'Directions'

    },
    methods: {
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        closeForm() {
            this.tableKey++
        },
        showForm(type, data, gridApi, width = 'lg') {
            this.formKey++
            this.formWidth = width
            this.formState = type
            this.formData = data
            this.formGridApi = gridApi
            this.$bvModal.show(this.formId)
        },
        onGridReady(params) {
            console.log('on demarre', params)
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false
        },
        togglePage(page) {
            this.actualPage = page
            this.type = page
        },

    }
}
</script>
<style>
.hideBouton {
    gap: 10px;
    transition-duration: 0.1s;
    transition-delay: 0.1s;
    cursor: pointer;
    opacity: 0
}

.ProjetParentLocal:hover .hideBouton {
    opacity: 1
}

.boutton {
    padding: 0px 10px;
    border-radius: 5px;
    height: 50px;
}

.ProjetParentLocal {
    display: flex;
    justify-content: space-between;
    border-radius: 5px;

    border: 1px solid #ffffff;
    padding: 5px 20px;
}

.dataParents .ProjetParentLocal {
    display: flex;
    justify-content: space-between;
    border: 1px solid #b3adad;
    border-radius: 5px;
    padding: 5px 5px;
}

.allBoutons {
    gap: 10px
}

.ProjetData {
    display: flex;
    flex-direction: column
}

.iconParent {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 2px;
}

.iconCircle {
    display: inline-block;
    width: 5px;
    height: 5px;
    border-radius: 50%;
}

.pageTitre {
    padding: 5px;
    border-radius: 5px;
    cursor: pointer
}
</style>
