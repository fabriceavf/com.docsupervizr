<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <!-- <div class="form-group">
                    <label>solde </label>
                    <input v-model="form.solde" :class="errors.solde?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.solde" class="invalid-feedback">
                        <template v-for=" error in errors.solde"> {{ error[0] }}</template>

                    </div>
                </div> -->


                <div class="form-group">
                    <label>code </label>
                    <input v-model="form.code" :class="errors.code?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.code" class="invalid-feedback">
                        <template v-for=" error in errors.code"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>UID MIFARE </label>
                    <input v-model="form.uid_mifare"
                           :class="errors.uid_mifare ?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.uid_mifare " class="invalid-feedback">
                        <template v-for=" error in errors.uid_mifare "> {{ error[0] }}</template>

                    </div>
                </div>


                <!-- <div class="form-group">
                    <label>expiration </label>
                    <input v-model="form.expiration" :class="errors.expiration?'form-control is-invalid':'form-control'"
                           type="datetime-local">

                    <div v-if="errors.expiration" class="invalid-feedback">
                        <template v-for=" error in errors.expiration"> {{ error[0] }}</template>

                    </div>
                </div> -->


                <!-- <div class="form-group">
                    <label>etat </label>
                    <input v-model="form.etat" :class="errors.etat?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.etat" class="invalid-feedback">
                        <template v-for=" error in errors.etat"> {{ error[0] }}</template>

                    </div>
                </div> -->


                <!-- <div class="form-group">
                    <label>decouvert </label>
                    <input v-model="form.decouvert" :class="errors.decouvert?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.decouvert" class="invalid-feedback">
                        <template v-for=" error in errors.decouvert"> {{ error[0] }}</template>

                    </div>
                </div> -->


                <div class="form-group">
                    <label>sites </label>
                    <CustomSelect
                        :key="form.site"
                        :columnDefs="['libelle']"
                        :oldValue="form.site"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{form.site_id=data.id;form.site=data}"
                        :url="`${axios.defaults.baseURL}/api/sites-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.site_id" class="invalid-feedback">
                        <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

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
    name: 'CreateCartes',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'sitesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                solde: "",

                code: "",

                uid_mifare: "",

                expiration: "",

                etat: "",

                site_id: "",

                decouvert: "",

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
            this.form.solde = "0"
            this.isLoading = true
            this.axios.post('/api/cartes', this.form).then(response => {
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
                solde: "",
                code: "",
                uid_mifare: "",
                expiration: "",
                etat: "",
                site_id: "",
                decouvert: "",
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
