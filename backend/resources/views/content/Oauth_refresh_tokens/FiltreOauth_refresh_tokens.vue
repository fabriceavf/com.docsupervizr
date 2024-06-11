<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('revoked')" class="form-group">
                    <label>revoked </label>
                    <input v-model="form.revoked" class="form-control"
                           type="text">

                    <div v-if="errors.revoked" class='div-error' show variant="danger">
                        {{ errors.revoked }}
                    </div>
                </div>


                <div v-if="canShowFilter('expires_at')" class="form-group">
                    <label>expires_at </label>
                    <input v-model="form.expires_at" class="form-control"
                           type="text">

                    <div v-if="errors.expires_at" class='div-error' show variant="danger">
                        {{ errors.expires_at }}
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
    name: 'FiltreOauth_refresh_tokens',
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

                access_token_id: "",

                revoked: "",

                expires_at: "",

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
