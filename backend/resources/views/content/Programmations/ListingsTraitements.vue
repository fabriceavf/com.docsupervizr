<template>
    <div>
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='showDetailDay'">Details</div>
                <div v-if="formState=='Remplacant'">Remplacement dun agent</div>
            </template>

            <div v-if="formState=='showDetailDay'">
                <DetailDaysView
                    :key="programmes.id"
                    :data="programmes"
                ></DetailDaysView>

            </div>
            <div v-if="formState=='Remplacant'">


                <h4>L'agent {{ agent }} ne pourra etre la veuillez le remplacer en precisant la raison </h4>
                <div class="form-group">
                    <label>description </label>
                    <textarea v-model="description" :class="errors.description?'form-control is-invalid':'form-control'"
                              type="text"></textarea>

                    <div v-if="errors.description" class="invalid-feedback">
                        <template v-for=" error in errors.description"> {{ error[0] }}</template>

                    </div>
                </div>
                <AgGridSearch :columnDefs="add.columnDefs"
                              :filterFields="['matricule', 'nom','prenom']" :filterValue="[2]"
                              :url="add.url" filterKey="type_id"
                >
                </AgGridSearch>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary" @click.prevent="saveRemplacement">Enregistrer le
                        remplacant
                    </button>
                    <button class="btn btn-danger" @click.prevent="removeRemplacement">Supprimer le remplacement
                    </button>
                </div>


            </div>


            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <b-overlay :show="isLoading">
            <div class="parentListingsTraitements">
                <div>
                    <button v-if="isPresent" class="btn btn-success" @click="detailDay()">
                        <i class="fa-solid fa-lock"></i>({{ pointages.length }})Pts
                    </button>
                    <button v-else class="btn btn-danger" disabled><i class="fa-solid fa-lock"></i>({{
                            pointages.length
                        }})Pts
                    </button>
                </div>
                <button v-if="isPresent" :disabled="canEdit" class="btn btn-secondary" @click.prevent="addAbscence()">
                    Declarer abscent
                </button>
                <button v-else :disabled="canEdit" class="btn btn-secondary" @click.prevent="addPresence()"> Declarer
                    Present
                </button>

                <div>
                    <template v-if="remplacentUser">
                        <button :disabled="canEdit" class="btn">{{ remplacentUser }}</button>
                        <button :disabled="canEdit" class="btn btn-danger" @click.prevent="removeRemplacement()">
                            supprimer
                        </button>

                    </template>
                    <template v-else>
                        <button :disabled="canEdit" class="btn">Pas de remplacant</button>
                        <button :disabled="canEdit" class="btn btn-primary" @click.prevent="addRemplacant()">Ajouter
                        </button>

                    </template>
                </div>


            </div>


        </b-overlay>

    </div>


</template>

<script>
import DetailDaysView from "./DetailDaysView.vue";
import AgGridSearch from "@/components/AgGridSearch.vue";
import VSelect from 'vue-select'


