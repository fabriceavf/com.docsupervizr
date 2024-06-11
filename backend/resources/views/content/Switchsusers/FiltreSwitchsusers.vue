<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('old_type')" class="form-group">
                    <label>old_type </label>
                    <input v-model="form.old_type" class="form-control"
                           type="text">

                    <div v-if="errors.old_type" class='div-error' show variant="danger">
                        {{ errors.old_type }}
                    </div>
                </div>


                <div v-if="canShowFilter('new_type')" class="form-group">
                    <label>new_type </label>
                    <input v-model="form.new_type" class="form-control"
                           type="text">

                    <div v-if="errors.new_type" class='div-error' show variant="danger">
                        {{ errors.new_type }}
                    </div>
                </div>


                <div v-if="canShowFilter('action')" class="form-group">
                    <label>action </label>
                    <input v-model="form.action" class="form-control"
                           type="text">

                    <div v-if="errors.action" class='div-error' show variant="danger">
                        {{ errors.action }}
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
    name: 'FiltreSwitchsusers',
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

                old_type: "",

                new_type: "",

                action: "",

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
