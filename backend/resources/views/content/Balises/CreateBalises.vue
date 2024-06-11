<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>ref </label>
                    <input v-model="form.ref" :class="errors.ref?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.ref" class="invalid-feedback">
                        <template v-for=" error in errors.ref"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>imei </label>
                    <input v-model="form.imei" :class="errors.imei?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.imei" class="invalid-feedback">
                        <template v-for=" error in errors.imei"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>identifiants_sadge </label>
                    <input v-model="form.identifiants_sadge"
                           :class="errors.identifiants_sadge?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.identifiants_sadge" class="invalid-feedback">
                        <template v-for=" error in errors.identifiants_sadge"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>creat_by </label>
                    <input v-model="form.creat_by" :class="errors.creat_by?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.creat_by" class="invalid-feedback">
                        <template v-for=" error in errors.creat_by"> {{ error[0] }}</template>

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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'CreateBalises',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                ref: "",

                libelle: "",

                imei: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",

                creat_by: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/balises', this.form).then(response => {
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
                ref: "",
                libelle: "",
                imei: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
                identifiants_sadge: "",
                creat_by: "",
            }
        }
    }
}
</script>
