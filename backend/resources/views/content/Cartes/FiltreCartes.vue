<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('solde')" class="form-group">
                    <label>solde </label>
                    <input v-model="form.solde" class="form-control"
                           type="text">

                    <div v-if="errors.solde" class='div-error' show variant="danger">
                        {{ errors.solde }}
                    </div>
                </div>


                <div v-if="canShowFilter('code')" class="form-group">
                    <label>code </label>
                    <input v-model="form.code" class="form-control"
                           type="text">

                    <div v-if="errors.code" class='div-error' show variant="danger">
                        {{ errors.code }}
                    </div>
                </div>


                <div v-if="canShowFilter('num_badge')" class="form-group">
                    <label>num_badge </label>
                    <input v-model="form.num_badge" class="form-control"
                           type="text">

                    <div v-if="errors.num_badge" class='div-error' show variant="danger">
                        {{ errors.num_badge }}
                    </div>
                </div>


                <div v-if="canShowFilter('expiration')" class="form-group">
                    <label>expiration </label>
                    <input v-model="form.expiration" class="form-control"
                           type="text">

                    <div v-if="errors.expiration" class='div-error' show variant="danger">
                        {{ errors.expiration }}
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


                <div v-if="canShowFilter('decouvert')" class="form-group">
                    <label>decouvert </label>
                    <input v-model="form.decouvert" class="form-control"
                           type="text">

                    <div v-if="errors.decouvert" class='div-error' show variant="danger">
                        {{ errors.decouvert }}
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


                <div v-if="canShowFilter('creat_by')" class="form-group">
                    <label>creat_by </label>
                    <input v-model="form.creat_by" class="form-control"
                           type="text">

                    <div v-if="errors.creat_by" class='div-error' show variant="danger">
                        {{ errors.creat_by }}
                    </div>
                </div>


                <div class="form-group">
                    <label>agences </label>
                    <v-select
                        v-model="form.agence_id"
                        :options="agencesData"
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
    name: 'FiltreCartes',
    components: {CustomSelect, Files},
    props: [
        'table',
        'agencesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                solde: "",

                code: "",

                num_badge: "",

                expiration: "",

                etat: "",

                agence_id: "",

                decouvert: "",

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
