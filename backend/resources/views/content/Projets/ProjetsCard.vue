<template>
    <div class="ProjetData">
        <div class="ProjetParent">
            <div class="d-flex justify-content-between allBoutons">
                <button class="btn" @click="toggleChild"><i class="fa-solid fa-sitemap"></i></button>
                <button class="btn"> {{ params.data.libelle }}</button>


            </div>
            <div class="d-flex justify-content-between allBoutons">
                <button v-b-tooltip.hover :title="'Createur :'+getCreateur()" class="btn">
                    <i class="fa-solid fa-user"></i>
                    {{ getUserAcronym(getCreateur()) }}
                </button>
                <div class="d-flex justify-content-between allBoutons">

                    <div class="btn hideBouton"
                         style="height:100%;background:#2881a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer;"
                         @click="updateElement"><i class="fa-solid fa-pen-to-square "></i> Editer
                    </div>
                </div>

            </div>

        </div>
    </div>

</template>

<script>
import moment from "moment/moment";

export default {
    name: 'ProjetsCard',
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

            return state;
        },
        getFailStepState(step) {
            let state = false
            // if(step=="Validation" && this.params.data.AllEtats.includes('VALIDER')){
            //     state=true
            // }

            return state;
        },
        getStartStepState(step) {
            let state = false
            if (step == "Validation") {
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
        deleteElement() {
            this.params.updateElement(this.params.data);

        },
        toggleChild() {
            this.show = !this.show
            this.params.node.setExpanded(this.show)
        },
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

.ProjetParent:hover .hideBouton {
    opacity: 1
}

.boutton {
    padding: 0px 10px;
    border-radius: 5px;
    height: 50px;
}

.ProjetParent {
    display: flex;
    justify-content: space-between;
    border-radius: 5px;
    border: 1px solid #cecece;
    padding: 5px 20px;
}

.dataParents .ProjetParent {
    display: flex;
    justify-content: space-between;
    border: 1px solid #b3adad;
    border-radius: 5px;
    padding: 5px 5px;
}

.allBoutons {
    gap: 10px
}

.ProjetData {
    display: flex;
    flex-direction: column
}
</style>
