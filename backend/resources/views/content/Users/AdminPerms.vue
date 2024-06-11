<template>
    <div>
        <b-overlay :show="isLoading">
            <template v-if="cloturer">
                <button v-if="status=='oui'" class="btn btn-success" disabled><i class="fa-solid fa-lock"></i> Oui
                </button>
                <button v-else class="btn btn-danger" disabled><i class="fa-solid fa-lock"></i> Non</button>
            </template>
            <template v-else>
                <button v-if="status=='oui'" class="btn btn-success" @click.prevent="addAbscence()"> Oui</button>
                <button v-else class="btn btn-danger" @click.prevent="addPresence()"> Non</button>
            </template>


        </b-overlay>

    </div>


</template>

<script>


export default {
    name: 'AdminPerms',
    components: {},
    props: [],
    data() {
        return {
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
    },
    watch: {},
    created() {
        this.id = "AdminPerms" + Date.now()
        let _etats = 'non'
        if (this.params.data.type != '' && this.params.data.type !== null && this.params.data.type.length > 0) {
            _etats = 'oui'
        }
        if (this.params.cloturer == "cloturer") {
            this.cloturer = true
        }
        this.status = _etats

    },
    mounted() {
        console.log('voici les params passer en props pour la mise en place manuel ==>', this.params)
    },
    methods: {
        btnClickedHandler() {
            this.params.clicked(this.params.data);
        },
        addPresence() {
            this.isLoading = true
            let data = {}
            data.user_id = this.params.data.user_id
            data.permission_id = this.params.data.permission_id
            this.axios.post('/api/permissionsActionAddPerm', data)
                // this.axios.post('/api/permissions/action?action=addPerm', data)
                .then(response => {
                    this.status = 'oui'
                })
                .finally(() => {
                    this.isLoading = false
                })
        },
        addAbscence() {
            this.isLoading = true
            let data = {}
            data.user_id = this.params.data.user_id
            data.permission_id = this.params.data.permission_id
            this.axios.post('/api/permissionsActionDeletePerm', data)
                // this.axios.post('/api/permissions/action?action=deletePerm', data)
                .then(response => {
                    this.status = 'non'
                })
                .finally(() => {
                    this.isLoading = false
                })
        }
    }
}
</script>
