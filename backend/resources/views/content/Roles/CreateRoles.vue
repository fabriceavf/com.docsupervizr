<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.name" :class="errors.name?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.name" class="invalid-feedback">
                        <template v-for=" error in errors.name"> {{ error[0] }}</template>

                    </div>
                </div>


                <!-- <div class="form-group">
                    <label>guard_name </label>
                    <input type="text" :class="errors.guard_name?'form-control is-invalid':'form-control'"
                           v-model="form.guard_name">

                    <div class="invalid-feedback" v-if="errors.guard_name">
                        <template v-for=" error in errors.guard_name"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>identifiants_sadge </label>
                    <input type="text" :class="errors.identifiants_sadge?'form-control is-invalid':'form-control'"
                           v-model="form.identifiants_sadge">

                    <div class="invalid-feedback" v-if="errors.identifiants_sadge">
                        <template v-for=" error in errors.identifiants_sadge"> {{ error[0] }}</template>

                    </div>
                </div> -->


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
    name: 'CreateRoles',
    components: {VSelect, CustomSelect, Files},
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

                name: "",

                guard_name: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                extra_attributes: "",

                identifiants_sadge: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.form.guard_name = this.form.name
            this.axios.post('/api/roles', this.form).then(response => {
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
                name: "",
                guard_name: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
                extra_attributes: "",
                identifiants_sadge: "",
            }
        }
    }
}
</script>
