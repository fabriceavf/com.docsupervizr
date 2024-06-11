<template>

  <div class="dropzoneElement">
    <template v-if="showUploadBlock()">
      <div class="allButtons">
        <button class="btn btn-primary" @click="openDropzone()" v-if="state=='webcam'">Uploader le fichier</button>
        <button class="btn btn-primary" @click="openWebcam()" v-if="state=='dropzone'">Utiliser la Webcam</button></div>

      <vue-dropzone
          :id="uid"
          ref="myVueDropzone"
          :options="dropzoneOptions"
          v-on:vdropzone-success="success"
          v-show="state=='dropzone'"
      >

      </vue-dropzone>
    </template>

    <div v-show="state=='cropper'">
      <cropper
          ref="myCropper"
          class="cropper"
          :src="imageUrl"
          :stencil-props="{
          aspectRatio: 10/12
        }"
      />

      <button class="btn btn-success cropper-buttons" @click="ValiderCropper()">Valider</button>
    </div>



    <div class="camera-box" v-show="state=='webcam'">
      <div style="height: 200px">
        <div v-if="isCameraOpen" class="camera-canvas">
          <video ref="camera" :width="canvasWidth" :height="canvasHeight" autoplay></video>
          <canvas v-show="false" id="photoTaken" ref="canvas" :width="canvasWidth" :height="canvasHeight"></canvas>
        </div>
      </div>
      <button class="btn btn-success" @click="capture">Enregistrer</button>
    </div>
    <b-overlay :show="isLoading">
      <div style="position:relative;" class="parent">
        <div class="dropzone-render" v-if="element.length>0">
          <div class="dropzone-render-block" v-for="(ele,key) in element">
            <img :src="ele.image_url" alt="">
            <div class="buttons">

              <div class="btn btn-success" @click="onDonwload(ele.download_url)"><i
                class="fa-solid fa-file-arrow-down"></i>
              </div>
              <div class="btn btn-danger" @click="onDelete(ele.id)"><i class="fa-solid fa-trash"></i></div>
            </div>

          </div>
        </div>

      </div>


    </b-overlay>


  </div>

</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import $ from 'jquery'
// import Cropper from 'cropperjs';

import 'vue-advanced-cropper/dist/style.css';
import { Cropper } from 'vue-advanced-cropper'

