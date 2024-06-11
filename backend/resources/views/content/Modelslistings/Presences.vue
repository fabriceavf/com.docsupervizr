<template>
    <div>

        <b-overlay :show="isLoading">
            <template>
                <div v-if="isPresent" class="present">
                    <span> <i class="fa-solid fa-lock"></i>Present</span>
                </div>
                <div v-else class="danger" disabled><i class="fa-solid fa-lock"></i> Abscent</div>
            </template>

        </b-overlay>

    </div>


</template>

<script>


export default {
    name: 'Presences',
    components: {},
    props: [],
    data() {
        return {
            formId: "programmations",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            status: 'non',
            isLoading: false,
            cloturer: false
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
        isPresent: function () {
            return false

        }

    },
    watch: {},
    created() {
        this.id = "ListingsTraitements" + Date.now()

        this.formId = 'Presences' + "_" + Date.now()


    },
    mounted() {
        console.log('voici les params de la presence==>', this.params)
        this.checkPresence();
    },
    methods: {

        checkPresence() {

            let donnees = {}
            donnees.jour = this.params.actualDate
            donnees.user_id = this.params.data.id
            donnees.rapport_id = this.params.rapportId
            this.axios.post('/api/pointagesActionGetPresences', donnees)
                // this.axios.post('/api/pointages/action?action=getPresences', donnees)
                .then(response => {
                    this.status = 'oui'
                })
                .finally(() => {
                    this.isLoading = false
                })
        }
    }
}
</script>
<style>
.danger {
    padding: 5px;
    background: #dc8282;

    justify-content: center;
    text-align: center;
    color: #fff;
    /*border-radius: 5px;*/
}

.present {
    padding: 5px;
    background: #69b76d;

    justify-content: center;
    text-align: center;
    color: #fff;
    /*border-radius: 5px;*/
}
</style>
