<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('content')" class="form-group">
                    <label>content </label>
                    <input v-model="form.content" class="form-control"
                           type="text">

                    <div v-if="errors.content" class='div-error' show variant="danger">
                        {{ errors.content }}
                    </div>
                </div>


                <div v-if="canShowFilter('js')" class="form-group">
                    <label>js </label>
                    <input v-model="form.js" class="form-control"
                           type="text">

                    <div v-if="errors.js" class='div-error' show variant="danger">
                        {{ errors.js }}
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


                <div v-if="canShowFilter('css')" class="form-group">
                    <label>css </label>
                    <input v-model="form.css" class="form-control"
                           type="text">

                    <div v-if="errors.css" class='div-error' show variant="danger">
                        {{ errors.css }}
                    </div>
                </div>


                <div v-if="canShowFilter('node_version')" class="form-group">
                    <label>node_version </label>
                    <input v-model="form.node_version" class="form-control"
                           type="text">

                    <div v-if="errors.node_version" class='div-error' show variant="danger">
                        {{ errors.node_version }}
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
                    <label>clients </label>
                    <v-select
                        v-model="form.client_id"
                        :options="clientsData"
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
    name: 'FiltreBadges',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'clientsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                client_id: "",

                content: "",

                created_at: "",

                updated_at: "",

                js: "",

                libelle: "",

                css: "",

                node_version: "",

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
