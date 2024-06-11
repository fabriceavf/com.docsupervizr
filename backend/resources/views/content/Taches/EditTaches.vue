<template>
    <b-overlay :show="isLoading">
        <div class="row">
            <div class="col-sm-12" style="border-right: 4px solid;">
                <form>
                    <div class="row">
                        <div class="form-group col-sm ">
                            <label>code</label>
                            <input v-model="form.code" class="form-control" type="text">
                        </div>
                        <div class="form-group col-sm ">
                            <label>Libelle</label>
                            <input v-model="form.libelle" class="form-control" type="text">
                        </div>

                        <div class="form-group col-sm">
                            <label>type </label>
                            <CustomSelect
                                :key="form.typestache"
                                :columnDefs="['libelle']"
                                :oldValue="form.typestache"
                                :renderCallBack="(data)=>`${data.Selectlabel}`"
                                :selectCallBack="(data)=>form.typestache_id=data.id"
                                :url="`${axios.defaults.baseURL}/api/typestaches-Aggrid`"
                                filter-key=""
                                filter-value=""
                            />
                            <div v-if="errors.typestache_id" class="invalid-feedback">
                                <template v-for=" error in errors.typestache_id"> {{ error[0] }}</template>

                            </div>
                        </div>
                        <!-- <div class="form-group col-sm-3">
                            <label>villes </label>
                            <CustomSelect
                                :key="form.ville"
                                :columnDefs="['libelle']"
                                :oldValue="form.ville"
                                :renderCallBack="(data)=>`${data.Selectlabel}`"
                                :selectCallBack="(data)=>form.ville_id=data.id"
                                :url="`${axios.defaults.baseURL}/api/villes-Aggrid`"
                                filter-key=""
                                filter-value=""
                            />
                            <div v-if="errors.ville_id" class="invalid-feedback">
                                <template v-for=" error in errors.ville_id"> {{ error[0] }}</template>

                            </div>
                        </div> -->

                        <!-- <div class="form-group col-sm-3">
                            <label>Pastille</label>
                            <input v-model="form.pastille" class="form-control" type="text">
                        </div> -->
                    </div>
                    <!-- <div class="row">
                        <div class="form-group">
                            <label>Pointeuse </label>
                            <div class="row">
                                <div class="d-flex justify-content-between" style="width: 90%;margin: 0 auto;">
                                    <button v-for="pointeuse in form.Pointeuses" class="btn btn-warning">
                                        <i class="fa-solid fa-bars-progress"></i> {{ pointeuse.libelle }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div> -->
                </form>
            </div>

        </div>

        <div class="container-fluid">
            <div class="row"><h3>Listes des agents affectées en fonction de la plage horaire</h3></div>
            <div class="row">

                <div class="col-sm-4" style="display: none">
                    <HorairesView :parentId="form.typestache_id" parentKey="tache" @newData1="newData"
                                  @selectHoraire="selectHoraire"></HorairesView>
                </div>

                <!--
                                <div class="col-sm-8">
                                    <template v-for="(horaire,index) in horaires">
                                        <div v-if="index==0" :key="horaire.id" class="col-sm-12">
                                            <div>
                                                <TravailleursView :horaireId="horaire.id" :parent='form' @newData="newDataInHoraires">
                                                </TravailleursView>
                                            </div>
                                        </div>

                                    </template>
                                </div> -->

                <div class="col-sm-12">
                    <TravailleursView
                        ref="horaireagentsview"
                        :horaireId="actualHoraire"
                        :horaires="horaires"
                        :parent='form'
                        :tacheId="form.id"
                        :typespostes="true"
                        @newData="newDataInHoraires"
                    >
                    </TravailleursView>
                </div>


            </div>
        </div>
        <div class="row">
            <div class="d-flex justify-content-between" style="width: 90%;margin: 0 auto;">
                <button class="btn btn-primary" @click.prevent="EditLine()">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>
        </div>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import $ from 'jquery'
import CreateHoraire from './Horaires/CreateHoraire.vue'
import EditHoraire from './Horaires/EditHoraire.vue'
import VSelect from 'vue-select'
import TravailleursView from "./Travailleurs/TravailleursView.vue";
import HorairesView from "./../Horaires/HorairesView.vue";

export default {
    name: 'EditTache',
    props: ['data',
        'villes',
        'table',
        'gridApi',
        'modalFormId',
        'typestachesData',
        'villesData',
        'pointeuseData'],
    components: {TravailleursView, CreateHoraire, EditHoraire, VSelect, CustomSelect, HorairesView},
    data() {
        return {
            hoursForm: '',
            errors: [],
            horaires: [],
            horaireSelected: [],
            actualHoraire: null,
            isLoading: false,
            form: {
                code: '',
                libelle: '',
                type: '',
                ville_id: '',
                pointeuse_id: '',
                pastille: ''
            }
        }
    },
    computed: {},
    mounted() {
        this.form = this.data
        console.log('voici les data ==>', this.form)
    },
    methods: {
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
        newDataJour(data) {
            console.log('on as recuperer le jour', data)
            this.actualJour = data.rowCount
        },
        EditLine() {
            this.isLoading = true
            this.axios.post('/api/taches/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                $('#close_modal_tache' + this.form.id).click()
                $('#refresh' + this.table).click()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Nouvelle tache ajouté')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/taches/' + this.form.id + '/delete').then(response => {
                this.isLoading = false
                $('#close_modal_tache' + this.form.id).click()
                $('#refresh' + this.table).click()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Tache supprimé')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
        showHoraireForm() {
            this.hoursForm = 'create'
        },
        showEditHoraireForm(tab) {
            this.hoursForm = 'edit'
            this.horaireSelected = tab
        },
        refreshHoraire() {
            this.hoursForm = ''
            this.getHoraires()
        },
        closeHoraireForm() {
            this.hoursForm = ''
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
    }
}
</script>
