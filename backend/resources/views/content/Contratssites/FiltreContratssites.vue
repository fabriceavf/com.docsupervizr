<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('agentsjour')" class="form-group">
                    <label>agentsjour </label>
                    <input v-model="form.agentsjour" class="form-control"
                           type="text">

                    <div v-if="errors.agentsjour" class='div-error' show variant="danger">
                        {{ errors.agentsjour }}
                    </div>
                </div>


                <div v-if="canShowFilter('agentsnuit')" class="form-group">
                    <label>agentsnuit </label>
                    <input v-model="form.agentsnuit" class="form-control"
                           type="text">

                    <div v-if="errors.agentsnuit" class='div-error' show variant="danger">
                        {{ errors.agentsnuit }}
                    </div>
                </div>


                <div class="form-group">
                    <label>contratsclients </label>
                    <v-select
                        v-model="form.contratsclient_id"
                        :options="contratsclientsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>prestations </label>
                    <v-select
                        v-model="form.prestation_id"
                        :options="prestationsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>sites </label>
                    <v-select
                        v-model="form.site_id"
                        :options="sitesData"
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
    name: 'FiltreContratssites',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'contratsclientsData',
        'prestationsData',
        'sitesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                contratsclient_id: "",

                site_id: "",

                prestation_id: "",

                agentsjour: "",

                agentsnuit: "",

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
