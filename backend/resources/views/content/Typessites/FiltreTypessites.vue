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


                <div v-if="canShowFilter('libelle')" class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" class="form-control"
                           type="text">

                    <div v-if="errors.libelle" class='div-error' show variant="danger">
                        {{ errors.libelle }}
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


                <div v-if="canShowFilter('canCreate')" class="form-group">
                    <label>canCreate </label>
                    <input v-model="form.canCreate" class="form-control"
                           type="text">

                    <div v-if="errors.canCreate" class='div-error' show variant="danger">
                        {{ errors.canCreate }}
                    </div>
                </div>


                <div v-if="canShowFilter('canUpdate')" class="form-group">
                    <label>canUpdate </label>
                    <input v-model="form.canUpdate" class="form-control"
                           type="text">

                    <div v-if="errors.canUpdate" class='div-error' show variant="danger">
                        {{ errors.canUpdate }}
                    </div>
                </div>


                <div v-if="canShowFilter('canDelete')" class="form-group">
                    <label>canDelete </label>
                    <input v-model="form.canDelete" class="form-control"
                           type="text">

                    <div v-if="errors.canDelete" class='div-error' show variant="danger">
                        {{ errors.canDelete }}
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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'FiltreTypessites',
    components: {CustomSelect, Files},
    props: [
        'table',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                code: "",

                libelle: "",

                creat_by: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                canCreate: "",

                canUpdate: "",

                canDelete: "",
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
