<template>
    <div class="container">

        <form @submit.prevent="Accepter()">
            <p>Valider ou refuser le depassement</p>

            <div class="form-group">
                <label>Motif </label>
                <textarea v-model="motif"
                          class="form-control "></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Accepter
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="Refuser()">
                    <i class="fas fa-close"></i> Refuser
                </button>
            </div>
        </form>


    </div>
</template>

<script>
import VSelect from 'vue-select'

export default {
    name: "traiteDepassement",
    components: {VSelect},
    props: ['data'],
    data() {
        return {
            isLoading: false,
            motif: ''
        }
    },
    mounted() {

    },
    computed: {
        dateManquant: function () {
            let dateExistant = this.data.debut_realise;
            if (!this.data.debut_realise) {
                dateExistant = this.data.fin_realise;
            }
            try {
                dateExistant = dateExistant.split(' ')[0]
            } catch (e) {

            }
            return dateExistant

        },
        type: function () {
            let type = 'fin';
            if (!this.data.debut_realise) {
                type = 'debut';
            }
            return type

        },
    },
    methods: {
        Accepter() {
            let data = {
                etats: 'ACCEPTER'
            }
            this.axios.post('/api/programmes/' + this.data.id + '/update', data).then(response => {
                this.isLoading = false
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('refreshData')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })

        },
        Refuser() {
            let data = {
                etats: 'REFUSER'
            }
            this.axios.post('/api/programmes/' + this.data.id + '/update', data).then(response => {
                this.isLoading = false
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('refreshData')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })

        },
    }
}
</script>

<style scoped>

</style>
