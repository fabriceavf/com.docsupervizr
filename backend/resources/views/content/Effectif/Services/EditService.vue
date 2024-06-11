<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="form-group">
                <label>Code <span class="text-danger">*</span></label>
                <input v-model="form.code" class="form-control" required type="text">
            </div>
            <div class="form-group">
                <label>Libelle <span class="text-danger">*</span></label>
                <input v-model="form.libelle" class="form-control" required type="text">
            </div>

            <div class="d-flex justify-content-between mt-2">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>
        </form>
    </b-overlay>
</template>

<script>
import $ from 'jquery'

export default {
    name: 'EditService',
    props: ['formLine', 'table'],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {
                code: '',
                libelle: ''
            }
        }
    },
    mounted() {
        this.form = this.formLine[0]
    },
    methods: {
        EditLine() {
            this.isLoading = true
            this.axios.post('/api/services/' + this.formLine[0].id + '/update', this.form).then(response => {
                this.isLoading = false
                $('#close_modal_service' + this.formLine[0].id).click()
                $('#refresh' + this.table).click()
                this.$toast.success('Service modifié')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/services/' + this.formLine[0].id + '/delete').then(response => {
                this.isLoading = false
                $('#close_modal_service' + this.formLine[0].id).click()
                $('#refresh' + this.table).click()
                this.$toast.success('Service supprimé')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        }
    }
}
</script>
