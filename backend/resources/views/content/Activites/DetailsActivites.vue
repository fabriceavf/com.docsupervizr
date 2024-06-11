<template>
    <b-overlay :show="isLoading">
        <div class="statut" style="margin:10px">
            <button v-if="isBloquer(form)" class="btn btn-danger" disabled style="width:100%;cursor:auto">Activite
                Bloquer
            </button>
            <button v-else-if="isTerminer(form)" class="btn btn-primary" disabled style="width:100%;cursor:auto">
                Activite Terminer
            </button>

            <button v-else-if="isAccepter(form)" class="btn btn-primary" disabled style="width:100%;cursor:auto">
                Activite Accepter
            </button>
            <button v-else-if="isRefuser(form)" class="btn btn-warning" disabled style="width:100%;cursor:auto">Activite
                Refuser
            </button>
            <button v-else-if="isValider(form)" class="btn btn-primary" disabled style="width:100%;cursor:auto">Activite
                Valider
                Valider
            </button>
            <button v-else class="btn btn-secondary" disabled style="width:100%;cursor:auto">Activite en attente de
                validation
            </button>
        </div>


        <div v-if="!isValider(form) && !form.CanUpdate">
            <div class="container">
                Cette activite n'est pas encore valider par le createur , Attendez qu'il la
                valide pour commencer voir le detail
            </div>
        </div>
        <div v-else class="container-fluid activite">
            <div class="row">
                <div class="col-sm-6 left">

                    <div class="container dataBlock">
                        <h6 style="cursor:pointer"><i class="fa-solid fa-circle-info"></i> Details de l'activite</h6>
                    </div>
                    <div class="container">
                        <div :key="vueKey" class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Intitule du travail a faire </label>
                                    <input v-model="form.libelle"
                                           :class="errors.libelle?'form-control is-invalid':'form-control'"
                                           :disabled="!canUpdateActivite(form)" type="text">

                                    <div v-if="errors.libelle" class="invalid-feedback">
                                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Explication du travail a faire</label>
                                    <Messages :disable="!canUpdateActivite(form)" :donnes="form.description"
                                              @changeData="changeData"></Messages>
                                </div>
                                <div v-if="canUpdateActivite(form)" class="d-flex justify-content-between"
                                     style="width: 70%;margin: 0 auto;">
                                    <button class="btn btn-primary" type="button" @click.prevent="EditLine">
                                        <i class="fas fa-close"></i> Mettre a jour
                                    </button>
                                    <button class="btn btn-warning" disabled type="button"
                                            @click.prevent="ChangeStateLine('ARCHIVER')">
                                        <i class="fas fa-close"></i> Archiver
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container dataBlock">
                        <h6 style="cursor:pointer"><i class="fa-solid fa-gears"></i> Traitement de la tache</h6>
                    </div>
                    <ul>
                        <li v-for="data in dataEtats" :class="data.classe">{{ data.libelle }}</li>
                    </ul>

                    <template v-if="form.IsWorkForMe && isValider(form)">
                        <div v-if="isBloquer(form) ||  isTerminer(form)  ||  isAbandonner(form)" class="container ">
                        </div>
                        <div v-else-if=" isRefuser(form) " class="container ">
                        </div>
                        <div v-else-if="(isAccepter(form) || (form.IsCreateByMe && isValider(form)) )"
                             class="container ">
                            <div class="send-avis">
                                <h6>Statut</h6>
                                <span>Vous avez accepter cette tache veuillez notez l'avancement </span>
                                <Messages :donnes="state" @changeData="changeData"></Messages>

                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-danger" type="button"
                                            @click.prevent="ChangeStateLine('BLOQUER')">
                                        <i class="fas fa-close"></i> Bloquer
                                    </button>
                                    <button class="btn btn-warning" type="button"
                                            @click.prevent="ChangeStateLine('ABANDONNER')">
                                        <i class="fas fa-close"></i> Abandonner
                                    </button>
                                    <button class="btn btn-primary" type="submit"
                                            @click.prevent="ChangeStateLine('TERMINER')">
                                        <i class="fas fa-check"></i> Terminer
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-else-if="isValider(form)" class="container ">
                            <div class="send-avis">
                                <h6>Traitement de la tache </h6>
                                <span>Cette tache vous as ete attribuer veuillez l'accepter pour commencer a boser dessus ou refuser la </span>

                                <Messages :donnes="state" @changeData="changeData"></Messages>


                                <div class="d-flex justify-content-between" style="width: 70%;margin: 0 auto;">
                                    <button class="btn btn-primary" type="submit"
                                            @click.prevent="ChangeStateLine('ACCEPTER')">
                                        <i class="fas fa-floppy-disk"></i> Accepter
                                    </button>
                                    <button class="btn btn-warning" type="submit"
                                            @click.prevent="ChangeStateLine('REFUSER')">
                                        <i class="fas fa-floppy-disk"></i> REFUSER
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="form.IsCreateByMe && !isValider(form)">
                        <div class="container ">
                            <div class="send-avis">
                                <h6>Validation de l'activite </h6>
                                <span>Si vous etes sur des donnees renseigner ,veuillez validez l'activite pour empeicher sa modification et lenvoyer au responsable pour traitement </span>

                                <div class="d-flex justify-content-center" style="width: 70%;margin: 0 auto;">
                                    <button class="btn btn-primary" type="submit"
                                            @click.prevent="ChangeStateLine('VALIDER')">
                                        <i class="fas fa-floppy-disk"></i> Valider
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                </div>
                <div class="col-sm-6 ">

                    <div class="container dataBlock">
                        <h6 style="cursor:pointer"><i class="fa-solid fa-sitemap"></i> Organigrame de la tache</h6>
                    </div>
                    <div class="container">
                        <div :key="vueKey" class="row">
                            <div class="listesParentsId">
                                <div v-for="parent in form.ParentElements"
                                     :class="IsActual(parent.id)?'btn parentId actuel':'btn parentId '"
                                     @click="goTo(parent.id)"> Activite {{ parent.id }}
                                </div>
                                <div :class="IsActual(form.id)?'btn parentId actuel':'btn parentId'"
                                     @click="goTo(form.id)">
                                    Activite
                                    {{ form.id }}
                                </div>

                            </div>


                        </div>
                    </div>

                    <div class="container dataBlock">
                        <h6 style="cursor:pointer" @click="moveBlock"><i class="fa-solid fa-bars-staggered"></i>
                            Ensemble des
                            sous taches ( {{ childsData.length }} )</h6>
                    </div>
                    <template v-if="showAll">
                        <div class="container">
                            <p>Retrouver l'ensemble des sous activites rattacher a la tache.Vous pouvez en rajouter ou
                                supprimer</p>
                        </div>

                        <template v-for="child in childsData">
                            <div class="col-sm-12 dataBlock detailSimplifier">
                                <div class="haut">
                            <span>
                            <b-avatar v-if="" v-if="isValider(child)" class="mr-3" variant="secondary">  <i
                                class="fas fa-floppy-disk" style="color:#fff"></i></b-avatar>
                            <b-avatar v-if="isTerminer(child)" class="mr-3" variant="primary"><i
                                class="fa-solid fa-circle-check"
                                style="color:#fff"></i></b-avatar>
                            <b-avatar v-if="isAccepter(child)" class="mr-3" variant="warning"><i
                                class="fa-solid fa-hourglass-half"
                                style="color:#fff"></i></b-avatar>
                            <b-avatar v-if="isBloquer(child)" class="mr-3" variant="danger"><i
                                class="fa-solid fa-triangle-exclamation"
                                style="color:#fff"></i></b-avatar>
                                {{ child.libelle }}
                            </span>
                                    <div class="btn"
                                         style="height:100%;background:#2881a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer;"
                                         @click="goTo(child.id)"><i class="fa-solid fa-eye "></i> Aller
                                    </div>
                                </div>
                                <div class="bas">
                            <span>
                               <i class="fa-solid fa-user "></i>   {{ getUser(child) }}
                            </span>
                                </div>
                            </div>


                        </template>
                        <ManageChilds v-if="canAdd(form)" :key='form.id' :data="{parent:form.id,id:0}"
                                      :usersData="usersData"
                                      @addData="addChild"></ManageChilds>
                    </template>

                </div>

            </div>


        </div>

    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import AgGridRendu from "@/components/AgGridRendu.vue"
