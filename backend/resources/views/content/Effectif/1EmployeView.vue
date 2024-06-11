<template>
    <div>
        <BreadCrumb>
            <template #breadcrumb_title>
                Liste du personnel
            </template>
            <template #breadcrumb_pages>
                <li class="breadcrumb-item active">
                    Personnel
                </li>
            </template>
        </BreadCrumb>

        <div class="card ">
            <div class="card-header d-flex">
                <div class="">
                    <button id="refresh-enrolements" class="btn btn-outline-dark mr-2" @click="getDatas()">
                        <i class="fa fa-refresh"></i> Actualiser
                    </button>
                </div>
                <div class="ml-auto">
                    <b-form-input v-model="filter" placeholder="Rechercher" type="search"></b-form-input>
                </div>
            </div>
            <div class="card-body overflow-auto">
                <b-table id="datas" :key="2"
                         :fields="fields" :filter="filter" :items="datas" :per-page="perPage" small sort-icon-left
                         @filtered="onFiltered">
                    <template #cell(id)="row">
                        <data-modal id="btn" :indice="'enrolement' + row.value" addClass="btn-primary " taille="lg">
                            <template #modal_btn>
                                <i class="fa-solid fa-pen-to-square "></i>
                            </template>
                            <template #modal_title>
                                Employe ID00{{ row.value }}
                            </template>
                            <template #modal_body>
                                <EditEmploye :fonctions="fonctions" :formLine="selectedLine(row.value)" :pays="pays"/>
                            </template>
                        </data-modal>
                    </template>
                </b-table>
            </div>
            <div class="card-footer">

                <b-pagination v-model="currentPage" :per-page="perPage" :total-rows="totalRows"
                              use-router></b-pagination>

            </div>
        </div>

    </div>
</template>

<script>
import moment from 'moment'
import BreadCrumb from '@/components/BreadCrumb'
import DataModal from '@/components/DataModal.vue'
import EditEmploye from './EditEnrolement.vue'

export default {
    name: 'EnrolementView',
    components: {BreadCrumb, DataModal, EditEmploye},
    data() {
        return {
            lastPage: 0,
            perPage: 6,
            currentPage: 1,
            totalPages: 0,
            totalRows: 0,
            filter: null,
            fields: [
                {
                    key: 'id',
                    label: ''
                },
                {
                    key: 'matricule',
                    sortable: 'true',
                    title: 'Matricule'
                },
                {
                    key: 'nom',
                    sortable: 'true',
                    label: 'Nom'
                },
                {
                    key: 'prenom',
                    sortable: 'true',
                    label: 'Prenom'
                },
                {
                    key: 'fonction.libelle',
                    sortable: 'true',
                    label: 'Fonction'
                },
                {
                    key: 'fonction.service.libelle',
                    sortable: 'true',
                    label: 'Service'
                },
                {
                    key: 'user.name',
                    sortable: 'true',
                    label: 'Enrolé par'
                },
                {
                    key: 'created_at',
                    sortable: 'true',
                    formatter: 'formatJour',
                    label: 'Date d\'enrolement'
                }
            ],
            datas: [],
            pays: [],
            fonctions: [],
            links: [],
            paginer: ''
        }
    },
    mounted() {
        this.getDatas()
    },
    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
                }
            } catch (e) {
            }

            return router;
        },
        rows() {
            return this.datas.length
        }
    },
    watch: {
        currentPage: {
            handler: function (value) {
                this.getDatas({page: value});
            },
        },
    },
    methods: {

        getDatas(params = {page: 1}) {
            console.log('params', params)

            this.axios.get(`/api/users?filter[type]=employe&filter[actif]=1&limit=${this.perPage}&paginate=1&page=${params.page}`).then((response) => {
                this.datas = response.data.data
                this.links = response.data.links
                this.currentPage = response.data.current_page
                this.perPage = response.data.per_page
                this.lastPage = response.data.last_page
                this.totalRows = response.data.total
                console.log('req', this.datas)

            })
        },
        getContries() {
            this.isLoading = true
            this.axios.get('/api/nations').then((response) => {
                this.pays = response.data
                this.isLoading = false
            })
        },
        getFonctions() {
            this.isLoading = true
            this.axios.get('/api/fonctions').then((response) => {
                this.fonctions = response.data
                this.isLoading = false
            })
        },
        onFiltered(filteredItems) {
            // this.rows = filteredItems.length
            // this.currentPage = 1
        },
        formatJour(row) {
            return moment(String(row)).format('DD/MM/YYYY')
        },
        formatHeure(row) {
            return moment(String(row)).format('hh:mm')
        },
        selectedLine(id) {
            return this.datas.filter(item => item.id === id)
        },

        linkGen(pageNum) {
            return pageNum === 1 ? '?' : `?page=${pageNum}`
        }

    }
}
</script>