export default {
  props: {
    getUrl: {
      type: String,
      required: true
    },
    max: {
      type: Number,
      required: true,
      default:2
    },
    uploadUrl: {
      type: String,
      required: true
    },
    value: {
      type: String,
      required: true
    }
  },
  name: "Files",
  components: {
    vueDropzone: vue2Dropzone,
    Cropper
  },
  data: function () {
    let that=this
    return {
      state: 'dropzone',
      imageUrl: '',
      isCameraOpen: false,
      canvasHeight: 200,
      canvasWidth: 190,
      items: [],
      isLoading: false,
      uid: 0,
      cropperCallBack:()=>{},
      dropzoneOptions: {
        url: '',
        method: 'post',
        thumbnailWidth: 150,
        clickable: true,
        addRemoveLinks: true,
        headers: {},
        transformFile: function (file, done) {// Create the image editor overlay
         let _newId =  "Dropzonne" + Date.now()
          let myDropZone = this;
          that.imageUrl=URL.createObjectURL(file)
          that.state='cropper'

          const image = document.getElementById(_newId)
               let callBack=canvas=>{
            if (typeof canvas.toBlob !== "undefined") {
              canvas.toBlob(function(blob) {
                myDropZone.createThumbnail(
                    blob,
                    myDropZone.options.thumbnailWidth,
                    myDropZone.options.thumbnailHeight,
                    myDropZone.options.thumbnailMethod,
                    false,
                    function (dataURL) {
                      // Update the Dropzone file thumbnail
                      myDropZone.emit('thumbnail', file, dataURL);          // Return the file to Dropzone
                      done(blob);
                    });
              }, "image/jpeg", 0.75);
            }
          else if (typeof canvas.msToBlob !== "undefined") {
              var blob = canvas.msToBlob()
              myDropZone.createThumbnail(
                  blob,
                  myDropZone.options.thumbnailWidth,
                  myDropZone.options.thumbnailHeight,
                  myDropZone.options.thumbnailMethod,
                  false,
                  function (dataURL) {
                    // Update the Dropzone file thumbnail
                    myDropZone.emit('thumbnail', file, dataURL);          // Return the file to Dropzone
                    done(blob);
                  });
            }
            else {
            }

          }
          that.cropperCallBack=callBack

        }


      },
      element: []
    }
  },
  beforeMount() {
    this.uid = "dropzone" + this.id
  },
  mounted() {
    console.log('voici la valeur de base ', this.value)
    if (this.value != null && this.value != "") {
      this.getFiles(this.value)
    }
  },
  created() {
    let url = this.$store.getters["general/apiUrl"] + this.uploadUrl
    this.dropzoneOptions.url=url

    console.log('voici les utl=', this.$store.getters["general/apiUrl"], this.uploadUrl)
  },

  watch: {
    'element': {
      handler: function (after, before) {
        console.log('changement des valeur ', after, before)
        let newValue = after.map(data => data.id).join(',')
        this.state='dropzone'
        this.$emit('input', newValue)
        this.$emit('addFile', after[after.length - 1])
      },
      deep: true
    }
  },
  methods: {
    showUploadBlock(){
      let visible=true
      if(this.element.length >= this.max){
        visible=false
      }
      return visible
    },
    ValiderCropper(){
      const { coordinates, image, visibleArea, canvas  } = this.$refs.myCropper.getResult()
      // console.log('voici le resultat de cropper')

      this.cropperCallBack(canvas)
      // console.log('voic la reponse de cropper==>',this.$refs.myCropper,canvas)
    },
    getFiles(ele) {
      this.isLoading = true
      let that = this

      this.axios.get(`${this.getUrl}/${ele}`)
        .then(response => {
          console.log('voici la reponse ', response.data)
          try {
            that.element = response.data.data
            that.isLoading = false
          } catch (e) {

          }
          // that.isLoading = false
        })
        .catch(error => {
          console.error('voici lerreur daxios ', error)
          that.isLoading = false
        })


    },
    getAddFiles(ele) {

      this.axios.get(`${this.getUrl}/${ele}`, {mode: 'cors'})
        .then(response => {
          console.log('voici la reponse ', response.data)
          that.element = response.data
        })
        .catch(error => {
          console.error('voici lerreur ', error)
        })


    },
    isImage(extension) {

      return ['png', 'jpeg', 'jpg'].includes(extension)


    },
    onDelete(id) {
      this.element = this.element.filter(data => parseInt(data.id) != parseInt(id))

      this.$emit('update:modelValue', this.element.map(data => data.id).join(','))
    },
    onDonwload(url) {
      window.open(url)
    },
    success(file, data) {
      console.log('sucess ', data)
      this.$refs.myVueDropzone.removeFile(file);
      this.element.push(data)
    },
    toggleCamera() {
      if (this.isCameraOpen) {
        this.isCameraOpen = false;
        this.stopCameraStream();
      } else {
        this.isCameraOpen = true;
        this.startCameraStream();
      }
    },
    openDropzone() {
      this.state = 'dropzone'
      if (this.isCameraOpen) {
        this.isCameraOpen = false;
        this.stopCameraStream();
      }
    },
    openWebcam() {
      this.state = 'webcam'
      this.isCameraOpen = true;
      this.startCameraStream();

    },
    startCameraStream() {
      const constraints = (window.constraints = {
        audio: false,
        video: true
      });
      navigator.mediaDevices
        .getUserMedia(constraints)
        .then(stream => {
          this.$refs.camera.srcObject = stream;
        }).catch(error => {
        alert("Browser doesn't support or there is some errors." + error);
      });
    },
    stopCameraStream() {
      let tracks = this.$refs.camera.srcObject.getTracks();
      tracks.forEach(track => {
        track.stop();
      });
    },
    capture() {
      const FLASH_TIMEOUT = 50;
      let self = this;
      setTimeout(() => {
        const context = self.$refs.canvas.getContext('2d');
        context.drawImage(self.$refs.camera, 0, 0, self.canvasWidth, self.canvasHeight);
        const dataUrl = self.$refs.canvas.toDataURL("image/jpeg")
          .replace("image/jpeg", "image/octet-stream");
        self.uploadPhoto(dataUrl);
        self.state = 'dropzone';
        self.stopCameraStream();
      }, FLASH_TIMEOUT);
    },
    addToPhotoGallery(dataURI) {
      this.items.push(
        {
          src: dataURI,
          thumbnail: dataURI,
          w: this.canvasWidth,
          h: this.canvasHeight,
          alt: 'some numbers on a grey background' // optional alt attribute for thumbnail image
        }
      )
    },
    uploadPhoto(dataURL) {
      let uniquePictureName = this.generateCapturePhotoName();
      let capturedPhotoFile = this.dataURLtoFile(dataURL, uniquePictureName + '.jpg')
      let formData = new FormData()
      formData.append('file', capturedPhotoFile)
      this.$refs.myVueDropzone.addFile(capturedPhotoFile)
      console.log('voici les data a renvoyer au server',formData)
      // Upload image api
      // axios.post('http://your-url-upload', formData).then(response => {
      //   console.log(response)
      // })
    },
    generateCapturePhotoName() {
      return Math.random().toString(36).substring(2, 15)
    },
    dataURLtoFile(dataURL, filename) {
      let arr = dataURL.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]),
        n = bstr.length,
        u8arr = new Uint8Array(n);

      while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
      }
      return new File([u8arr], filename, {type: mime});
    },
  }
}
</script>

<style lang="scss">
.cropper {
  height: 250px;
  width: 250px;
  background: #DDD;
}
.allButtons{
  margin:5px
}
.allFile {
  display: flex;
  justify-content: space-around;
  gap: 10px;

  .block {
    border: 1px solid black;
    padding: 10px
  }
}

.dropzoneElement {
  margin: 10px;

  .dz-message {
    //display: none;
    margin: 0px !important;
  }

  .dropzone {
    min-height: 50px !important;
    cursor: pointer;
    border: 2px dashed;
    border-radius: 5px;

  }
}
.cropper{
  margin:0 auto;
}
.cropper-buttons{
  margin: 5px auto;
  display: inherit;
}

.dropzone-render {
  margin: 10px;
  border: 1px solid #9e9e9e;
  border-radius: 5px;
  padding: 10px;
  display: flex;
  gap: 10px;
  justify-content: center;
  flex-wrap: wrap;

  .dropzone-render-block {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-content: center;
    align-items: center;
    gap: 10px;

    img {
      width: 100px;
      height: 50px;

    }

    .buttons {
      opacity: 0;
      position: absolute;
      display: flex;
      gap: 10px;
    }

    &:hover {
      .buttons {
        opacity: 1 !important;
      }
    }
  }
}

.parent {
  width: 100%;
  height: 100%;
  min-height: 50px;
}

.loader {
  width: 100%;
  height: 100%;
  min-height: 50px;
  background: #686868;
  position: absolute;
  top: 0;
  opacity: 0.7;
}

</style>
