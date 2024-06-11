<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>present </label>
                    <input v-model="form.present" :class="errors.present?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.present" class="invalid-feedback">
                        <template v-for=" error in errors.present"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>listingsjours </label>
                    <v-select
                        v-model="form.listingsjour_id"
                        :options="listingsjoursData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.listingsjour_id" class="invalid-feedback">
                        <template v-for=" error in errors.listingsjour_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>users </label>
                    <v-select
                        v-model="form.user_id"
                        :options="usersData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.user_id" class="invalid-feedback">
                        <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

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
    name: 'CreateListingsetats',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'listingsjoursData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                listingsjour_id: "",

                user_id: "",

                present: "",

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
            this.axios.post('/api/listingsetats', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
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
                listingsjour_id: "",
                user_id: "",
                present: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        }
    }
}
</script>
