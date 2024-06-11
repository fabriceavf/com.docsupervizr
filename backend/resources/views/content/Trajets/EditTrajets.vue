<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'EditTrajets',
    components: {CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
        'lignesData',
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

                arrive: "",

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

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/trajets/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/trajets/' + this.form.id + '/delete').then(response => {
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
