<template>
    <b-overlay :show="isLoading">
        <!--{{form.action}}-->

        <div class="parent ">
            <div class="row">
                <div v-if="form.action == 'Update'" class="btn btn-warning col " disabled>Modification de {{
                        entite
                    }} avec l'id #{{ form.entite_cle }}
                </div>
                <div v-if="form.action == 'Create'" class="btn btn-success col " disabled>Creation de
                    {{ entite }}
                    avec l'id #{{ form.entite_cle }}
                </div>
                <div v-if="form.action == 'Delete'" class="btn btn-danger col " disabled>Suppression de {{
                        entite
                    }}
                    avec l'id #{{ form.entite_cle }}
                </div>
                <div class="btn btn-warning col mx-1" disabled><i class="fa-solid fa-calendar-days"></i> {{
                        date
                    }}
                </div>
                <div class="btn btn-warning col mx-1" disabled><i class="fa-solid fa-user"></i> {{ agents }}
                </div>
            </div>

            <div v-if="libelle">
                <label for="">Element Traiter</label>
                <p class="details">
                    {{ libelle }}
                </p>
            </div>
            <div class="container">
                <template v-if="champs.length > 0">
                    <div v-for="cle in champs" v-if="!cle.champ.endsWith('_id')" class="row">


                        <div class="col" style="overflow: hidden;">
                            <label for="">Champ modifier</label>
                            <p class="champ">{{ cle.champ }}</p>
                        </div>
                        <div v-if="cle.ancien" class="col" style="overflow: hidden;">
                            <label for="">Ancienne valeur</label>
                            <p :class="cle.nouveau!=cle.ancien?'oldData':'data'"> --- {{ cle.ancien }}</p>
                        </div>
                        <div v-else class="col">
                            <label for="">Ancienne valeur</label>
                            <p class="oldData"> Null</p>
                        </div>
                        <div v-if="cle.nouveau" class="col" style="overflow: hidden;">
                            <label for="">Nouvelle valeur</label>
                            <p :class="cle.nouveau!=cle.ancien?'newData':'data'"> +++ {{ cle.nouveau }}</p>
                        </div>
                        <div v-else class="col">
                            <label for="">Nouvelle valeur</label>
                            <p class="newData"> Null</p>
                        </div>

                    </div>
                </template>
                <template v-else>

                    <div class="btn btn-success" disabled style="width:100%">Aucune information n'a ete modifier</div>
                </template>
            </div>
        </div>


        <!-- <div class="container">
            <div class="row">
                <template v-if="champs.length > 0">
                    <div class="col-12" v-for="cle in champs" >
                        <div>
                            <label for="">Champ modifier</label>
                            <p class="champ">{{ cle.champ }}</p>
                        </div>
                        <div v-if="cle.ancien">
                            <label for="">Ancienne valeur</label>
                            <p class="oldData"> --- {{ cle.ancien }}</p>
                        </div>
                        <div v-if="cle.nouveau">
                            <label for="">Nouvelle valeur</label>
                            <p class="newData"> +++ {{ cle.nouveau }}</p>
                        </div>
                        <div v-else>
                            <label for="">Nouvelle valeur</label>
                            <p class="newData"> Null</p>
                        </div>
                    </div>
                </template>

                <template class="col-12" v-else>

                    <div class="btn btn-success" disabled style="width:100%">Aucune information n'a ete modifier</div>
                </template>
            </div>
        </div> -->


    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import moment from 'moment'

