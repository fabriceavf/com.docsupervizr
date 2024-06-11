<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>code </label>
                    <input v-model="form.code" :class="errors.code ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.code" class="invalid-feedback">
                        <template v-for=" error in errors.code"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>

                <!--
                                <div class="form-group">
                                    <label>nature </label>
                                    <input type="text" :class="errors.nature?'form-control is-invalid':'form-control'"
                                           v-model="form.nature">

                                    <div class="invalid-feedback" v-if="errors.nature">
                                        <template v-for=" error in errors.nature"> {{ error[0] }}</template>

                                    </div>
                                </div> -->

                <!--
                                <div class="form-group">
                                    <label>coordonnees </label>
                                    <input type="text" :class="errors.coordonnees?'form-control is-invalid':'form-control'"
                                           v-model="form.coordonnees">

                                    <div class="invalid-feedback" v-if="errors.coordonnees">
                                        <template v-for=" error in errors.coordonnees"> {{ error[0] }}</template>

                                    </div>
                                </div> -->

                <div class="row">
                    <div class="form-group col-sm">
                        <label>Nbs jours /Semaine</label>
                        <input v-model="form.jours" :class="errors.jours ? 'form-control is-invalid' : 'form-control'"
                               :max="7" :min="0" type="number">

                        <div v-if="errors.jours" class="invalid-feedback">
                            <template v-for=" error in errors.jours"> {{ error[0] }}</template>

                        </div>
                    </div>

                    <div class="form-group col-sm">
                        <label>max jours </label>
                        <input v-model="form.maxnuits" :class="errors.jours?'form-control is-invalid':'form-control'"
                               :max="7"
                               :min="0"
                               type="number">

                        <div v-if="errors.jours" class="invalid-feedback">
                            <template v-for=" error in errors.jours"> {{ error[0] }}</template>

                        </div>
                    </div>

                    <div class="form-group col-sm">
                        <label>max nuits </label>
                        <input v-model="form.maxjours" :class="errors.jours?'form-control is-invalid':'form-control'"
                               :max="7"
                               :min="0"
                               type="number">

                        <div v-if="errors.jours" class="invalid-feedback">
                            <template v-for=" error in errors.jours"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- <div class="form-group col-sm-12">
                        <label>contratsclients </label>
                        <CustomSelect :key="form.contratsclient"
                                      :url="`${axios.defaults.baseURL}/api/contratsclients-Aggrid`"
                                      :columnDefs="['libelle']" filter-key="" filter-value=""
                                      :oldValue="form.contratsclient"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.contratsclient_id = data.id"
                        />
                        <div class="invalid-feedback" v-if="errors.contratsclient_id">
                            <template v-for=" error in errors.contratsclient_id"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>sites </label>
                        <CustomSelect
                            :key="form.site"
                            :url="`${axios.defaults.baseURL}/api/sites-Aggrid`"
                            :columnDefs="['libelle','client.Selectlabel']"
                            filter-key=""
                            filter-value=""
                            :oldValue="form.site"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>form.site_id=data.id"
                        />
                        <div class="invalid-feedback" v-if="errors.site_id">
                            <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                        </div>
                    </div> -->
                    <div class="form-group  col-sm-12">
                        <label>sites </label>
                        <CustomSelect :key="form.site" :columnDefs="['libelle', 'client.Selectlabel']"
                                      :oldValue="form.site"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.site_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/sites-Aggrid`" filter-key=""
                                      filter-value=""/>
                        <div v-if="errors.site_id" class="invalid-feedback">
                            <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                        </div>
                    </div>

                    <div class="form-group  col-sm-12">
                        <label>type </label>
                        <CustomSelect :key="form.typesposte" :columnDefs="['libelle']"
                                      :oldValue="form.typesposte"
                                      :renderCallBack="(data) => `${data.Selectlabel}`"
                                      :selectCallBack="(data) => form.typesposte_id = data.id"
                                      :url="`${axios.defaults.baseURL}/api/typespostes-Aggrid`" filter-key=""
                                      filter-value=""/>
                        <div v-if="errors.typesposte_id" class="invalid-feedback">
                            <template v-for=" error in errors.typesposte_id"> {{ error[0] }}</template>

                        </div>
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
    name: 'CreatePostes',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'contratsclientsData',
        'pointeusesData',
        'sitesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code: "",

                libelle: "",

                nature: "",

                coordonnees: "",

                site_id: "",

                pointeuse_id: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",

                creat_by: "",

                jours: "",

                contratsclient_id: "",
                typesposte_id: "",

                type: "",


                maxjours: "",


                maxnuits: "",
            }
        }
    },
    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
                }
            } catch (e) {
            }

            return router;
        },
    },
    methods: {
        createLine() {
            this.isLoading = true
            if (this.$routeData.meta.operationnel) {
                this.form.type = "operationnel"
            } else if (this.$routeData.meta.nonimporter) {
                this.form.type = "nonimporter"
            } else if (this.$routeData.meta.baladeur) {
                this.form.type = "baladeur"
            } else if (this.$routeData.meta.surete_aeriene) {
                this.form.type = "surete_aeriene"
            }
            this.axios.post('/api/postes', this.form).then(response => {
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
                code: "",
                libelle: "",
                nature: "",
                coordonnees: "",
                site_id: "",
                pointeuse_id: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
                identifiants_sadge: "",
                creat_by: "",
                jours: "",
                contratsclient_id: "",
            }
        }
    }
}
</script>
