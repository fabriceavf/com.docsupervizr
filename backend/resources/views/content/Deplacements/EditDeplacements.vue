<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">

                <div class="row">
                    <div class="col-sm form-group">
                        <label>lignes </label>

                        <CustomSelect
                            :key="form.ligne"
                            :columnDefs="['libelle']"
                            :oldValue="form.ligne"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>{form.ligne_id=data.id;form.ligne=data}"
                            :url="`${axios.defaults.baseURL}/api/lignes-Aggrid`"
                            filter-key=""
                            filter-value=""
                        />
                        <div v-if="errors.ligne_id" class="invalid-feedback">
                            <template v-for=" error in errors.ligne_id"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="col-sm form-group">
                        <label>moyenstransports </label>

                        <CustomSelect
                            :key="form.moyenstransport"
                            :columnDefs="['libelle']"
                            :oldValue="form.moyenstransport"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>{form.moyenstransport_id=data.id;form.moyenstransport=data}"
                            :url="`${axios.defaults.baseURL}/api/moyenstransports-Aggrid`"
                            filter-key=""
                            filter-value=""
                        />
                        <div v-if="errors.moyenstransport_id" class="invalid-feedback">
                            <template v-for=" error in errors.moyenstransport_id"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm form-group">
                        <label>date </label>
                        <input v-model="form.date" :class="errors.date?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.date" class="invalid-feedback">
                            <template v-for=" error in errors.date"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="col-sm form-group">
                        <label>debut_prevu </label>
                        <input v-model="form.debut_prevu"
                               :class="errors.debut_prevu?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.debut_prevu" class="invalid-feedback">
                            <template v-for=" error in errors.debut_prevu"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div class="col-sm form-group">
                        <label>fin_prevu </label>
                        <input v-model="form.fin_prevu"
                               :class="errors.fin_prevu?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.fin_prevu" class="invalid-feedback">
                            <template v-for=" error in errors.fin_prevu"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm form-group">
                        <label>Programmes passage</label>
                        <SiteDays :parentDate="form.date" :parentId="form.id"/>

                    </div>
                </div>

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
import SiteDays from "./SiteDays.vue";
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'EditDeplacements',
    components: {CustomSelect, Files, SiteDays},
    props: ['data', 'gridApi', 'modalFormId',
        'lignesData',
        'lignesmoyenstransportsData',
        'moyenstransportsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                date: "",

                debut_prevu: "",

                fin_prevu: "",

                lignesmoyenstransport_id: "",

                creat_by: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                moyenstransport_id: "",

                ligne_id: "",
            }
        }
    },

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/deplacements/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/deplacements/' + this.form.id + '/delete').then(response => {
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