export default {
    name: 'ListingsTraitements',
    components: {DetailDaysView, AgGridSearch, VSelect},
    props: [],
    data() {
        return {
            status: 'non',
            isLoading: false,
            cloturer: false,
            oldPointages: [],
            updateOldPointages: 0,
            newProgrammes: false,
            newProgrammesData: {},
            formId: "programmations",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            remplacant: "",
            description: "",
            errors: [],
            usersData: [],
            remplacantkey: 0,
            add: {
                formId: "listings",
                formState: "",
                formData: {},
                formWidth: 'lg',
                formGridApi: {},
                formKey: 0,
                tableKey: 0,
                url: 'http://127.0.0.1:8000/api/listings-Aggrid',
                table: 'Users',
                requette: 18,
                columnDefs: null,
                rowData: null,
                gridApi: null,
                columnApi: null,
                rowModelType: null,
                pagination: true,
                paginationPageSize: 100,
                cacheBlockSize: 10,
                maxBlocksInCache: 1,
                extrasData: {},
            },
        }
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
        programmes: function () {
            let programmes = {}
            console.log('Pointages ==> voici letat actual', this.newProgrammes, this.newProgrammesData)
            if (this.newProgrammes) {
                programmes = this.newProgrammesData
            } else {
                try {
                    programmes = this.params.data.programmes
                        .filter(ele => {
                            let _date = ele.date.split(' ')[0]
                            return _date == this.params.actualDate
                        })
                    programmes = programmes[0]
                } catch (e) {
                }
            }

            console.log('Programmes ==> voici le programmes actual', programmes)

            return programmes
        },
        pointages: function () {
            let pointages = []

            try {
                pointages = this.programmes.preuves
            } catch (e) {
            }

            console.log('Pointages ==> voici le pointages actual', pointages, this.programmes.preuves)

            return pointages
        },
        isPresent: function () {
            return this.pointages.length >= 1 ||
                (this.programmes.debut_realise != null && this.programmes.debut_realise != '') ||
                (this.programmes.fin_realise != null && this.programmes.fin_realise != '')

        },
        agent: function () {
            return this.params.data.user.Selectlabel

        },
        remplacentUser: function () {
            return this.programmes.Remplacantuser

        },
        actualRemplacant: function () {
            let data = ''

            if (this.programmes.remplacant) {
                data = this.programmes.remplacant
            }
            return data

        },
        canEdit: function () {

            return this.params.data.programmation.valider2

        },
    },
    watch: {},
    created() {
        this.id = "ListingsTraitements" + Date.now()
        this.formId = 'ListingsTraitements' + "_" + Date.now()
        let _etats = 'non'
        if (this.params.data.present == 'oui') {
            _etats = 'oui'
        }
        if (this.params.etats == "manuel-cloturer" || this.params.etats == "automatique-cloturer") {
            this.cloturer = true
        }
        this.cloturer = false
        this.status = _etats
        this.usersData = this.params.usersData
        this.add.url = this.axios.defaults.baseURL + '/api/users-Aggrid',
            this.add.rowBuffer = 0;
        this.add.rowModelType = 'serverSide';
        this.add.cacheBlockSize = 50;
        this.add.maxBlocksInCache = 2;
        this.add.columnDefs = [

            {
                field: null,

                width: 100,
                pinned: 'left',
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: '',
                cellRendererSelector: params => {
                    let response = {
                        component: 'AgGridBtnClicked',
                        params: {
                            clicked: field => {
                                this.SelectUser(field)
                            },
                            // render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`
                            render: `<div class="" style="width:100%;height:100%;background:#2885a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  Select </div>`

                        }
                    }
                    return response;
                },
            },


            {
                field: "matricule",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'matricule',
            },

            {
                field: "nom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'nom',
            },

            {
                field: "prenom",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'prenom',
            }


        ];


    },
    mounted() {
        console.log('voici les params passer en props pour la mise en place manuel ==>', this.params)
    },
    methods: {
        btnClickedHandler() {
            this.params.clicked(this.params.data);
        },
        addPresence() {
            console.log('voici le programme ===>', this.programmes)
            this.isLoading = true
            this.axios.post('/api/pointagesActionAddPresence', this.programmes)
                .then(response => {
                    this.isLoading = false
                    this.newProgrammes = true,
                        this.newProgrammesData = response.data
                })
                .catch(error => {
                    this.isLoading = false
                    this.newProgrammes = false
                    this.newProgrammesData = {}
                })
        },
        addAbscence() {
            console.log('voici le programme ===>', this.programmes)
            this.isLoading = true
            this.axios.post('/api/pointages/action?action=addAbscence', this.programmes)
                .then(response => {
                    this.isLoading = false
                    this.newProgrammes = true,
                        this.newProgrammesData = response.data
                })
                .catch(error => {
                    this.isLoading = false
                    this.newProgrammes = false
                    this.newProgrammesData = {}
                })
        },
        canAdmin() {
            // fonction utiliser pour verifier si je peux encore changer le status dun agent
            return this.params.etats == 'manuel'
        },
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('showDetailDay', {}, this.gridApi)
        },
        detailDay() {
            console.log('voici les pointage ===>', this.pointages)
            this.showForm('showDetailDay', {}, this.gridApi)
        },
        addRemplacant() {
            this.remplacant = this.programmes.remplacant
            try {
                this.description = this.programmes.extra_attributes.extras - data['description']

            } catch (e) {

            }
            this.remplacantkey++
            this.showForm('Remplacant', {}, this.gridApi)
        },
        saveRemplacement() {

            if (this.description != '') {
                let data = {
                    remplacant: this.remplacant,
                    description: this.description,
                }

                this.axios.post('/api/programmes/' + this.programmes.id + '/update', data).then((response) => {
                    this.newProgrammes = true,
                        this.newProgrammesData = response.data

                    this.$bvModal.hide(this.formId)

                    this.addPresence()


                    this.$toast.success('Remplacant effectuer avec success')
                }).catch(error => {

                    this.$toast.error('Remplacant non enregistrer')
                    console.log(error.response.data)
                })
            } else {
                alert('Veuiller entrer une description')
            }

        },
        removeRemplacement() {
            let data = {
                remplacant: -1,
                description: "",
            }

            this.axios.post('/api/programmes/' + this.programmes.id + '/update', data).then((response) => {
                this.newProgrammes = true,
                    this.newProgrammesData = response.data

                this.$bvModal.hide(this.formId)
                this.addAbscence()

                this.$toast.success('Remplacant effectuer avec success')
            }).catch(error => {

                this.$toast.error('Remplacant non enregistrer')
                console.log(error.response.data)
            })
        },
        SelectUser(field) {
            this.remplacant = field.id
            this.saveRemplacement();
        },
        showForm(type, data, gridApi, width = 'lg') {
            this.formKey++
            this.formWidth = width
            this.formState = type
            this.formData = data
            this.formGridApi = gridApi
            this.$bvModal.show(this.formId)
        },
    }
}
</script>
<style scoped>
.parentListingsTraitements {
    display: flex;
    flex-direction: row;
    gap: 10px
}

.boutonAction {
    border: 1px solid #d0d0d0;
    border-radius: 5px;
    padding: 0px 10px;
    cursor: pointer
}

.boutonAction:hover {
    color: green;
    border: 1px solid green;
}
</style>
