<template>
    <div class="marquer">
        marker

    </div>
</template>

<script>
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'CreatePositions',
    components: {CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'voituresData',
    ],
    data() {
        return {
            'test': 'test'
        }
    },
    mounted() {
        console.log('element monter', this.$parent);
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/positions', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        resetForm() {
            this.form = {
                id: "",
                date: "",
                longitude: "",
                latitude: "",
                voiture_id: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
                identifiants_sadge: "",
                creat_by: "",
            }
        }
    }
}
</script>

<style>
.marquer {
    padding: 10px;
    background: red;
    width: 150px;
    heigth: 150px;
}
</style>
