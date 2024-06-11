<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">

                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle"
                           :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group">
                    <label>heure_debut </label>
                    <input v-model="form.heure_debut"
                           :class="errors.heure_debut?'form-control is-invalid':'form-control'"
                           type="time">

                    <div v-if="errors.heure_debut" class="invalid-feedback">
                        <template v-for=" error in errors.heure_debut"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group">
                    <label>heure_fin </label>
                    <input v-model="form.heure_fin" :class="errors.heure_fin?'form-control is-invalid':'form-control'"
                           type="time">

                    <div v-if="errors.heure_fin" class="invalid-feedback">
                        <template v-for=" error in errors.heure_fin"> {{ error[0] }}</template>

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
    name: 'CreatePassagesrondes',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId', 'parentId'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                heure_fin: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.form.site_id = this.parentId
            this.axios.post('/api/passagesrondes', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
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
                heure_fin: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        }
    }
}
</script>
