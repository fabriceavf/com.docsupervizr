<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

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
    name: 'CreateGroupepermissions',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

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
            this.axios.post('/api/groupepermissions', this.form).then(response => {
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
                libelle: "",
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
