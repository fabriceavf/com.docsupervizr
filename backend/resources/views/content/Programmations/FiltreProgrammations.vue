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


                <div v-if="canShowFilter('date_debut')" class="form-group">
                    <label>date_debut </label>
                    <input v-model="form.date_debut" class="form-control"
                           type="date">

                    <div v-if="errors.date_debut" class='div-error' show variant="danger">
                        {{ errors.date_debut }}
                    </div>
                </div>


                <div v-if="canShowFilter('date_fin')" class="form-group">
                    <label>date_fin </label>
                    <input v-model="form.date_fin" class="form-control"
                           type="date">

                    <div v-if="errors.date_fin" class='div-error' show variant="danger">
                        {{ errors.date_fin }}
                    </div>
                </div>


                <div v-if="canShowFilter('statut')" class="form-group">
                    <label>statut </label>
                    <input v-model="form.statut" class="form-control"
                           type="text">

                    <div v-if="errors.statut" class='div-error' show variant="danger">
                        {{ errors.statut }}
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
                    <label>taches </label>
                    <v-select
                        v-model="form.tache_id"
                        :options="tachesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>users </label>
                    <v-select
                        v-model="form.user_id"
                        :options="usersData"
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
    name: 'FiltreProgrammations',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'tachesData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                description: "",

                date_debut: "",

                date_fin: "",

                tache_id: "",

                user_id: "",

                statut: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

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
