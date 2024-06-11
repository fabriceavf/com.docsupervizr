<template>
  <b-overlay :show="isLoading">
    <div class="card ">
      <div class="card-header">
        <slot name="datatable_header_title"></slot>
        <div class="d-flex">
          <div class="mr-2">
            <select v-if="showLength" class="form-control" v-model="perPage" required>
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="100">100</option>
              <option value="500">500</option>
            </select>
          </div>
          <div class="">
            <button :id="'refresh'+this.table" class="btn btn-outline-dark mr-2" @click="getDatas()">
              <i class="fa fa-refresh"></i>
              <span v-if="showLength">Actualiser</span>
            </button>
          </div>
          <slot name="datatable_header_btns"></slot>
          <div class="ml-auto">
            <b-form-input v-model="filter" type="search" placeholder="Rechercher" ></b-form-input>
          </div>
        </div>
      </div>
      <div class="card-body overflow-auto">
        <b-table sort-icon-left id="datas" :items="datas" :per-page="perPage" :filter="filter" @filtered="onFiltered" :fields="this.fields" small >
          <template #cell(id)="row">
            <slot :id="row.value" :data="selectedLine(row.value)" name="datatable_btns"></slot>
          </template>
          <template #cell(statut)="row">
            <slot :statut="row.value" name="datatable_statut"></slot>
          </template>
        </b-table>
      </div>
      <div class="card-footer ">
        <div class="justify-content-between d-flex align-content-center">
          <div >
            <select v-if="showLength" class="form-control" v-model="perPage" required>
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="100">100</option>
              <option value="500">500</option>
            </select>
          </div>
          <div >
            {{total}} Lignes
          </div>
          <div v-if="showLength">
            <b-pagination-nav v-model="currentPage" :link-gen="linkGen" :number-of-pages="lastPage" use-router ></b-pagination-nav>
          </div>
        </div>
      </div>
    </div>
  </b-overlay>
</template>

<script>
import moment from 'moment'

export default {
  name: 'DataTable',
  props: ['fields', 'url', 'table', 'limit'],

  data () {
    return {
      isLoading: false,
      lastPage: 1,
      perPage: 100,
      currentPage: 1,
      total: 0,
      showLength: true,
      filter: null,
      datas: [],
      links: []
    }
  },
  created() {
    if (this.limit) {
      this.perPage = this.limit
      this.showLength=false
    }
  },

  mounted () {
    this.getDatas()
  },
   computed: {$routeData:function(){let router = {meta:{}};try{router=window.routeData}catch (e) {};return router; },
        routeData:function () {
            let router={meta:{}}
            if(window.router){
                try{ router=window.router; }catch (e) { }
            }


            return router
        },
    rows () {
      return this.datas.length
    }
  },
  watch: {
    currentPage: {
      handler: function (value) {
        this.getDatas(value, this.perPage)
      }
    },
    perPage: {
      handler: function (value) {
        this.getDatas(1, value)
      }
    }
  },
  methods: {
    getDatas (page = 1, perPage = this.perPage) {
      this.$toast.info('Actualisation...', { duration: 1000 })
      this.isLoading = true
      this.axios.get(this.url + `paginate=1&limit=${perPage}&page=${page}`).then((response) => {
        this.datas = response.data.data
        this.links = response.data.links
        this.currentPage = response.data.current_page
        this.perPage = response.data.per_page
        this.lastPage = response.data.last_page
        this.total = response.data.total
        this.isLoading = false
      }).catch(error => {
        console.log(error.response.data)
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },
    onFiltered (filteredItems) {
      this.rows = filteredItems.length
      this.currentPage = 1
    },
    linkGen (pageNum) {
      return pageNum === 1 ? '?' : `?page=${pageNum}`
    },
    formatJour (row) {
      // return moment(String(new Date(row))).format('DD/MM/YYYY')
      return 'je vois'+ row
    },
    formatHeure (row) {
      return moment(String(new Date(row))).format('HH:mm')
    },
    selectedLine (id) {
      return this.datas.filter(item => item.id === id)
    }
  }
}
</script>
