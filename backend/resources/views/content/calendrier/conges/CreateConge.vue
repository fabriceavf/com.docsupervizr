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
import moment from 'moment'

export default {
    name: 'CreateConge',
    components: {DataTable},
    data() {
        return {
            url: '/api/conges?',
            table: 'conges',
            textButton: 'Créer',
            employes: [],
            errors: [],
            isLoading: false,
            fields: [
                {
                    key: 'id',
                    label: ''
                },
                {
                    key: 'user.name',
                    sortable: true,
                    label: 'Employé'
                },
                {
                    key: 'debut',
                    sortable: true,
                    formatter: function (row) {
                        return moment(String(new Date(row))).format('DD/MM/YYYY ')
                    },
                    label: 'Depart'
                },
                {
                    key: 'fin',
                    sortable: true,
                    formatter: function (row) {
                        return moment(String(new Date(row))).format('DD/MM/YYYY ')
                    },
                    label: 'Retour'
                }
            ],
            form: {
                employe_id: '',
                debut: '',
                fin: ''
            }
        }
    },
    mounted() {
        this.getEmployes()
    },
    methods: {
        getEmployes() {
            this.$store.state.isLoading = true
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
                this.axios.post('/api/conges/' + this.form.id + '/update', this.form).then(response => {
                    this.isLoading = false
                    this.setTextButton()
                    console.log(response.data)
                    $('#refresh' + this.table).click()
                    this.$toast.success('Congé modifié !')
                }).catch(error => {
                    this.errors = error.response.data.errors
                    this.isLoading = false
                    this.$toast.error('Une erreur s\'est produite lors de l\'enregistrement !')
                })
            } else {
                this.axios.post('/api/conges', this.form).then(response => {
                    this.isLoading = false
                    this.resetForm()
                    console.log(response.data)
                    $('#refresh' + this.table).click()
                    this.$toast.success('Nouveau congé planifié !')
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
            this.axios.post('/api/conges/' + id + '/delete').then(response => {
                console.log(response.data)
                this.isLoading = false
                $('#refresh' + this.table).click()
                this.$toast.success('Congé supprimé !')
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
                fin: ''
            }
        }
    }
}
</script>
