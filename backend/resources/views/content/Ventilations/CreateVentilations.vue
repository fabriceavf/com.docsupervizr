<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="row">
                    <div class="form-group col-sm-12 ">
                        <label>users </label>
                        <CustomSelect :key="form.user" :columnDefs="['nom','prenom','matricule']" :oldValue="form.user"
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
                               :class="errors.semaine?'form-control is-invalid':'form-control'"
                               type="week">

                        <div v-if="errors.semaine" class="invalid-feedback">
                            <template v-for=" error in errors.semaine"> {{ error[0] }}</template>

                        </div>
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

            <button class="btn btn-primary" type="submit">
                <i class="fas fa-floppy-disk"></i> Creer
            </button>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'CreateVentilations',
    components: {VSelect, CustomSelect, Files},
    props: [
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

                libelle: "",

                description: "",

                semaine: "",

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
    methods: {
        createLine() {
            this.isLoading = true
            // this.axios.post('/api/get-matrice', this.form).then(response => {
            this.axios.post('/api/ventilations', this.form).then(response => {
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')

                // window.open(response.data, "_blank");
                console.log(response.data)
            }).catch(error => {
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
                semaine: "",
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
