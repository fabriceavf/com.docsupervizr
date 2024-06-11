<template>
    <b-overlay :show="isLoading">
        <!-- <Readprogrammesusers
            :key="form"
            :data="form"

            :horairesData="horairesData"
            :usersData="usersData"
        /> -->
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="row">
                    <div class="form-group col-sm-12 ">
                        <label>users </label>
                        <CustomSelect :key="form.user" :columnDefs="['nom', 'prenom', 'matricule']"
                                      :oldValue="form.user"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.user_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/users-Aggrid`" filter-key=""
                                      filter-value=""/>
                        <div v-if="errors.user_id" class="invalid-feedback">
                            <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

                        </div>
                    </div>

                    <div class="form-group col-sm-12  ">
                        <label>semaine </label>
                        <input v-model="form.semaine"
                               :class="errors.semaine ? 'form-control is-invalid' : 'form-control'"
                               type="week">

                        <div v-if="errors.semaine" class="invalid-feedback">
                            <template v-for=" error in errors.semaine"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <Programmes :user-select="form.user_id" :weekselect="form.semaine"/>
                    </div>
                    <!--  <div class="col-sm-6">


        <div class="form-group">
            <label>date_fin </label>
            <input v-model="form.date_fin"
                   :class="errors.date_fin?'form-control is-invalid':'form-control'"
                   type="date">

            <div v-if="errors.date_fin" class="invalid-feedback">
                <template v-for=" error in errors.date_fin"> {{ error[0] }}</template>

            </div>
        </div>
    </div> -->
                </div>


            </div>
            <div class="d-flex justify-content-between">
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
import Readprogrammesusers from "./Readprogrammesusers.vue";
import VSelect from 'vue-select'
import Programmes from "./Programmes.vue";

export default {
    name: 'EditVentilations',
    components: {VSelect, CustomSelect, Files, Readprogrammesusers, Programmes},
    props: ['data', 'gridApi', 'modalFormId',
        'tachesData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

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
            },
            horairesData: [],
        }
    },

    mounted() {
        this.form = this.data
        this.form['date_debut'] = this.form['date_debut'].split(' ')[0]
        this.form['date_fin'] = this.form['date_fin'].split(' ')[0]
        // this.gethoraires()

    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/programmations/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        ValideLine() {
            this.isLoading = true
            this.axios.post('/api/programmations/' + this.form.id + '/update', {statut: 'valider'}).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
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
            this.axios.post('/api/programmations/' + this.form.id + '/delete').then(response => {
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
        gethoraires() {
            this.axios.get('/api/horaires/tache_id/' + this.data.tache_id).then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // this.$store.commit('setIsLoading', false)
                }
                this.horairesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
    }
}
</script>
