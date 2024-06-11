<template>
  <div>
    <b-overlay :show="isLoading">
      <input type="checkbox" v-model="status" @change="change($event)">

    </b-overlay>

  </div>


</template>

<script>


export default {
  name: 'SelectLines',
  components: {},
  props: [],
  data() {
    return {
      status: false,
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
  created() {
    this.id = "SelectLines" + Date.now()

    let _etats = false
    try{

      _etats=this.params.select.includes(this.params.data.id)
    }catch (e) {
      console.error('erreur dans le traitement de le traitemenet de la selection de la ligne ',e)

    }
    this.status = _etats

  },
  mounted() {
    console.log('voici les params passer en props pour la selection des lignes ==>', this.params)
  },
  methods: {
    btnClickedHandler() {
      this.params.clicked(this.params.data);
    },
    change(event) {
      if(this.status){
        this.params.selected(this.params.data)
      }else{
        this.params.deSelected(this.params.data)
      }
    },
  }
}
</script>
