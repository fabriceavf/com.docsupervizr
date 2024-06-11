<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">
                <div class="form-group">
                    <label>vehicule </label>
                    <CustomSelect
                        :key="form.voiture"
                        :columnDefs="['libelle']"
                        :oldValue="form.voiture"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{form.voiture_id=data.id;form.voiture=data}"
                        :url="`${axios.defaults.baseURL}/api/voitures-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.voiture_id" class="invalid-feedback">
                        <template v-for=" error in errors.voiture_id"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group">
                    <label>code </label>
                    <input v-model="form.code" :class="errors.code?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.code" class="invalid-feedback">
                        <template v-for=" error in errors.code"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>UUID </label>
                    <input v-model="form.adresse_mac"
                           :class="errors.adresse_mac?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.adresse_mac" class="invalid-feedback">
                        <template v-for=" error in errors.adresse_mac"> {{ error[0] }}</template>

                    </div>
                </div>


                <!-- <div class="form-group">
                    <label>etat </label>
                    <input v-model="form.etat" :class="errors.etat?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.etat" class="invalid-feedback">
                        <template v-for=" error in errors.etat"> {{ error[0] }}</template>

                    </div>
                </div> -->


                <div class="form-group">
                    <label>alimentation </label>
                    <input v-model="form.alimentation"
                           :class="errors.alimentation?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.alimentation" class="invalid-feedback">
                        <template v-for=" error in errors.alimentation"> {{ error[0] }}</template>

                    </div>
                </div>


                <!-- <div class="form-group">
                    <label>reseau </label>
                    <input v-model="form.reseau" :class="errors.reseau?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.reseau" class="invalid-feedback">
                        <template v-for=" error in errors.reseau"> {{ error[0] }}</template>

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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'CreateTerminals',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'voituresData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code: "",

                adresse_mac: "",

                etat: "",

                alimentation: "",

                reseau: "",

                voiture_id: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                identifiants_sadge: "",

                creat_by: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/terminals', this.form).then(response => {
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
                adresse_mac: "",
                etat: "",
                alimentation: "",
                reseau: "",
                voiture_id: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
                identifiants_sadge: "",
                creat_by: "",
            }
        }
    }
}
</script>
