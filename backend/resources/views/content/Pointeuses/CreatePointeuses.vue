<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>code teleric </label>
                    <input v-model="form.code_teleric"
                           :class="errors.code_teleric?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.code_teleric" class="invalid-feedback">
                        <template v-for=" error in errors.code_teleric"> {{ error[0] }}</template>

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
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group">
                    <label>sites </label>
                    <CustomSelect
                        :key="form.site"
                        :columnDefs="['libelle','client.libelle']"
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
import CustomSelect from "@/components/CustomSelect.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'CreatePointeuses',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'recuperesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code_teleric: "",

                code: "",

                libelle: "",

                recupere_id: "",

                created_at: "",

                updated_at: "",

                findId: "",

                extra_attributes: "",

                deleted_at: "",
                pointeuse_id: "",

                identifiants_sadge: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/pointeuses', this.form).then(response => {
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
                recupere_id: "",
                created_at: "",
                updated_at: "",
                findId: "",
                extra_attributes: "",
                deleted_at: "",
                identifiants_sadge: "",
            }
        }
    }
}
</script>
