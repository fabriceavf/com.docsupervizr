<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>

                <div :style="{ display: ishidden('client_id') }" class="row">
                    <div class="form-group col-sm-12 ">
                        <label>clients </label>
                        <CustomSelect :key="form.client" :columnDefs="['libelle']" :oldValue="form.client"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.client_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/clients-Aggrid`" filter-key=""
                                      filter-value=""/>
                        <div v-if="errors.client_id" class="invalid-feedback">
                            <template v-for=" error in errors.client_id"> {{ error[0] }}</template>

                        </div>
                    </div>

                </div>
                <div :style="{ display: ishidden('zone_id') }" class="row">
                    <div class="form-group col-sm-12 ">
                        <label>zones </label>
                        <CustomSelect :key="form.zone" :columnDefs="['libelle']" :oldValue="form.zone"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.zone_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/zones-Aggrid`" filter-key=""
                                      filter-value=""/>
                        <div v-if="errors.zone_id" class="invalid-feedback">
                            <template v-for=" error in errors.zone_id"> {{ error[0] }}</template>

                        </div>
                    </div>

                </div>

                <div :style="{ display: ishidden('typessite_id') }" class="row">
                    <div class="form-group col-sm-12 ">
                        <label>typessites </label>
                        <CustomSelect :key="form.typessite" :columnDefs="['libelle']" :oldValue="form.typessite"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.typessite_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/typessites-Aggrid`" filter-key=""
                                      filter-value=""/>
                        <div v-if="errors.typessite_id" class="invalid-feedback">
                            <template v-for=" error in errors.typessite_id"> {{ error[0] }}</template>

                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-sm">
                        <label>date de debut </label>
                        <input v-model="form.date_debut" class="form-control" required type="date"/>
                    </div>
                    <div class="form-group col-sm">
                        <label>date de debut </label>
                        <input v-model="form.date_fin" class="form-control" required type="date"/>
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
    name: 'CreateSites',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'clientsData',
        'zonesData',
        'champsAfficher'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                client_id: "",

                zone_id: "",

                created_at: "",

                updated_at: "",

                type: "",

                extra_attributes: "",

                deleted_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.form.type = "nonimporter"
            this.isLoading = true
            this.axios.post('/api/sites', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
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
                client_id: "",
                zone_id: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
            }
        },
        ishidden(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            if (this.champsAfficher.includes(fieldName)) {
                return "none"
            }
        },
    }
}
</script>
