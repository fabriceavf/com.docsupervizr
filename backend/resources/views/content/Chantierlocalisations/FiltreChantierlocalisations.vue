<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('latitude')" class="form-group">
                    <label>latitude </label>
                    <input v-model="form.latitude" class="form-control"
                           type="text">

                    <div v-if="errors.latitude" class='div-error' show variant="danger">
                        {{ errors.latitude }}
                    </div>
                </div>


                <div v-if="canShowFilter('longitude')" class="form-group">
                    <label>longitude </label>
                    <input v-model="form.longitude" class="form-control"
                           type="text">

                    <div v-if="errors.longitude" class='div-error' show variant="danger">
                        {{ errors.longitude }}
                    </div>
                </div>


                <div class="form-group">
                    <label>chantiers </label>
                    <v-select
                        v-model="form.chantier_id"
                        :options="chantiersData"
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
    name: 'FiltreChantierlocalisations',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'chantiersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                chantier_id: "",

                latitude: "",

                longitude: "",

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
