<template>
  <div>

    <div class="row">
      <div class="col-md-6">
        <video id="webcam" autoplay playsinline style="height: 50vh;width: 100%;object-fit: fill;"></video>
        <audio id="snapSound" src="audio/snap.wav" preload = "auto"></audio>
      </div>
      <div class="col-md-6">
        <canvas id="canvas" width="100%" height="100%"></canvas>
      </div>
    </div>
    <button class="btn btn-app" id="capture">
      <i class="fas fa-camera"></i> Capturer
    </button>
  </div>

</template>
<script>
import Webcam from 'webcam-easy';

export default {
    data(){
        return{
            webcam_object:'',
            picture:'',
        }
    },
    props:['inputId', 'agent_id'],
    created() {
        this.run_webcam();
    },
    methods:{
            run_webcam(){
                const webcamElement = document.getElementById('webcam');
                const canvasElement = document.getElementById('canvas');
                const snapSoundElement = document.getElementById('snapSound');
                const webcam = new Webcam(webcamElement, 'enviroment', canvasElement, snapSoundElement);

                this.$store.commit('setLoading', true)
                webcam.start()
                .then(result =>{
                    console.log("webcam started");
                })
                .catch(err => {
                    console.log(err);
                });

                this.webcam_object = webcam;
                this.$store.commit('setLoading', false)

            },
            take_picture(){
                this.picture =  this.webcam_object.snap();
            },
            save_picture(){
                this.url = document.getElementById("canvas").toDataURL("image/jpeg");

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                let data = new FormData();
                data.append('picture', this.picture);
                data.append('nav', 'Webcam');
                this.$store.commit('setLoading', true);
                axios.post('/agents/update/'+this.agent.id, data, config)
                .then(response => (
                    this.$store.commit('setLoading', false),
                    this.$toast.success(`Photo téléchargé avec success`)
                ))
                .catch(error => {
                    this.$store.commit('setLoading', false),
                    this.errors = error.response.data.errors
                });

            },

    }
}
</script>
