<template>
    <b-overlay :show="isLoading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4 left ">
                    <h3>Formulaire de creation des activites</h3>


                    <div class="form-group">
                        <label>libelle </label>
                        <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                               type="text">

                        <div v-if="errors.libelle" class="invalid-feedback">
                            <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description </label>
                        <Messages :donnes="description" @changeData="changeData"></Messages>
                    </div>

                </div>
                <div class="col-sm-8">
                    <div v-if="form.type=='besoins'" class="col-sm-12">

                        <ChildsView
                            :parentId="form.id"
                            parentType="objectifs"
                        >

                        </ChildsView>
                    </div>
                    <div v-if="form.type=='objectifs'" class="col-sm-12">


                        <ChildsView
                            :parentId="form.id"
                            parentType="actions"
                        >

                        </ChildsView>
                    </div>

                </div>
            </div>


            <div v-if="!form.validate" class="row dataBlock">
                <div class="d-flex justify-content-between" style="width: 70%;margin: 0 auto;">
                    <button class="btn btn-primary" type="submit" @click.prevent="EditLine()">
                        <i class="fas fa-floppy-disk"></i> Mettre à jour
                    </button>
                    <button v-if="form.parent==0" class="btn btn-warning" type="submit" @click.prevent="ValidateLine()">
                        <i class="fas fa-floppy-disk"></i> Valider
                    </button>
                    <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                        <i class="fas fa-close"></i> Supprimer
                    </button>
                </div>
            </div>

        </div>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import AgGridRendu from "@/components/AgGridRendu.vue"
import ManageChilds from "./ManageChilds.vue";

import ChildsView from "./Childs/ChildsView.vue"
import Messages from './Messages.vue'
import VSelect from 'vue-select'
import Files from "@/components/Files.vue"
import CkeditorInput from "./Ckeditor/CkeditorInput.vue"

export default {
    name: 'EditActivites',
    components: {VSelect, CustomSelect, Files, AgGridRendu, ManageChilds, Messages, CkeditorInput, ChildsView},
    props: ['data', 'gridApi', 'modalFormId', 'usersData'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                isLock: "",

                description: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",
                ParentElements: [],

                deleted_at: "",
            },
            description: "",
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
            change: 0
        }
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
        taille: function () {
            let result = 'col-sm-12'
            if (this.filtre) {
                result = 'col-sm-9'
            }
            return result
        },
    },
    mounted() {

        console.log('EditActivites  mounted', this.data)
        this.form = this.data
        this.description = this.form.description

        this.getchilds()
    },
    methods: {

        EditLine() {
            this.isLoading = true

            this.form.description = this.description

            this.axios.post('/api/activites/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                console.log('on as mia jours la ligne ', this.data.Ancetres)
                this.gridApi.refreshServerSide({route: [this.data.Ancetres], purge: true})
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
        ValidateLine() {
            this.isLoading = true

            let data = {
                validate: 1
            }

            this.axios.post('/api/activites/' + this.form.id + '/update', data).then(response => {
                this.isLoading = false
                this.gridApi.refreshServerSide()
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
            this.axios.get('/api/activites/parent/' + this.form.id).then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.childsData = response.data

            }).catch(error => {
                console.log(error.response.data)
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
    }
}
</script>
<style scoped>
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
    border-right: 2px solid red;
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

.listeParents {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
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

</style>
