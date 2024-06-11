<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>latitude </label>
                    <input v-model="form.latitude" :class="errors.latitude?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.latitude" class="invalid-feedback">
                        <template v-for=" error in errors.latitude"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>longitude </label>
                    <input v-model="form.longitude" :class="errors.longitude?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.longitude" class="invalid-feedback">
                        <template v-for=" error in errors.longitude"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>chantiers </label>
                    <CustomSelect
                        :key="form.chantier"
                        :columnDefs="['libelle']"
                        :oldValue="form.chantier"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.chantier_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/chantiers-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.chantier_id" class="invalid-feedback">
                        <template v-for=" error in errors.chantier_id"> {{ error[0] }}</template>

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
    name: 'CreateChantierlocalisations',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'chantiersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                chantier_id: "",

                latitude: "",

                longitude: "",

                created_at: "",

                updated_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/chantierlocalisations', this.form).then(response => {
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
                chantier_id: "",
                latitude: "",
                longitude: "",
                created_at: "",
                updated_at: "",
            }
        }
    }
}
</script>
