<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

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
                    <label>latitude </label>
                    <input v-model="form.latitude" :class="errors.latitude?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.latitude" class="invalid-feedback">
                        <template v-for=" error in errors.latitude"> {{ error[0] }}</template>

                    </div>
                </div>


                <!-- <div class="form-group">
                    <label>villes </label>
                    <CustomSelect
                        :key="form.ville"
                        :columnDefs="['libelle']"
                        :oldValue="form.ville"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{form.ville_id=data.id;form.ville=data}"
                        :url="`${axios.defaults.baseURL}/api/villes-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.ville_id" class="invalid-feedback">
                        <template v-for=" error in errors.ville_id"> {{ error[0] }}</template>

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
    name: 'CreatePoints',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'villesData',
        'parentId'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                longitude: "",

                latitude: "",

                ville_id: "",

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
            this.form.ville_id = this.parentId
            this.axios.post('/api/points', this.form).then(response => {
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
                libelle: "",
                longitude: "",
                latitude: "",
                ville_id: "",
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
