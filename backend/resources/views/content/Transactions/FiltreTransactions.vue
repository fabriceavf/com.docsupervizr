<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('area_alias')" class="form-group">
                    <label>area_alias </label>
                    <input v-model="form.area_alias" class="form-control"
                           type="text">

                    <div v-if="errors.area_alias" class='div-error' show variant="danger">
                        {{ errors.area_alias }}
                    </div>
                </div>


                <div v-if="canShowFilter('first_name')" class="form-group">
                    <label>first_name </label>
                    <input v-model="form.first_name" class="form-control"
                           type="text">

                    <div v-if="errors.first_name" class='div-error' show variant="danger">
                        {{ errors.first_name }}
                    </div>
                </div>


                <div v-if="canShowFilter('last_name')" class="form-group">
                    <label>last_name </label>
                    <input v-model="form.last_name" class="form-control"
                           type="text">

                    <div v-if="errors.last_name" class='div-error' show variant="danger">
                        {{ errors.last_name }}
                    </div>
                </div>


                <div v-if="canShowFilter('card_no')" class="form-group">
                    <label>card_no </label>
                    <input v-model="form.card_no" class="form-control"
                           type="text">

                    <div v-if="errors.card_no" class='div-error' show variant="danger">
                        {{ errors.card_no }}
                    </div>
                </div>


                <div v-if="canShowFilter('terminal_alias')" class="form-group">
                    <label>terminal_alias </label>
                    <input v-model="form.terminal_alias" class="form-control"
                           type="text">

                    <div v-if="errors.terminal_alias" class='div-error' show variant="danger">
                        {{ errors.terminal_alias }}
                    </div>
                </div>


                <div v-if="canShowFilter('emp_code')" class="form-group">
                    <label>emp_code </label>
                    <input v-model="form.emp_code" class="form-control"
                           type="text">

                    <div v-if="errors.emp_code" class='div-error' show variant="danger">
                        {{ errors.emp_code }}
                    </div>
                </div>


                <div v-if="canShowFilter('punch_date')" class="form-group">
                    <label>punch_date </label>
                    <input v-model="form.punch_date" class="form-control"
                           type="text">

                    <div v-if="errors.punch_date" class='div-error' show variant="danger">
                        {{ errors.punch_date }}
                    </div>
                </div>


                <div v-if="canShowFilter('punch_time')" class="form-group">
                    <label>punch_time </label>
                    <input v-model="form.punch_time" class="form-control"
                           type="text">

                    <div v-if="errors.punch_time" class='div-error' show variant="danger">
                        {{ errors.punch_time }}
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
    name: 'FiltreTransactions',
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

                bio_id: "",

                area_alias: "",

                first_name: "",

                last_name: "",

                card_no: "",

                terminal_alias: "",

                emp_code: "",

                punch_date: "",

                punch_time: "",

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
