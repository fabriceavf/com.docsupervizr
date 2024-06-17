<template>
    <b-overlay :show="isLoading" >
        <form @submit.prevent="createLine()">
            <div class="mb-3">
                                    
                                    
                                    
                                    
                                    
                                    
                        <div class="form-group" v-if="canShowFilter('identifiants_sadge')">
                            <label>identifiants_sadge </label>
                                                            <input type="text" class="form-control"
                                       v-model="form.identifiants_sadge">
                            
                            <div class='div-error' v-if="errors.identifiants_sadge" show variant="danger">
                                {{errors.identifiants_sadge}}</div>
                        </div>
                    
                                    
                        <div class="form-group" v-if="canShowFilter('creat_by')">
                            <label>creat_by </label>
                                                            <input type="text" class="form-control"
                                       v-model="form.creat_by">
                            
                            <div class='div-error' v-if="errors.creat_by" show variant="danger">
                                {{errors.creat_by}}</div>
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
    import CustomSelect from "@/components/CustomSelect.vue"

    export default {
        name: 'FiltreIntroductions',
        components: { CustomSelect,Files },
        props: [
            'table',
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
