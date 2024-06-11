<template>
    <div class="row">
        <div class="col-4">
            <button v-if="textButton === 'Mettre à jour'" class="btn btn-primary mb-3" type="button"
                    @click.prevent="setTextButton()">
                <i class="fas fa-plus"></i> Nouveau
            </button>
            <b-overlay :show="isLoading">
                <form @submit.prevent="createLine()">
                    <div class="form-group">
                        <label>Employe <span class="text-danger">*</span></label>
                        <select v-model="form.user_id" class="form-control">
                            <option v-for="employe in this.employes" :key="employe.id" :value="employe.id">
                                {{ employe.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type<span class="text-danger">*</span></label>
                        <select v-model="form.solder" class="form-control">
                            <option v-for="solde in this.soldable" :key="solde.id" :value="solde.value">{{
                                    solde.label
                                }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Motif <span class="text-danger"></span></label>
                        <textarea v-model="form.raison" class="form-control" required type="date"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Depart <span class="text-danger">*</span></label>
                        <input v-model="form.debut" class="form-control" required type="date">
                    </div>
                    <div class="form-group">
                        <label>Retour <span class="text-danger">*</span></label>
                        <input v-model="form.fin" class="form-control" required type="date">
                    </div>
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-floppy-disk"></i> {{ textButton }}
                    </button>
                </form>
            </b-overlay>
        </div>
        <div class="col-8">
            <DataTable :fields="fields" :table="table" :url="url" limit="10">
                <template #datatable_btns="slotProps">
                    <button class="btn btn-sm btn-info m-1" @click.prevent="selectLine(slotProps.data)">
                        <i class="fa-solid fa-edit "></i>
                    </button>
                    <button class="btn btn-sm btn-danger m-1" @click.prevent="deleteLine(slotProps.id)">
                        <i class="fa-solid fa-trash-alt "></i>
                    </button>
                </template>
            </DataTable>
        </div>
    </div>
</template>

<script>
import $ from 'jquery'
import DataTable from '@/components/DataTable.vue'

export default {
    name: 'CreateAbsence',
    components: {DataTable},
    data() {
        return {
            url: '/api/abscences?',
            table: 'absences',
            textButton: 'Créer',
            errors: [],
            employes: [],
            isLoading: false,
            soldable: [
                {
                    id: 1,
                    value: 'avec',
                    label: 'Avec solde'
                },
                {
                    id: 2,
                    value: 'sans',
                    label: 'Sans solde'
                }
            ],
            fields: [
                {
                    key: 'id',
                    label: ''
                },
                {
                    key: 'user.name',
                    sortable: true,
                    label: 'Employe'
                },
                {
                    key: 'debut',
                    sortable: true,
                    label: 'Debut'
                },
                {
                    key: 'fin',
                    sortable: true,
                    label: 'Fin'
                },
                {
                    key: 'raison',
                    sortable: true,
                    label: 'Motif'
                }
            ],
            form: {
                employe_id: '',
                debut: '',
                raison: '',
                type: '',
                fin: ''
            }
        }
    },
    mounted() {
        this.getEmployes()
    },
    methods: {
        getEmployes() {
            this.$store.state.isLoading = true;
            this.axios.get('/api/users?filter[type]=employe&filter[actif]=1&sort=-nom').then((response) => {
                this.employes = response.data
                this.$store.state.isLoading = false
            }).catch(error => {
                console.log(error)
                this.$store.state.isLoading = false
            })
        },
        createLine() {
            this.isLoading = true
            if (this.textButton === 'Mettre à jour') {
                this.axios.post('/api/abscences/' + this.form.id + '/update', this.form).then(response => {
                    this.isLoading = false
                    this.setTextButton()
                    console.log(response.data)
                    $('#refresh' + this.table).click()
                    this.$toast.success('Absence modifié !')
                }).catch(error => {
                    this.errors = error.response.data.errors
                    this.isLoading = false
                    this.$toast.error('Une erreur s\'est produite lors de l\'enregistrement !')
                })
            } else {
                this.axios.post('/api/abscences', this.form).then(response => {
                    this.isLoading = false
                    this.resetForm()
                    console.log(response.data)
                    $('#refresh' + this.table).click()
                    this.$toast.success('Nouvelle absence ajouté !')
                }).catch(error => {
                    this.errors = error.response.data.errors
                    this.isLoading = false
                    this.$toast.error('Une erreur s\'est produite lors de l\'enregistrement !')
                })
            }
        },
        selectLine(data) {
            this.form = Object.assign({}, data[0])
            this.textButton = 'Mettre à jour'
        },
        setTextButton() {
            this.resetForm()
            this.textButton = 'Créer'
        },
        deleteLine(id) {
            this.isLoading = true
            this.axios.post('/api/abscences/' + id + '/delete').then(response => {
                console.log(response.data)
                this.isLoading = false
                $('#refresh' + this.table).click()
                this.$toast.success('Absence supprimé !')
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Une erreur s\'est produite lors de la suppression !')
            })
        },
        resetForm() {
            this.form = {
                employe_id: '',
                debut: '',
                raison: '',
                type: '',
                fin: ''
            }
        }
    }
}
</script>
