<template>
  <div style="text-align:center">
    <button class="btn btn-secondary" v-if="!importFile" @click="openImport"><i class="fas fa-image"></i> Importer une photo</button>

    <template v-if="importFile">

      <Files
        v-model="donnees"
        getUrl="/api/base/get_files"
        uploadUrl="/api/base/uploads_files"
        @addFile="ajoutFiles"
        :max="1"

      ></Files>
      <div class="allButtons">
        <button class="btn btn-success" @click="validerImport"><i class="fas fa-check"></i> Valider</button>
        <button class="btn btn-danger" @click="annulerImport"><i class="fas fa-xmark"></i> Close</button>
      </div>
    </template>
  </div>



</template>

<script>
import Files from "@/components/Files.vue"

export default {
  props: {
    value: {
      type: String,
      required: true
    }
  },
  name: "PhotoSgs",
  components: {Files },
  data: function () {
    return {
      fichier:{},
      importFile:false,
      donnees:'',

    }
  },
  beforeMount() {
    this.uid = "dropzone" + this.id
  },
  mounted() {

  },
  created() {
  },

  watch: {
  },
  methods: {
    openImport(){
      this.importFile=true
    },
    validerImport(){
      this.importFile=false
      this.$emit('input',this.fichier.web_path)
    },
    annulerImport(){
      this.importFile=false

    },
    ajoutFiles(files){
      console.log('voici les fichiers',files)
      this.fichier=files

    },
  }
}
</script>

<style>
.allButtons{
  display:flex;
  justify-content:space-around;
}

</style>
