<template>
    <div>
        <b-overlay :show="isLoading">
            <div>
                {{ position }}
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
        position: function () {
            let position = 'Non defini'
            if (this.params.data.type == 'Fixe') {

                try {
                    position = 'S : ' + this.params.data.site.libelle
                } catch (e) {

                }
            } else {

                try {
                    position = 'M.T : ' + this.params.data.deplacement.moyenstransport.Selectlabel + ' ( ' + this.params.data.deplacement.ligne.Selectlabel + ' )'
                } catch (e) {

                }
            }
            return position


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
