<template>
    <div class="activiteData">
        <div class="activiteParent">
            <div class="d-flex justify-content-between allBoutons">
                <button v-if="params.data.validate" class="btn"><i class="fa-solid fa-check-circle"
                                                                   style="color:green"></i></button>
                <button v-else class="btn"><i class="fa-solid fa-check-circle" style="color:#898989"></i></button>

                <button class="btn"> {{ getLibelle(params.data.libelle) }}</button>


            </div>
            <div class="d-flex justify-content-between allBoutons">
                <button v-b-tooltip.hover :title="'Createur :'+getCreateur()" class="btn">
                    <i class="fa-solid fa-person-digging"></i>
                    {{ getUserAcronym(getCreateur()) }}
                </button>
                <button v-b-tooltip.hover :title="'Travailleur :'+getUser()" class="btn">
                    <i class="fa-solid fa-person-digging"></i>
                    {{ getUserAcronym(getUser()) }}
                </button>
                <div class="d-flex justify-content-between allBoutons">
                    <!--                <button class="btn btn-primary" type="submit"  v-for="etats in params.data.AllEtats">-->
                    <!--                    <i class="fas fa-floppy-disk"></i> {{etats}}-->
                    <!--                </button>-->


                    <button class="btn">
                        <i class="fa-solid fa-calendar-days" style="color:#5d5b5b"></i>
                        {{ formatDate(params.data.created_at) }}
                    </button>

                    <!--                    <div class="btn hideBouton"  v-b-tooltip.hover title="Valider"-->
                    <!--                         style="height:100%;background:#2881a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer;"-->
                    <!--                         @click="valideElement"><i class="fa-solid fa-check "></i>-->
                    <!--                    </div>-->
                    <div v-b-tooltip.hover class="btn  hideBouton"
                         style="height:100%;background:#cc8018;color:#fff;border-radius:5px;text-align:center;cursor:pointer;"
                         title="Editer"
                         @click="updateElement"><i class="fa-solid fa-edit "></i>
                    </div>
                    <div v-b-tooltip.hover class="btn  hideBouton"
                         style="height:100%;background:#b9363e;color:#fff;border-radius:5px;text-align:center;cursor:pointer;"
                         title="supprimer"
                         @click="deleteElement"><i class="fa-solid fa-trash "></i>
                    </div>
                </div>

            </div>

        </div>
    </div>

</template>

<script>
import moment from "moment/moment";

export default {
    name: 'ActivitesActions',
    components: {},
    props: [],
    data() {
        return {
            visible: [],
            rowIndex: null,
            show: false,
            steps: [
                'Validation',
                'Acceptation',
                'Traitement',
            ]
        }
    },
    computed: {},
    created() {
        this.id = "AgGridBtnClicked" + Date.now()
        this.rowIndex = this.params.rowIndex + 1

        // console.log('on veut afficher 1',Object.getOwnPropertyNames(this.params.api));
        // // ParamsTest.api.getDisplayedRowAtIndex(0).setExpanded(false)
        // console.log('voici le params de la ligne ===>',this.rowIndex,this.params.showChild())

    },
    mounted() {
        // console.log('voici les params passer en props ==>',this.params)
    },
    methods: {

        getLibelle(data) {
            return data.substring(0, 30) + "..." ?? data.length > 30
        },


        getUserAcronym(data) {
            let user = 'XX'
            try {
                user = data.nom[0] + data.nom[1] + data.nom[2] + '. ' + data.prenom[0]
            } catch (e) {

            }
            return user
        },

        getCreateur() {
            let user = 'XX'
            try {
                user = this.params.data.Createur.Selectlabel
            } catch (e) {

            }
            return user
        },

        getUser() {
            let user = 'XX'
            try {
                user = this.params.data.user.Selectlabel
            } catch (e) {

            }
            return user
        },
        formatDate(date) {
            return moment(date).format('DD/MM/YYYY à HH:mm:ss')
        },
        getSuccessStepState(step) {
            let state = false
            if (step == "Validation" && this.params.data.AllEtats.includes('VALIDER')) {
                state = true
            }
            if (step == "Acceptation" && this.params.data.AllEtats.includes('ACCEPETER')) {
                state = true
            }
            if (step == "Traitement" && this.params.data.AllEtats.includes('TERMINER')) {
                state = true
            }

            return state;
        },
        getFailStepState(step) {
            let state = false
            // if(step=="Validation" && this.params.data.AllEtats.includes('VALIDER')){
            //     state=true
            // }
            if (step == "Acceptation" && this.params.data.AllEtats.includes('REFUSER')) {
                state = true
            }
            if (step == "Traitement" && this.params.data.AllEtats.includes('ABANDONNER')) {
                state = true
            }
            if (step == "Traitement" && this.params.data.AllEtats.includes('BLOQUER')) {
                state = true
            }

            return state;
        },
        getStartStepState(step) {
            let state = false
            if (step == "Validation") {
                state = true
            }
            if (step == "Acceptation" && this.params.data.AllEtats.includes('VALIDER')) {
                state = true
            }

            return state;
        },
        btnClickedHandler() {
            // this.params.clicked(this.params.data);
        },
        updateElement() {
            this.params.updateElement(this.params.data);
        },
        valideElement() {
            this.params.validateElement(this.params.data);
        },
        deleteElement() {
            this.params.deleteElement(this.params.data);

        },
        showChild() {
            // this.show = true
            // console.log('on veut afficher le detail de ', this.rowIndex)
            // this.params.node.setExpanded(true)
        },
        hideChild() {
            // this.show = false
            // console.log('on veut afficher le detail de ', this.rowIndex)
            // this.params.node.setExpanded(false)
        }
    }
}
</script>
<style>
.hideBouton {
    gap: 10px;
    transition-duration: 0.1s;
    transition-delay: 0.1s;
    cursor: pointer;
    opacity: 0
}

.activiteParent:hover .hideBouton {
    opacity: 1
}

.boutton {
    padding: 0px 10px;
    border-radius: 5px;
    height: 50px;
}

.activiteParent {
    display: flex;
    justify-content: space-between;
    border-radius: 5px;
    border: 1px solid #cecece;
    padding: 5px 20px;
}

.dataParents .activiteParent {
    display: flex;
    justify-content: space-between;
    border: 1px solid #b3adad;
    border-radius: 5px;
    padding: 5px 5px;
}

.allBoutons {
    gap: 10px
}

.activiteData {
    display: flex;
    flex-direction: column
}
</style>
