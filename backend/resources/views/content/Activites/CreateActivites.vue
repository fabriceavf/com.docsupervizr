<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div v-if="$routeData.meta.type=='objectifs'" class="container dataBlock">
                <h6 style="cursor:pointer"><i class="fa-solid fa-sitemap"></i> Definir un nouvelle objectifs</h6>
            </div>
            <div v-else-if="$routeData.meta.type=='besoins'" class="container dataBlock">
                <h6 style="cursor:pointer"><i class="fa-solid fa-sitemap"></i> Definir un nouveau besoin</h6>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group">
                    <label>description </label>
                    >
                    <Messages :donnes="form.description" @changeData="changeData"></Messages>
                    <div v-if="errors.description" class="invalid-feedback">
                        <template v-for=" error in errors.description"> {{ error[0] }}</template>

                    </div>
                </div>
            </div>

            <button class="btn btn-primary" type="submit">
                <i class="fas fa-floppy-disk"></i> Créer
            </button>
        </form>
        <!--        <ManagesActivites></ManagesActivites>-->
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

import Messages from "./Messages.vue"
import ChildsView from "./Childs/ChildsView.vue"
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'CreateActivites',
    components: {VSelect, CustomSelect, Files, Messages, ChildsView},
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
                description: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                type: '',
                deleted_at: "",
            },
            child: []
        }
    },
    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
                }
            } catch (e) {
            }

            return router;
        },
        taille: function () {
            let result = 'col-sm-12'
            if (this.filtre) {
                result = 'col-sm-9'
            }
            return result
        },
    },
    methods: {
        createLine() {
            if (this.$routeData.meta.type == 'besoins') {
                this.form.type = 'besoins';
            }
            if (this.$routeData.meta.type == 'objectifs') {
                this.form.type = 'objectifs';
            }
            if (this.$routeData.meta.type == 'taches') {
                this.form.type = 'taches';
            }
            if (this.$routeData.meta.type == 'actions') {
                this.form.type = 'actions';
            }
            this.isLoading = true
            this.axios.post('/api/activites', this.form).then(response => {
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
                description: "",
                created_at: "",
                updated_at: "",
                extra_attributes: "",
                deleted_at: "",
            }
        },
        changeData(data) {
            this.form.description = data
        },
    }
}
</script>
