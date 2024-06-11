<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('date')" class="form-group">
                    <label>date </label>
                    <input v-model="form.date" class="form-control"
                           type="text">

                    <div v-if="errors.date" class='div-error' show variant="danger">
                        {{ errors.date }}
                    </div>
                </div>


                <div v-if="canShowFilter('ligne')" class="form-group">
                    <label>ligne </label>
                    <input v-model="form.ligne" class="form-control"
                           type="text">

                    <div v-if="errors.ligne" class='div-error' show variant="danger">
                        {{ errors.ligne }}
                    </div>
                </div>


                <div v-if="canShowFilter('moyenstransport')" class="form-group">
                    <label>moyenstransport </label>
                    <input v-model="form.moyenstransport" class="form-control"
                           type="text">

                    <div v-if="errors.moyenstransport" class='div-error' show variant="danger">
                        {{ errors.moyenstransport }}
                    </div>
                </div>


                <div v-if="canShowFilter('debut_prevu')" class="form-group">
                    <label>debut_prevu </label>
                    <input v-model="form.debut_prevu" class="form-control"
                           type="text">

                    <div v-if="errors.debut_prevu" class='div-error' show variant="danger">
                        {{ errors.debut_prevu }}
                    </div>
                </div>


                <div v-if="canShowFilter('fin_prevu')" class="form-group">
                    <label>fin_prevu </label>
                    <input v-model="form.fin_prevu" class="form-control"
                           type="text">

                    <div v-if="errors.fin_prevu" class='div-error' show variant="danger">
                        {{ errors.fin_prevu }}
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
                    <label>lignesmoyenstransports </label>
                    <v-select
                        v-model="form.lignesmoyenstransport_id"
                        :options="lignesmoyenstransportsData"
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
    name: 'FiltreDeplacements',
    components: {CustomSelect, Files},
    props: [
        'table',
        'lignesmoyenstransportsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                date: "",

                ligne: "",

                moyenstransport: "",

                debut_prevu: "",

                fin_prevu: "",

                lignesmoyenstransport_id: "",

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
