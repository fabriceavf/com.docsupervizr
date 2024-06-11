<template>
    <b-overlay :show="isLoading">
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState == 'Create'">Ajouter des pointeuses</div>
            </template>

            <div v-if="formState == 'Create'">
                <AgGridSearch
                    :columnDefs="columnDefs"
                    :filterFields="['code', 'libelle']"
                    :url="url"
                    @destruction="finishAddPointeuse"
                >
                </AgGridSearch>
            </div>

            <template #modal-footer>
                <div></div>
                <button
                    v-if="formState == 'Create'"
                    class="btn btn-primary"
                    type="button"
                    @click.prevent="finishAddPointeuse()"
                >
                    <i class="fas fa-floppy-disk"></i> Valider
                </button>
            </template>
        </b-modal>
        <form @submit.prevent="EditLine()">


            <div class="row">
                <div class="form-group col-sm">
                    <label>code </label>
                    <input v-model="form.code" :class="errors.code ? 'form-control is-invalid' : 'form-control'"
                           :disabled="isDisabled('form.code')" type="text">

                    <div v-if="errors.code" class="invalid-feedback">
                        <template v-for=" error in errors.code"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group  col-sm">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle ? 'form-control is-invalid' : 'form-control'"
                           :disabled="isDisabled('form.libelle')" type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group  col-sm">
                    <label>Nb jour /Semaine </label>
                    <input v-model="form.jours" :class="errors.jours ? 'form-control is-invalid' : 'form-control'"
                           :disabled="isDisabled('form.jours')" type="text">

                    <div v-if="errors.jours" class="invalid-feedback">
                        <template v-for=" error in errors.jours"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group  col-sm">
                    <label>Nbrs agents J </label>
                    <input v-model="form.maxjours" :class="errors.maxjours ? 'form-control is-invalid' : 'form-control'"
                           :disabled="isDisabled('form.maxjours')" type="text">

                    <div v-if="errors.maxjours" class="invalid-feedback">
                        <template v-for=" error in errors.maxjours"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group  col-sm">
                    <label>Nbrs agents N </label>
                    <input v-model="form.maxnuits" :class="errors.maxnuits ? 'form-control is-invalid' : 'form-control'"
                           :disabled="isDisabled('form.maxnuits')" type="text">

                    <div v-if="errors.maxnuits" class="invalid-feedback">
                        <template v-for=" error in errors.maxnuits"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group  col-sm">
                    <label>sites </label>
                    <CustomSelect :key="form.site" :columnDefs="['libelle', 'client.Selectlabel']"
                                  :oldValue="form.site"
                                  :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :selectCallBack="(data) => form.site_id = data.id"
                                  :url="`${axios.defaults.baseURL}/api/sites-Aggrid`" filter-key=""
                                  filter-value=""/>
                    <div v-if="errors.site_id" class="invalid-feedback">
                        <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group  col-sm">
                    <label>clients </label>
                    <CustomSelect :key="form.site" :columnDefs="['libelle', 'client.Selectlabel']"
                                  :oldValue="form.site.client"
                                  :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :selectCallBack="(data) => form.site_id = data.id"
                                  :url="`${axios.defaults.baseURL}/api/sites-Aggrid`" filter-key=""
                                  filter-value=""/>
                    <div v-if="errors.site_id" class="invalid-feedback">
                        <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group  col-sm">
                    <label>zones </label>
                    <CustomSelect :key="form.site" :columnDefs="['libelle', 'client.Selectlabel']"
                                  :oldValue="form.site.zone"
                                  :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :selectCallBack="(data) => form.site_id = data.id"
                                  :url="`${axios.defaults.baseURL}/api/sites-Aggrid`" filter-key=""
                                  filter-value=""/>
                    <div v-if="errors.site_id" class="invalid-feedback">
                        <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                    </div>
                </div>
            </div>


            <div class="container-fluid">
                <div class="row">

                    <div class="col-sm-12" style="display: none">
                        <h3>Listes des horaire</h3>
                        <HorairesView :parentId="form.id" parentKey="poste" @getFormData="receiveFormData"
                                      @newData1="newData"></HorairesView>
                    </div>


                    <div class="col-sm-12">
                        <h3>Listes des agents affectées en fonction de la plage horaire</h3>
                        <HoraireagentsView
                            ref="horaireagentsview"
                            :horaireId="actualHoraire"
                            :horaires="horaires"
                            :parent='form'
                            :typespostes="$routeData.meta.postesimporter"
                            @newData="newDataInHoraires"
                        >
                        </HoraireagentsView>
                    </div>


                </div>
            </div>


            <div v-if="!$routeData.meta.postesimporter" class="d-flex justify-content-between">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import PostesagentsView from "./Postesagents/PostesagentsView.vue";