import ManageChilds from "./ManageChilds.vue";
import Messages from './Messages.vue'
import VSelect from 'vue-select'
import Files from "@/components/Files.vue"
import CkeditorInput from "./Ckeditor/CkeditorInput.vue"

export default {
    name: 'DetailsActivites',
    components: {VSelect, CustomSelect, Files, AgGridRendu, ManageChilds, Messages, CkeditorInput},
    props: ['data', 'gridApi', 'modalFormId', 'usersData'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                description: "",

                created_at: "",

                updated_at: "",
                CanUpdate: false,

                extra_attributes: "",
                ParentElements: [],

                deleted_at: "",
            },
            description: "",
            stateDescription: "",
            detail: 'Childs',
            showCreate: true,
            childs: [],
            menbres: [],
            ressources: [],
            childsId: [],
            menbresId: [],
            ressourcesId: [],
            childsData: [],
            menbresData: [],
            ressourcesData: [],
            show: [],
            childsUrl: "",
            menbresUrl: "",
            ressourcesUrl: "",
            change: 0,
            vueKey: 0,
            state: "",
            showAll: true
        }
    },

    mounted() {

        console.log('EditActivites  mounted', this.data)
        this.form = this.data
        this.description = this.form.description

        this.getchilds()
    },
    methods: {

        canUpdateActivite(data) {
            // faire la verification de la capacte de l'utilisateur a modifier l'activite

            return data.CanUpdate && !this.isValider(data)
        },
        isAccepter(data) {
            let verification = false;
            try {
                verification = data.AllEtats.includes('ACCEPTER')
            } catch (e) {
            }
            return verification
        },
        isValider(data) {
            let verification = false;
            try {
                verification = data.AllEtats.includes('VALIDER')
            } catch (e) {
            }
            return verification
        },
        isBloquer(data) {
            let verification = false;
            try {
                verification = data.AllEtats.includes('BLOQUER')
            } catch (e) {
            }
            return verification
        },
        isRefuser(data) {
            let verification = false;
            try {
                verification = data.AllEtats.includes('REFUSER')
            } catch (e) {
            }
            return verification
        },
        isTerminer(data) {
            let verification = false;
            try {
                verification = data.AllEtats.includes('TERMINER')
            } catch (e) {
            }
            return verification
        },
        isAbandonner(data) {
            let verification = false;
            try {
                verification = data.AllEtats.includes('ABANDONNER')
            } catch (e) {
            }
            return verification
        },
        canAdd(data) {
            console.log('ajouter ', data.IsWorkForMe, this.isValider(data))
            return (!this.isValider(data) ||
                (this.isValider(data) && data.IsWorkForMe && !data.IsCreateByMe)
            );
        },
        getUser(data) {
            let user = 'Non defini'
            try {
                user = data.user.Selectlabel
            } catch (e) {

            }
            return user
        },
        getUserById(id) {
            let user = 'Non defini'
            try {

                user = this.usersData.filter(data => data.id == id)
                console.log('getUserById', id, user, this.usersData)
                user = user.Selectlabel
            } catch (e) {

            }
            return user
        },
        getUserAcronym(data) {
            let user = 'XX'
            try {
                user = data.user.nom[0] + data.user.prenom[0]
            } catch (e) {

            }
            return user
        },
        moveBlock() {
            this.showAll = !this.showAll
        },
        IsActual(id) {
            return id == this.form.id
        },
        hasDescription(data) {
            return data != "" && data != null
        },
        goTo(id, force = false) {
            // if (this.form.id != id) {
            if (this.form.id) {
                this.showAll = true
                this.isLoading = true
                let newData = {}
                this.axios.get('/api/activites/id/' + id).then((response) => {
                    newData = response.data[0]
                    this.form = newData
                    this.childsData = []
                    this.getchilds()
                    this.vueKey++
                }).catch(error => {
                    this.isLoading = false
                    console.log(error.response.data)
                    this.$toast.error('Erreur survenue lors de la récuperation')
                })

            }


        },

        EditLine() {
            this.isLoading = true

            this.form.description = this.description

            this.axios.post('/api/activites/' + this.form.id + '/update', this.form).then(response => {

                this.form = response.data

                this.vueKey++
                this.isLoading = false
                console.log('on as mia jours la ligne ', this.data.Ancetres)

                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
            })
        },
        ValidateLine() {
            this.isLoading = true
            this.showAll = true
            this.isLoading = true
            let newData = {}

            let data = {
                description: 'OK',
                type: 'VALIDER',
                parent: this.form.id
            }

            this.isLoading = true
            this.axios.post('/api/activites', data).then(response => {
                this.isLoading = false
                this.goTo(this.form.id, true)

                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        ChangeStateLine(etat) {
            this.isLoading = true
            this.showAll = true
            this.isLoading = true
            let newData = {}

            let data = {
                description: this.stateDescription,
                type: etat,
                parent: this.form.id
            }

            this.isLoading = true
            this.axios.post('/api/activites', data).then(response => {
                this.isLoading = false
                this.stateDescription = ''
                this.goTo(this.form.id, true)

                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        changeData(data) {
            console.log('EditActivites  changeData', data)
            if (this.change != 0) {
                this.description = data
            } else {
                this.change++
            }
        },

        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/activites/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                // this.gridApi.applyServerSideTransaction({
                //     remove: [
                //         this.form
                //     ]
                // });

                this.gridApi.refreshServerSide({route: [this.data.Ancetres], purge: true})
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
        showDetail(name) {
            if (this.detail == name) {
                this.detail = 'Base'
            } else {
                this.detail = name

            }

        },
        addChild(data) {
            this.childsData.push(data)
        },
        deleteChild(identifiant) {
            this.childsData = this.childsData.filter(data => data.id != identifiant)
        },
        updateChild(donnee) {
            this.childsData = this.childsData.map(data => {
                let newData = data
                if (data.id == donnee.id) {
                    newData = donnee
                }
                return newData
            })
        },
        getchilds() {
            this.isLoading = true
            this.axios.get('/api/activites/parent/' + this.form.id + '?filter[type]=normal').then((response) => {

                this.childsData = response.data
                this.isLoading = false
            }).catch(error => {
                console.log(error.response.data)

                this.isLoading = false
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        toogle(id) {
            if (this.show.includes(id)) {
                this.show = this.show.filter(data => data != id)

            } else {
                this.show.push(id)
            }

        },
        canShow(id) {
            return this.show.includes(id)
        }
        // getressources() {
        //     this.axios.get('/api/ressources').then((response) => {
        //         this.requette--
        //         if (this.requette == 0) {
        //             // // this.$store.commit('setIsLoading', false)
        //         }
        //
        //         this.ressourcesId = response.data.map(data=>data.id)
        //
        //     }).catch(error => {
        //         console.log(error.response.data)
        //         // // this.$store.commit('setIsLoading', false)
        //         this.$toast.error('Erreur survenue lors de la récuperation')
        //     })
        // },
        // getworks() {
        //     this.axios.get('/api/works').then((response) => {
        //         this.requette--
        //         if (this.requette == 0) {
        //             // // this.$store.commit('setIsLoading', false)
        //         }
        //
        //         this.menbresId = response.data.map(data=>data.id)
        //
        //     }).catch(error => {
        //         console.log(error.response.data)
        //         // // this.$store.commit('setIsLoading', false)
        //         this.$toast.error('Erreur survenue lors de la récuperation')
        //     })
        // },
    },


    computed: {
        dataEtats: function () {
            let allEtats = [];
            let donnes = {
                libelle: `Activite Creer le ${this.form.created_at} par ${this.form.Createur.Selectlabel}`,
                classe: " state state-creation"
            }
            allEtats.push(donnes)
            this.form.Status.forEach(data => {
                donnes = false
                if (data.type == 'BLOQUER') {
                    donnes = {
                        libelle: `Activite bloquer le ${data.created_at} par ${this.getUser(data)}`,
                        classe: " state state-bloquer"
                    }
                } else if (data.type == 'ACCEPTER') {
                    donnes = {
                        libelle: `Activite accepeter le ${data.created_at} par ${this.getUser(data)}`,
                        classe: " state state-accepeter"
                    }

                } else if (data.type == 'VALIDER') {
                    donnes = {
                        libelle: `Activite valider le ${data.created_at} par ${this.getUser(data)}`,
                        classe: " state state-accepeter"
                    }

                } else if (data.type == 'REFUSER') {
                    donnes = {
                        libelle: `Activite refuser le ${data.created_at} par ${this.getUser(data)}`,
                        classe: " state state-accepeter"
                    }

                }

                if (donnes) {
                    allEtats.push(donnes)
                }

            })


            return allEtats

        },
    }
}
</script>
<style scoped>
.activite {
    display: flex;
    flex-direction: column;
    gap: 10px
}

.stats {
    width: 100%;
    padding: 10px;
    border: 1px solid #9d929299;
    margin: 10px auto;
    border-radius: 5px;
    cursor: pointer;
}

.stats-childs {
    cursor: pointer;
    position: relative;
    display: flex;
    justify-content: space-between;
}

.stats-childs-parents {
    width: 95%;
    padding: 10px;
    border: 1px solid #9d929299;
    margin: 10px auto;
    border-radius: 5px;
    display: flex;
    gap: 10px;
    flex-direction: column;
}

.stats:hover {
    color: green;
    border-color: green
}

.stats.selected {
    color: green;
    border-color: green
}

.left {
    border-right: 2px solid #e3e3e3;
}

.element {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.stats-childs-crud {
    justify-content: space-around;
    top: 10px;
    right: 0;
    z-index: 1000000;
    opacity: 0;
    gap: 10px;
    transition: 0.5;
    display: flex;
}

.stats-childs-crud i {
    font-size: 15px;
    background: #fff;
    border-radius: 50%;
    padding: 5px;
}

.stats-childs-crud i:hover {
    background: #009fff;
    border-radius: 50%;
    padding: 5px;
    color: #fff;
}


.stats-childs:hover .stats-childs-crud {
    opacity: 1
}

.updateButton {
    color: #ec5020;
}

.deleteButton {
    color: red;
}

.icones {
    font-size: 15px;
    background: #fff;
    border-radius: 50%;
    padding: 5px;
}

.icones:hover {
    background: #009fff;
    border-radius: 50%;
    padding: 5px;
    color: #fff;
}

.active .icones {
    background: #009fff !important;
    border-radius: 50% !important;
    padding: 5px !important;
    color: #fff !important;
}

.blockCreate {
    width: 80%;
    margin: 0 auto;
}

.listesParentsId {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    width: 100%;
    justify-content: center
}

.parentId {
    border: 1px solid black;
}

.actuel {
    border: 1px solid #43a72c;
}

.parentElement {
    border-radius: 5px;
    padding: 10px;
    border: 1px solid #e1e1e1;
    width: 95%;
    position: relative;
    display: flex;
    gap: 10px;
    flex-direction: column;
}

.parentElement .rangParent {
    text-align: center
}

.parentElement .rang {
    border-radius: 5px;
    background: green;
    color: #fff;
    padding: 5px;
}

.send-avis {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin: 10px auto;
    width: 90%
}

.dataBlock {
    box-shadow: rgba(0, 0, 0, 0.24) 2px 1px 9px;
    width: 98%;
    margin: 10px auto;
    padding: 10px;
    border: 1px solid #04040438;
    border-radius: 5px;
}

.showChild {
    border: 1px solid #43a72c;
}

.showChild h6 {
    color: #43a72c;
}

.showChild svg {
    fill: #43a72c;
}

.boutton {
    padding: 0px 10px;
    border-radius: 5px;
    height: 50px;
}

.detail {
    display: flex;
    flex-direction: column;
    gap: 10px;
    justify-content: center;
    align-content: center;
    margin: 10px;
}

.detailElement .hideEl {
    display: none
}

.detailSimplifier {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 95%;
    gap: 10px
}

.detailSimplifier .haut {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.detailSimplifier .bas {
    text-align: center
}

.detailSimplifier .bas span {
    padding: 5px 50px;
    border: 1px solid #aca0a0;
    border-radius: 5px;
    background: #efefef;
}

.state {
    width: 95%;
    padding: 10px;
    border-radius: 5px;
    margin: 0 auto;
}

.state {
    width: 95%;
    padding: 10px;
    border-radius: 5px;
    margin: 0 auto;
}

/*.state-creation{*/
/*    border:1px solid green;*/
/*}*/

/*.detailElement:hover .hideEl {*/
/*    display: block*/
/*}*/

</style>
