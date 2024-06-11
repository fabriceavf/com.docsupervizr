<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('type')" class="form-group">
                    <label>type </label>
                    <input v-model="form.type" class="form-control"
                           type="text">

                    <div v-if="errors.type" class='div-error' show variant="danger">
                        {{ errors.type }}
                    </div>
                </div>


                <div v-if="canShowFilter('fichiers')" class="form-group">
                    <label>fichiers </label>
                    <input v-model="form.fichiers" class="form-control"
                           type="text">

                    <div v-if="errors.fichiers" class='div-error' show variant="danger">
                        {{ errors.fichiers }}
                    </div>
                </div>


                <div v-if="canShowFilter('liaisons')" class="form-group">
                    <label>liaisons </label>
                    <input v-model="form.liaisons" class="form-control"
                           type="text">

                    <div v-if="errors.liaisons" class='div-error' show variant="danger">
                        {{ errors.liaisons }}
                    </div>
                </div>


                <div v-if="canShowFilter('identifiant')" class="form-group">
                    <label>identifiant </label>
                    <input v-model="form.identifiant" class="form-control"
                           type="text">

                    <div v-if="errors.identifiant" class='div-error' show variant="danger">
                        {{ errors.identifiant }}
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


                <div v-if="canShowFilter('creat_by')" class="form-group">
                    <label>creat_by </label>
                    <input v-model="form.creat_by" class="form-control"
                           type="text">

                    <div v-if="errors.creat_by" class='div-error' show variant="danger">
                        {{ errors.creat_by }}
                    </div>
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
    name: 'FiltreImports',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                type: "",

                fichiers: "",

                liaisons: "",

                identifiant: "",

                etats: "",

                creat_by: "",

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
