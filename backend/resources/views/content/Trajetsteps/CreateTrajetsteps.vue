<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>left </label>
                    <input v-model="form.left" :class="errors.left?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.left" class="invalid-feedback">
                        <template v-for=" error in errors.left"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>right </label>
                    <input v-model="form.right" :class="errors.right?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.right" class="invalid-feedback">
                        <template v-for=" error in errors.right"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>front </label>
                    <input v-model="form.front" :class="errors.front?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.front" class="invalid-feedback">
                        <template v-for=" error in errors.front"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>creat_by </label>
                    <input v-model="form.creat_by" :class="errors.creat_by?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.creat_by" class="invalid-feedback">
                        <template v-for=" error in errors.creat_by"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>trajets </label>
                    <CustomSelect
                        :key="form.trajet"
                        :columnDefs="['libelle']"
                        :oldValue="form.trajet"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.trajet_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/trajets-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.trajet_id" class="invalid-feedback">
                        <template v-for=" error in errors.trajet_id"> {{ error[0] }}</template>

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
    name: 'CreateTrajetsteps',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'trajetsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                left: "",

                right: "",

                front: "",

                trajet_id: "",

                extra_attributes: "",

                creat_by: "",

                deleted_at: "",

                created_at: "",

                updated_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/trajetsteps', this.form).then(response => {
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
                left: "",
                right: "",
                front: "",
                trajet_id: "",
                extra_attributes: "",
                creat_by: "",
                deleted_at: "",
                created_at: "",
                updated_at: "",
            }
        }
    }
}
</script>
