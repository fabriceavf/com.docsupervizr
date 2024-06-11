<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('nom')" class="form-group">
                    <label>nom </label>
                    <input v-model="form.nom" class="form-control"
                           type="text">

                    <div v-if="errors.nom" class='div-error' show variant="danger">
                        {{ errors.nom }}
                    </div>
                </div>


                <div v-if="canShowFilter('rubrique')" class="form-group">
                    <label>rubrique </label>
                    <input v-model="form.rubrique" class="form-control"
                           type="text">

                    <div v-if="errors.rubrique" class='div-error' show variant="danger">
                        {{ errors.rubrique }}
                    </div>
                </div>


                <div v-if="canShowFilter('fichier')" class="form-group">
                    <label>fichier </label>
                    <input v-model="form.fichier" class="form-control"
                           type="text">

                    <div v-if="errors.fichier" class='div-error' show variant="danger">
                        {{ errors.fichier }}
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
    name: 'FiltreDocuments',
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

                nom: "",

                rubrique: "",

                fichier: "",

                agent_id: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

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
