<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>date_debut </label>
                    <input v-model="form.date_debut" :class="errors.date_debut?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.date_debut" class="invalid-feedback">
                        <template v-for=" error in errors.date_debut"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>date_fin </label>
                    <input v-model="form.date_fin" :class="errors.date_fin?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.date_fin" class="invalid-feedback">
                        <template v-for=" error in errors.date_fin"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>statuts </label>
                    <input v-model="form.statuts" :class="errors.statuts?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.statuts" class="invalid-feedback">
                        <template v-for=" error in errors.statuts"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>creat_by </label>
                    <input v-model="form.creat_by" :class="errors.creat_by?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.creat_by" class="invalid-feedback">
                        <template v-for=" error in errors.creat_by"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cartes </label>
                    <CustomSelect
                        :key="form.carte"
                        :columnDefs="['libelle']"
                        :oldValue="form.carte"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{form.carte_id=data.id;form.carte=data}"
                        :url="`${axios.defaults.baseURL}/api/cartes-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.carte_id" class="invalid-feedback">
                        <template v-for=" error in errors.carte_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>users </label>
                    <CustomSelect
                        :key="form.user"
                        :columnDefs="['libelle']"
                        :oldValue="form.user"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{form.user_id=data.id;form.user=data}"
                        :url="`${axios.defaults.baseURL}/api/users-Aggrid`"
                        filter-key=""
                        filter-value=""
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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'CreateIdentifications',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'cartesData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                user_id: "",

                carte_id: "",

                date_debut: "",

                date_fin: "",

                statuts: "",

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
            this.axios.post('/api/identifications', this.form).then(response => {
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
                user_id: "",
                carte_id: "",
                date_debut: "",
                date_fin: "",
                statuts: "",
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
