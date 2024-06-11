<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('action')" class="form-group">
                    <label>action </label>
                    <input v-model="form.action" class="form-control"
                           type="text">

                    <div v-if="errors.action" class='div-error' show variant="danger">
                        {{ errors.action }}
                    </div>
                </div>


                <div v-if="canShowFilter('ip')" class="form-group">
                    <label>ip </label>
                    <input v-model="form.ip" class="form-control"
                           type="text">

                    <div v-if="errors.ip" class='div-error' show variant="danger">
                        {{ errors.ip }}
                    </div>
                </div>


                <div v-if="canShowFilter('details')" class="form-group">
                    <label>details </label>
                    <input v-model="form.details" class="form-control"
                           type="text">

                    <div v-if="errors.details" class='div-error' show variant="danger">
                        {{ errors.details }}
                    </div>
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
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'FiltreSurveillances',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                action: "",

                ip: "",

                details: "",

                user_id: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                extra_attributes: "",
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
