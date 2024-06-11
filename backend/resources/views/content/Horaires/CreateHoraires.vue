<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <form class="mb-3">
                <div class="form-group ">
                    <label>Libelle <span class="text-danger">*</span></label>
                    <input v-model="form.libelle" class="form-control" required type="text">
                </div>

                <div class="row ">
                    <div class="form-group col-6">
                        <label>Debut <span class="text-danger">*</span></label>
                        <input v-model="form.debut" class="form-control" required type="time">
                    </div>
                    <div class="form-group col-6">
                        <label>Fin <span class="text-danger">*</span></label>
                        <input v-model="form.fin" class="form-control" required type="time">
                    </div>
                </div>
                <div class="row ">
                    <div class="form-group col-4">
                        <label>volume horaire minimum <span class="text-danger">*</span></label>
                        <input v-model="form.vol_horaire_min" class="form-control" required type="time">
                    </div>
                    <div class="form-group col-4">
                        <label>nombre de poitagne minimum <span class="text-danger">*</span></label>
                        <input v-model="form.nmb_pointage_min" class="form-control" min="0" required type="number">
                    </div>
                    <div class="form-group col-4">
                        <label>Tolérance <span class="text-danger">*</span></label>
                        <input v-model="form.tolerance" class="form-control" required type="number">
                    </div>
                </div>


            </form>
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
    name: 'CreateHoraires',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'tachesData',
        'parentKey',
        'parentId'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                debut: "",

                fin: "",

                tolerance: "",

                type: "",

                tache_id: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                identifiants_sadge: "",

                creat_by: "",

                parent: "",

                parentId: "",
            }
        }
    },
    methods: {
        createLine() {

            this.form.parentId = this.parentId
            // this.form.parent = this.parentKey
            this.form.poste_id = this.parentId
            this.isLoading = true
            this.axios.post('/api/horaires', this.form).then(response => {
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
                debut: "",
                fin: "",
                tolerance: "",
                type: "",
                tache_id: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
                identifiants_sadge: "",
                creat_by: "",
                parent: "",
                parentId: "",
            }
        }
    }
}
</script>
