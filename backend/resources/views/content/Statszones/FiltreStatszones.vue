<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('nom1')" class="form-group">
                    <label>nom1 </label>
                    <input v-model="form.nom1" class="form-control"
                           type="text">

                    <div v-if="errors.nom1" class='div-error' show variant="danger">
                        {{ errors.nom1 }}
                    </div>
                </div>


                <div v-if="canShowFilter('nom2')" class="form-group">
                    <label>nom2 </label>
                    <input v-model="form.nom2" class="form-control"
                           type="text">

                    <div v-if="errors.nom2" class='div-error' show variant="danger">
                        {{ errors.nom2 }}
                    </div>
                </div>


                <div v-if="canShowFilter('nom3')" class="form-group">
                    <label>nom3 </label>
                    <input v-model="form.nom3" class="form-control"
                           type="text">

                    <div v-if="errors.nom3" class='div-error' show variant="danger">
                        {{ errors.nom3 }}
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
                    <label>modelslistings </label>
                    <v-select
                        v-model="form.modelslisting_id"
                        :options="modelslistingsData"
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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'FiltreStatszones',
    components: {CustomSelect, Files},
    props: [
        'table',
        'modelslistingsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                nom1: "",

                modelslisting_id: "",

                modelslistingjour1_id: "",

                nom2: "",

                modelslistingnuit2_id: "",

                modelslistingjour2_id: "",

                nom3: "",

                modelslistingnuit3_id: "",

                modelslistingjour3_id: "",

                creat_by: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

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
