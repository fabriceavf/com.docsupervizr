<template>
  <div class="row">
    <div class="col-md-4">
      <button v-if="textButton === 'Mettre à jour'" class="btn btn-primary mb-3" type="button"
              @click.prevent="setTextButton()">
        <i class="fas fa-plus"></i> Nouveau
      </button>
      <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
          <div class="form-group">
            <label>Libelle <span class="text-danger">*</span></label>
            <input v-model="form.raison" class="form-control" required type="text">
          </div>
          <div class="form-group">
            <label>Debut <span class="text-danger">*</span></label>
            <input v-model="form.debut" class="form-control" required type="date">
          </div>
          <div class="form-group">
            <label>Fin <span class="text-danger">*</span></label>
            <input v-model="form.fin" class="form-control" required type="date">
          </div>
          <button class="btn btn-primary" type="submit">
            <i class="fas fa-floppy-disk"></i> {{ textButton }}
          </button>
        </form>
      </b-overlay>
    </div>
    <div class="col-md-8">
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
import DataTable from '@/components/DataTable.vue'
import $ from "jquery";

export default {
  name: 'CreateJoursferie',
  components: {DataTable},
  data() {
    return {
      url: '/api/joursferies?',
      table: 'joursferies',
      textButton: 'Créer',
      errors: [],
      isLoading: false,
      fields: [
        {
          key: 'id',
          label: ''
        },
        {
          key: 'debut',
          sortable: true,
          label: 'Debut'
        },
        ,
        {
          key: 'fin',
          sortable: true,
          label: 'Fin'
        },
        ,
        {
          key: 'raison',
          sortable: true,
          label: 'Libelle'
        }
      ],
      form: {
        raison: '',
        debut: '',
        fin: ''
      }
    }
  },
  methods: {
    createLine() {
      this.isLoading = true
      if (this.textButton === 'Mettre à jour') {
        this.axios.post('/api/joursferies/' + this.form.id + '/update', this.form).then(response => {
          this.isLoading = false
          this.setTextButton()
          console.log(response.data)
          $('#refresh' + this.table).click()
          this.$toast.success('Jour ferié modifié !')
        }).catch(error => {
          this.errors = error.response.data.errors
          this.isLoading = false
          this.$toast.error('Une erreur s\'est produite lors de l\'enregistrement !')
        })
      } else {
        this.axios.post('/api/joursferies', this.form).then(response => {
          this.isLoading = false
          this.resetForm()
          console.log(response.data)
          $('#refresh' + this.table).click()
          this.$toast.success('Nouveau jour ferié ajouté !')
        }).catch(error => {
          this.errors = error.response.data.errors
          this.isLoading = false
          this.$toast.error('Une erreur s\'est produite lors de l\'enregistrement !')
        })
      }
    },
    resetForm() {
      this.form = {
        raison: '',
        debut: '',
        fin: ''
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
      this.axios.post('/api/joursferies/' + id + '/delete').then(response => {
        console.log(response.data)
        this.isLoading = false
        $('#refresh' + this.table).click()
        this.$toast.success('Jour ferié supprimé !')
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Une erreur s\'est produite lors de la suppression !')
      })
    }
  }
}
</script>