export default {
    name: 'EditSurveillances',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
        'usersData'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            oldData: {},
            newData: {},
            touteLesCles: [],
            form: {

                id: "",

                action: "",

                entite: "",

                entite_cle: "",

                ancien: "",

                nouveau: "",

                user_id: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                extra_attributes: "",
            },
            agents: ""
        }
    },

    created() {


        try {
            this.oldData = JSON.parse(this.data.ancien)
        } catch (e) {

        }
        try {
            this.newData = JSON.parse(this.data.nouveau)
        } catch (e) {

        }

        let key1 = Object.keys(this.oldData)
        let key2 = Object.keys(this.newData)
        this.touteLesCles = key1.concat(key2);
        this.touteLesCles = this.touteLesCles.filter((value, index, array) => {
            return array.indexOf(value) === index;
        })
        console.log('voici les data ==>', this.oldData, this.newData)
    },
    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
                }
            } catch (e) {
            }

            return router;
        },
        champs: function () {
            let data = this.touteLesCles
                .map(data => {
                    let oldData = this.oldData[data];
                    if (!Object.keys(this.oldData).includes(data) || oldData === null || oldData.length == 0) {
                        oldData = "";
                    }

                    let newData = this.newData[data];
                    if (!Object.keys(this.newData).includes(data) || newData === null || newData.length == 0) {
                        newData = "";
                    }


                    console.log('voici les data cruds ==>', data, oldData, newData)
                    return {'champ': data, 'ancien': oldData, 'nouveau': newData}
                })
            return data


        },
        champs1: function () {
            let data = this.touteLesCles.map(data => {
                    let oldData = this.oldData[data];
                    if (!Object.keys(this.oldData).includes(data) || oldData === null || oldData.length == 0) {
                        oldData = "";
                    }

                    let newData = this.newData[data];
                    if (!Object.keys(this.newData).includes(data) || newData === null || newData.length == 0) {
                        newData = "";
                    }


                    console.log('voici les data cruds ==>', data, oldData, newData)
                    return {'champ': data, 'ancien': oldData, 'nouveau': newData}
                }
            ).filter(data => String(data.nouveau) === String(data.ancien))
            return data


        },
        libelle: function () {
            let response = ""
            let champ = Object.keys(this.oldData)
            if (champ.includes('nom') && champ.includes('prenom') && champ.includes('matricule')) {

                if (!this.oldData['nom'] && !this.oldData['prenom'] && !this.oldData['matricule']) {
                    response = null
                } else {
                    if (!this.oldData['nom']) {
                        this.oldData['nom'] = 'vide'
                    }
                    if (!this.oldData['prenom']) {
                        this.oldData['prenom'] = 'vide'
                    }
                    if (!this.oldData['matricule']) {
                        this.oldData['matricule'] = 'vide'
                    }
                    response = this.oldData['nom'] + " " + this.oldData['prenom'] + " " + this.oldData['matricule']
                }

            } else if (champ.includes('libelle')) {

                if (!this.oldData['libelle']) {
                    response = null
                } else {
                    response = this.oldData['libelle']
                }

            } else if (champ.includes('name')) {

                if (!this.oldData['name']) {
                    response = null
                } else {
                    response = this.oldData['name']
                }

            } else {

            }
            return response

        },
        date: function () {
            if (!this.form.created_at) {
                return 'Date inconnue'
            } else {

            }
            return moment(this.form.created_at).format('DD/MM/YYYY H:m:s')


        },
        entite: function () {
            let response = this.form.entite
            if (this.form.entite == "Users" && this.oldData.type_id == 2) {
                response = 'Agents'
            }
            return response;


        },
    },
    mounted() {
        this.form = this.data
        try {
            this.agents = this.form.user.nom + " " + this.form.user.prenom
        } catch (e) {
            console.log('error agents', e)

        }


    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/cruds/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/cruds/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
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
<style>
.modification {
    display: flex;
    flex-direction: column;
    gap: 5px
}

.champ {
    padding: 10px;
    background: #e8e8e8;
    border-radius: 5px;
}

.oldData {
    padding: 10px;
    background: #e8e8e8;
    border-radius: 5px;
    color: #c42626;
    overflow: hidden;

}

.newData {
    padding: 10px;
    background: #e8e8e8;
    border-radius: 5px;
    color: #389955;
    overflow: hidden;

}

.data {
    padding: 10px;
    background: #e8e8e8;
    border-radius: 5px;
    overflow: hidden;

}

.details {
    padding: 10px;
    background: #e8e8e8;
    border-radius: 5px;
    color: #389955;
}

.parent {
    display: flex;
    gap: 10px;
    flex-direction: column;
}
</style>
