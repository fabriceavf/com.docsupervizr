<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>area_alias </label>
                    <input v-model="form.area_alias" :class="errors.area_alias?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.area_alias" class="invalid-feedback">
                        <template v-for=" error in errors.area_alias"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>first_name </label>
                    <input v-model="form.first_name" :class="errors.first_name?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.first_name" class="invalid-feedback">
                        <template v-for=" error in errors.first_name"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>last_name </label>
                    <input v-model="form.last_name" :class="errors.last_name?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.last_name" class="invalid-feedback">
                        <template v-for=" error in errors.last_name"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>card_no </label>
                    <input v-model="form.card_no" :class="errors.card_no?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.card_no" class="invalid-feedback">
                        <template v-for=" error in errors.card_no"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>terminal_alias </label>
                    <input v-model="form.terminal_alias"
                           :class="errors.terminal_alias?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.terminal_alias" class="invalid-feedback">
                        <template v-for=" error in errors.terminal_alias"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>emp_code </label>
                    <input v-model="form.emp_code" :class="errors.emp_code?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.emp_code" class="invalid-feedback">
                        <template v-for=" error in errors.emp_code"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>punch_date </label>
                    <input v-model="form.punch_date" :class="errors.punch_date?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.punch_date" class="invalid-feedback">
                        <template v-for=" error in errors.punch_date"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>punch_time </label>
                    <input v-model="form.punch_time" :class="errors.punch_time?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.punch_time" class="invalid-feedback">
                        <template v-for=" error in errors.punch_time"> {{ error[0] }}</template>

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
    name: 'EditTransactions',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                bio_id: "",

                area_alias: "",

                first_name: "",

                last_name: "",

                card_no: "",

                terminal_alias: "",

                emp_code: "",

                punch_date: "",

                punch_time: "",

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
            this.axios.post('/api/transactions/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/transactions/' + this.form.id + '/delete').then(response => {
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
