<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>name </label>
                    <input v-model="form.name" :class="errors.name?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.name" class="invalid-feedback">
                        <template v-for=" error in errors.name"> {{ error[0] }}</template>

                    </div>
                </div>


                <!--        <div class="form-group">-->
                <!--          <label>guard_name </label>-->
                <!--          <input v-model="form.guard_name" :class="errors.guard_name?'form-control is-invalid':'form-control'"-->
                <!--                 type="text">-->

                <!--          <div v-if="errors.guard_name" class="invalid-feedback">-->
                <!--            <template v-for=" error in errors.guard_name"> {{ error[0] }}</template>-->

                <!--          </div>-->
                <!--        </div>-->


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
    name: 'EditPermissions',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                name: "",

                guard_name: "api",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                extra_attributes: "",
            }
        }
    },

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/permissions/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/permissions/' + this.form.id + '/delete').then(response => {
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
