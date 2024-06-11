<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('libelle')" class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" class="form-control"
                           type="text">

                    <div v-if="errors.libelle" class='div-error' show variant="danger">
                        {{ errors.libelle }}
                    </div>
                </div>


                <div v-if="canShowFilter('description')" class="form-group">
                    <label>description </label>
                    <input v-model="form.description" class="form-control"
                           type="text">

                    <div v-if="errors.description" class='div-error' show variant="danger">
                        {{ errors.description }}
                    </div>
                </div>


                <div v-if="canShowFilter('order')" class="form-group">
                    <label>order </label>
                    <input v-model="form.order" class="form-control"
                           type="text">

                    <div v-if="errors.order" class='div-error' show variant="danger">
                        {{ errors.order }}
                    </div>
                </div>


                <div class="form-group">
                    <label>processus </label>
                    <v-select
                        v-model="form.processu_id"
                        :options="processusData"
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
    name: 'FiltreDetails',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'processusData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                description: "",

                order: "",

                processu_id: "",

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
