<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('code')" class="form-group">
                    <label>code </label>
                    <input v-model="form.code" class="form-control"
                           type="text">

                    <div v-if="errors.code" class='div-error' show variant="danger">
                        {{ errors.code }}
                    </div>
                </div>


                <div v-if="canShowFilter('libelle')" class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" class="form-control"
                           type="text">

                    <div v-if="errors.libelle" class='div-error' show variant="danger">
                        {{ errors.libelle }}
                    </div>
                </div>


                <div v-if="canShowFilter('findId')" class="form-group">
                    <label>findId </label>
                    <input v-model="form.findId" class="form-control"
                           type="text">

                    <div v-if="errors.findId" class='div-error' show variant="danger">
                        {{ errors.findId }}
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


                <div class="form-group">
                    <label>recuperes </label>
                    <v-select
                        v-model="form.recupere_id"
                        :options="recuperesData"
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
    name: 'FiltrePointeuses',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'recuperesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code: "",

                libelle: "",

                recupere_id: "",

                created_at: "",

                updated_at: "",

                findId: "",

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
