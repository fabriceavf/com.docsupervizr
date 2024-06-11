<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
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
                    <CustomSelect :key="form.typeseffectif" :columnDefs="['libelle']" :oldValue="form.typeseffectif"
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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'EditSwitchsusers',
    components: {CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
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

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/switchsusers/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/switchsusers/' + this.form.id + '/delete').then(response => {
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
