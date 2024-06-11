<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('date_debut')" class="form-group">
                    <label>date_debut </label>
                    <input v-model="form.date_debut" class="form-control"
                           type="text">

                    <div v-if="errors.date_debut" class='div-error' show variant="danger">
                        {{ errors.date_debut }}
                    </div>
                </div>


                <div v-if="canShowFilter('date_fin')" class="form-group">
                    <label>date_fin </label>
                    <input v-model="form.date_fin" class="form-control"
                           type="text">

                    <div v-if="errors.date_fin" class='div-error' show variant="danger">
                        {{ errors.date_fin }}
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
                    <label>balises </label>
                    <v-select
                        v-model="form.balise_id"
                        :options="balisesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>moyenstransports </label>
                    <v-select
                        v-model="form.moyenstransport_id"
                        :options="moyenstransportsData"
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
    name: 'FiltreTrackings',
    components: {CustomSelect, Files},
    props: [
        'table',
        'balisesData',
        'moyenstransportsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                balise_id: "",

                moyenstransport_id: "",

                date_debut: "",

                date_fin: "",

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
