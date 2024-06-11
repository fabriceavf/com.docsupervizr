<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>debut </label>
                    <input v-model="form.debut" :class="errors.debut?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.debut" class="invalid-feedback">
                        <template v-for=" error in errors.debut"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>fin </label>
                    <input v-model="form.fin" :class="errors.fin?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.fin" class="invalid-feedback">
                        <template v-for=" error in errors.fin"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>groupe </label>
                    <input v-model="form.groupe" :class="errors.groupe?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.groupe" class="invalid-feedback">
                        <template v-for=" error in errors.groupe"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>activites </label>
                    <CustomSelect
                        :key="form.activite"
                        :columnDefs="['libelle']"
                        :oldValue="form.activite"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.activite_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/activites-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.activite_id" class="invalid-feedback">
                        <template v-for=" error in errors.activite_id"> {{ error[0] }}</template>

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
import VSelect from 'vue-select'

export default {
    name: 'EditWorks',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
        'activitesData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                activite_id: "",

                user_id: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                debut: "",

                fin: "",

                groupe: "",
            }
        }
    },

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/works/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/works/' + this.form.id + '/delete').then(response => {
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
    }
}
</script>
