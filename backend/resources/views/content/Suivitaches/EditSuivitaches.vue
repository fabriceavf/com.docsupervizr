<template>
    <b-overlay :show="isLoading" >
        <form @submit.prevent="EditLine()">
            <div class="mb-3">






<div class="form-group">
            <label>libelle </label>
                                            <input type="text" :class="errors.libelle?'form-control is-invalid':'form-control'"
                       v-model="form.libelle">

            <div class="invalid-feedback" v-if="errors.libelle">
                <template v-for=" error in errors.libelle" >  {{error[0]}}</template>

            </div>
        </div>


        <div class="form-group">
            <label>priorite </label>
                                            <input type="text" :class="errors.priorite?'form-control is-invalid':'form-control'"
                       v-model="form.priorite">

            <div class="invalid-feedback" v-if="errors.priorite">
                <template v-for=" error in errors.priorite" >  {{error[0]}}</template>

            </div>
        </div>
        <div class="form-group">
            <label>date_demande </label>
                                            <input type="date" :class="errors.date_demande?'form-control is-invalid':'form-control'"
                       v-model="form.date_demande">

            <div class="invalid-feedback" v-if="errors.date_demande">
                <template v-for=" error in errors.date_demande" >  {{error[0]}}</template>

            </div>
        </div>


        <div class="form-group">
            <label>deadline </label>
                                            <input type="date" :class="errors.deadline?'form-control is-invalid':'form-control'"
                       v-model="form.deadline">

            <div class="invalid-feedback" v-if="errors.deadline">
                <template v-for=" error in errors.deadline" >  {{error[0]}}</template>

            </div>
        </div>
        <div class="form-group">
            <label>date_fin </label>
                                            <input type="date" :class="errors.date_fin?'form-control is-invalid':'form-control'"
                       v-model="form.date_fin">

            <div class="invalid-feedback" v-if="errors.date_fin">
                <template v-for=" error in errors.date_fin" >  {{error[0]}}</template>

            </div>
        </div>


        <div class="form-group">
            <label>faisabilite </label>
                                            <input type="text" :class="errors.faisabilite?'form-control is-invalid':'form-control'"
                       v-model="form.faisabilite">

            <div class="invalid-feedback" v-if="errors.faisabilite">
                <template v-for=" error in errors.faisabilite" >  {{error[0]}}</template>

            </div>
        </div>
        <div class="form-group">
            <label>commentaire </label>
                                            <input type="text" :class="errors.commentaire?'form-control is-invalid':'form-control'"
                       v-model="form.commentaire">

            <div class="invalid-feedback" v-if="errors.commentaire">
                <template v-for=" error in errors.commentaire" >  {{error[0]}}</template>

            </div>
        </div>


        <div class="form-group">
    <label>projets </label>
    <CustomSelect
        :key="form.projet"
        :columnDefs="['libelle']"
        :oldValue="form.projet"
        :renderCallBack="(data)=>`${data.Selectlabel}`"
        :selectCallBack="(data)=>form.projet_id=data.id"
        :url="`${axios.defaults.baseURL}/api/projets-Aggrid`"
        filter-key=""
        filter-value=""
    />
    <div v-if="errors.projet_id" class="invalid-feedback">
        <template v-for=" error in errors.projet_id"> {{ error[0] }}</template>

    </div>
</div>
<div class="form-group">
    <label>clients </label>
    <CustomSelect
        :key="form.client"
        :columnDefs="['libelle']"
        :oldValue="form.client"
        :renderCallBack="(data)=>`${data.Selectlabel}`"
        :selectCallBack="(data)=>form.client_id=data.id"
        :url="`${axios.defaults.baseURL}/api/clients-Aggrid`"
        filter-key=""
        filter-value=""
    />
    <div v-if="errors.client_id" class="invalid-feedback">
        <template v-for=" error in errors.client_id"> {{ error[0] }}</template>

    </div>
</div>
<div class="form-group">
    <label>users </label>
    <CustomSelect :key="form.user" :columnDefs="['nom', 'prenom']" :oldValue="form.user"
                            :renderCallBack="(data) => `${data.Selectlabel}`"
                            :selectCallBack="(data) => form.user_id = data.id"
                            :url="`${axios.defaults.baseURL}/api/users-Aggrid`" filter-key="" filter-value="" />


    <div v-if="errors.user_id" class="invalid-feedback">
        <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

    </div>
</div>


                </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" >
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button type="button" class="btn btn-danger" @click.prevent="DeleteLine()">
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>
        </form>
    </b-overlay>
</template>

<script>
    import $ from 'jquery'
    import Files from "@/components/Files.vue"
    import CustomSelect from "@/components/CustomSelect.vue"
    export default {
        name: 'EditSuivitaches',
        components: { CustomSelect,Files },
        props: ['data','gridApi','modalFormId',
                    ],
        data () {
            return {
                errors: [],
                isLoading: false,
                form: {

                        id:"",

                        created_at:"",

                        updated_at:"",

                        deleted_at:"",

                        extra_attributes:"",

                        identifiants_sadge:"",

                        creat_by:"",
                                    }
            }
        },

        mounted () {
            this.form = this.data
                                                                                                                                                                                                                        },
        methods: {

            EditLine () {
                this.isLoading = true
                this.axios.post('/api/Suivitaches/' + this.form.id + '/update', this.form).then(response => {
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
            DeleteLine () {
                this.isLoading = true
                this.axios.post('/api/Suivitaches/' + this.form.id + '/delete').then(response => {
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
