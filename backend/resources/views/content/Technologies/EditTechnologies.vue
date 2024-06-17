<template>
    <b-overlay :show="isLoading" >
        <form @submit.prevent="EditLine()">
            <div class="mb-3">
                                    
                                    
                                    
                                    
                                    
                                    
                        <div class="form-group">
                            <label>identifiants_sadge </label>
                                                            <input type="text" :class="errors.identifiants_sadge?'form-control is-invalid':'form-control'"
                                       v-model="form.identifiants_sadge">
                            
                            <div class="invalid-feedback" v-if="errors.identifiants_sadge">
                                <template v-for=" error in errors.identifiants_sadge" >  {{error[0]}}</template>

                            </div>
                        </div>
                    
                                    
                        <div class="form-group">
                            <label>creat_by </label>
                                                            <input type="text" :class="errors.creat_by?'form-control is-invalid':'form-control'"
                                       v-model="form.creat_by">
                            
                            <div class="invalid-feedback" v-if="errors.creat_by">
                                <template v-for=" error in errors.creat_by" >  {{error[0]}}</template>

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
        name: 'EditTechnologies',
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
                this.axios.post('/api/technologies/' + this.form.id + '/update', this.form).then(response => {
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
                this.axios.post('/api/technologies/' + this.form.id + '/delete').then(response => {
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
