<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('etats')" class="form-group">
                    <label>etats </label>
                    <input v-model="form.etats" class="form-control"
                           type="text">

                    <div v-if="errors.etats" class='div-error' show variant="danger">
                        {{ errors.etats }}
                    </div>
                </div>


                <div class="form-group">
                    <label>modelslistings </label>
                    <v-select
                        v-model="form.modelslisting_id"
                        :options="modelslistingsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>postes </label>
                    <v-select
                        v-model="form.poste_id"
                        :options="postesData"
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
    name: 'FiltreListingspostes',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'modelslistingsData',
        'postesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                modelslisting_id: "",

                poste_id: "",

                etats: "",

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
