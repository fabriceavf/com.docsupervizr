<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('statut')" class="form-group">
                    <label>statut </label>
                    <input v-model="form.statut" class="form-control"
                           type="text">

                    <div v-if="errors.statut" class='div-error' show variant="danger">
                        {{ errors.statut }}
                    </div>
                </div>


                <div class="form-group">
                    <label>interventions </label>
                    <v-select
                        v-model="form.intervention_id"
                        :options="interventionsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>users </label>
                    <v-select
                        v-model="form.user_id"
                        :options="usersData"
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
    name: 'FiltreInterventionusers',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'interventionsData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                intervention_id: "",

                user_id: "",

                statut: "",

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
