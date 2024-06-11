<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('Libelle')" class="form-group">
                    <label>Libelle </label>
                    <input v-model="form.Libelle" class="form-control"
                           type="text">

                    <div v-if="errors.Libelle" class='div-error' show variant="danger">
                        {{ errors.Libelle }}
                    </div>
                </div>


                <div v-if="canShowFilter('userFiltre')" class="form-group">
                    <label>userFiltre </label>
                    <input v-model="form.userFiltre" class="form-control"
                           type="text">

                    <div v-if="errors.userFiltre" class='div-error' show variant="danger">
                        {{ errors.userFiltre }}
                    </div>
                </div>


                <div v-if="canShowFilter('userMatricule')" class="form-group">
                    <label>userMatricule </label>
                    <input v-model="form.userMatricule" class="form-control"
                           type="text">

                    <div v-if="errors.userMatricule" class='div-error' show variant="danger">
                        {{ errors.userMatricule }}
                    </div>
                </div>


                <div v-if="canShowFilter('identifiants_sadge')" class="form-group">
                    <label>identifiants_sadge </label>
                    <input v-model="form.identifiants_sadge" class="form-control"
                           type="text">

                    <div v-if="errors.identifiants_sadge" class='div-error' show variant="danger">
                        {{ errors.identifiants_sadge }}
                    </div>
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
    name: 'FiltreModelslistings',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                Libelle: "",

                userFiltre: "",

                userMatricule: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",
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
