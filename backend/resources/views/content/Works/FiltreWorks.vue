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


                <div v-if="canShowFilter('groupe')" class="form-group">
                    <label>groupe </label>
                    <input v-model="form.groupe" class="form-control"
                           type="text">

                    <div v-if="errors.groupe" class='div-error' show variant="danger">
                        {{ errors.groupe }}
                    </div>
                </div>


                <div class="form-group">
                    <label>activites </label>
                    <v-select
                        v-model="form.activite_id"
                        :options="activitesData"
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
    name: 'FiltreWorks',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'activitesData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                activite_id: "",

                user_id: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                debut: "",

                fin: "",

                groupe: "",
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
