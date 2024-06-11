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


                <div v-if="canShowFilter('type')" class="form-group">
                    <label>type </label>
                    <input v-model="form.type" class="form-control"
                           type="text">

                    <div v-if="errors.type" class='div-error' show variant="danger">
                        {{ errors.type }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle')" class="form-group">
                    <label>cle </label>
                    <input v-model="form.cle" class="form-control"
                           type="text">

                    <div v-if="errors.cle" class='div-error' show variant="danger">
                        {{ errors.cle }}
                    </div>
                </div>


                <div v-if="canShowFilter('width')" class="form-group">
                    <label>width </label>
                    <input v-model="form.width" class="form-control"
                           type="text">

                    <div v-if="errors.width" class='div-error' show variant="danger">
                        {{ errors.width }}
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
    name: 'FiltreFormschamps',
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

                libelle: "",

                description: "",

                type: "",

                cle: "",

                width: "",

                extra_attributes: "",

                creat_by: "",

                deleted_at: "",

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
