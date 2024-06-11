<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">


            <div class="row">
                <div class="form-group col-sm">
                    <label>code </label>
                    <input v-model="form.code" :class="errors.code?'form-control is-invalid':'form-control'"
                           disabled type="text">

                    <div v-if="errors.code" class="invalid-feedback">
                        <template v-for=" error in errors.code"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group  col-sm">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           disabled type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group  col-sm">
                    <label>jours </label>
                    <input v-model="form.jours" :class="errors.jours?'form-control is-invalid':'form-control'"
                           disabled type="text">

                    <div v-if="errors.jours" class="invalid-feedback">
                        <template v-for=" error in errors.jours"> {{ error[0] }}</template>

                    </div>
                </div>
            </div>
            <div class="row">


                <div class="form-group  col-sm">
                    <label>contrats clients </label>
                    <v-select
                        v-model="form.contratsclient_id"
                        :options="contratsclientsData"
                        :reduce="ele => ele.id"
                        disabled label="Selectlabel"
                    />
                    <div v-if="errors.contratsclient_id" class="invalid-feedback">
                        <template v-for=" error in errors.contratsclient_id"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group  col-sm">
                    <label>pointeuses </label>
                    <CustomSelect
                        :key="form.pointeuse"
                        :columnDefs="['libelle']"
                        :oldValue="form.pointeuse"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.pointeuse_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/pointeuses-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.pointeuse_id" class="invalid-feedback">
                        <template v-for=" error in errors.pointeuse_id"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group  col-sm">
                    <label>sites </label>
                    <v-select
                        v-model="form.site_id"
                        :options="sitesData"
                        :reduce="ele => ele.id"
                        disabled label="Selectlabel"
                    />
                    <div v-if="errors.site_id" class="invalid-feedback">
                        <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group  col-sm">
                    <label>Client </label>
                    <input v-model="client" class="form-control"
                           disabled type="text">
                    <div v-if="errors.site_id" class="invalid-feedback">
                        <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-6">
                    <h3>Faction jour</h3>
                    <PostesagentsView :parent='form' faction="jour"></PostesagentsView>
                </div>
                <div class="col-sm-6">
                    <h3>Faction nuit</h3>
                    <PostesagentsView :parent='form' faction="nuit"></PostesagentsView>
                </div>

            </div>
            <div class="mb-3">


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
import PostesagentsView from "./../Postes/Postesagents/PostesagentsView.vue";

export default {
    name: 'EditPostes',
    components: {VSelect, CustomSelect, Files, PostesagentsView},
    props: ['data', 'gridApi', 'modalFormId',
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
            }
        }
    },

    mounted() {
        this.form = this.data
    },

    computed: {
        client: function () {
            let data = ""
            try {
                let site = this.sitesData.filter(data => data.id == this.form.site_id)[0]
                // console.log('voici le site ',site)
                data = site.client.Selectlabel
            } catch (e) {
            }


            return data


        },
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/postes/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/postes/' + this.form.id + '/delete').then(response => {
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
