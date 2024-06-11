<template>
    <b-overlay :show="isLoading">

        <div class="parentElement">
            <button :class="isPresent?'btn btn-success':'btn btn-danger'" style="margin:0;padding:5px;"
                    @click="detailDay()">
                <i class="fa-solid fa-lock"></i>({{ pointages.length }})Pts
            </button>
            <b-modal :id="formId" :size="formWidth">

                <template #modal-title>
                    <div v-if="formState=='showDetailDay'">Details</div>
                </template>
                <b-overlay :show="isLoading">
                    <div v-if="formState=='showDetailDay'">
                        <DetailDaysView
                            :key="programme.id"
                            :data="programme"
                            :formID="formId"
                            :programmationsuser="programme"
                            @refresh="launchRefresh"
                            @horaires-qualifies-updated="updateHorairesQualifies"
                        ></DetailDaysView>

                    </div>
                </b-overlay>

                <template #modal-footer>
                    <div>
                        <!-- <button v-if="formState=='showDetailDay'" class="btn btn-primary" type="submit" @click.prevent="EditLine()">
                            <i class="fas fa-floppy-disk"></i> Mettre à jour
                        </button> -->
                    </div>
                </template>

            </b-modal>


        </div>

    </b-overlay>
</template>

<script>
import DetailDaysView from "./../DetailDaysView.vue";
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
            horairesQualifiesParent: {},
            form: {},
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
                programme: {}
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
        pointeuses: function () {
            let pointeuses = []
            try {
                pointeuses = this.params.data.horaire.poste.pointeuses
            } catch (e) {

            }
            let pointeusesId = []
            pointeuses.forEach(pointeuse => {
                pointeusesId.push(pointeuse.id)
            })
            return pointeusesId
        },
        pointages: function () {
            let pointages = []

            try {
                pointages = this.params.data.pointages_rattacher_auto
                pointages = pointages.split(',')
            } catch (e) {
                pointages = []
            }


            return pointages
        },
        isPresent: function () {
            return this.pointages.length >= 1 ||
                (this.params.data.debut_realise != null && this.params.data.debut_realise != '') ||
                (this.params.data.fin_realise != null && this.params.data.fin_realise != '')

        },
        agent: function () {
            return this.params.data.user.Selectlabel

        },
        remplacentUser: function () {
            return this.params.data.Remplacantuser

        },
        actualRemplacant: function () {
            let data = ''

            if (this.params.data.remplacant) {
                data = this.params.data.remplacant
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
        this.programme = this.params.data


    },
    mounted() {
        console.log('voici les params passer en props pour la mise en place manuel ==>', this.params)
    },
    methods: {
        btnClickedHandler() {
            this.params.clicked(this.params.data);
        },
        addPresence() {
            console.log('voici le programme ===>', this.params.data)
            this.isLoading = true
            this.axios.post('/api/pointagesActionAddPresence', this.params.data)
                // this.axios.post('/api/pointages/action?action=addPresence', this.params.data)
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
            console.log('voici le programme ===>', this.params.data)
            this.isLoading = true
            this.axios.post('/api/pointagesActionAddAbscence', this.params.data)
                // this.axios.post('/api/pointages/action?action=addAbscence', this.params.data)
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
            this.showForm('showDetailDay', {}, this.gridApi,)
        },
        detailDay() {
            console.log('voici les pointage ===>', this.pointages)
            this.showForm('showDetailDay', {}, this.gridApi, 'xl')
        },
        addRemplacant() {
            this.remplacant = this.params.data.remplacant
            try {
                this.description = this.params.data.extra_attributes.extras - data['description']

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

                this.axios.post('/api/programmes/' + this.params.data.id + '/update', data).then((response) => {
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

            this.axios.post('/api/programmes/' + this.params.data.id + '/update', data).then((response) => {
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
        // Méthode pour mettre à jour les horairesQualifies du parent
        updateHorairesQualifies(newHorairesQualifies) {
            // Mettez à jour la variable dans le parent avec la nouvelle valeur
            this.horairesQualifiesParent = newHorairesQualifies;
            console.log('one veut qualifier lhoraire...this.horairesQualifiesParent', this.horairesQualifiesParent);
        },
        // Méthode pour mettre à jour les horairesQualifies du parent
        launchRefresh(newHorairesQualifies) {
            this.params.api.refreshServerSide()
        },
        EditLine() {
            this.isLoading = true
            this.form.qualification_horaire = this.horairesQualifiesParent
            this.axios.post('/api/programmes/' + this.params.data.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.newProgrammes = true,
                    this.programme = response.data
                this.$bvModal.hide(this.formId)
                this.$emit('close')
                this.$toast.success('effectuer avec success')

            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
    }
}
</script>
<style scoped>
.parentElement {
    display: flex;
    width: 100%;
    height: 100%;
    align-content: center;
    align-items: center;

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
