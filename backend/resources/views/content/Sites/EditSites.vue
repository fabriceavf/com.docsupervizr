<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">

                <div class="row">
                    <div class="form-group col-sm">
                        <label>libelle </label>
                        <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.libelle" class="invalid-feedback">
                            <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                        </div>
                    </div>


                    <div :style="{ display: ishidden('client_id') }" class="form-group col-sm ">
                        <label>clients </label>
                        <CustomSelect
                            :key="form.client"
                            :columnDefs="['libelle']"
                            :oldValue="form.client"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>form.client_id=data.id"
                            :url="`${axios.defaults.baseURL}/api/clients-Aggrid`"
                            filter-key=""
                            filter-value=""
                        />
                        <div v-if="errors.client_id" class="invalid-feedback">
                            <template v-for=" error in errors.client_id"> {{ error[0] }}</template>

                        </div>
                    </div>

                    <div :style="{ display: ishidden('zone_id') }" class="form-group col-sm ">
                        <label>zones </label>
                        <CustomSelect
                            :key="form.zone"
                            :columnDefs="['libelle']"
                            :oldValue="form.zone"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>form.zone_id=data.id"
                            :url="`${axios.defaults.baseURL}/api/zones-Aggrid`"
                            filter-key=""
                            filter-value=""
                        />
                        <div v-if="errors.zone_id" class="invalid-feedback">
                            <template v-for=" error in errors.zone_id"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div :style="{ display: ishidden('typessite_id') }" class="form-group col-sm ">
                        <label>typessites </label>
                        <CustomSelect
                            :key="form.typessite"
                            :columnDefs="['libelle']"
                            :oldValue="form.typessite"
                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                            :selectCallBack="(data)=>form.typessite_id=data.id"
                            :url="`${axios.defaults.baseURL}/api/typessites-Aggrid`"
                            filter-key=""
                            filter-value=""
                        />
                        <div v-if="errors.typessite_id" class="invalid-feedback">
                            <template v-for=" error in errors.typessite_id"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <!-- <div class="row"> -->
                    <div class="form-group col-sm">
                        <label>date de debut </label>
                        <input v-model="form.date_debut" class="form-control" required type="date"/>
                    </div>
                    <div class="form-group col-sm">
                        <label>date de fin </label>
                        <input v-model="form.date_fin" class="form-control" required type="date"/>
                    </div>
                    <!-- </div> -->


                </div>

                <!-- <div class="row">
                    <div class="col-sm">
                        <label>pastille </label>
                        <input v-model="form.pastille" :class="errors.pastille?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.pastille" class="invalid-feedback">
                            <template v-for=" error in errors.pastille"> {{ error[0] }}</template>

                        </div>
                    </div>

                </div> -->
                <div class="col-sm-12 card">
                    <div class="card-body allBoutons">
                        <button v-b-tooltip.hover :style="actualPage == 'Pastilles' ? 'border: 3px solid  green' : ''"
                                class="btn" style="" @click.prevent="togglePage('Pastilles')">
                            <div class="iconParent">
                                <span> <i class="fa-solid fa-filter"></i> Pastilles
                                </span>
                            </div>
                        </button>
                        <button v-b-tooltip.hover :style="actualPage == 'Rondes' ? 'border: 3px solid  green' : ''"
                                class="btn" style="" @click.prevent="togglePage('Rondes')">
                            <div class="iconParent">
                                <span> <i class="fa-solid fa-filter"></i> Rondes
                                </span>
                            </div>
                        </button>
                        <button v-b-tooltip.hover :style="actualPage == 'Sites' ? 'border: 3px solid  green' : ''"
                                class="btn" style="" @click.prevent="togglePage('Sites')">
                            <div class="iconParent">
                                <span> <i class="fa-solid fa-filter"></i> Pointeuse
                                </span>
                            </div>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div v-if="actualPage == 'Pastilles'" class="col-sm">
                        <h3>Pastille </h3>
                        <PastillesView :parentId="data.id"></PastillesView>
                    </div>
                    <div v-if="actualPage == 'Rondes'" class="col-sm">
                        <h3>Ronde </h3>
                        <PassagesrondesView :parentId="data.id"></PassagesrondesView>
                    </div>
                    <div v-if="actualPage == 'Sites'" class="col-sm">
                        <h3>Pointeuse </h3>
                        <Sitespointeuses :parentId="data.id"></Sitespointeuses>
                    </div>
                </div>


                <!-- <div class="row">
                    <h1 style="text-align: center;">Proyecto Vue Google Map</h1>
                    <Maps :mapkey="mapkey"/>
                </div> -->
            </div>
            <div v-if="type !='Sites'" class="d-flex justify-content-between">
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
import PastillesView from "./Pastilles/PastillesView.vue";
import PassagesrondesView from "./Passagesrondes/PassagesrondesView.vue";
import Sitespointeuses from "./Sitespointeuses.vue";
import VSelect from 'vue-select'
import Maps from "./Maps.vue";

export default {
    name: 'EditSites',
    components: {VSelect, CustomSelect, Files, Sitespointeuses, PastillesView, PassagesrondesView, Maps},
    props: ['data', 'gridApi', 'modalFormId',
        'clientsData',
        'zonesData',
        'champsAfficher', 'mapkey'
    ],
    data() {
        return {
            errors: [],
            actualPage: '',
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                client_id: "",

                zone_id: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",
            }
        }
    },

    mounted() {
        this.form = this.data
        this.actualPage = 'Pastilles'
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/sites/' + this.form.id + '/update', this.form).then(response => {
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
            this.axios.post('/api/sites/' + this.form.id + '/delete').then(response => {
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
        ishidden(fieldName) {
            // METHODE UTILISER DANS (HIDE) POUR PERMETTRE DE MASQUER LES CHAMPS MIS DANS LE TABLEAU champsAfficher
            if (this.champsAfficher.includes(fieldName)) {
                return "none"
            }
        },
        togglePage(page) {
            this.actualPage = page
            this.tableKey++
        },
    }
}
</script>
