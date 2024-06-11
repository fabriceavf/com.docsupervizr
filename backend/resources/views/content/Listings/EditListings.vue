<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>name </label>
                    <input v-model="form.name" :class="errors.name?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.name" class="invalid-feedback">
                        <template v-for=" error in errors.name"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>nom </label>
                    <input v-model="form.nom" :class="errors.nom?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.nom" class="invalid-feedback">
                        <template v-for=" error in errors.nom"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>prenom </label>
                    <input v-model="form.prenom" :class="errors.prenom?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.prenom" class="invalid-feedback">
                        <template v-for=" error in errors.prenom"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>matricule </label>
                    <input v-model="form.matricule" :class="errors.matricule?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.matricule" class="invalid-feedback">
                        <template v-for=" error in errors.matricule"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>num_badge </label>
                    <input v-model="form.num_badge" :class="errors.num_badge?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.num_badge" class="invalid-feedback">
                        <template v-for=" error in errors.num_badge"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>emp_code </label>
                    <input v-model="form.emp_code" :class="errors.emp_code?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.emp_code" class="invalid-feedback">
                        <template v-for=" error in errors.emp_code"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>date </label>
                    <input v-model="form.date" :class="errors.date?'form-control is-invalid':'form-control'"
                           type="date">

                    <div v-if="errors.date" class="invalid-feedback">
                        <template v-for=" error in errors.date"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>present </label>
                    <input v-model="form.present" :class="errors.present?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.present" class="invalid-feedback">
                        <template v-for=" error in errors.present"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>id_date </label>
                    <input v-model="form.id_date" :class="errors.id_date?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.id_date" class="invalid-feedback">
                        <template v-for=" error in errors.id_date"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>actifs </label>
                    <v-select
                        v-model="form.actif_id"
                        :options="actifsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.actif_id" class="invalid-feedback">
                        <template v-for=" error in errors.actif_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>balises </label>
                    <v-select
                        v-model="form.balise_id"
                        :options="balisesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.balise_id" class="invalid-feedback">
                        <template v-for=" error in errors.balise_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>categories </label>
                    <v-select
                        v-model="form.categorie_id"
                        :options="categoriesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.categorie_id" class="invalid-feedback">
                        <template v-for=" error in errors.categorie_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>contrats </label>
                    <v-select
                        v-model="form.contrat_id"
                        :options="contratsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.contrat_id" class="invalid-feedback">
                        <template v-for=" error in errors.contrat_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>directions </label>
                    <v-select
                        v-model="form.direction_id"
                        :options="directionsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.direction_id" class="invalid-feedback">
                        <template v-for=" error in errors.direction_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>echelons </label>
                    <v-select
                        v-model="form.echelon_id"
                        :options="echelonsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.echelon_id" class="invalid-feedback">
                        <template v-for=" error in errors.echelon_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>factions </label>
                    <v-select
                        v-model="form.faction_id"
                        :options="factionsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.faction_id" class="invalid-feedback">
                        <template v-for=" error in errors.faction_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>fonctions </label>
                    <v-select
                        v-model="form.fonction_id"
                        :options="fonctionsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.fonction_id" class="invalid-feedback">
                        <template v-for=" error in errors.fonction_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>matrimoniales </label>
                    <v-select
                        v-model="form.matrimoniale_id"
                        :options="matrimonialesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.matrimoniale_id" class="invalid-feedback">
                        <template v-for=" error in errors.matrimoniale_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>nationalites </label>
                    <v-select
                        v-model="form.nationalite_id"
                        :options="nationalitesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.nationalite_id" class="invalid-feedback">
                        <template v-for=" error in errors.nationalite_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>onlines </label>
                    <v-select
                        v-model="form.online_id"
                        :options="onlinesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.online_id" class="invalid-feedback">
                        <template v-for=" error in errors.online_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>postes </label>
                    <v-select
                        v-model="form.poste_id"
                        :options="postesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.poste_id" class="invalid-feedback">
                        <template v-for=" error in errors.poste_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>sexes </label>
                    <v-select
                        v-model="form.sexe_id"
                        :options="sexesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.sexe_id" class="invalid-feedback">
                        <template v-for=" error in errors.sexe_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>sites </label>
                    <v-select
                        v-model="form.site_id"
                        :options="sitesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.site_id" class="invalid-feedback">
                        <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>situations </label>
                    <v-select
                        v-model="form.situation_id"
                        :options="situationsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.situation_id" class="invalid-feedback">
                        <template v-for=" error in errors.situation_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>types </label>
                    <v-select
                        v-model="form.type_id"
                        :options="typesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.type_id" class="invalid-feedback">
                        <template v-for=" error in errors.type_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>villes </label>
                    <v-select
                        v-model="form.ville_id"
                        :options="villesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.ville_id" class="invalid-feedback">
                        <template v-for=" error in errors.ville_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>zones </label>
                    <v-select
                        v-model="form.zone_id"
                        :options="zonesData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                    />
                    <div v-if="errors.zone_id" class="invalid-feedback">
                        <template v-for=" error in errors.zone_id"> {{ error[0] }}</template>

                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'EditListings',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
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

    mounted() {
        this.form = this.data
        this.form['date'] = this.form['date'].split(' ')[0]
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/listings/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/listings/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
    }
}
</script>
