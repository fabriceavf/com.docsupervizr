<template>
    <b-overlay :show="isLoading">
        <div :key="etats">
            <div v-if="etats=='1'" class=""
                 style="width:100%;height:100%;background:#2885a7;color:#fff;border-radius:5px;text-align:center;cursor:pointer;display: flex;gap: 5px;align-items:center">
                <div class="spinner-border text-light" role="status" style="width: 20px;height: 20px;margin-left:2px">
                    <span class="sr-only">Loading...</span>
                </div>
                <div>Traitement</div>

            </div>
            <div v-else class=""
                 style="width:100%;height:100%;border-radius:5px;text-align:center;cursor:pointer">
                <div>Traitement terminer</div>

            </div>

        </div>
    </b-overlay>
</template>

<script>


export default {
    name: 'AgGridBtnClicked',
    components: {},
    props: [],
    data() {

        return {
            etats: 1
        }
    },

    created() {
        this.id = "AgGridBtnClicked" + Date.now()

    },
    mounted() {
        this.etats = this.params.data.etats
        // console.log('voici les params passer en props ==>',this.params)
    },
    methods: {
        btnClickedHandler() {
            this.params.clicked(this.params.data);
        },
        annulerImport() {
            let data = this.params.data
            data.etats = 4
            this.axios.post('/api/imports/' + data.id + '/update', data).then(response => {
                this.isLoading = false
                this.$toast.success('Operation effectuer avec succes')

                this.etats = 4
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        validerImport() {

            let data = this.params.data
            data.etats = 3
            this.axios.post('/api/imports/' + data.id + '/update', data).then(response => {
                this.isLoading = false
                this.$toast.success('Operation effectuer avec succes')
                this.etats = 3
            }).catch(error => {
                this.errors = error
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        }
    }
}
</script>

<style>
.agGridBtnParent {
    display: flex;
    width: 100%;
    height: 100%;
    justify-content: center;
    align-content: center;
    align-items: center;
}
</style>
