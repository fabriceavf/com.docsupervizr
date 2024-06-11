<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('left')" class="form-group">
                    <label>left </label>
                    <input v-model="form.left" class="form-control"
                           type="text">

                    <div v-if="errors.left" class='div-error' show variant="danger">
                        {{ errors.left }}
                    </div>
                </div>


                <div v-if="canShowFilter('right')" class="form-group">
                    <label>right </label>
                    <input v-model="form.right" class="form-control"
                           type="text">

                    <div v-if="errors.right" class='div-error' show variant="danger">
                        {{ errors.right }}
                    </div>
                </div>


                <div v-if="canShowFilter('front')" class="form-group">
                    <label>front </label>
                    <input v-model="form.front" class="form-control"
                           type="text">

                    <div v-if="errors.front" class='div-error' show variant="danger">
                        {{ errors.front }}
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


                <div class="form-group">
                    <label>trajets </label>
                    <v-select
                        v-model="form.trajet_id"
                        :options="trajetsData"
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
    name: 'FiltreTrajetsteps',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'trajetsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                left: "",

                right: "",

                front: "",

                trajet_id: "",

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
