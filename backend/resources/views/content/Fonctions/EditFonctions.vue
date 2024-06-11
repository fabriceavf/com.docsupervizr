<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


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


                <!-- <div class="form-group">
                    <label>identifiants_sadge </label>
                    <input type="text" :class="errors.identifiants_sadge?'form-control is-invalid':'form-control'"
                           v-model="form.identifiants_sadge">

                    <div class="invalid-feedback" v-if="errors.identifiants_sadge">
                        <template v-for=" error in errors.identifiants_sadge"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>creat_by </label>
                    <input type="text" :class="errors.creat_by?'form-control is-invalid':'form-control'"
                           v-model="form.creat_by">

                    <div class="invalid-feedback" v-if="errors.creat_by">
                        <template v-for=" error in errors.creat_by"> {{ error[0] }}</template>

                    </div>
                </div> -->


                <div class="form-group">
                    <label>services </label>
                    <CustomSelect
                        :key="form.service"
                        :columnDefs="['libelle']"
                        :oldValue="form.service"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.service_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/services-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.service_id" class="invalid-feedback">
                        <template v-for=" error in errors.service_id"> {{ error[0] }}</template>

                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'EditFonctions',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
        'servicesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code: "",

                libelle: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                service_id: "",

                deleted_at: "",

                identifiants_sadge: "",

                creat_by: "",
            }
        }
    },

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/fonctions/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
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
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/fonctions/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
    }
}
</script>
