<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('quantite')" class="form-group">
                    <label>quantite </label>
                    <input v-model="form.quantite" class="form-control"
                           type="text">

                    <div v-if="errors.quantite" class='div-error' show variant="danger">
                        {{ errors.quantite }}
                    </div>
                </div>


                <div class="form-group">
                    <label>materielinterventions </label>
                    <v-select
                        v-model="form.materielintervention_id"
                        :options="materielinterventionsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>materiels </label>
                    <v-select
                        v-model="form.materiel_id"
                        :options="materielsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>

            </div>

            <button class="btn btn-primary" type="submit">
                <i class="fas fas fa-search"></i> Appliquer
            </button>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'FiltreMaterielinterventiondetails',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'materielinterventionsData',
        'materielsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                materiel_id: "",

                materielintervention_id: "",

                quantite: "",

                created_at: "",

                updated_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.$emit('applyfilter', this.form)
        },
        canShowFilter(name) {
            let can = true
            const queryString = window.location.search
            const urlParams = new URLSearchParams(queryString);
            if (urlParams.has(`filter_${name}`)) {
                can = false
            }
            return can
        }
    }
}
</script>
