<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('date')" class="form-group">
                    <label>date </label>
                    <input v-model="form.date" class="form-control"
                           type="date">

                    <div v-if="errors.date" class='div-error' show variant="danger">
                        {{ errors.date }}
                    </div>
                </div>


                <div v-if="canShowFilter('debut_prevu')" class="form-group">
                    <label>debut_prevu </label>
                    <input v-model="form.debut_prevu" class="form-control"
                           type="text">

                    <div v-if="errors.debut_prevu" class='div-error' show variant="danger">
                        {{ errors.debut_prevu }}
                    </div>
                </div>


                <div v-if="canShowFilter('fin_prevu')" class="form-group">
                    <label>fin_prevu </label>
                    <input v-model="form.fin_prevu" class="form-control"
                           type="text">

                    <div v-if="errors.fin_prevu" class='div-error' show variant="danger">
                        {{ errors.fin_prevu }}
                    </div>
                </div>


                <div v-if="canShowFilter('debut_reel')" class="form-group">
                    <label>debut_reel </label>
                    <input v-model="form.debut_reel" class="form-control"
                           type="text">

                    <div v-if="errors.debut_reel" class='div-error' show variant="danger">
                        {{ errors.debut_reel }}
                    </div>
                </div>


                <div v-if="canShowFilter('debut_realise')" class="form-group">
                    <label>debut_realise </label>
                    <input v-model="form.debut_realise" class="form-control"
                           type="text">

                    <div v-if="errors.debut_realise" class='div-error' show variant="danger">
                        {{ errors.debut_realise }}
                    </div>
                </div>


                <div v-if="canShowFilter('fin_realise')" class="form-group">
                    <label>fin_realise </label>
                    <input v-model="form.fin_realise" class="form-control"
                           type="text">

                    <div v-if="errors.fin_realise" class='div-error' show variant="danger">
                        {{ errors.fin_realise }}
                    </div>
                </div>


                <div v-if="canShowFilter('etats')" class="form-group">
                    <label>etats </label>
                    <input v-model="form.etats" class="form-control"
                           type="text">

                    <div v-if="errors.etats" class='div-error' show variant="danger">
                        {{ errors.etats }}
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
                    <label>horaires </label>
                    <v-select
                        v-model="form.horaire_id"
                        :options="horairesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>programmationsusers </label>
                    <v-select
                        v-model="form.programmationsuser_id"
                        :options="programmationsusersData"
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
    name: 'FiltreProgrammes',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'horairesData',
        'programmationsusersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                date: "",

                debut_prevu: "",

                fin_prevu: "",

                debut_reel: "",

                debut_realise: "",

                fin_realise: "",

                programmationsuser_id: "",

                horaire_id: "",

                etats: "",

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
