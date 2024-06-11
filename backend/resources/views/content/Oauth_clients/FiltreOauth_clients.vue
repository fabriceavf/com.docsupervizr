<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('name')" class="form-group">
                    <label>name </label>
                    <input v-model="form.name" class="form-control"
                           type="text">

                    <div v-if="errors.name" class='div-error' show variant="danger">
                        {{ errors.name }}
                    </div>
                </div>


                <div v-if="canShowFilter('secret')" class="form-group">
                    <label>secret </label>
                    <input v-model="form.secret" class="form-control"
                           type="text">

                    <div v-if="errors.secret" class='div-error' show variant="danger">
                        {{ errors.secret }}
                    </div>
                </div>


                <div v-if="canShowFilter('provider')" class="form-group">
                    <label>provider </label>
                    <input v-model="form.provider" class="form-control"
                           type="text">

                    <div v-if="errors.provider" class='div-error' show variant="danger">
                        {{ errors.provider }}
                    </div>
                </div>


                <div v-if="canShowFilter('redirect')" class="form-group">
                    <label>redirect </label>
                    <input v-model="form.redirect" class="form-control"
                           type="text">

                    <div v-if="errors.redirect" class='div-error' show variant="danger">
                        {{ errors.redirect }}
                    </div>
                </div>


                <div v-if="canShowFilter('personal_access_client')" class="form-group">
                    <label>personal_access_client </label>
                    <input v-model="form.personal_access_client" class="form-control"
                           type="text">

                    <div v-if="errors.personal_access_client" class='div-error' show variant="danger">
                        {{ errors.personal_access_client }}
                    </div>
                </div>


                <div v-if="canShowFilter('password_client')" class="form-group">
                    <label>password_client </label>
                    <input v-model="form.password_client" class="form-control"
                           type="text">

                    <div v-if="errors.password_client" class='div-error' show variant="danger">
                        {{ errors.password_client }}
                    </div>
                </div>


                <div v-if="canShowFilter('revoked')" class="form-group">
                    <label>revoked </label>
                    <input v-model="form.revoked" class="form-control"
                           type="text">

                    <div v-if="errors.revoked" class='div-error' show variant="danger">
                        {{ errors.revoked }}
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
    name: 'FiltreOauth_clients',
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

                user_id: "",

                name: "",

                secret: "",

                provider: "",

                redirect: "",

                personal_access_client: "",

                password_client: "",

                revoked: "",

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
