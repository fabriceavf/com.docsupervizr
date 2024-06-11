<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">

                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>solde </label>
                        <input v-model="form.solde" :class="errors.solde?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.solde" class="invalid-feedback">
                            <template v-for=" error in errors.solde"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="form-group col-sm-3">
                        <label>code </label>
                        <input v-model="form.code" :class="errors.code?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.code" class="invalid-feedback">
                            <template v-for=" error in errors.code"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="form-group col-sm-3">
                        <label>UID MIFARE </label>
                        <input v-model="form.uid_mifare"
                               :class="errors.uid_mifa ?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.uid_mifa " class="invalid-feedback">
                            <template v-for=" error in errors.uid_mifa "> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="form-group col-sm-3">
                        <label>Etat </label>
                        <v-select
                            v-model="form.etats"
                            :options="EtatsData"
                            label="Selectlabel"
                        />
                        <div v-if="errors.etats" class="invalid-feedback">
                            <template v-for=" error in errors.etats "> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>sites </label>

                        <CustomSelect
                            :key="form.site"
                            :columnDefs="['libelle']"
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
                <div class="row">
                    <TransactionsView :carte="form.uid_mifare"></TransactionsView>
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
import VSelect from 'vue-select'
import TransactionsView from "./TransactionsView.vue";
export default {
    name: 'EditCartes',
    components: {
        CustomSelect, VSelect, Files,
        TransactionsView,
    },
    props: ['data', 'gridApi', 'modalFormId',
        'sitesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            EtatsData: [],
            form: {

                id: "",

                solde: "",

                code: "",

                uid_mifa: "",

                expiration: "",

                etats: "",

                site_id: "",

                decouvert: "",

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
        this.EtatsData = [
            'Activer', 'Desactiver'
        ]
    },
    methods: {
        EditLine() {
            this.isLoading = true
            this.axios.post('/api/cartes/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/cartes/' + this.form.id + '/delete').then(response => {
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
