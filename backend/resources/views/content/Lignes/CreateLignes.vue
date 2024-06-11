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


                <!-- <div class="form-group">
                    <label>depart </label>
                    <input v-model="form.depart" :class="errors.depart?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.depart" class="invalid-feedback">
                        <template v-for=" error in errors.depart"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>arrive </label>
                    <input v-model="form.arrive" :class="errors.arrive?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.arrive" class="invalid-feedback">
                        <template v-for=" error in errors.arrive"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>distance </label>
                    <input v-model="form.distance" :class="errors.distance?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.distance" class="invalid-feedback">
                        <template v-for=" error in errors.distance"> {{ error[0] }}</template>

                    </div>
                </div>-->


                <div class="form-group">
                    <label>tarifs </label>
                    <input v-model="form.tarifs" :class="errors.tarifs?'form-control is-invalid':'form-control'"
                           min="0" type="number">

                    <div v-if="errors.tarifs" class="invalid-feedback">
                        <template v-for=" error in errors.tarifs"> {{ error[0] }}</template>

                    </div>
                </div>


                <!-- <div class="form-group">
                    <label>type </label>
                    <input v-model="form.type" :class="errors.type?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.type" class="invalid-feedback">
                        <template v-for=" error in errors.type"> {{ error[0] }}</template>

                    </div>
                </div> -->


                <div class="form-group">
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
    name: 'CreateLignes',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'villesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code: "",

                depart: "",

                arrive: "",

                distance: "",

                tarifs: "",

                type: "",

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
            this.axios.post('/api/lignes', this.form).then(response => {
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
                depart: "",
                arrive: "",
                distance: "",
                tarifs: "",
                type: "",
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
