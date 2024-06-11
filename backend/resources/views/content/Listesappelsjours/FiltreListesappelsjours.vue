<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('rand')" class="form-group">
                    <label>rand </label>
                    <input v-model="form.rand" class="form-control"
                           type="text">

                    <div v-if="errors.rand" class='div-error' show variant="danger">
                        {{ errors.rand }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour01')" class="form-group">
                    <label>jour01 </label>
                    <input v-model="form.jour01" class="form-control"
                           type="text">

                    <div v-if="errors.jour01" class='div-error' show variant="danger">
                        {{ errors.jour01 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour02')" class="form-group">
                    <label>jour02 </label>
                    <input v-model="form.jour02" class="form-control"
                           type="text">

                    <div v-if="errors.jour02" class='div-error' show variant="danger">
                        {{ errors.jour02 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour03')" class="form-group">
                    <label>jour03 </label>
                    <input v-model="form.jour03" class="form-control"
                           type="text">

                    <div v-if="errors.jour03" class='div-error' show variant="danger">
                        {{ errors.jour03 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour04')" class="form-group">
                    <label>jour04 </label>
                    <input v-model="form.jour04" class="form-control"
                           type="text">

                    <div v-if="errors.jour04" class='div-error' show variant="danger">
                        {{ errors.jour04 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour05')" class="form-group">
                    <label>jour05 </label>
                    <input v-model="form.jour05" class="form-control"
                           type="text">

                    <div v-if="errors.jour05" class='div-error' show variant="danger">
                        {{ errors.jour05 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour06')" class="form-group">
                    <label>jour06 </label>
                    <input v-model="form.jour06" class="form-control"
                           type="text">

                    <div v-if="errors.jour06" class='div-error' show variant="danger">
                        {{ errors.jour06 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour07')" class="form-group">
                    <label>jour07 </label>
                    <input v-model="form.jour07" class="form-control"
                           type="text">

                    <div v-if="errors.jour07" class='div-error' show variant="danger">
                        {{ errors.jour07 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour08')" class="form-group">
                    <label>jour08 </label>
                    <input v-model="form.jour08" class="form-control"
                           type="text">

                    <div v-if="errors.jour08" class='div-error' show variant="danger">
                        {{ errors.jour08 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour09')" class="form-group">
                    <label>jour09 </label>
                    <input v-model="form.jour09" class="form-control"
                           type="text">

                    <div v-if="errors.jour09" class='div-error' show variant="danger">
                        {{ errors.jour09 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour10')" class="form-group">
                    <label>jour10 </label>
                    <input v-model="form.jour10" class="form-control"
                           type="text">

                    <div v-if="errors.jour10" class='div-error' show variant="danger">
                        {{ errors.jour10 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour11')" class="form-group">
                    <label>jour11 </label>
                    <input v-model="form.jour11" class="form-control"
                           type="text">

                    <div v-if="errors.jour11" class='div-error' show variant="danger">
                        {{ errors.jour11 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour12')" class="form-group">
                    <label>jour12 </label>
                    <input v-model="form.jour12" class="form-control"
                           type="text">

                    <div v-if="errors.jour12" class='div-error' show variant="danger">
                        {{ errors.jour12 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour13')" class="form-group">
                    <label>jour13 </label>
                    <input v-model="form.jour13" class="form-control"
                           type="text">

                    <div v-if="errors.jour13" class='div-error' show variant="danger">
                        {{ errors.jour13 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour14')" class="form-group">
                    <label>jour14 </label>
                    <input v-model="form.jour14" class="form-control"
                           type="text">

                    <div v-if="errors.jour14" class='div-error' show variant="danger">
                        {{ errors.jour14 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour15')" class="form-group">
                    <label>jour15 </label>
                    <input v-model="form.jour15" class="form-control"
                           type="text">

                    <div v-if="errors.jour15" class='div-error' show variant="danger">
                        {{ errors.jour15 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour16')" class="form-group">
                    <label>jour16 </label>
                    <input v-model="form.jour16" class="form-control"
                           type="text">

                    <div v-if="errors.jour16" class='div-error' show variant="danger">
                        {{ errors.jour16 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour17')" class="form-group">
                    <label>jour17 </label>
                    <input v-model="form.jour17" class="form-control"
                           type="text">

                    <div v-if="errors.jour17" class='div-error' show variant="danger">
                        {{ errors.jour17 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour18')" class="form-group">
                    <label>jour18 </label>
                    <input v-model="form.jour18" class="form-control"
                           type="text">

                    <div v-if="errors.jour18" class='div-error' show variant="danger">
                        {{ errors.jour18 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour19')" class="form-group">
                    <label>jour19 </label>
                    <input v-model="form.jour19" class="form-control"
                           type="text">

                    <div v-if="errors.jour19" class='div-error' show variant="danger">
                        {{ errors.jour19 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour20')" class="form-group">
                    <label>jour20 </label>
                    <input v-model="form.jour20" class="form-control"
                           type="text">

                    <div v-if="errors.jour20" class='div-error' show variant="danger">
                        {{ errors.jour20 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour21')" class="form-group">
                    <label>jour21 </label>
                    <input v-model="form.jour21" class="form-control"
                           type="text">

                    <div v-if="errors.jour21" class='div-error' show variant="danger">
                        {{ errors.jour21 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour22')" class="form-group">
                    <label>jour22 </label>
                    <input v-model="form.jour22" class="form-control"
                           type="text">

                    <div v-if="errors.jour22" class='div-error' show variant="danger">
                        {{ errors.jour22 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour23')" class="form-group">
                    <label>jour23 </label>
                    <input v-model="form.jour23" class="form-control"
                           type="text">

                    <div v-if="errors.jour23" class='div-error' show variant="danger">
                        {{ errors.jour23 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour24')" class="form-group">
                    <label>jour24 </label>
                    <input v-model="form.jour24" class="form-control"
                           type="text">

                    <div v-if="errors.jour24" class='div-error' show variant="danger">
                        {{ errors.jour24 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour25')" class="form-group">
                    <label>jour25 </label>
                    <input v-model="form.jour25" class="form-control"
                           type="text">

                    <div v-if="errors.jour25" class='div-error' show variant="danger">
                        {{ errors.jour25 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour26')" class="form-group">
                    <label>jour26 </label>
                    <input v-model="form.jour26" class="form-control"
                           type="text">

                    <div v-if="errors.jour26" class='div-error' show variant="danger">
                        {{ errors.jour26 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour27')" class="form-group">
                    <label>jour27 </label>
                    <input v-model="form.jour27" class="form-control"
                           type="text">

                    <div v-if="errors.jour27" class='div-error' show variant="danger">
                        {{ errors.jour27 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour28')" class="form-group">
                    <label>jour28 </label>
                    <input v-model="form.jour28" class="form-control"
                           type="text">

                    <div v-if="errors.jour28" class='div-error' show variant="danger">
                        {{ errors.jour28 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour29')" class="form-group">
                    <label>jour29 </label>
                    <input v-model="form.jour29" class="form-control"
                           type="text">

                    <div v-if="errors.jour29" class='div-error' show variant="danger">
                        {{ errors.jour29 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour30')" class="form-group">
                    <label>jour30 </label>
                    <input v-model="form.jour30" class="form-control"
                           type="text">

                    <div v-if="errors.jour30" class='div-error' show variant="danger">
                        {{ errors.jour30 }}
                    </div>
                </div>


                <div v-if="canShowFilter('jour31')" class="form-group">
                    <label>jour31 </label>
                    <input v-model="form.jour31" class="form-control"
                           type="text">

                    <div v-if="errors.jour31" class='div-error' show variant="danger">
                        {{ errors.jour31 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache01')" class="form-group">
                    <label>tache01 </label>
                    <input v-model="form.tache01" class="form-control"
                           type="text">

                    <div v-if="errors.tache01" class='div-error' show variant="danger">
                        {{ errors.tache01 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache02')" class="form-group">
                    <label>tache02 </label>
                    <input v-model="form.tache02" class="form-control"
                           type="text">

                    <div v-if="errors.tache02" class='div-error' show variant="danger">
                        {{ errors.tache02 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache03')" class="form-group">
                    <label>tache03 </label>
                    <input v-model="form.tache03" class="form-control"
                           type="text">

                    <div v-if="errors.tache03" class='div-error' show variant="danger">
                        {{ errors.tache03 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache04')" class="form-group">
                    <label>tache04 </label>
                    <input v-model="form.tache04" class="form-control"
                           type="text">

                    <div v-if="errors.tache04" class='div-error' show variant="danger">
                        {{ errors.tache04 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache05')" class="form-group">
                    <label>tache05 </label>
                    <input v-model="form.tache05" class="form-control"
                           type="text">

                    <div v-if="errors.tache05" class='div-error' show variant="danger">
                        {{ errors.tache05 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache06')" class="form-group">
                    <label>tache06 </label>
                    <input v-model="form.tache06" class="form-control"
                           type="text">

                    <div v-if="errors.tache06" class='div-error' show variant="danger">
                        {{ errors.tache06 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache07')" class="form-group">
                    <label>tache07 </label>
                    <input v-model="form.tache07" class="form-control"
                           type="text">

                    <div v-if="errors.tache07" class='div-error' show variant="danger">
                        {{ errors.tache07 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache08')" class="form-group">
                    <label>tache08 </label>
                    <input v-model="form.tache08" class="form-control"
                           type="text">

                    <div v-if="errors.tache08" class='div-error' show variant="danger">
                        {{ errors.tache08 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache09')" class="form-group">
                    <label>tache09 </label>
                    <input v-model="form.tache09" class="form-control"
                           type="text">

                    <div v-if="errors.tache09" class='div-error' show variant="danger">
                        {{ errors.tache09 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache10')" class="form-group">
                    <label>tache10 </label>
                    <input v-model="form.tache10" class="form-control"
                           type="text">

                    <div v-if="errors.tache10" class='div-error' show variant="danger">
                        {{ errors.tache10 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache11')" class="form-group">
                    <label>tache11 </label>
                    <input v-model="form.tache11" class="form-control"
                           type="text">

                    <div v-if="errors.tache11" class='div-error' show variant="danger">
                        {{ errors.tache11 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache12')" class="form-group">
                    <label>tache12 </label>
                    <input v-model="form.tache12" class="form-control"
                           type="text">

                    <div v-if="errors.tache12" class='div-error' show variant="danger">
                        {{ errors.tache12 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache13')" class="form-group">
                    <label>tache13 </label>
                    <input v-model="form.tache13" class="form-control"
                           type="text">

                    <div v-if="errors.tache13" class='div-error' show variant="danger">
                        {{ errors.tache13 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache14')" class="form-group">
                    <label>tache14 </label>
                    <input v-model="form.tache14" class="form-control"
                           type="text">

                    <div v-if="errors.tache14" class='div-error' show variant="danger">
                        {{ errors.tache14 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache15')" class="form-group">
                    <label>tache15 </label>
                    <input v-model="form.tache15" class="form-control"
                           type="text">

                    <div v-if="errors.tache15" class='div-error' show variant="danger">
                        {{ errors.tache15 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache16')" class="form-group">
                    <label>tache16 </label>
                    <input v-model="form.tache16" class="form-control"
                           type="text">

                    <div v-if="errors.tache16" class='div-error' show variant="danger">
                        {{ errors.tache16 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache17')" class="form-group">
                    <label>tache17 </label>
                    <input v-model="form.tache17" class="form-control"
                           type="text">

                    <div v-if="errors.tache17" class='div-error' show variant="danger">
                        {{ errors.tache17 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache18')" class="form-group">
                    <label>tache18 </label>
                    <input v-model="form.tache18" class="form-control"
                           type="text">

                    <div v-if="errors.tache18" class='div-error' show variant="danger">
                        {{ errors.tache18 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache19')" class="form-group">
                    <label>tache19 </label>
                    <input v-model="form.tache19" class="form-control"
                           type="text">

                    <div v-if="errors.tache19" class='div-error' show variant="danger">
                        {{ errors.tache19 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache20')" class="form-group">
                    <label>tache20 </label>
                    <input v-model="form.tache20" class="form-control"
                           type="text">

                    <div v-if="errors.tache20" class='div-error' show variant="danger">
                        {{ errors.tache20 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache21')" class="form-group">
                    <label>tache21 </label>
                    <input v-model="form.tache21" class="form-control"
                           type="text">

                    <div v-if="errors.tache21" class='div-error' show variant="danger">
                        {{ errors.tache21 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache22')" class="form-group">
                    <label>tache22 </label>
                    <input v-model="form.tache22" class="form-control"
                           type="text">

                    <div v-if="errors.tache22" class='div-error' show variant="danger">
                        {{ errors.tache22 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache23')" class="form-group">
                    <label>tache23 </label>
                    <input v-model="form.tache23" class="form-control"
                           type="text">

                    <div v-if="errors.tache23" class='div-error' show variant="danger">
                        {{ errors.tache23 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache24')" class="form-group">
                    <label>tache24 </label>
                    <input v-model="form.tache24" class="form-control"
                           type="text">

                    <div v-if="errors.tache24" class='div-error' show variant="danger">
                        {{ errors.tache24 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache25')" class="form-group">
                    <label>tache25 </label>
                    <input v-model="form.tache25" class="form-control"
                           type="text">

                    <div v-if="errors.tache25" class='div-error' show variant="danger">
                        {{ errors.tache25 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache26')" class="form-group">
                    <label>tache26 </label>
                    <input v-model="form.tache26" class="form-control"
                           type="text">

                    <div v-if="errors.tache26" class='div-error' show variant="danger">
                        {{ errors.tache26 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache27')" class="form-group">
                    <label>tache27 </label>
                    <input v-model="form.tache27" class="form-control"
                           type="text">

                    <div v-if="errors.tache27" class='div-error' show variant="danger">
                        {{ errors.tache27 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache28')" class="form-group">
                    <label>tache28 </label>
                    <input v-model="form.tache28" class="form-control"
                           type="text">

                    <div v-if="errors.tache28" class='div-error' show variant="danger">
                        {{ errors.tache28 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache29')" class="form-group">
                    <label>tache29 </label>
                    <input v-model="form.tache29" class="form-control"
                           type="text">

                    <div v-if="errors.tache29" class='div-error' show variant="danger">
                        {{ errors.tache29 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache30')" class="form-group">
                    <label>tache30 </label>
                    <input v-model="form.tache30" class="form-control"
                           type="text">

                    <div v-if="errors.tache30" class='div-error' show variant="danger">
                        {{ errors.tache30 }}
                    </div>
                </div>


                <div v-if="canShowFilter('tache31')" class="form-group">
                    <label>tache31 </label>
                    <input v-model="form.tache31" class="form-control"
                           type="text">

                    <div v-if="errors.tache31" class='div-error' show variant="danger">
                        {{ errors.tache31 }}
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


                <div class="form-group">
                    <label>listesappels </label>
                    <v-select
                        v-model="form.listesappel_id"
                        :options="listesappelsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
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
    name: 'FiltreListesappelsjours',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'listesappelsData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                rand: "",

                jour01: "",

                jour02: "",

                jour03: "",

                jour04: "",

                jour05: "",

                jour06: "",

                jour07: "",

                jour08: "",

                jour09: "",

                jour10: "",

                jour11: "",

                jour12: "",

                jour13: "",

                jour14: "",

                jour15: "",

                jour16: "",

                jour17: "",

                jour18: "",

                jour19: "",

                jour20: "",

                jour21: "",

                jour22: "",

                jour23: "",

                jour24: "",

                jour25: "",

                jour26: "",

                jour27: "",

                jour28: "",

                jour29: "",

                jour30: "",

                jour31: "",

                tache01: "",

                tache02: "",

                tache03: "",

                tache04: "",

                tache05: "",

                tache06: "",

                tache07: "",

                tache08: "",

                tache09: "",

                tache10: "",

                tache11: "",

                tache12: "",

                tache13: "",

                tache14: "",

                tache15: "",

                tache16: "",

                tache17: "",

                tache18: "",

                tache19: "",

                tache20: "",

                tache21: "",

                tache22: "",

                tache23: "",

                tache24: "",

                tache25: "",

                tache26: "",

                tache27: "",

                tache28: "",

                tache29: "",

                tache30: "",

                tache31: "",

                listesappel_id: "",

                user_id: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                identifiants_sadge: "",
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
