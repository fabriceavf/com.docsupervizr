<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>code </label>
                    <input v-model="form.code" :class="errors.code ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.code" class="invalid-feedback">
                        <template v-for=" error in errors.code"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>


                <div v-if="!typetacheselectionner" class="form-group">
                    <label>type </label>
                    <CustomSelect :key="form.typestache" :columnDefs="['libelle']"
                                  :oldValue="form.typestache" :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :selectCallBack="(data) => form.typestache_id = data.id"
                                  :url="`${axios.defaults.baseURL}/api/typestaches-Aggrid`"
                                  filter-key=""
                                  filter-value=""/>
                    <div v-if="errors.typestache_id" class="invalid-feedback">
                        <template v-for=" error in errors.typestache_id"> {{ error[0] }}</template>

                    </div>
                </div>
                <!-- <div class="form-group">
                    <label>villes </label>
                    <CustomSelect :key="form.ville" :columnDefs="['libelle']"
                                  :oldValue="form.ville" :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :selectCallBack="(data) => form.ville_id = data.id"
                                  :url="`${axios.defaults.baseURL}/api/villes-Aggrid`"
                                  filter-key=""
                                  filter-value=""/>
                    <div v-if="errors.ville_id" class="invalid-feedback">
                        <template v-for=" error in errors.ville_id"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group ">
                    <label>Pastille</label>
                    <input v-model="form.pastille" class="form-control" type="text">
                </div>

                <div class="form-group">
                    <label>Pointeuse </label>
                    <v-select v-model="form.pointeuse_id" :options="pointeusesData" :reduce="ele => ele.id"
                              label="Selectlabel"/>
                    <div v-if="errors.pointeuse_id" class="invalid-feedback">
                        <template v-for=" error in errors.pointeuse_id"> {{ error[0] }}</template>

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
    name: 'CreateTaches',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'typestachesData',
        'villesData',
        'pointeusesData',
        'typetacheselectionner'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                typestache_id: "",

                libelle: "",

                ville_id: "",

                pointeuse_id: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
                pastille: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            if (this.typetacheselectionner) {
                this.form.typestache_id = this.typetacheselectionner
            }
            this.axios.post('/api/taches', this.form).then(response => {
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
                typestache_id: "",
                libelle: "",
                ville_id: "",
                pointeuse_id: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        }
    }
}
</script>
