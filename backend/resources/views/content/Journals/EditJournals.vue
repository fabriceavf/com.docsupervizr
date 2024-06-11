<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="row">
                <!-- {{ form.pointeuse.deploiementspointeusesmoyenstransports[1] }} -->
                <div class="col-sm-12">
                    <h3>Informations personnels</h3>
                </div>
                <div v-if="form.user" class="form-group  col-sm-3">
                    <label>Nom </label>
                    <!-- <CustomSelect :key="form.user"
                                  :columnDefs="['libelle']"
                                  :oldValue="form.user"
                                  :renderCallBack="(data) => `${data.nom}`"
                                  :selectCallBack="(data) => form.user = data.id"
                                  :url="`${axios.defaults.baseURL}/api/users-Aggrid`"
                                  filter-key=""
                                  filter-value=""/> -->
                    <input
                        v-model="form.user.nom"
                        :class="
                                    errors.code
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                        type="text"
                    />
                    <div v-if="errors.user" class="invalid-feedback">
                        <template v-for=" error in errors.user"> {{ error[0] }}</template>

                    </div>
                </div>
                <div v-if="form.user" class="form-group  col-sm-3">
                    <label>Prenom </label>
                    <!-- <CustomSelect :key="form.user"
                                  :columnDefs="['libelle']"
                                  :oldValue="form.user"
                                  :renderCallBack="(data) => `${data.prenom}`"
                                  :selectCallBack="(data) => form.user = data.id"
                                  :url="`${axios.defaults.baseURL}/api/users-Aggrid`"
                                  filter-key=""
                                  filter-value=""/> -->
                    <input
                        v-model="form.user.prenom"
                        :class="
                                    errors.code
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                        type="text"
                    />
                    <div v-if="errors.user" class="invalid-feedback">
                        <template v-for=" error in errors.user"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label>badge </label>
                    <input v-model="form.card_no" :class="errors.card_no?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.card_no" class="invalid-feedback">
                        <template v-for=" error in errors.card_no"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label>Date </label>
                    <input v-model="form.punch_time" :class="errors.punch_time?'form-control is-invalid':'form-control'"
                           type="text">
                </div>
                <div class="col-sm-12">
                    <h3>Informations sur le terminals</h3>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>code </label>
                        <input
                            v-model="form.pointeuse.code"
                            :class="
                                    errors.code
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                            type="text"
                        />

                        <div v-if="errors.code" class="invalid-feedback">
                            <template v-for="error in errors.code">
                                {{ error[0] }}
                            </template
                            >
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>libelle </label>
                        <input
                            v-model="form.pointeuse.Selectlabel"
                            :class="
                                    errors.libelle
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                            type="text"
                        />

                        <div v-if="errors.libelle" class="invalid-feedback">
                            <template v-for="error in errors.libelle">
                                {{ error[0] }}
                            </template
                            >
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label>sites </label>
                        <!-- <CustomSelect
                            :key="form.pointeuse.site"
                            :url="`${axios.defaults.baseURL}/api/sites-Aggrid`"
                            :columnDefs="['libelle','client.Selectlabel']"
                            filter-key=""
                            filter-value=""
                            :oldValue="form.pointeuse.site"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>{form.site_id=data.id;form.site=data}"
                        /> -->
                        <input
                            v-model="form.pointeuse.site.Selectlabel"
                            :class="
                                    errors.libelle
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                            type="text"
                        />
                        <div v-if="errors.site_id" class="invalid-feedback">
                            <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div>
                <div v-if="form.pointeuse.deploiementspointeusesmoyenstransport" class="col-sm">
                    <div class="form-group">
                        <label>moyen de transport </label>
                        <!-- <CustomSelect
                            :key="form.pointeuse.site"
                            :url="`${axios.defaults.baseURL}/api/sites-Aggrid`"
                            :columnDefs="['libelle','client.Selectlabel']"
                            filter-key=""
                            filter-value=""
                            :oldValue="form.pointeuse.site"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>{form.site_id=data.id;form.site=data}"
                        /> -->
                        <input
                            v-model="form.pointeuse.deploiementspointeusesmoyenstransports.moyenstransport.Selectlabel"
                            :class="
                                    errors.libelle
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                            type="text"
                        />
                        <div v-if="errors.site_id" class="invalid-feedback">
                            <template v-for=" error in errors.site_id"> {{ error[0] }}</template>

                        </div>
                    </div>
                </div>

                <div class="col-sm-12" v-if="form.ligne">
                    <h3>Informations sur la ligne</h3>
                </div>
                <div v-if="form.ligne" class="form-group  col-sm-4">
                    <label>Ligne </label>
                    <input
                        v-model="form.ligne.libelle"
                        :class="
                                    errors.code
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                        type="text"
                    />
                </div>
                <div v-if="form.ligne && form.cout" class="form-group  col-sm-4">
                    <label>tarifs </label>

                    <input
                        v-model="form.cout"
                        :class="
                                    errors.code
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                        type="text"
                    />
                </div>
                <div v-if="form.ligne && form.type" class="form-group  col-sm-4">
                    <label>Etats de la carte </label>

                    <input
                        v-model="form.type"
                        :class="
                                    errors.code
                                        ? 'form-control is-invalid'
                                        : 'form-control'
                                "
                        type="text"
                    />
                </div>
                <div class="col-sm-12">
                    <h3>Traitements operer sur la transactions</h3>
                </div>
                <div class="col-sm-12">
                    <DetaiTransactionView :parentId="form.id"/>
                </div>

            </div>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import DetaiTransactionView from "./DetaiTransactionView.vue";

export default {
    name: 'EditJournals',
    components: {VSelect, DetaiTransactionView, CustomSelect, Files},
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
        'pointeusesData',
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

                pointeuse_id: "",

                site_id: "",

                deleted_at: "",
            }
        }
    },

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/journals/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/journals/' + this.form.id + '/delete').then(response => {
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
