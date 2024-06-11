<template>
    <div>
        <b-overlay :show="isLoading">
            <div>
                {{ poste }}
            </div>


        </b-overlay>

    </div>


</template>

<script>


export default {
    name: 'CheckPoste',
    components: {},
    props: [],
    data() {
        return {
            status: 'non',
            isLoading: false,
            cloturer: false,
            oldPointages: [],
            updateOldPointages: 0,
            newProgrammes: false,
            newProgrammesData: {},
            formId: "programmations",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            remplacant: "",
            description: "",
            errors: [],
            usersData: []
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
        programmes: function () {
            let programmes = {}
            console.log('Pointages ==> voici letat actual', this.newProgrammes, this.newProgrammesData)
            if (this.newProgrammes) {
                programmes = this.newProgrammesData
            } else {
                try {
                    programmes = this.params.data.programmes
                        .filter(ele => {
                            let _date = ele.date.split(' ')[0]
                            return _date == this.params.actualDate
                        })
                    programmes = programmes[0]
                } catch (e) {
                }
            }

            console.log('Programmes ==> voici le programmes actual', programmes)

            return programmes
        },
        poste: function () {
            let poste = 'Non defini'
            try {
                poste = this.params.data.horaire.poste.site.libelle
            } catch (e) {

            }
            poste = poste.split('/')[0]
            return poste

        },
    },
    watch: {},
    created() {
        this.id = "ListingsTraitements" + Date.now()
        this.formId = 'ListingsTraitements' + "_" + Date.now()


    },
    mounted() {
    },
    methods: {}
}
</script>
<style scoped>
.parentListingsTraitements {
    display: flex;
    flex-direction: row;
    gap: 10px
}

.boutonAction {
    border: 1px solid #d0d0d0;
    border-radius: 5px;
    padding: 0px 10px;
    cursor: pointer
}

.boutonAction:hover {
    color: green;
    border: 1px solid green;
}
</style>
