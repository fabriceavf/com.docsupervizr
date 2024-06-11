<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('jour')" class="form-group">
                    <label>jour </label>
                    <input v-model="form.jour" class="form-control"
                           type="text">

                    <div v-if="errors.jour" class='div-error' show variant="danger">
                        {{ errors.jour }}
                    </div>
                </div>


                <div v-if="canShowFilter('debut')" class="form-group">
                    <label>debut </label>
                    <input v-model="form.debut" class="form-control"
                           type="text">

                    <div v-if="errors.debut" class='div-error' show variant="danger">
                        {{ errors.debut }}
                    </div>
                </div>


                <div v-if="canShowFilter('fin')" class="form-group">
                    <label>fin </label>
                    <input v-model="form.fin" class="form-control"
                           type="text">

                    <div v-if="errors.fin" class='div-error' show variant="danger">
                        {{ errors.fin }}
                    </div>
                </div>


                <div class="form-group">
                    <label>interventionusers </label>
                    <v-select
                        v-model="form.interventionuser_id"
                        :options="interventionusersData"
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
    name: 'FiltreInterventiondetails',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'interventionusersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                interventionuser_id: "",

                jour: "",

                debut: "",

                fin: "",

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
