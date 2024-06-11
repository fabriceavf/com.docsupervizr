<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>lat </label>
                    <input v-model="form.lat" :class="errors.lat?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.lat" class="invalid-feedback">
                        <template v-for=" error in errors.lat"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>lon </label>
                    <input v-model="form.lon" :class="errors.lon?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.lon" class="invalid-feedback">
                        <template v-for=" error in errors.lon"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>name </label>
                    <input v-model="form.name" :class="errors.name?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.name" class="invalid-feedback">
                        <template v-for=" error in errors.name"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>title </label>
                    <input v-model="form.title" :class="errors.title?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.title" class="invalid-feedback">
                        <template v-for=" error in errors.title"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>speed </label>
                    <input v-model="form.speed" :class="errors.speed?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.speed" class="invalid-feedback">
                        <template v-for=" error in errors.speed"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>icon_color </label>
                    <input v-model="form.icon_color" :class="errors.icon_color?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.icon_color" class="invalid-feedback">
                        <template v-for=" error in errors.icon_color"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>moyenstransportid </label>
                    <input v-model="form.moyenstransportid"
                           :class="errors.moyenstransportid?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.moyenstransportid" class="invalid-feedback">
                        <template v-for=" error in errors.moyenstransportid"> {{ error[0] }}</template>

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
                    <label>date </label>
                    <input v-model="form.date" :class="errors.date?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.date" class="invalid-feedback">
                        <template v-for=" error in errors.date"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tracername </label>
                    <input v-model="form.tracername" :class="errors.tracername?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tracername" class="invalid-feedback">
                        <template v-for=" error in errors.tracername"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>traceruniqueid </label>
                    <input v-model="form.traceruniqueid"
                           :class="errors.traceruniqueid?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.traceruniqueid" class="invalid-feedback">
                        <template v-for=" error in errors.traceruniqueid"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>sim </label>
                    <input v-model="form.sim" :class="errors.sim?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.sim" class="invalid-feedback">
                        <template v-for=" error in errors.sim"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>balises </label>
                    <CustomSelect
                        :key="form.balise"
                        :columnDefs="['libelle']"
                        :oldValue="form.balise"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{form.balise_id=data.id;form.balise=data}"
                        :url="`${axios.defaults.baseURL}/api/balises-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.balise_id" class="invalid-feedback">
                        <template v-for=" error in errors.balise_id"> {{ error[0] }}</template>

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
    name: 'CreatePositions',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'balisesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                lat: "",

                lon: "",

                name: "",

                title: "",

                speed: "",

                icon_color: "",

                moyenstransportid: "",

                creat_by: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                date: "",

                tracername: "",

                traceruniqueid: "",

                sim: "",

                balise_id: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/positions', this.form).then(response => {
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
                lat: "",
                lon: "",
                name: "",
                title: "",
                speed: "",
                icon_color: "",
                moyenstransportid: "",
                creat_by: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
                date: "",
                tracername: "",
                traceruniqueid: "",
                sim: "",
                balise_id: "",
            }
        }
    }
}
</script>
