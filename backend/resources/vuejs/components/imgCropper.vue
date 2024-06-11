<template>
    <div class="container">
        <input v-if="!this.capture" :key="ckey" type="file" name="fileUpload" id="fileUpload" />
        <div class="row my-3">
            <div class="col-md-6">
                <div id="uploadedImage" class="container-fluid"></div>
            </div>
            <div class="col-md-6">
                <img id="imgCroppedResult" class="w-100" />
            </div>
        </div>



        <button class="btn btn-app" id="rotateLeftButton">
            <i class="fas fa-rotate-left"></i> Tourner à gauche
        </button>

        <button class="btn btn-app" id="rotateRightButton">
            <i class="fas fa-rotate-right"></i> Tourner à droite
        </button>
        <button class="btn btn-app" id="cropButton">
            <i class="fas fa-crop-simple"></i> Recadrer
        </button>

        <button class="btn btn-app" id="saveButton">
            <i class="fas fa-save"></i> Sauvegarder
        </button>

    </div>
</template>
<script>
import 'cropperjs/dist/cropper.css';
import Cropper from 'cropperjs';

export default {
    props:['inputId', 'agent_id', 'capture'],
    data() {
        return {
            ckey:0
        }
    },
    mounted() {
        let inputId = this.inputId;
        let agent_id = this.agent_id;
        let capture = this.capture;
        let that=this

        if((capture != null) && (agent_id != null)){

            const uploadedImageDiv = document.getElementById("canvas");
            getImage();
            let cropper = null;

            const cropButton = document.getElementById("cropButton");
            const rotateRightButton = document.getElementById("rotateRightButton");
            const rotateLeftButton = document.getElementById("rotateLeftButton");
            const saveButton = document.getElementById("saveButton");

            cropButton.addEventListener("click", cropImage);
            rotateRightButton.addEventListener("click", rotateRightImage);
            rotateLeftButton.addEventListener("click", rotateLeftImage);
            saveButton.addEventListener("click", saveImage);

            let myGreatImage = null;

            function getImage() {
                console.log("images", capture);
                const imageToProcess = capture;

                // display uploaded image
                let newImg = new Image(imageToProcess.width, imageToProcess.height);
                newImg.src = imageToProcess;
                newImg.id = "myGreatImage";
                uploadedImageDiv.style.width = "100%";
                uploadedImageDiv.style.height = "500px";
                uploadedImageDiv.appendChild(newImg);

                myGreatImage = document.getElementById("myGreatImage");

                processImage();
            }


            function processImage() {
                cropper = new Cropper(myGreatImage, {
                    aspectRatio: 4/4,
                    crop(event) {
                        console.log(
                            Math.round(event.detail.width),
                            Math.round(event.detail.height)
                        );
                        const canvas = this.cropper.getCroppedCanvas();
                    }
                });
            }

            function cropImage() {
                const imgurl = cropper.getCroppedCanvas().toDataURL();
                document.getElementById("imgCroppedResult").src= imgurl;
            }

            function rotateRightImage() {
                cropper.rotate(90);
            }

            function rotateLeftImage() {
                cropper.rotate(-90);
            }



            function saveImage() {
                // // var btnClose = document.getElementById('close_modal_photo');
                cropper.getCroppedCanvas().toBlob((blob) => {
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }

                    let data = new FormData();
                    data.append('photo', blob);
                    data.append('nav', 'Photo');
                    //this.$store.commit('setLoading', true);
                    axios.post('/api/agents/update/'+agent_id, data, config)
                    .then(response => (
                        //this.$store.commit('setLoading', false),
                        this.$toast.success(`Photo téléchargé avec success`)
                    ))
                    .catch(error => {
                        console.log(error)
                    });
                });


                document.getElementById("newImg").src= cropper.getCroppedCanvas().toDataURL();
                // // btnClose.click()
            }

        }

        else if(agent_id != null){

            const uploadedImageDiv = document.getElementById("uploadedImage");

            const fileUpload = document.getElementById("fileUpload");
            fileUpload.addEventListener("change", getImage, false);
            let cropper = null;

            const cropButton = document.getElementById("cropButton");
            const rotateRightButton = document.getElementById("rotateRightButton");
            const rotateLeftButton = document.getElementById("rotateLeftButton");
            const saveButton = document.getElementById("saveButton");

            cropButton.addEventListener("click", cropImage);
            rotateRightButton.addEventListener("click", rotateRightImage);
            rotateLeftButton.addEventListener("click", rotateLeftImage);
            saveButton.addEventListener("click", saveImage);

            let myGreatImage = null;

            function getImage() {
                console.log("images", this.files[0]);
                const imageToProcess = this.files[0];

                //const imageToProcess = capture;



                // display uploaded image
                let newImg = new Image(imageToProcess.width, imageToProcess.height);
                newImg.src = imageToProcess;
                newImg.src = URL.createObjectURL(imageToProcess);
                newImg.id = "myGreatImage";
                uploadedImageDiv.style.width = "100%";
                uploadedImageDiv.style.height = "500px";
                uploadedImageDiv.appendChild(newImg);

                myGreatImage = document.getElementById("myGreatImage");

                processImage();
            }

            function processImage() {
                cropper = new Cropper(myGreatImage, {
                    aspectRatio: 4/4,
                    crop(event) {
                        console.log(
                            Math.round(event.detail.width),
                            Math.round(event.detail.height)
                        );
                        const canvas = this.cropper.getCroppedCanvas();
                    }
                });
            }

            function cropImage() {
                const imgurl = cropper.getCroppedCanvas().toDataURL();
                document.getElementById("imgCroppedResult").src= imgurl;
            }

            function rotateRightImage() {
                cropper.rotate(90);
            }

            function rotateLeftImage() {
                cropper.rotate(-90);
            }



            function saveImage() {
                // var btnClose = document.getElementById('close_modal_photo');
                cropper.getCroppedCanvas().toBlob((blob) => {
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }

                    let data = new FormData();
                    data.append('photo', blob);
                    data.append('nav', 'Photo');
                    //this.$store.commit('setLoading', true);
                    axios.post('/api/agents/update/'+agent_id, data, config)
                    .then(response => (
                        //this.$store.commit('setLoading', false),
                        this.$toast.success(`Photo téléchargé avec success`)
                    ))
                    .catch(error => {
                        console.log(error)
                    });
                });


                document.getElementById("newImg").src= cropper.getCroppedCanvas().toDataURL();
                // btnClose.click()
              that.$emit("savephoto")
            }

        }

        else {
            const uploadedImageDiv = document.getElementById("uploadedImage");

            const fileUpload = document.getElementById("fileUpload");
            fileUpload.addEventListener("change", getImage, false);
            let cropper = null;

            const cropButton = document.getElementById("cropButton");
            const rotateRightButton = document.getElementById("rotateRightButton");
            const rotateLeftButton = document.getElementById("rotateLeftButton");
            const saveButton = document.getElementById("saveButton");

            cropButton.addEventListener("click", cropImage);
            rotateRightButton.addEventListener("click", rotateRightImage);
            rotateLeftButton.addEventListener("click", rotateLeftImage);
            saveButton.addEventListener("click", saveImage);

            let myGreatImage = null;

            function getImage() {
                console.log("images", this.files[0]);
                const imageToProcess = this.files[0];

                // display uploaded image
                let newImg = new Image(imageToProcess.width, imageToProcess.height);
                newImg.src = imageToProcess;
                newImg.src = URL.createObjectURL(imageToProcess);
                newImg.id = "myGreatImage";
                uploadedImageDiv.style.width = "100%";
                uploadedImageDiv.style.height = "500px";
                uploadedImageDiv.appendChild(newImg);

                myGreatImage = document.getElementById("myGreatImage");

                processImage();
            }

            function processImage() {
                cropper = new Cropper(myGreatImage, {
                    aspectRatio: 4/4,
                    crop(event) {
                        console.log(
                            Math.round(event.detail.width),
                            Math.round(event.detail.height)
                        );
                        const canvas = this.cropper.getCroppedCanvas();
                    }
                });
            }

            function cropImage() {
                const imgurl = cropper.getCroppedCanvas().toDataURL();
                document.getElementById("imgCroppedResult").src= imgurl;
            }

            function rotateRightImage() {
                cropper.rotate(90);
            }

            function rotateLeftImage() {
                cropper.rotate(-90);
            }

            function saveImage() {
                // var btnClose = document.getElementById('close_modal_photo');
                var newCanvas =  cropper.getCroppedCanvas();
                document.body.appendChild(newCanvas);
                newCanvas.id = "canvas_generated";

                document.getElementById("newImg").src = cropper.getCroppedCanvas().toDataURL();
                that.$emit("savephoto")

            }



        }

    },
    methods: {
        regenerate(){
            ckey += 1;
        }
    },
}

</script>
