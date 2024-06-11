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


                <div v-if="canShowFilter('nature')" class="form-group">
                    <label>nature </label>
                    <input v-model="form.nature" class="form-control"
                           type="text">

                    <div v-if="errors.nature" class='div-error' show variant="danger">
                        {{ errors.nature }}
                    </div>
                </div>


                <div v-if="canShowFilter('coordonnees')" class="form-group">
                    <label>coordonnees </label>
                    <input v-model="form.coordonnees" class="form-control"
                           type="text">

                    <div v-if="errors.coordonnees" class='div-error' show variant="danger">
                        {{ errors.coordonnees }}
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


                <div v-if="canShowFilter('jours')" class="form-group">
                    <label>jours </label>
                    <input v-model="form.jours" class="form-control"
                           type="text">

                    <div v-if="errors.jours" class='div-error' show variant="danger">
                        {{ errors.jours }}
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
                    <label>pointeuses </label>
                    <v-select
                        v-model="form.pointeuse_id"
                        :options="pointeusesData"
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
    name: 'FiltrePostes',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'contratsclientsData',
        'pointeusesData',
        'sitesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code: "",

                libelle: "",

                nature: "",

                coordonnees: "",

                site_id: "",

                pointeuse_id: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",

                identifiants_sadge: "",

                creat_by: "",

                jours: "",

                contratsclient_id: "",
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
