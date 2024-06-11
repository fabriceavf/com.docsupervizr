<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <!-- <div class="form-group">
                    <label>code </label>
                    <input v-model="form.code" :class="errors.code?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.code" class="invalid-feedback">
                        <template v-for=" error in errors.code"> {{ error[0] }}</template>

                    </div>
                </div> -->


                <div class="form-group">
                    <label>durees </label>
                    <input v-model="form.durees" :class="errors.durees?'form-control is-invalid':'form-control'"
                           type="time">

                    <div v-if="errors.durees" class="invalid-feedback">
                        <template v-for=" error in errors.durees"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>ordre </label>
                    <input v-model="form.ordre" :class="errors.ordre?'form-control is-invalid':'form-control'" min="1"
                           required
                           type="number">

                    <div v-if="errors.ordre" class="invalid-feedback">
                        <template v-for=" error in errors.ordre"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>sites </label>
                    <CustomSelect
                        :key="form.site"
                        :columnDefs="['libelle']"
                        :oldValue="form.site"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{form.site_id=data.id;formsitee=data}"
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
    name: 'CreateTrajets',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'lignesData',
        'parentId'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code: "",

                ligne_id: "",

                depart: "",

                durees: "",

                ordre: "",

                distance: "",

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
            this.form.ligne_id = this.parentId
            this.axios.post('/api/trajets', this.form).then(response => {
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
                ligne_id: "",
                depart: "",
                durees: "",
                ordre: "",
                distance: "",
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
