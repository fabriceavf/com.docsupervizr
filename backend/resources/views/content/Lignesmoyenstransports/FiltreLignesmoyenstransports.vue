<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('heure_debut')" class="form-group">
                    <label>heure_debut </label>
                    <input v-model="form.heure_debut" class="form-control"
                           type="text">

                    <div v-if="errors.heure_debut" class='div-error' show variant="danger">
                        {{ errors.heure_debut }}
                    </div>
                </div>


                <div v-if="canShowFilter('heure_fin')" class="form-group">
                    <label>heure_fin </label>
                    <input v-model="form.heure_fin" class="form-control"
                           type="text">

                    <div v-if="errors.heure_fin" class='div-error' show variant="danger">
                        {{ errors.heure_fin }}
                    </div>
                </div>


                <div v-if="canShowFilter('lun')" class="form-group">
                    <label>lun </label>
                    <input v-model="form.lun" class="form-control"
                           type="text">

                    <div v-if="errors.lun" class='div-error' show variant="danger">
                        {{ errors.lun }}
                    </div>
                </div>


                <div v-if="canShowFilter('mar')" class="form-group">
                    <label>mar </label>
                    <input v-model="form.mar" class="form-control"
                           type="text">

                    <div v-if="errors.mar" class='div-error' show variant="danger">
                        {{ errors.mar }}
                    </div>
                </div>


                <div v-if="canShowFilter('mer')" class="form-group">
                    <label>mer </label>
                    <input v-model="form.mer" class="form-control"
                           type="text">

                    <div v-if="errors.mer" class='div-error' show variant="danger">
                        {{ errors.mer }}
                    </div>
                </div>


                <div v-if="canShowFilter('jeu')" class="form-group">
                    <label>jeu </label>
                    <input v-model="form.jeu" class="form-control"
                           type="text">

                    <div v-if="errors.jeu" class='div-error' show variant="danger">
                        {{ errors.jeu }}
                    </div>
                </div>


                <div v-if="canShowFilter('ven')" class="form-group">
                    <label>ven </label>
                    <input v-model="form.ven" class="form-control"
                           type="text">

                    <div v-if="errors.ven" class='div-error' show variant="danger">
                        {{ errors.ven }}
                    </div>
                </div>


                <div v-if="canShowFilter('sam')" class="form-group">
                    <label>sam </label>
                    <input v-model="form.sam" class="form-control"
                           type="text">

                    <div v-if="errors.sam" class='div-error' show variant="danger">
                        {{ errors.sam }}
                    </div>
                </div>


                <div v-if="canShowFilter('dim')" class="form-group">
                    <label>dim </label>
                    <input v-model="form.dim" class="form-control"
                           type="text">

                    <div v-if="errors.dim" class='div-error' show variant="danger">
                        {{ errors.dim }}
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
                    <label>moyenstransports </label>
                    <v-select
                        v-model="form.moyenstransport_id"
                        :options="moyenstransportsData"
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
    name: 'FiltreLignesmoyenstransports',
    components: {CustomSelect, Files},
    props: [
        'table',
        'lignesData',
        'moyenstransportsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                moyenstransport_id: "",

                ligne_id: "",

                heure_debut: "",

                heure_fin: "",

                lun: "",

                mar: "",

                mer: "",

                jeu: "",

                ven: "",

                sam: "",

                dim: "",

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
