<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>name </label>
                    <input v-model="form.name" :class="errors.name?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.name" class="invalid-feedback">
                        <template v-for=" error in errors.name"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>icon </label>
                    <input v-model="form.icon" :class="errors.icon?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.icon" class="invalid-feedback">
                        <template v-for=" error in errors.icon"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group">
                    <label>slug </label>
                    <input v-model="form.slug" :class="errors.slug?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.slug" class="invalid-feedback">
                        <template v-for=" error in errors.slug"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group">
                    <label>url </label>
                    <input v-model="form.url" :class="errors.url?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.url" class="invalid-feedback">
                        <template v-for=" error in errors.url"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group">
                    <label>ordre </label>
                    <input v-model="form.ordre" :class="errors.ordre?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.ordre" class="invalid-feedback">
                        <template v-for=" error in errors.ordre"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group">
                    <label>issu </label>
                    <input v-model="form.issu" :class="errors.issu?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.issu" class="invalid-feedback">
                        <template v-for=" error in errors.issu"> {{ error[0] }}</template>

                    </div>
                </div>

                <div class="form-group  ">
                    <label>Menu pricipale </label>
                    <CustomSelect
                        :key="form.menu"
                        :columnDefs="['name']"
                        :oldValue="form.menu" :renderCallBack="(data) => `${data.Selectlabel}`"
                        :selectCallBack="(data) => form.menu_id = data.id"
                        :url="`${axios.defaults.baseURL}/api/menus-Aggrid`"
                        filter-key=""
                        filter-value=""/>
                    <div v-if="errors.menu_id" class="invalid-feedback">
                        <template v-for=" error in errors.menu_id"> {{ error[0] }}</template>

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
    name: 'CreateMenus',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId', 'parentId'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                name: "",

                icon: "",

                slug: "",

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
            this.form.entreprise_id = this.parentId
            this.axios.post('/api/menus', this.form).then(response => {
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
                name: "",
                icon: "",
                slug: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
            }
        }
    }
}
</script>
