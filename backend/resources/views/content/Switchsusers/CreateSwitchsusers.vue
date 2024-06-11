<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <!-- <div class="form-group">
                    <label>old_type </label>
                                                    <input type="text" :class="errors.old_type?'form-control is-invalid':'form-control'"
                               v-model="form.old_type">

                    <div class="invalid-feedback" v-if="errors.old_type">
                        <template v-for=" error in errors.old_type" >  {{error[0]}}</template>

                    </div>
                </div> -->


                <div class="form-group">
                    <label>new_type </label>
                    <CustomSelect :key="form.new_type" :columnDefs="['libelle']" :oldValue="form.new_type"
                                  :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :selectCallBack="(data) => form.new_type = data.id"
                                  :url="`${axios.defaults.baseURL}/api/typeseffectifs-Aggrid`" filter-key=""
                                  filter-value=""/>
                    <div v-if="errors.new_type" class="invalid-feedback">
                        <template v-for=" error in errors.new_type"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>action </label>
                    <input v-model="form.action" :class="errors.action?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.action" class="invalid-feedback">
                        <template v-for=" error in errors.action"> {{ error[0] }}</template>

                    </div>
                </div>


                <!-- <div class="form-group">
                    <label>creat_by </label>
                                                    <input type="text" :class="errors.creat_by?'form-control is-invalid':'form-control'"
                               v-model="form.creat_by">

                    <div class="invalid-feedback" v-if="errors.creat_by">
                        <template v-for=" error in errors.creat_by" >  {{error[0]}}</template>

                    </div>
                </div> -->


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

export default {
    name: 'CreateSwitchsusers',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'parentId'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                old_type: "",

                new_type: "",

                action: "",

                creat_by: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.form.old_type = this.parentId
            this.axios.post('/api/switchsusers', this.form).then(response => {
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
                old_type: "",
                new_type: "",
                action: "",
                creat_by: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        }
    }
}
</script>
