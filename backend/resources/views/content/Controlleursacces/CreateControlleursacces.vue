<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">
                <div class="form-group">
                    <label>type </label>
                    <v-select v-model="form.type" :options="['Fixe','Mobile']" label="Selectlabel"/>

                </div>
                <div class="row">
                    <div class="col-sm form-group">
                        <label>pointeuses </label>
                        <CustomSelect
                            :key="form.pointeuse"
                            :columnDefs="['libelle']"
                            :oldValue="form.pointeuse"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>{form.pointeuse_id=data.id;form.pointeuse=data}"
                            :url="`${axios.defaults.baseURL}/api/pointeuses-Aggrid`"
                            filter-key=""
                            filter-value=""
                        />
                        <div v-if="errors.pointeuse_id" class="invalid-feedback">
                            <template v-for=" error in errors.pointeuse_id"> {{ error[0] }}</template>

                        </div>
                    </div>

                    <div v-if="form.type=='Mobile'" class="col-sm form-group">
                        <label>deplacements </label>
                        <CustomSelect
                            :key="form.deplacement"
                            :columnDefs="['libelle']"
                            :oldValue="form.deplacement"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>{form.deplacement_id=data.id;form.deplacement=data}"
                            :url="`${axios.defaults.baseURL}/api/deplacements-Aggrid`"
                            filter-key=""
                            filter-value=""
                        />
                        <div v-if="errors.deplacement_id" class="invalid-feedback">
                            <template v-for=" error in errors.deplacement_id"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div v-else class="col-sm form-group">
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
                <div class="row">
                    <div class="col-sm form-group">
                        <label>date_debut </label>
                        <input v-model="form.date_debut"
                               :class="errors.date_debut?'form-control is-invalid':'form-control'"
                               type="datetime-local">

                        <div v-if="errors.date_debut" class="invalid-feedback">
                            <template v-for=" error in errors.date_debut"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div class="col-sm form-group">
                        <label>date_fin </label>
                        <input v-model="form.date_fin" :class="errors.date_fin?'form-control is-invalid':'form-control'"
                               type="datetime-local">

                        <div v-if="errors.date_fin" class="invalid-feedback">
                            <template v-for=" error in errors.date_fin"> {{ error[0] }}</template>

                        </div>
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
import VSelect from 'vue-select'

export default {
    name: 'CreateControlleursacces',
    components: {CustomSelect, Files, VSelect},
    props: [
        'gridApi',
        'modalFormId',
        'lignesData',
        'deplacementsData',
        'pointeusesData',
        'sitesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                pointeuse_id: "",

                ligne_id: "",

                deplacement_id: "",

                site_id: "",

                date_debut: "",

                date_fin: "",

                creat_by: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
                type: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/controlleursacces', this.form).then(response => {
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
                pointeuse_id: "",
                ligne_id: "",
                deplacement_id: "",
                site_id: "",
                date_debut: "",
                date_fin: "",
                creat_by: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        }
    }
}
</script>
