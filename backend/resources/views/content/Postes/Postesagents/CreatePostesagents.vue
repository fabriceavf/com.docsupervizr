<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <!--                <div class="form-group">-->
                <!--                    <label>faction </label>-->
                <!--                    <input type="text" :class="errors.faction?'form-control is-invalid':'form-control'"-->
                <!--                           v-model="form.faction">-->

                <!--                    <div class="invalid-feedback" v-if="errors.faction">-->
                <!--                        <template v-for=" error in errors.faction"> {{ error[0] }}</template>-->

                <!--                    </div>-->
                <!--                </div>-->


                <!--                <div class="form-group">-->
                <!--                    <label>postes </label>-->
                <!--                    <v-select-->
                <!--                        :options="postesData"-->
                <!--                        label="Selectlabel"-->
                <!--                        :reduce="ele => ele.id"-->
                <!--                        v-model="form.poste_id"-->
                <!--                    />-->
                <!--                    <div class="invalid-feedback" v-if="errors.poste_id">-->
                <!--                        <template v-for=" error in errors.poste_id"> {{ error[0] }}</template>-->

                <!--                    </div>-->
                <!--                </div>-->


                <div class="form-group">
                    <label>users </label>
                    <CustomSelect
                        :key="form.user"
                        :columnDefs="['nom','prenom','matricule']"
                        :oldValue="form.user"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.user_id=data.id"
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
import CustomSelect from "@/components/CustomSelect.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'CreatePostesagents',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'postesData',
        'usersData',
        'parentId',
        'faction'

    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                poste_id: "",

                user_id: "",

                faction: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",
            }
        }
    },
    mounted() {
        this.form.faction = this.faction
        this.form.poste_id = this.parentId
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/postesagents', this.form).then(response => {
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
                poste_id: "",
                user_id: "",
                faction: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
            }
        }
    }
}
</script>
