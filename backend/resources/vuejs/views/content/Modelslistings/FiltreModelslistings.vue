<template>
    <b-overlay :show="isLoading" >
        <form @submit.prevent="createLine()">
            <div class="mb-3">
                                    
                                    
                        <div class="form-group" v-if="canShowFilter('Libelle')">
                            <label>Libelle </label>
                                                            <input type="text" class="form-control"
                                       v-model="form.Libelle">
                            
                            <div class='div-error' v-if="errors.Libelle" show variant="danger">
                                {{errors.Libelle}}</div>
                        </div>
                    
                                    
                        <div class="form-group" v-if="canShowFilter('userFiltre')">
                            <label>userFiltre </label>
                                                            <input type="text" class="form-control"
                                       v-model="form.userFiltre">
                            
                            <div class='div-error' v-if="errors.userFiltre" show variant="danger">
                                {{errors.userFiltre}}</div>
                        </div>
                    
                                    
                        <div class="form-group" v-if="canShowFilter('userMatricule')">
                            <label>userMatricule </label>
                                                            <input type="text" class="form-control"
                                       v-model="form.userMatricule">
                            
                            <div class='div-error' v-if="errors.userMatricule" show variant="danger">
                                {{errors.userMatricule}}</div>
                        </div>
                    
                                    
                                    
                                    
                                    
                                    
                        <div class="form-group" v-if="canShowFilter('identifiants_sadge')">
                            <label>identifiants_sadge </label>
                                                            <input type="text" class="form-control"
                                       v-model="form.identifiants_sadge">
                            
                            <div class='div-error' v-if="errors.identifiants_sadge" show variant="danger">
                                {{errors.identifiants_sadge}}</div>
                        </div>
                    
                

                            </div>

            <button type="submit" class="btn btn-primary" >
                <i class="fas fas fa-search"></i> Appliquer
            </button>
        </form>
    </b-overlay>
</template>

<script>
    import $ from 'jquery'

    import Files from "@/components/Files.vue"
    import VSelect from 'vue-select'

    export default {
        name: 'FiltreModelslistings',
        components: { VSelect,Files },
        props: [
            'table',
                    ],
        data () {
            return {
                errors: [],
                isLoading: false,
                form: {
                
                id:"",
                
                Libelle:"",
                
                userFiltre:"",
                
                userMatricule:"",
                
                created_at:"",
                
                updated_at:"",
                
                extra_attributes:"",
                
                deleted_at:"",
                
                identifiants_sadge:"",
                                }
            }
        },
        methods: {
            createLine () {
                this.$emit('applyfilter', this.form)
            },
            canShowFilter (name) {
                let can=true
                const queryString = window.location.search
                const urlParams = new URLSearchParams(queryString);
                if(urlParams.has(`filter_${name}`)){
                    can=false
                }
                return can
            }
        }
    }
</script>
