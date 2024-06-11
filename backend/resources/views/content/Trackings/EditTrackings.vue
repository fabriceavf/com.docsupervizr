<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>date_debut </label>
                    <input v-model="form.date_debut" :class="errors.date_debut?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.date_debut" class="invalid-feedback">
                        <template v-for=" error in errors.date_debut"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>date_fin </label>
                    <input v-model="form.date_fin" :class="errors.date_fin?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.date_fin" class="invalid-feedback">
                        <template v-for=" error in errors.date_fin"> {{ error[0] }}</template>

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
                    <label>balises </label>

                    <CustomSelect
                        :key="form.balise"
                        :columnDefs="['libelle']"
                        :oldValue="form.balise"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{form.balise_id=data.id;form.balise=data}"
                        :url="`${axios.defaults.baseURL}/api/balises-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.balise_id" class="invalid-feedback">
                        <template v-for=" error in errors.balise_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>moyenstransports </label>

                    <CustomSelect
                        :key="form.moyenstransport"
                        :columnDefs="['libelle']"
                        :oldValue="form.moyenstransport"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{form.moyenstransport_id=data.id;form.moyenstransport=data}"
                        :url="`${axios.defaults.baseURL}/api/moyenstransports-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.moyenstransport_id" class="invalid-feedback">
                        <template v-for=" error in errors.moyenstransport_id"> {{ error[0] }}</template>

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
    name: 'EditTrackings',
    components: {CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
        'balisesData',
        'moyenstransportsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                balise_id: "",

                moyenstransport_id: "",

                date_debut: "",

                date_fin: "",

                creat_by: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            }
        }
    },

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/trackings/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/trackings/' + this.form.id + '/delete').then(response => {
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
