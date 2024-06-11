<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('identifiants_sadge')" class="form-group">
                    <label>identifiants_sadge </label>
                    <input v-model="form.identifiants_sadge" class="form-control"
                           type="text">

                    <div v-if="errors.identifiants_sadge" class='div-error' show variant="danger">
                        {{ errors.identifiants_sadge }}
                    </div>
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
    name: 'FiltreProgrammationsusers',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                user_id: "",

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
