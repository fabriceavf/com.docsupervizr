<template>
  <div>
    <button :id="'btn'+this.indice" type="button" :class="'btn '+this.addClass" data-toggle="modal" :data-target="'#'+this.indice" @click.prevent="show()">
      <slot name="modal_btn"></slot>
    </button>
    <div class="modal fade" :id="this.indice" :class="this.newClass" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div :class="'modal-dialog modal-dialog-centered modal-dialog-scrollable modal-'+this.taille">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">
                <slot name="modal_title"></slot>
              </h4>
              <button type="button" :id="'close_modal_'+this.indice" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="reset()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" v-if="charger == true">
              <slot name="modal_body"></slot>
            </div>
          </div>
        </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'DataModal',
  props: ['indice', 'taille', 'addClass', 'newClass'],
  data () {
    return {
      charger: false
    }
  },
  methods: {
    show () {
      this.charger = true
    },
    reset () {
      this.charger = false
    }
  }
}
</script>
