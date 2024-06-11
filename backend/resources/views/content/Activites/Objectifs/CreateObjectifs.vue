<template>
    <b-overlay :show="isLoading">
        <form :key="key">

            <div v-if="state=='creating'" class="formulaireObjectifs">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Libelle</label>
                            <input
                                v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                                required
                                type="text">

                            <div v-if="errors.libelle" class="invalid-feedback">
                                <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Concerner </label>
                            <v-select

                                v-model="form.user_id"
                                :options="usersData"
                                :reduce="ele => ele.id"
                                label="Selectlabel"
                                required
                            />
                            <div v-if="errors.user_id" class="invalid-feedback">
                                <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>debut </label>
                            <input
                                v-model="form.debut" :class="errors.debut?'form-control is-invalid':'form-control'"
                                required
                                type="datetime-local">

                            <div v-if="errors.debut" class="invalid-feedback">
                                <template v-for=" error in errors.debut"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>fin </label>
                            <input
                                v-model="form.fin" :class="errors.fin?'form-control is-invalid':'form-control'" required
                                type="datetime-local">

                            <div v-if="errors.fin" class="invalid-feedback">
                                <template v-for=" error in errors.fin"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">

                        <div class="form-group">
                            <label>Details</label>
                            <Messages :donnes="form.description" @changeData="changeData"></Messages>
                        </div>
                        <div style="text-align:center;margin:10px">

                            <button v-if="form.id==0" class="btn btn-primary" type="submit"
                                    @click.prevent="createLine()">
                                <i class="fas fa-floppy-disk"></i> Ajouter
                            </button>
                            <button v-else class="btn btn-primary" type="submit" @click.prevent="updateLine()">
                                <i class="fas fa-floppy-disk"></i> mettre a jour
                            </button>
                        </div>
                    </div>

                </div>
                <div class="row">

                </div>
                <div @click="close">
                    <i class="icones fa-solid fa-circle-xmark  closeButton "></i>

                </div>
            </div>
            <div v-if="state=='listes'" class="stats-childs-parents">

                <div class="stats-childs">

                    <span>  <span class="acronym">{{ getUserAcronym() }}</span> {{ form.libelle }}- {{
                            form.updated_at
                        }}-   {{ getUser() }}</span>
                    <div
                        class="stats-childs-crud"
                        @click="goTo('details')">
                        <i class="icones fa-solid fa-eye  eyesButton "></i>
                        <!--                                    <i class="icones fa-solid fa-pen-to-square updateButton "></i>-->
                        <!--                                    <i class="icones fa-solid fa-trash-can deleteButton "></i>-->
                    </div>
                </div>
            </div>
            <div v-if="state=='details'" class="details">
                <div class="row">{{ form.libelle }}</div>
                <div class="row users">{{ getUser() }}</div>
                <div class="row"></div>
                <div class="row">
                    <div class="col-sm-6 periode">
                        <span>Debut</span>
                        <span>{{ form.debut }}</span>
                    </div>
                    <div class="col-sm-6 periode">
                        <span>Fin</span>
                        <span>{{ form.fin }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 periode">
                        <span>Creer le </span>
                        <span>{{ form.created_at }}</span>
                    </div>
                    <div class="col-sm-6 periode">
                        <span>Fin</span>
                        <span>{{ form.fin }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <Messages :disable="true" :donnes="form.description"></Messages>

                    </div>

                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary" type="submit" @click.prevent="goTo('creating')">
                        <i class="fas fa-floppy-disk"></i> Editer
                    </button>
                    <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                        <i class="fas fa-close"></i> Supprimer
                    </button>
                </div>
                <div @click="goTo('listes')">
                    <i class="icones fa-solid fa-circle-xmark  closeButton "></i>

                </div>


            </div>
            <div v-if="state=='creating-liste'" class="newButton">
                <div class="listes">
                    <button class="btn btn-secondary" @click="goTo('creating')">
                        <i class="fa-solid fa-square-plus"></i> Ajouter des objectifs
                    </button>
                </div>
            </div>

        </form>

    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import Messages from "./../Messages.vue"

export default {
    name: 'CreateObjectifs',
    components: {VSelect, CustomSelect, Files, Messages},
    props: {
        activitesData: {
            type: Array,
        },
        usersData: {
            type: Array,
        },
        data: {
            type: Object,
            default: {}
        },
        etat: {
            type: String,
            default: 'creating-liste'
        }
    },
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                fin: "",

                debut: "",
                user_id: "",
                user: {},

                description: "",

                activite_id: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",
            },
            show: [],
            showForm: true,
            state: 'creating',
            key: 0
        }
    },
    created() {
        this.state = this.etat
    },
    mounted() {
        Object.keys(this.data).forEach(data => {
            this.form[data] = this.data[data]
        })
        console.log('voici la donnes passer ==>', this.form)
    },
    methods: {
        changeData(data) {
            this.form.description = data
        },
        createLine() {
            let data = {}
            data.user_id = this.form.user_id;
            data.activite_id = this.form.activite_id;
            data.debut = this.form.debut;
            data.fin = this.form.fin;
            data.libelle = this.form.libelle;
            data.description = this.form.description;
            this.isLoading = true
            this.axios.post('/api/objectifs', data)
                .then(response => {
                    this.isLoading = false
                    this.resetForm()
                    this.$toast.success('Operation effectuer avec succes')
                    this.$emit('addData', response.data)
                    console.log(response.data)
                })
                .catch(error => {
                    this.errors = error.response
                    this.isLoading = false
                    this.$toast.error('Erreur survenue lors de l\'enregistrement')
                })
        },
        updateLine() {
            let data = {}
            data.user_id = this.form.user_id;
            data.activite_id = this.form.activite_id;
            data.debut = this.form.debut;
            data.fin = this.form.fin;
            data.libelle = this.form.libelle;
            data.description = this.form.description;

            this.isLoading = true
            this.axios.post('/api/objectifs/' + this.form.id + '/update', data)
                .then(response => {
                    this.isLoading = false
                    this.form = response.data

                    this.$emit('updateData', response.data)
                    this.goTo('details')

                    this.key++
                    this.$toast.success('Operation effectuer avec succes')
                })
                .catch(error => {
                    this.errors = error.response
                    this.isLoading = false
                    this.$toast.error('Erreur survenue lors de l\'enregistrement')
                })
        },

        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/objectifs/' + this.form.id + '/delete').then(response => {
                this.isLoading = false
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('deleteData', this.form.id)
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
        resetForm() {
            this.form = Object.assign({}, this.form)
            this.form.id = 0;
            this.form.libelle = "";
            this.form.debut = "";
            this.form.fin = "";
            this.form.description = "";
            this.form.created_at = "";
            this.form.updated_at = "";
            this.form.extra_attributes = "";
            this.form.deleted_at = "";
        },
        goTo(etats) {
            this.state = etats
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
        },
        close() {
            if (this.form.id == 0) {
                this.goTo('creating-liste')

            } else {

                this.goTo('details')
            }
        },
        getUser() {
            let user = ''
            try {
                user = this.form.user.Selectlabel
            } catch (e) {

            }
            return user
        },
        getUserAcronym() {
            let user = 'XX'
            try {
                user = this.form.user.nom[0] + this.form.user.prenom[0]
            } catch (e) {

            }
            return user
        }
    }
}

</script>
<style>
.formulaireObjectifs {
    width: 95%;
    padding: 10px;
    border: 1px solid #9d929299;
    margin: 10px auto;
    border-radius: 5px;
    position: relative

}

.newButton {
    width: 30%;
    padding: 10px;
    border: 2px dashed #9d929299;
    margin: 10px auto;
    border-radius: 5px;

}

.closeButton {
    padding: 10px !important;
    position: absolute !important;
    top: 10px !important;
    right: 3% !important;
    background: #e38282 !important;
    color: #fff !important;
    border-radius: 50% !important;
    cursor: pointer !important;
    z-index: 10000 !important;
}

.listes {
    text-align: center;
    border-radius: 5px;
}

.periode {
    display: flex;
    flex-direction: column;
    align-items: center;
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

.details {
    width: 95%;
    padding: 10px;
    border: 1px solid #9d929299;
    margin: 10px auto;
    border-radius: 5px;
    background: none;
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

.acronym {
    padding: 10px;
    background: #5c3fe8;
    border-radius: 50%;
    color: #fff;
}
</style>
