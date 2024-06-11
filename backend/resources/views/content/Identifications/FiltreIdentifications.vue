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


                <div v-if="canShowFilter('statuts')" class="form-group">
                    <label>statuts </label>
                    <input v-model="form.statuts" class="form-control"
                           type="text">

                    <div v-if="errors.statuts" class='div-error' show variant="danger">
                        {{ errors.statuts }}
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
                    <label>cartes </label>
                    <v-select
                        v-model="form.carte_id"
                        :options="cartesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'FiltreIdentifications',
    components: {CustomSelect, Files},
    props: [
        'table',
        'cartesData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                user_id: "",

                carte_id: "",

                date_debut: "",

                date_fin: "",

                statuts: "",

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
