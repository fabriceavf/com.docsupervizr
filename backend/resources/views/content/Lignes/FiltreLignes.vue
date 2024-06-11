<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('code')" class="form-group">
                    <label>code </label>
                    <input v-model="form.code" class="form-control"
                           type="text">

                    <div v-if="errors.code" class='div-error' show variant="danger">
                        {{ errors.code }}
                    </div>
                </div>


                <div v-if="canShowFilter('depart')" class="form-group">
                    <label>depart </label>
                    <input v-model="form.depart" class="form-control"
                           type="text">

                    <div v-if="errors.depart" class='div-error' show variant="danger">
                        {{ errors.depart }}
                    </div>
                </div>


                <div v-if="canShowFilter('arrive')" class="form-group">
                    <label>arrive </label>
                    <input v-model="form.arrive" class="form-control"
                           type="text">

                    <div v-if="errors.arrive" class='div-error' show variant="danger">
                        {{ errors.arrive }}
                    </div>
                </div>


                <div v-if="canShowFilter('distance')" class="form-group">
                    <label>distance </label>
                    <input v-model="form.distance" class="form-control"
                           type="text">

                    <div v-if="errors.distance" class='div-error' show variant="danger">
                        {{ errors.distance }}
                    </div>
                </div>


                <div v-if="canShowFilter('tarif')" class="form-group">
                    <label>tarif </label>
                    <input v-model="form.tarif" class="form-control"
                           type="text">

                    <div v-if="errors.tarif" class='div-error' show variant="danger">
                        {{ errors.tarif }}
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


                <div v-if="canShowFilter('identifiants_sadge')" class="form-group">
                    <label>identifiants_sadge </label>
                    <input v-model="form.identifiants_sadge" class="form-control"
                           type="text">

                    <div v-if="errors.identifiants_sadge" class='div-error' show variant="danger">
                        {{ errors.identifiants_sadge }}
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
                    <label>villes </label>
                    <v-select
                        v-model="form.ville_id"
                        :options="villesData"
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
    name: 'FiltreLignes',
    components: {CustomSelect, Files},
    props: [
        'table',
        'villesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code: "",

                depart: "",

                arrive: "",

                distance: "",

                tarif: "",

                type: "",

                ville_id: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                identifiants_sadge: "",

                creat_by: "",
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
