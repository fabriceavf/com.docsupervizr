<template>
    <div>
        <div class="rendus">

        </div>
        <div class="selection">

        </div>
    </div>

</template>

<script>
export default {
    name: "SelectComponents",
    props: {
        data:{
            default:{}
        },
        url:{
            default:false
        }
    },
    data(){
      return {
          selected:[],
      }
    },
    mounted() {
        if(Objects.keys(this.data)>0){
            this.selected.push(this.data)
        }
        if(this.url){
            alert('on peut commencer a recuperer selon lurl')
        }
        else{
            alert('on ne peut pas commencer a recuperer car lurl nest pas definit')
        }
    }
}
</script>

<style scoped>

</style>
