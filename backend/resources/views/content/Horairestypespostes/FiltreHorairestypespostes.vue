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


                <div v-if="canShowFilter('debut')" class="form-group">
                    <label>debut </label>
                    <input v-model="form.debut" class="form-control"
                           type="text">

                    <div v-if="errors.debut" class='div-error' show variant="danger">
                        {{ errors.debut }}
                    </div>
                </div>


                <div v-if="canShowFilter('fin')" class="form-group">
                    <label>fin </label>
                    <input v-model="form.fin" class="form-control"
                           type="text">

                    <div v-if="errors.fin" class='div-error' show variant="danger">
                        {{ errors.fin }}
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
                    <label>typespostes </label>
                    <v-select
                        v-model="form.typesposte_id"
                        :options="typespostesData"
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
    name: 'FiltreHorairestypespostes',
    components: {CustomSelect, Files},
    props: [
        'table',
        'typespostesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                debut: "",

                fin: "",

                typesposte_id: "",

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
