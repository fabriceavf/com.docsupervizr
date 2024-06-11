<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>libelle1 </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group">
                    <label>description </label>
                    <input v-model="form.description"
                           :class="errors.description?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.description" class="invalid-feedback">
                        <template v-for=" error in errors.description"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-4">


                        <div class="form-group">
                            <label>Semaine </label>
                            <input v-model="form.semaine"
                                   :class="errors.semaine?'form-control is-invalid':'form-control'"
                                   required type="week">

                            <div v-if="errors.semaine" class="invalid-feedback">
                                <template v-for=" error in errors.semaine"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">

                        <div class="form-group">
                            <label>date_debut </label>
                            <input v-model="form.date_debut"
                                   :class="errors.date_debut?'form-control is-invalid':'form-control'"
                                   disabled type="date">

                            <div v-if="errors.date_debut" class="invalid-feedback">
                                <template v-for=" error in errors.date_debut"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">


                        <div class="form-group">
                            <label>date_fin </label>
                            <input v-model="form.date_fin"
                                   :class="errors.date_fin?'form-control is-invalid':'form-control'"
                                   disabled type="date">

                            <div v-if="errors.date_fin" class="invalid-feedback">
                                <template v-for=" error in errors.date_fin"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                </div>


                <!--                <div class="form-group">-->
                <!--                    <label>statut </label>-->
                <!--                    <input type="text" :class="errors.statut?'form-control is-invalid':'form-control'"-->
                <!--                           v-model="form.statut">-->

                <!--                    <div class="invalid-feedback" v-if="errors.statut">-->
                <!--                        <template v-for=" error in errors.statut"> {{ error[0] }}</template>-->

                <!--                    </div>-->
                <!--                </div>-->


                <!--                <div class="form-group">-->
                <!--                    <label>identifiants_sadge </label>-->
                <!--                    <input type="text" :class="errors.identifiants_sadge?'form-control is-invalid':'form-control'"-->
                <!--                           v-model="form.identifiants_sadge">-->

                <!--                    <div class="invalid-feedback" v-if="errors.identifiants_sadge">-->
                <!--                        <template v-for=" error in errors.identifiants_sadge"> {{ error[0] }}</template>-->

                <!--                    </div>-->
                <!--                </div>-->


                <div class="form-group">
                    <label>taches </label>
                    <v-select
                        v-model="form.tache_id"
                        :options="tachesData"
                        :reduce="ele => ele.id"
                        disabled
                        label="Selectlabel"
                    />
                    <div v-if="errors.tache_id" class="invalid-feedback">
                        <template v-for=" error in errors.tache_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>users </label>
                    <CustomSelect
                        :key="form.user"
                        :columnDefs="['nom','prenom','matricule']"
                        :oldValue="form.user"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.user_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/users-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.user_id" class="invalid-feedback">
                        <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

                    </div>
                </div>

            </div>

            <button class="btn btn-primary" type="submit">
                <i class="fas fa-floppy-disk"></i> Enregistrer
            </button>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import moment from "moment";

export default {
    name: 'DuplicateHebdoProgrammations',
    components: {VSelect, CustomSelect, Files},
    props: [
        'data',
        'gridApi',
        'modalFormId',
        'tachesData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",
                semaine: "",

                libelle: "",

                description: "",

                date_debut: "",

                date_fin: "",

                tache_id: "",

                user_id: "",

                statut: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                identifiants_sadge: "",
            }
        }
    },
    created() {
        console.log('voici la data ==>', this.data)
        this.form = this.data
        this.form.libelle = 'Copie ' + this.form.libelle

    },
    computed: {
        date: function () {
            let semaine = this.form.semaine;
            semaine = this.getJoursNumberFromWeek(semaine)
            return semaine
        }
    },
    watch: {
        'form.semaine': {
            handler: function (after, before) {
                let semaine = after;
                semaine = this.getJoursNumberFromWeek(semaine)
                this.form.date_debut = semaine.Lundi
                this.form.date_fin = semaine.Dimanche
                console.log('voici les nouvelles data ==>', semaine)
            },
            deep: true
        },
    },
    methods: {
        getDateOfWeek(w, y) {
            const d = (1 + (w - 1) * 7) // 1st of January + 7 days for each week
            return new Date(y, 0, d)
        },
        getJoursNumberFromWeek(week) {
            const date = {}
            date.Lundi = moment(`${week}`).add(0, 'days').format('YYYY-MM-DD')
            date.Mardi = moment(`${week}`).add(1, 'days').format('YYYY-MM-DD')
            date.Mercredi = moment(`${week}`).add(2, 'days').format('YYYY-MM-DD')
            date.Jeudi = moment(`${week}`).add(3, 'days').format('YYYY-MM-DD')
            date.Vendredi = moment(`${week}`).add(4, 'days').format('YYYY-MM-DD')
            date.Samedi = moment(`${week}`).add(5, 'days').format('YYYY-MM-DD')
            date.Dimanche = moment(`${week}`).add(6, 'days').format('YYYY-MM-DD')
            return date
        },
        createLine() {
            this.isLoading = true
            this.axios.post('/api/programmationsActionDupliquerProgrammationsHebdo', this.form).then(response => {
                // this.axios.post('/api/programmations/action?action=dupliquerProgrammationsHebdo', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.isLoading = false
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        resetForm() {
            this.form = {
                id: "",
                libelle: "",
                description: "",
                date_debut: "",
                date_fin: "",
                tache_id: "",
                user_id: "",
                statut: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
                identifiants_sadge: "",
            }
        }
    }
}
</script>
