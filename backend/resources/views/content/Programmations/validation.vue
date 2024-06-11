<template>
    <b-overlay :show="isLoading">

        <template v-if="valider == 'valider1'">
            <form @submit.prevent="EditLine()">
                <h5 class="text-center text-uppercase">Cette action n'est pas reversible confirmer vous la
                    validation???</h5>
                <div class="mt-2 d-flex justify-content-between">
                    <button class="btn btn-sm btn-primary" type="submit">
                        <i class="fas fa-floppy-disk"></i> confirmer
                    </button>
                    <button class="btn btn-sm btn-danger" type="button" @click.prevent="closeForm()">
                        <i class="fas fa-close"></i> Annuler
                    </button>
                </div>
            </form>
        </template>
        <template v-if="valider == 'valider2'">
            <form @submit.prevent="EditLine2()">
                <h5 class="text-center text-uppercase">Cette action n'est pas reversible confirmer vous la
                    validation???</h5>
                <div class="mt-2 d-flex justify-content-between">
                    <button class="btn btn-sm btn-primary" type="submit">
                        <i class="fas fa-floppy-disk"></i> confirmer
                    </button>
                    <button class="btn btn-sm btn-danger" type="button" @click.prevent="closeForm()">
                        <i class="fas fa-close"></i> Annuler
                    </button>
                </div>
            </form>
        </template>

    </b-overlay>
</template>

<script>

export default {
    name: 'validation',
    // components: { VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId', 'valider'
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {}
        }
    },

    mounted() {
        this.form = this.data
        // console.log('valider=>',this.valider)
    },
    methods: {

        EditLine() {
            const today = new Date();
            const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            const dateTime = date + ' ' + time;
            // console.log('clikk=>', dateTime)
            this.form.valider1 = dateTime
            // console.log('this.form', this.form)
            this.isLoading = true
            this.axios.post('/api/programmations/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
                // console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },

        EditLine2() {
            const today = new Date();
            const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            const dateTime = date + ' ' + time;
            // console.log('clikk=>', dateTime)
            this.form.valider2 = dateTime
            // console.log('this.form', this.form)
            this.isLoading = true
            this.axios.post('/api/programmations/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
                // console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        closeForm() {
            this.$bvModal.hide(this.modalFormId)
        },
    }
}
</script>
