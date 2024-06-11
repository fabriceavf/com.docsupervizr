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
                    <label>lignes </label>
                    <v-select
                        v-model="form.ligne_id"
                        :options="lignesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>deplacements </label>
                    <v-select
                        v-model="form.deplacement_id"
                        :options="deplacementsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>pointeuses </label>
                    <v-select
                        v-model="form.pointeuse_id"
                        :options="pointeusesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>sites </label>
                    <v-select
                        v-model="form.site_id"
                        :options="sitesData"
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
    name: 'FiltreControlleursacces',
    components: {CustomSelect, Files},
    props: [
        'table',
        'lignesData',
        'deplacementsData',
        'pointeusesData',
        'sitesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                pointeuse_id: "",

                ligne_id: "",

                deplacement_id: "",

                site_id: "",

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
