<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


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
                    <label>contratsclients </label>
                    <CustomSelect
                        :key="form.contratsclient"
                        :columnDefs="['libelle']"
                        :oldValue="form.contratsclient"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.contratsclient_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/contratsclients-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.contratsclient_id" class="invalid-feedback">
                        <template v-for=" error in errors.contratsclient_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>prestations </label>
                    <CustomSelect
                        :key="form.prestation"
                        :columnDefs="['libelle']"
                        :oldValue="form.prestation"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.prestation_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/prestations-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.prestation_id" class="invalid-feedback">
                        <template v-for=" error in errors.prestation_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>sites </label>
                    <CustomSelect
                        :key="form.site"
                        :columnDefs="['libelle','client.Selectlabel']"
                        :oldValue="form.site"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.site_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/sites-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.site_id" class="invalid-feedback">
                        <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

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
    name: 'CreateContratssites',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'contratsclientsData',
        'prestationsData',
        'sitesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                contratsclient_id: "",

                site_id: "",

                prestation_id: "",

                agentsjour: "",

                agentsnuit: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/contratssites', this.form).then(response => {
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
                contratsclient_id: "",
                site_id: "",
                prestation_id: "",
                agentsjour: "",
                agentsnuit: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
            }
        }
    }
}
</script>
