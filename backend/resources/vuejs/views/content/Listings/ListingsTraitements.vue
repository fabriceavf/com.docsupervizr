<template>
  <div>
    <b-overlay :show="isLoading">
      <template v-if="!canAdmin()">
        <button v-if="status=='oui'" class="btn btn-success" disabled><i class="fa-solid fa-lock"></i> Present</button>
        <button v-else class="btn btn-danger" disabled><i class="fa-solid fa-lock"></i> Abscent</button>
      </template>
      <template v-else>
        <button v-if="status=='oui'" class="btn btn-success" @click.prevent="addAbscence()"> Present</button>
        <button v-else class="btn btn-danger" @click.prevent="addPresence()"> Abscent</button>
      </template>


    </b-overlay>

  </div>


</template>

<script>


export default {
  name: 'ListingsTraitements',
  components: {},
  props: [],
  data() {
    return {
      status: 'non',
      isLoading: false,
      cloturer: false
    }
  },
   computed: {$routeData:function(){let router = {meta:{}};try{router=window.routeData}catch (e) {};return router; },
        routeData:function () {
            let router={meta:{}}
            if(window.router){
                try{ router=window.router; }catch (e) { }
            }


            return router
        },},
  watch: {},
  created() {
    this.id = "ListingsTraitements" + Date.now()
    let _etats = 'non'
    if (this.params.data.present == 'oui') {
      _etats = 'oui'
    }
    if (this.params.etats == "manuel-cloturer" || this.params.etats == "automatique-cloturer") {
      this.cloturer = true
    }
    this.status = _etats

  },
  mounted() {
    console.log('voici les params passer en props pour la mise en place manuel ==>', this.params)
  },
  methods: {
    btnClickedHandler() {
      this.params.clicked(this.params.data);
    },
    addPresence() {
      this.isLoading = true
      let data = {}
      data.user_id = this.params.data.id_user
      data.date_id = this.params.data.id_date
      data.presence = 'oui'
      this.axios.post('/api/listingsetatsActionPresence', data)
    //   this.axios.post('/api/listingsetats/action?action=presence', data)
          .then(response => {
            this.status = 'oui'
          })
          .finally(() => {
            this.isLoading = false
          })
    },
    addAbscence() {

      this.isLoading = true
      let data = {}
      data.user_id = this.params.data.id_user
      data.date_id = this.params.data.id_date
      data.presence = 'non'
      this.axios.post('/api/listingsetatsActionPresence', data)
    //   this.axios.post('/api/listingsetats/action?action=presence', data)
          .then(response => {
            this.status = 'non'
          })
          .finally(() => {
            this.isLoading = false
          })
    },
    canAdmin() {
      // fonction utiliser pour verifier si je peux encore changer le status dun agent
      return this.params.etats == 'manuel'
    }
  }
}
</script>
