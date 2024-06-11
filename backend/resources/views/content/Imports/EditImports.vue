<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="row">
                    <div class="form-group col-sm">
                        <label>type </label>
                        <input v-model="form.type" :class="errors.type?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.type" class="invalid-feedback">
                            <template v-for=" error in errors.type"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <!--                    <div class="form-group col-sm">-->
                    <!--                        <label>fichiers </label>-->
                    <!--                        <input v-model="form.fichiers" :class="errors.fichiers?'form-control is-invalid':'form-control'"-->
                    <!--                               type="text">-->

                    <!--                        <div v-if="errors.fichiers" class="invalid-feedback">-->
                    <!--                            <template v-for=" error in errors.fichiers"> {{ error[0] }}</template>-->

                    <!--                        </div>-->
                    <!--                    </div>-->


                    <!--                    <div class="form-group col-sm">-->
                    <!--                        <label>liaisons </label>-->
                    <!--                        <input v-model="form.liaisons" :class="errors.liaisons?'form-control is-invalid':'form-control'"-->
                    <!--                               type="text">-->

                    <!--                        <div v-if="errors.liaisons" class="invalid-feedback">-->
                    <!--                            <template v-for=" error in errors.liaisons"> {{ error[0] }}</template>-->

                    <!--                        </div>-->
                    <!--                    </div>-->


                    <!--                    <div class="form-group col-sm">-->
                    <!--                        <label>identifiant </label>-->
                    <!--                        <input v-model="form.identifiant"-->
                    <!--                               :class="errors.identifiant?'form-control is-invalid':'form-control'"-->
                    <!--                               type="text">-->

                    <!--                        <div v-if="errors.identifiant" class="invalid-feedback">-->
                    <!--                            <template v-for=" error in errors.identifiant"> {{ error[0] }}</template>-->

                    <!--                        </div>-->
                    <!--                    </div>-->


                    <div class="form-group col-sm">
                        <label>etats </label>
                        <input v-model="form.etats" :class="errors.etats?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.etats" class="invalid-feedback">
                            <template v-for=" error in errors.etats"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="form-group col-sm">
                        <label>importe par </label>
                        <!-- <input v-model="form.creat_by" :class="errors.creat_by?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.creat_by" class="invalid-feedback">
                            <template v-for=" error in errors.creat_by"> {{ error[0] }}</template>

                        </div> -->
                        <CustomSelect :key="form.user" :columnDefs="['nom', 'prenom']" :disable="true"
                                      :oldValue="form.user"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.user_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/users-Aggrid`" filter-key="type_id"
                                      filter-value="1"/>

                        <div v-if="errors.user_id" class="invalid-feedback">
                            <template v-for="error in errors.user_id">
                                {{ error[0] }}
                            </template>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12">

                    <ModificationImports :type="data.type" :typeValue="data.id"/>
                </div>


            </div>

        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import ModificationImports from "./ModificationImports.vue";

export default {
    name: 'EditImports',
    components: {ModificationImports, VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                type: "",

                fichiers: "",

                liaisons: "",

                identifiant: "",

                etats: "",

                creat_by: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",
            },
        }
    },
    mounted() {
        this.form = this.data
    },
    methods: {
        EditLine() {
            this.isLoading = true
            this.axios.post('/api/imports/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/imports/' + this.form.id + '/delete').then(response => {
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
