<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">

                <div class="form-group ">
                    <p>Libelle </p>
                    <input v-model="form.libelle" :class="errors.libelle ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>


                </div>
                <div class="form-group ">
                    <p>type </p>
                    <!-- <input v-model="form.type" :class="errors.type ? 'form-control is-invalid' : 'form-control'"
                        type="text"> -->
                    <v-select v-model="form.type" :options="validationsData" :required="true" label="Selectlabel"/>

                    <div v-if="errors.type" class="invalid-feedback">
                        <template v-for=" error in errors.type"> {{ error[0] }}</template>

                    </div>

                </div>
                <div class="form-group">
                    <label>zones </label>
                    <CustomSelect :key="form.zone" :columnDefs="['libelle']" :oldValue="form.zone"
                                  :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :required="true"
                                  :selectCallBack="(data) => { form.zone_id = data.id; form.zone = data }"
                                  :url="`${axios.defaults.baseURL}/api/zones-Aggrid`" filter-key="" filter-value=""/>
                    <div v-if="errors.zone_id" class="invalid-feedback">
                        <template v-for=" error in errors.zone_id"> {{ error[0] }}</template>

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
import VSelect from "vue-select";

export default {
    name: 'CreateHomezones',
    components: {CustomSelect, VSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'zonesData',
    ],
    data() {
        return {
            errors: [],
            validationsData: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                type: "",

                modelslisting_id: "",

                zone_id: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            }
        }
    },
    mounted() {

        this.validationsData = ["client", "interne", "operationnel", "GrosClient"]

    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/homezones', this.form).then(response => {
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
                modelslisting_id: "",
                zone_id: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        }
    }
}
</script>
