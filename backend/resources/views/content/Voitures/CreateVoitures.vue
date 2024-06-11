<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>code </label>
                    <input v-model="form.code" :class="errors.code?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.code" class="invalid-feedback">
                        <template v-for=" error in errors.code"> {{ error[0] }}</template>

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
                    <label>plaque </label>
                    <input v-model="form.plaque" :class="errors.plaque?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.plaque" class="invalid-feedback">
                        <template v-for=" error in errors.plaque"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>capacite </label>
                    <input v-model="form.capacite" :class="errors.capacite?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.capacite" class="invalid-feedback">
                        <template v-for=" error in errors.capacite"> {{ error[0] }}</template>

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
    name: 'CreateVoitures',
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

                code: "",

                libelle: "",

                plaque: "",

                capacite: "",

                deleted_at: "",

                creat_by: "",

                identifiants_sadge: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            let data = {...this.form}
            data['action'] = 'CreateVoiture'
            this.axios.post('useCase', data).then(response => {
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
                code: "",
                libelle: "",
                plaque: "",
                capacite: "",
                deleted_at: "",
                creat_by: "",
                identifiants_sadge: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
            }
        }
    }
}
</script>
