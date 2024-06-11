<template>

  <div class="agGridBtnParent" v-html="params.render"  @click.prevent="btnClickedHandler()" ></div>
</template>

<script>


export default {
  name: 'AgGridBtnClicked',
  components: {},
  props: [],

  created() {
    this.id = "AgGridBtnClicked" + Date.now()

  },
  mounted(){
    // console.log('voici les params passer en props ==>',this.params)
  },
  methods: {
    btnClickedHandler() {
      this.params.clicked(this.params.data);
    }
  }
}
</script>

<style>
.agGridBtnParent{
    display: flex;
    width: 100%;
    height: 100%;
    justify-content: center;
    align-content: center;
    align-items: center;
}
</style>
