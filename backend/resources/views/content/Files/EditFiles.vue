<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>old_name </label>
                    <input v-model="form.old_name" :class="errors.old_name?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.old_name" class="invalid-feedback">
                        <template v-for=" error in errors.old_name"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>new_name </label>
                    <input v-model="form.new_name" :class="errors.new_name?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.new_name" class="invalid-feedback">
                        <template v-for=" error in errors.new_name"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>descriptions </label>
                    <input v-model="form.descriptions"
                           :class="errors.descriptions?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.descriptions" class="invalid-feedback">
                        <template v-for=" error in errors.descriptions"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>extensions </label>
                    <input v-model="form.extensions" :class="errors.extensions?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.extensions" class="invalid-feedback">
                        <template v-for=" error in errors.extensions"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>size </label>
                    <input v-model="form.size" :class="errors.size?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.size" class="invalid-feedback">
                        <template v-for=" error in errors.size"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>path </label>
                    <input v-model="form.path" :class="errors.path?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.path" class="invalid-feedback">
                        <template v-for=" error in errors.path"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>web_path </label>
                    <input v-model="form.web_path" :class="errors.web_path?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.web_path" class="invalid-feedback">
                        <template v-for=" error in errors.web_path"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>statut </label>
                    <input v-model="form.statut" :class="errors.statut?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.statut" class="invalid-feedback">
                        <template v-for=" error in errors.statut"> {{ error[0] }}</template>

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
    name: 'EditFiles',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                old_name: "",

                new_name: "",

                descriptions: "",

                extensions: "",

                size: "",

                path: "",

                web_path: "",

                statut: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            }
        }
    },

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/files/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/files/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
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
