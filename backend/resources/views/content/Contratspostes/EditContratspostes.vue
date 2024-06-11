<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>jours </label>
                    <input v-model="form.jours" :class="errors.jours?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jours" class="invalid-feedback">
                        <template v-for=" error in errors.jours"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>agentsjour </label>
                    <input v-model="form.agentsjour" :class="errors.agentsjour?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.agentsjour" class="invalid-feedback">
                        <template v-for=" error in errors.agentsjour"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>agentsnuit </label>
                    <input v-model="form.agentsnuit" :class="errors.agentsnuit?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.agentsnuit" class="invalid-feedback">
                        <template v-for=" error in errors.agentsnuit"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>contratssites </label>
                    <CustomSelect
                        :key="form.contratssite"
                        :columnDefs="['libelle']"
                        :oldValue="form.contratssite"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.contratssite_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/contratssites-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.contratssite_id" class="invalid-feedback">
                        <template v-for=" error in errors.contratssite_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>postes </label>
                    <CustomSelect
                        :key="form.poste"
                        :columnDefs="['libelle']"
                        :oldValue="form.poste"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.poste_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/postes-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.poste_id" class="invalid-feedback">
                        <template v-for=" error in errors.poste_id"> {{ error[0] }}</template>

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
    name: 'EditContratspostes',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
        'contratssitesData',
        'postesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                contratssite_id: "",

                poste_id: "",

                jours: "",

                agentsjour: "",

                agentsnuit: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

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
            this.axios.post('/api/contratspostes/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/contratspostes/' + this.form.id + '/delete').then(response => {
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
