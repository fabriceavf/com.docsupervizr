<template>
  <div>

    <data-modal :indice="'new-programmation'" taille="lg" addClass="btn-primary ">
      <template #modal_btn >
        <i class="fa fa-plus"></i> Nouvelle programmation
      </template>
      <template #modal_title >
        Creer une nouvelle programmation
      </template>
      <template #modal_body >
        <CreateProgrammation :table="table"/>
      </template>
    </data-modal>
  </div>

</template>

<script>

import DataModal from '@/components/DataModal.vue'
import CreateProgrammation from "@/views/Programmations/CreateProgrammation.vue";
export default {
  name: "CellRender",
  components:{DataModal,CreateProgrammation},
  data() {
    return {
      data: null,
      table:'programmation'
    }
  },
  mounted() {
    console.log('voila les paramettre passer', this.params)
    this.data = this.params.data
  },
  methods: {
    showData() {
      let newData = this.data
      newData['prenom'] =this.makeid(10)
      this.params.api.applyServerSideTransaction(
        {
          update: [
           newData
          ],
        }
      )
      console.log('on as cliquer', this.data.name)
    },
    makeid(length) {
      let result = '';
      const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      const charactersLength = characters.length;
      let counter = 0;
      while (counter < length) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        counter += 1;
      }
      return result;
    }
  }

}
</script>

<style scoped>

</style>
