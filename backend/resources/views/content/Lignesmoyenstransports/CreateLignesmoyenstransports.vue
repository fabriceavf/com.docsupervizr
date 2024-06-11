<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>heure_debut </label>
                    <input v-model="form.heure_debut"
                           :class="errors.heure_debut?'form-control is-invalid':'form-control'"
                           type="time">

                    <div v-if="errors.heure_debut" class="invalid-feedback">
                        <template v-for=" error in errors.heure_debut"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>heure_fin </label>
                    <input v-model="form.heure_fin" :class="errors.heure_fin?'form-control is-invalid':'form-control'"
                           type="time">

                    <div v-if="errors.heure_fin" class="invalid-feedback">
                        <template v-for=" error in errors.heure_fin"> {{ error[0] }}</template>

                    </div>
                </div>


                <!-- <div class="form-group">
                    <label>lun </label>
                                                    <input type="text" :class="errors.lun?'form-control is-invalid':'form-control'"
                               v-model="form.lun">

                    <div class="invalid-feedback" v-if="errors.lun">
                        <template v-for=" error in errors.lun" >  {{error[0]}}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>mar </label>
                                                    <input type="text" :class="errors.mar?'form-control is-invalid':'form-control'"
                               v-model="form.mar">

                    <div class="invalid-feedback" v-if="errors.mar">
                        <template v-for=" error in errors.mar" >  {{error[0]}}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>mer </label>
                                                    <input type="text" :class="errors.mer?'form-control is-invalid':'form-control'"
                               v-model="form.mer">

                    <div class="invalid-feedback" v-if="errors.mer">
                        <template v-for=" error in errors.mer" >  {{error[0]}}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jeu </label>
                                                    <input type="text" :class="errors.jeu?'form-control is-invalid':'form-control'"
                               v-model="form.jeu">

                    <div class="invalid-feedback" v-if="errors.jeu">
                        <template v-for=" error in errors.jeu" >  {{error[0]}}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>ven </label>
                                                    <input type="text" :class="errors.ven?'form-control is-invalid':'form-control'"
                               v-model="form.ven">

                    <div class="invalid-feedback" v-if="errors.ven">
                        <template v-for=" error in errors.ven" >  {{error[0]}}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>sam </label>
                                                    <input type="text" :class="errors.sam?'form-control is-invalid':'form-control'"
                               v-model="form.sam">

                    <div class="invalid-feedback" v-if="errors.sam">
                        <template v-for=" error in errors.sam" >  {{error[0]}}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>dim </label>
                                                    <input type="text" :class="errors.dim?'form-control is-invalid':'form-control'"
                               v-model="form.dim">

                    <div class="invalid-feedback" v-if="errors.dim">
                        <template v-for=" error in errors.dim" >  {{error[0]}}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>creat_by </label>
                                                    <input type="text" :class="errors.creat_by?'form-control is-invalid':'form-control'"
                               v-model="form.creat_by">

                    <div class="invalid-feedback" v-if="errors.creat_by">
                        <template v-for=" error in errors.creat_by" >  {{error[0]}}</template>

                    </div>
                </div>
             -->


                <div class="form-group">
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


                <!-- <div class="form-group">
                    <label>moyenstransports </label>
                    <CustomSelect
                        :key="form.moyenstransport"
                        :url="`${axios.defaults.baseURL}/api/moyenstransports-Aggrid`"
                        :columnDefs="['libelle']"
                        filter-key=""
                        filter-value=""
                        :oldValue="form.moyenstransport"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{form.moyenstransport_id=data.id;form.moyenstransport=data}"
                    />
                    <div class="invalid-feedback" v-if="errors.moyenstransport_id">
                        <template v-for=" error in errors.moyenstransport_id" >  {{error[0]}}</template>

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
    name: 'CreateLignesmoyenstransports',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'lignesData',
        'moyenstransportsData', 'parentId'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                moyenstransport_id: "",

                ligne_id: "",

                heure_debut: "",

                heure_fin: "",

                lun: "",

                mar: "",

                mer: "",

                jeu: "",

                ven: "",

                sam: "",

                dim: "",

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
            this.form.moyenstransport_id = this.parentId
            this.axios.post('/api/lignesmoyenstransports', this.form).then(response => {
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
                moyenstransport_id: "",
                ligne_id: "",
                heure_debut: "",
                heure_fin: "",
                lun: "",
                mar: "",
                mer: "",
                jeu: "",
                ven: "",
                sam: "",
                dim: "",
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
