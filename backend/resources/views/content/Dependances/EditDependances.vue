<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
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
                    <label>version </label>
                    <input v-model="form.version" :class="errors.version?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.version" class="invalid-feedback">
                        <template v-for=" error in errors.version"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>identifiants_sadge </label>
                    <input v-model="form.identifiants_sadge"
                           :class="errors.identifiants_sadge?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.identifiants_sadge" class="invalid-feedback">
                        <template v-for=" error in errors.identifiants_sadge"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>badges </label>
                    <CustomSelect
                        :key="form.badge"
                        :columnDefs="['libelle']"
                        :oldValue="form.badge"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.badge_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/badges-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.badge_id" class="invalid-feedback">
                        <template v-for=" error in errors.badge_id"> {{ error[0] }}</template>

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
    name: 'EditDependances',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
        'badgesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                badge_id: "",

                libelle: "",

                created_at: "",

                updated_at: "",

                version: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",
            }
        }
    },

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/dependances/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/dependances/' + this.form.id + '/delete').then(response => {
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
