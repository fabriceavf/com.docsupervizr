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


                <div v-if="canShowFilter('adresse_mac')" class="form-group">
                    <label>adresse_mac </label>
                    <input v-model="form.adresse_mac" class="form-control"
                           type="text">

                    <div v-if="errors.adresse_mac" class='div-error' show variant="danger">
                        {{ errors.adresse_mac }}
                    </div>
                </div>


                <div v-if="canShowFilter('etat')" class="form-group">
                    <label>etat </label>
                    <input v-model="form.etat" class="form-control"
                           type="text">

                    <div v-if="errors.etat" class='div-error' show variant="danger">
                        {{ errors.etat }}
                    </div>
                </div>


                <div v-if="canShowFilter('alimentation')" class="form-group">
                    <label>alimentation </label>
                    <input v-model="form.alimentation" class="form-control"
                           type="text">

                    <div v-if="errors.alimentation" class='div-error' show variant="danger">
                        {{ errors.alimentation }}
                    </div>
                </div>


                <div v-if="canShowFilter('reseau')" class="form-group">
                    <label>reseau </label>
                    <input v-model="form.reseau" class="form-control"
                           type="text">

                    <div v-if="errors.reseau" class='div-error' show variant="danger">
                        {{ errors.reseau }}
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
                    <label>voitures </label>
                    <v-select
                        v-model="form.voiture_id"
                        :options="voituresData"
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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'FiltreTerminals',
    components: {CustomSelect, Files},
    props: [
        'table',
        'voituresData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code: "",

                adresse_mac: "",

                etat: "",

                alimentation: "",

                reseau: "",

                voiture_id: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                identifiants_sadge: "",

                creat_by: "",
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
