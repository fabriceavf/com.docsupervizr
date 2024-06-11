<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('type')" class="form-group">
                    <label>type </label>
                    <input v-model="form.type" class="form-control"
                           type="text">

                    <div v-if="errors.type" class='div-error' show variant="danger">
                        {{ errors.type }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle')" class="form-group">
                    <label>cle </label>
                    <input v-model="form.cle" class="form-control"
                           type="text">

                    <div v-if="errors.cle" class='div-error' show variant="danger">
                        {{ errors.cle }}
                    </div>
                </div>


                <div v-if="canShowFilter('valeur')" class="form-group">
                    <label>valeur </label>
                    <input v-model="form.valeur" class="form-control"
                           type="text">

                    <div v-if="errors.valeur" class='div-error' show variant="danger">
                        {{ errors.valeur }}
                    </div>
                </div>


                <div class="form-group">
                    <label>activites </label>
                    <v-select
                        v-model="form.activite_id"
                        :options="activitesData"
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
    name: 'FiltreRessources',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'activitesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                type: "",

                cle: "",

                valeur: "",

                activite_id: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",
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
