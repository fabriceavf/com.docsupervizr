<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>quantite </label>
                    <input v-model="form.quantite" :class="errors.quantite?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.quantite" class="invalid-feedback">
                        <template v-for=" error in errors.quantite"> {{ error[0] }}</template>

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


                <div class="form-group">
                    <label>materiels </label>
                    <CustomSelect
                        :key="form.materiel"
                        :columnDefs="['libelle']"
                        :oldValue="form.materiel"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.materiel_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/materiels-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.materiel_id" class="invalid-feedback">
                        <template v-for=" error in errors.materiel_id"> {{ error[0] }}</template>

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
    name: 'CreateMaterielprevisionnels',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'chantiersData',
        'materielsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                materiel_id: "",

                chantier_id: "",

                quantite: "",

                created_at: "",

                updated_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/materielprevisionnels', this.form).then(response => {
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
                materiel_id: "",
                chantier_id: "",
                quantite: "",
                created_at: "",
                updated_at: "",
            }
        }
    }
}
</script>
