<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>date </label>
                    <input v-model="form.date" :class="errors.date?'form-control is-invalid':'form-control'"
                           type="date">

                    <div v-if="errors.date" class="invalid-feedback">
                        <template v-for=" error in errors.date"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>debut_prevu </label>
                    <input v-model="form.debut_prevu"
                           :class="errors.debut_prevu?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.debut_prevu" class="invalid-feedback">
                        <template v-for=" error in errors.debut_prevu"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>fin_prevu </label>
                    <input v-model="form.fin_prevu" :class="errors.fin_prevu?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.fin_prevu" class="invalid-feedback">
                        <template v-for=" error in errors.fin_prevu"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>debut_reel </label>
                    <input v-model="form.debut_reel" :class="errors.debut_reel?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.debut_reel" class="invalid-feedback">
                        <template v-for=" error in errors.debut_reel"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>debut_realise </label>
                    <input v-model="form.debut_realise"
                           :class="errors.debut_realise?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.debut_realise" class="invalid-feedback">
                        <template v-for=" error in errors.debut_realise"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>fin_realise </label>
                    <input v-model="form.fin_realise"
                           :class="errors.fin_realise?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.fin_realise" class="invalid-feedback">
                        <template v-for=" error in errors.fin_realise"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>etats </label>
                    <input v-model="form.etats" :class="errors.etats?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.etats" class="invalid-feedback">
                        <template v-for=" error in errors.etats"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>identifiants_sadge </label>
                    <input v-model="form.identifiants_sadge"
                           :class="errors.identifiants_sadge?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.identifiants_sadge" class="invalid-feedback">
                        <template v-for=" error in errors.identifiants_sadge"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>horaires </label>
                    <CustomSelect
                        :key="form.horaire"
                        :columnDefs="['libelle']"
                        :oldValue="form.horaire"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.horaire_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/horaires-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.horaire_id" class="invalid-feedback">
                        <template v-for=" error in errors.horaire_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>programmationsusers </label>
                    <CustomSelect
                        :key="form.programmationsuser"
                        :columnDefs="['libelle']"
                        :oldValue="form.programmationsuser"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.programmationsuser_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/programmationsusers-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.programmationsuser_id" class="invalid-feedback">
                        <template v-for=" error in errors.programmationsuser_id"> {{ error[0] }}</template>

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
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'EditProgrammes',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
        'horairesData',
        'programmationsusersData',
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

                debut_reel: "",

                debut_realise: "",

                fin_realise: "",

                programmationsuser_id: "",

                horaire_id: "",

                etats: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                identifiants_sadge: "",
            }
        }
    },

    mounted() {
        this.form = this.data
        this.form['date'] = this.form['date'].split(' ')[0]
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/programmes/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/programmes/' + this.form.id + '/delete').then(response => {
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
