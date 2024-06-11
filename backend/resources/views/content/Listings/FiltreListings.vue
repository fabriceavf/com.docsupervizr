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


                <div v-if="canShowFilter('nom')" class="form-group">
                    <label>nom </label>
                    <input v-model="form.nom" class="form-control"
                           type="text">

                    <div v-if="errors.nom" class='div-error' show variant="danger">
                        {{ errors.nom }}
                    </div>
                </div>


                <div v-if="canShowFilter('prenom')" class="form-group">
                    <label>prenom </label>
                    <input v-model="form.prenom" class="form-control"
                           type="text">

                    <div v-if="errors.prenom" class='div-error' show variant="danger">
                        {{ errors.prenom }}
                    </div>
                </div>


                <div v-if="canShowFilter('matricule')" class="form-group">
                    <label>matricule </label>
                    <input v-model="form.matricule" class="form-control"
                           type="text">

                    <div v-if="errors.matricule" class='div-error' show variant="danger">
                        {{ errors.matricule }}
                    </div>
                </div>


                <div v-if="canShowFilter('num_badge')" class="form-group">
                    <label>num_badge </label>
                    <input v-model="form.num_badge" class="form-control"
                           type="text">

                    <div v-if="errors.num_badge" class='div-error' show variant="danger">
                        {{ errors.num_badge }}
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


                <div v-if="canShowFilter('date')" class="form-group">
                    <label>date </label>
                    <input v-model="form.date" class="form-control"
                           type="date">

                    <div v-if="errors.date" class='div-error' show variant="danger">
                        {{ errors.date }}
                    </div>
                </div>


                <div v-if="canShowFilter('present')" class="form-group">
                    <label>present </label>
                    <input v-model="form.present" class="form-control"
                           type="text">

                    <div v-if="errors.present" class='div-error' show variant="danger">
                        {{ errors.present }}
                    </div>
                </div>


                <div v-if="canShowFilter('id_date')" class="form-group">
                    <label>id_date </label>
                    <input v-model="form.id_date" class="form-control"
                           type="text">

                    <div v-if="errors.id_date" class='div-error' show variant="danger">
                        {{ errors.id_date }}
                    </div>
                </div>


                <div class="form-group">
                    <label>actifs </label>
                    <v-select
                        v-model="form.actif_id"
                        :options="actifsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>balises </label>
                    <v-select
                        v-model="form.balise_id"
                        :options="balisesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>categories </label>
                    <v-select
                        v-model="form.categorie_id"
                        :options="categoriesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>contrats </label>
                    <v-select
                        v-model="form.contrat_id"
                        :options="contratsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>directions </label>
                    <v-select
                        v-model="form.direction_id"
                        :options="directionsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>echelons </label>
                    <v-select
                        v-model="form.echelon_id"
                        :options="echelonsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>factions </label>
                    <v-select
                        v-model="form.faction_id"
                        :options="factionsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>fonctions </label>
                    <v-select
                        v-model="form.fonction_id"
                        :options="fonctionsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>matrimoniales </label>
                    <v-select
                        v-model="form.matrimoniale_id"
                        :options="matrimonialesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>nationalites </label>
                    <v-select
                        v-model="form.nationalite_id"
                        :options="nationalitesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>onlines </label>
                    <v-select
                        v-model="form.online_id"
                        :options="onlinesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>postes </label>
                    <v-select
                        v-model="form.poste_id"
                        :options="postesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>sexes </label>
                    <v-select
                        v-model="form.sexe_id"
                        :options="sexesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>sites </label>
                    <v-select
                        v-model="form.site_id"
                        :options="sitesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>situations </label>
                    <v-select
                        v-model="form.situation_id"
                        :options="situationsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>types </label>
                    <v-select
                        v-model="form.type_id"
                        :options="typesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>villes </label>
                    <v-select
                        v-model="form.ville_id"
                        :options="villesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>


                <div class="form-group">
                    <label>zones </label>
                    <v-select
                        v-model="form.zone_id"
                        :options="zonesData"
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
    name: 'FiltreListings',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'actifsData',
        'balisesData',
        'categoriesData',
        'contratsData',
        'directionsData',
        'echelonsData',
        'factionsData',
        'fonctionsData',
        'matrimonialesData',
        'nationalitesData',
        'onlinesData',
        'postesData',
        'sexesData',
        'sitesData',
        'situationsData',
        'typesData',
        'villesData',
        'zonesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                name: "",

                nom: "",

                prenom: "",

                matricule: "",

                num_badge: "",

                actif_id: "",

                nationalite_id: "",

                contrat_id: "",

                direction_id: "",

                categorie_id: "",

                echelon_id: "",

                sexe_id: "",

                matrimoniale_id: "",

                poste_id: "",

                ville_id: "",

                zone_id: "",

                situation_id: "",

                balise_id: "",

                fonction_id: "",

                emp_code: "",

                online_id: "",

                type_id: "",

                faction_id: "",

                date: "",

                present: "",

                site_id: "",

                id_date: "",

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