import PointeusesPostesView from "./PointeusesPostes/PointeusesPostesView.vue";
import HorairesView from "../Horaires/HorairesView.vue";
import HoraireagentsView from "./Horaireagents/HoraireagentsView.vue";
import AgGridSearch from "@/components/AgGridSearch.vue";

export default {
    name: 'EditPostes',
    components: {
        HoraireagentsView,
        HorairesView,
        VSelect,
        CustomSelect,
        Files,
        PostesagentsView,
        AgGridSearch,
        PointeusesPostesView
    },
    props: ['data', 'gridApi', 'modalFormId',
        'contratsclientsData',
        'pointeusesData',
        'sitesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            actualHoraire: null,
            form: {

                id: "",

                code: "",

                libelle: "",

                nature: "",

                coordonnees: "",

                site_id: "",

                pointeuse_id: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",

                creat_by: "",

                jours: "",


                contratsclient_id: "",

                pointeuses: []
            },
            donne: {

                id: "",

                pointeuse_id: "",

                poste_id: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",

                creat_by: "",

                jours: "",


                contratsclient_id: "",

                pointeuses: []
            },
            formId: "users",
            formState: "",
            formData: {},
            formWidth: "lg",
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            url: "http://127.0.0.1:8000/api/pointeuses-Aggrid",
            table: "users",
            requette: 9,
            columnDefs: null,
            rowData: null,
            gridApi1: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 20,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            agGridData: {},
            dateSelect: [],
            posteSelect: [],
            lastPosteSelectCount: 0,
            read: false,
            viewpointeuse: false,
            actualJour: 0,
            actualNuit: 0,
            champsDesactiver: [],

            horairedata: "",

            horaires: [],

        }
    },
    created() {
        (this.url = this.axios.defaults.baseURL + "/api/pointeuses-Aggrid"),
            (this.formId = this.table + "_" + Date.now());
        this.rowBuffer = 0;
        this.rowModelType = "serverSide";
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
    },
    watch: {
        'routeData': {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null)
                this.gridApi.refreshServerSide()
            },
            deep: true
        },
    },
    // watch: {
    //     horairedata(nouvelleValeur, ancienneValeur) {
    //         console.log(`La valeur de horaire a changé de "${ancienneValeur}" à "${nouvelleValeur}"`);
    //         this.gridApi.refreshCells()
    //         // Vous pouvez effectuer des actions supplémentaires ici en réponse au changement de valeur.
    //     },
    // },
    beforeMount() {
        this.columnDefs = [
            {
                field: null,

                width: 60,
                pinned: "left",
                suppressColumnsToolPanel: true,
                sortable: false,
                headerName: "",
                cellRendererSelector: (params) => {
                    let response = {
                        component: "AgGridBtnClicked",
                        params: {
                            clicked: (field) => {
                                this.addPointeuse(field);
                            },
                            render: `<div class="" style="width:100%;height:100%;background:#2885a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa fa-plus"></i></div>`,
                            // render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-pen-to-square "></i></div>`,
                        },
                    };
                    return response;
                },
            },


            {
                headerName: 'zone',
                field: 'site.zone.Selectlabel',
            },
            {
                headerName: 'site',
                field: 'site.Selectlabel',
            },
            {

                hide: true,
                suppressColumnsToolPanel: true,

                headerName: 'site',
                field: 'site_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['site']['Selectlabel']
                    } catch (e) {

                    }
                    return retour
                },

                filter: "CustomFiltre",
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/sites-Aggrid',
                    columnDefs: [
                        {
                            field: "",
                            sortable: true,
                            filter: "agTextColumnFilter",
                            filterParams: {suppressAndOrCondition: true},
                            headerName: "",
                            cellStyle: {fontSize: '11px'},
                            valueFormatter: (params) => {
                                let retour = "";
                                try {
                                    return `${params.data["Selectlabel"]}`;
                                } catch (e) {
                                }
                                return retour;
                            },
                        },
                    ],
                    filterFields: ['libelle'],
                },
            },
            {
                headerName: 'client',
                field: 'site.client.Selectlabel',
            },
            {
                field: "code",
                sortable: true,
                maxWidth: 120,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'code',
            },

            {
                field: "libelle",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'libelle',
            }

        ];
    },
    mounted() {
        this.form = this.data
        console.log('voici les data ==>', this.form)
        this.form.horaire = ""
        this.selectHoraireHandler();
        // this.form.pointeuse_id=this.form.pointeuses.map(data=>data.id).join(',')
        if (!this.$routeData.meta.postesimporter) {
            this.champsDesactiver = []
        } else {
            this.champsDesactiver = [
                'form.code',
                'form.site_id',
                'form.libelle',
                'client',
                'form.pointeuse_id',
                'form.contratsclient_id',
                'form.jours'
            ]
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
        client: function () {
            let data = ""
            try {
                let site = this.sitesData.filter(data => data.id == this.form.site_id)[0]
                // console.log('voici le site ',site)
                data = site.client.Selectlabel
            } catch (e) {
            }


            return data


        },
        personnalHoraires: function () {
            return this.horaires.map(e => {
                return {
                    'id': e.id,
                    'Selectlabel': `plage horaire : ${e.libelle} ${e.debut} - ${e.fin}`,
                }
            })


        },
    },
    methods: {
        openCreate() {
            this.showForm("Create", {}, this.gridApi, "xl");
        },
        onGridReady(params) {
            console.log("on demarre", params);
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false;
        },
        showForm(type, data, gridApi, width = "lg") {
            this.formKey++;
            this.formWidth = width;
            this.formState = type;
            this.formData = data;
            this.formGridApi = gridApi;
            this.$bvModal.show(this.formId);
        },
        isDisabled(fieldName) {
            return this.champsDesactiver.includes(fieldName)
        },
        newDataInHoraires(data) {
            let actualJour = data.rowData.filter(e => e.horaire.libelle.toLowerCase() == 'jour').length
            let actualNuit = data.rowData.filter(e => e.horaire.libelle.toLowerCase() == 'nuit').length
            if (actualJour != 0) {
                this.actualJour = actualJour
            }
            if (actualNuit != 0) {
                this.actualNuit = actualJour
            }
            // this.selectHoraire(this.actualJour);
        },
        newDataNuit(data) {
            console.log('on as recuperer la nuit', data)
            this.actualNuit = data.rowCount
        },
        finishAddPointeuse() {
            if (this.posteSelect.length != this.lastPosteSelectCount) {
                this.lastPosteSelectCount = this.posteSelect.length;
                console.log('this.gridApi.refreshCells')
            }
            this.$bvModal.hide(this.formId);
        },
        addPointeuse(data) {
            this.donne.poste_id = this.form.id;
            this.donne.pointeuse_id = data.Selectvalue;

            // this.posteSelect.push(data.Selectvalue);
            // this.$toast.success("Operation effectuer avec succes");

            this.isLoading = true
            this.axios.post('/api/postespointeuses', this.donne).then(response => {
                this.isLoading = false
                // this.resetForm()
                // this.gridApi.applyServerSideTransaction({
                //     add: [
                //         response.data
                //     ],
                // });
                // this.gridApi.refreshServerSide()
                // this.$bvModal.hide(this.modalFormId)
                // Ajouter la nouvelle pointeuse au tableau form.pointeuses
                this.posteSelect.push(response.data);

                this.$toast.success('Operation effectuer avec succes')
                // this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })

        },
        deletePoste(data) {

            // const clickedDate = data.id;

            // const index = this.form.pointeuses.indexOf(clickedDate);
            // if (index > -1) {
            //     this.form.pointeuses.splice(index, 1);
            //     this.tableKey++;
            //     this.$toast.success("Operation effectuer avec succes");
            // }
            console.log('data=>', data.pivot)


            let extra = data.pivot
            extra.action = 'detach'
            let donnes = Object.keys(extra).map(key => `${key}=${extra[key]}`).join('&')
            console.log('voici les donne ==>', donnes)
            let url = "/api/postespointeuses/action?" + donnes;
            // let url = "/api/postespointeuses/action?" + donnes;
            this.axios
                .get(url)
                .then((response) => {


                })
                .catch((error) => {
                    console.log(error);
                });
        },
        EditLine() {
            this.isLoading = true
            this.axios.post('/api/postes/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                // this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/postes/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
        newData(data) {
            console.log('voici les data 1', data);
            this.horaires = data
            try {
                this.actualHoraire = this.horaires[0].id

            } catch (e) {

            }
            console.log('voici les data 1', this.actualHoraire);

        },
        selectHoraire(data) {
            this.horaires = [data]
        },
        viewpointeuses() {
            this.viewpointeuse = true
        },
        receiveFormData(formData) {

            // Faites quelque chose avec les données reçues
        },
    }
}
</script>
