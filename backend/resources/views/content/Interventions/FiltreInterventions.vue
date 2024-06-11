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


                <div v-if="canShowFilter('detail')" class="form-group">
                    <label>detail </label>
                    <input v-model="form.detail" class="form-control"
                           type="text">

                    <div v-if="errors.detail" class='div-error' show variant="danger">
                        {{ errors.detail }}
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


                <div v-if="canShowFilter('statut')" class="form-group">
                    <label>statut </label>
                    <input v-model="form.statut" class="form-control"
                           type="text">

                    <div v-if="errors.statut" class='div-error' show variant="danger">
                        {{ errors.statut }}
                    </div>
                </div>


                <div class="form-group">
                    <label>causeracines </label>
                    <v-select
                        v-model="form.causeracine_id"
                        :options="causeracinesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>chantiers </label>
                    <v-select
                        v-model="form.chantier_id"
                        :options="chantiersData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>mesurespreventives </label>
                    <v-select
                        v-model="form.mesurespreventive_id"
                        :options="mesurespreventivesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>typeinterventions </label>
                    <v-select
                        v-model="form.typeintervention_id"
                        :options="typeinterventionsData"
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
    name: 'FiltreInterventions',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'causeracinesData',
        'chantiersData',
        'mesurespreventivesData',
        'typeinterventionsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                detail: "",

                typeintervention_id: "",

                mesurespreventive_id: "",

                causeracine_id: "",

                chantier_id: "",

                debut_prevus: "",

                fin_prevus: "",

                debut_effectif: "",

                fin_effectif: "",

                statut: "",

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
