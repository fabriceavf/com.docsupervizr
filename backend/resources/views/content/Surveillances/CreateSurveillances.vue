<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>action </label>
                    <input v-model="form.action" :class="errors.action?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.action" class="invalid-feedback">
                        <template v-for=" error in errors.action"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>ip </label>
                    <input v-model="form.ip" :class="errors.ip?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.ip" class="invalid-feedback">
                        <template v-for=" error in errors.ip"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>details </label>
                    <input v-model="form.details" :class="errors.details?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.details" class="invalid-feedback">
                        <template v-for=" error in errors.details"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>users </label>
                    <v-select
                        v-model="form.user_id"
                        :options="usersData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.user_id" class="invalid-feedback">
                        <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

                    </div>
                </div>

            </div>

            <button class="btn btn-primary" type="submit">
                <i class="fas fa-floppy-disk"></i> Créer
            </button>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'CreateSurveillances',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                action: "",

                ip: "",

                details: "",

                user_id: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                extra_attributes: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/logs', this.form).then(response => {
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
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        resetForm() {
            this.form = {
                id: "",
                action: "",
                ip: "",
                details: "",
                user_id: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
                extra_attributes: "",
            }
        }
    }
}
</script>
