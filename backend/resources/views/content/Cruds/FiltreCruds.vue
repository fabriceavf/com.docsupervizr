<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('action')" class="form-group">
                    <label>action </label>
                    <input v-model="form.action" class="form-control"
                           type="text">

                    <div v-if="errors.action" class='div-error' show variant="danger">
                        {{ errors.action }}
                    </div>
                </div>


                <div v-if="canShowFilter('entite')" class="form-group">
                    <label>entite </label>
                    <input v-model="form.entite" class="form-control"
                           type="text">

                    <div v-if="errors.entite" class='div-error' show variant="danger">
                        {{ errors.entite }}
                    </div>
                </div>


                <div v-if="canShowFilter('entite_cle')" class="form-group">
                    <label>entite_cle </label>
                    <input v-model="form.entite_cle" class="form-control"
                           type="text">

                    <div v-if="errors.entite_cle" class='div-error' show variant="danger">
                        {{ errors.entite_cle }}
                    </div>
                </div>


                <div v-if="canShowFilter('ancien')" class="form-group">
                    <label>ancien </label>
                    <input v-model="form.ancien" class="form-control"
                           type="text">

                    <div v-if="errors.ancien" class='div-error' show variant="danger">
                        {{ errors.ancien }}
                    </div>
                </div>


                <div v-if="canShowFilter('nouveau')" class="form-group">
                    <label>nouveau </label>
                    <input v-model="form.nouveau" class="form-control"
                           type="text">

                    <div v-if="errors.nouveau" class='div-error' show variant="danger">
                        {{ errors.nouveau }}
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
    name: 'FiltreCruds',
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

                action: "",

                entite: "",

                entite_cle: "",

                ancien: "",

                nouveau: "",

                user_id: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                extra_attributes: "",
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
