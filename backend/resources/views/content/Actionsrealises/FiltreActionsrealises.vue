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


                <div v-if="canShowFilter('descriptions')" class="form-group">
                    <label>descriptions </label>
                    <input v-model="form.descriptions" class="form-control"
                           type="text">

                    <div v-if="errors.descriptions" class='div-error' show variant="danger">
                        {{ errors.descriptions }}
                    </div>
                </div>


                <div v-if="canShowFilter('debut_previsionnel')" class="form-group">
                    <label>debut_previsionnel </label>
                    <input v-model="form.debut_previsionnel" class="form-control"
                           type="date">

                    <div v-if="errors.debut_previsionnel" class='div-error' show variant="danger">
                        {{ errors.debut_previsionnel }}
                    </div>
                </div>


                <div v-if="canShowFilter('fin_previsionnel')" class="form-group">
                    <label>fin_previsionnel </label>
                    <input v-model="form.fin_previsionnel" class="form-control"
                           type="date">

                    <div v-if="errors.fin_previsionnel" class='div-error' show variant="danger">
                        {{ errors.fin_previsionnel }}
                    </div>
                </div>


                <div v-if="canShowFilter('debut_reel')" class="form-group">
                    <label>debut_reel </label>
                    <input v-model="form.debut_reel" class="form-control"
                           type="date">

                    <div v-if="errors.debut_reel" class='div-error' show variant="danger">
                        {{ errors.debut_reel }}
                    </div>
                </div>


                <div v-if="canShowFilter('fin_reel')" class="form-group">
                    <label>fin_reel </label>
                    <input v-model="form.fin_reel" class="form-control"
                           type="date">

                    <div v-if="errors.fin_reel" class='div-error' show variant="danger">
                        {{ errors.fin_reel }}
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


                <div v-if="canShowFilter('evaluation')" class="form-group">
                    <label>evaluation </label>
                    <input v-model="form.evaluation" class="form-control"
                           type="text">

                    <div v-if="errors.evaluation" class='div-error' show variant="danger">
                        {{ errors.evaluation }}
                    </div>
                </div>


                <div class="form-group">
                    <label>actionsprevisionelles </label>
                    <v-select
                        v-model="form.actionsprevisionelle_id"
                        :options="actionsprevisionellesData"
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
    name: 'FiltreActionsrealises',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'actionsprevisionellesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                descriptions: "",

                debut_previsionnel: "",

                fin_previsionnel: "",

                debut_reel: "",

                fin_reel: "",

                actionsprevisionelle_id: "",

                creat_by: "",

                evaluation: "",

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
