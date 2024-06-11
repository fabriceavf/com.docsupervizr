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


                <div v-if="canShowFilter('couleur')" class="form-group">
                    <label>couleur </label>
                    <input v-model="form.couleur" class="form-control"
                           type="text">

                    <div v-if="errors.couleur" class='div-error' show variant="danger">
                        {{ errors.couleur }}
                    </div>
                </div>


                <div v-if="canShowFilter('debut_prevus')" class="form-group">
                    <label>debut_prevus </label>
                    <input v-model="form.debut_prevus" class="form-control"
                           type="text">

                    <div v-if="errors.debut_prevus" class='div-error' show variant="danger">
                        {{ errors.debut_prevus }}
                    </div>
                </div>


                <div v-if="canShowFilter('fin_prevus')" class="form-group">
                    <label>fin_prevus </label>
                    <input v-model="form.fin_prevus" class="form-control"
                           type="text">

                    <div v-if="errors.fin_prevus" class='div-error' show variant="danger">
                        {{ errors.fin_prevus }}
                    </div>
                </div>


                <div v-if="canShowFilter('debut_effectif')" class="form-group">
                    <label>debut_effectif </label>
                    <input v-model="form.debut_effectif" class="form-control"
                           type="text">

                    <div v-if="errors.debut_effectif" class='div-error' show variant="danger">
                        {{ errors.debut_effectif }}
                    </div>
                </div>


                <div v-if="canShowFilter('fin_effectif')" class="form-group">
                    <label>fin_effectif </label>
                    <input v-model="form.fin_effectif" class="form-control"
                           type="text">

                    <div v-if="errors.fin_effectif" class='div-error' show variant="danger">
                        {{ errors.fin_effectif }}
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
    name: 'FiltreChantiers',
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

                libelle: "",

                couleur: "",

                debut_prevus: "",

                fin_prevus: "",

                debut_effectif: "",

                fin_effectif: "",

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
