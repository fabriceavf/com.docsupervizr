<template>
    <b-overlay :show="isLoading" >
        <form @submit.prevent="createLine()">
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

            <button type="submit" class="btn btn-primary" >
                <i class="fas fa-floppy-disk"></i> Créer
            </button>
        </form>
    </b-overlay>
</template>

<script>
    import $ from 'jquery'
    import Files from "@/components/Files.vue"
    import CustomSelect from "@/components/CustomSelect.vue"
    export default {
        name: 'CreateTechnologies',
        components: { CustomSelect,Files },
        props: [
            'gridApi',
            'modalFormId',
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
        methods: {
            createLine () {
                this.isLoading = true
                this.axios.post('/api/technologies', this.form).then(response => {
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
            resetForm () {
                this.form = {
                                            id:"",
                                            created_at:"",
                                            updated_at:"",
                                            deleted_at:"",
                                            extra_attributes:"",
                                            identifiants_sadge:"",
                                            creat_by:"",
                                    }
            }
        }
    }
</script>
