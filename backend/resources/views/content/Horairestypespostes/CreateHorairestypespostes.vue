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
                    <label>debut </label>
                    <input v-model="form.debut" :class="errors.debut?'form-control is-invalid':'form-control'"
                           type="time">

                    <div v-if="errors.debut" class="invalid-feedback">
                        <template v-for=" error in errors.debut"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>fin </label>
                    <input v-model="form.fin" :class="errors.fin?'form-control is-invalid':'form-control'"
                           type="time">

                    <div v-if="errors.fin" class="invalid-feedback">
                        <template v-for=" error in errors.fin"> {{ error[0] }}</template>

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


                <!-- <div class="form-group">
                    <label>typespostes </label>
                    <CustomSelect
                        :key="form.typesposte"
                        :url="`${axios.defaults.baseURL}/api/typespostes-Aggrid`"
                        :columnDefs="['libelle']"
                        filter-key=""
                        filter-value=""
                        :oldValue="form.typesposte"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{form.typesposte_id=data.id;form.typesposte=data}"
                    />
                    <div class="invalid-feedback" v-if="errors.typesposte_id">
                        <template v-for=" error in errors.typesposte_id" >  {{error[0]}}</template>

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
    name: 'CreateHorairestypespostes',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'typespostesData', 'parentId'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                debut: "",

                fin: "",

                typesposte_id: "",

                ordre: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.form.typesposte_id = this.parentId
            this.isLoading = true
            this.axios.post('/api/horairestypespostes', this.form).then(response => {
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
                debut: "",
                fin: "",
                typesposte_id: "",
                ordre: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        }
    }
}
</script>
