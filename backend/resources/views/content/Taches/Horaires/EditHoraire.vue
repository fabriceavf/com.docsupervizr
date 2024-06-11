<template>
    <b-overlay :show="isLoading">
        <form class="mb-3" @submit.prevent="editLine()">
            <div class="form-group ">
                <label>Libelle <span class="text-danger">*</span></label>
                <input v-model="form.libelle" class="form-control" required type="text">
            </div>

            <div class="row ">
                <div class="form-group col-4">
                    <label>Debut <span class="text-danger">*</span></label>
                    <input v-model="form.debut" class="form-control" required type="time">
                </div>
                <div class="form-group col-4">
                    <label>Fin <span class="text-danger">*</span></label>
                    <input v-model="form.fin" class="form-control" required type="time">
                </div>
                <div class="form-group col-4">
                    <label>Tolérance <span class="text-danger">*</span></label>
                    <input v-model="form.tolerance" class="form-control" required type="number">
                </div>
            </div>

            <div class="d-flex justify-content-between">

                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="deleteLine()">
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>

        </form>
    </b-overlay>
</template>

<script>

export default {
    name: 'EditHoraire',
    props: ['horaire'],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {
                user_id: '',
                debut: '',
                fin: '',
                libelle: '',
                type: '',
                tolerance: '0',
                tache_id: ''
            }
        }
    },
    mounted() {
        this.form = this.horaire
        this.form.user_id = 0
    },
    methods: {
        editLine() {
            this.isLoading = true
            this.axios.post('/api/horaires/' + this.horaire.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.$emit('refreshHoraire')
            }).catch(error => {
                console.error('voici lerruer==>', error)
                this.isLoading = false
            })
        },
        deleteLine() {
            this.isLoading = true
            this.axios.post('/api/horaires/' + this.horaire.id + '/delete').then(response => {
                this.isLoading = false
                this.$emit('refreshHoraire')
            }).catch(error => {
                console.error('voici lerruer==>', error)
                this.isLoading = false
            })
        },
        resetForm() {
            this.form = {
                user_id: this.$store.state.user.id,
                debut: '',
                fin: '',
                libelle: '',
                type: '',
                tolerance: '0',
                tache_id: ''
            }
        }
    }
}
</script>
