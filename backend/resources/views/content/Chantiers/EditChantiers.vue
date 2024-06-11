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
                    <label>couleur </label>
                    <input v-model="form.couleur" :class="errors.couleur?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.couleur" class="invalid-feedback">
                        <template v-for=" error in errors.couleur"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>debut_prevus </label>
                    <input v-model="form.debut_prevus"
                           :class="errors.debut_prevus?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.debut_prevus" class="invalid-feedback">
                        <template v-for=" error in errors.debut_prevus"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>fin_prevus </label>
                    <input v-model="form.fin_prevus" :class="errors.fin_prevus?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.fin_prevus" class="invalid-feedback">
                        <template v-for=" error in errors.fin_prevus"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>debut_effectif </label>
                    <input v-model="form.debut_effectif"
                           :class="errors.debut_effectif?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.debut_effectif" class="invalid-feedback">
                        <template v-for=" error in errors.debut_effectif"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>fin_effectif </label>
                    <input v-model="form.fin_effectif"
                           :class="errors.fin_effectif?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.fin_effectif" class="invalid-feedback">
                        <template v-for=" error in errors.fin_effectif"> {{ error[0] }}</template>

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
    name: 'EditChantiers',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                couleur: "",

                debut_prevus: "",

                fin_prevus: "",

                debut_effectif: "",

                fin_effectif: "",

                created_at: "",

                updated_at: "",
            }
        }
    },

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/chantiers/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/chantiers/' + this.form.id + '/delete').then(response => {
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
