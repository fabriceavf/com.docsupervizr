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
                    <label>approvisionements </label>
                    <v-select
                        v-model="form.approvisionement_id"
                        :options="approvisionementsData"
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
    name: 'FiltreApprovisionementdetails',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'approvisionementsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                approvisionement_id: "",

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
