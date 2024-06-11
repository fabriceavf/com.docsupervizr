<template>
    <div style="position:relative;width: 100%">

        <div class="allButtons">
            <button class="btn btn-secondary" @click="imprimer()">Imprimer</button>
            <button class="btn btn-secondary" @click="telecharger()">Telecharger</button>
        </div>
        <div class="row badges" v-show="show">

            <div class="badge-parent">
                <!--        <div class="text-center" style="margin:10px">-->
                <!--          <div class="btn btn-primary" @click="download(`badge_recto${agent.id}`,'recto')">Telecharger le recto</div>-->
                <!--        </div>-->
                <div :id="'badge_recto'+agent.id" class="badge-recto-min badge-element">
                    <img :src="require('@/assets/images/clean.recto.png')">

                    <img id="rectophoto" class="rounded mx-auto images infoPhoto" :src="$store.getters['general/apiUrl']+'/'+agent.photo"
                         cross-origin="Anonymous">
                    <div class="detail">
                        <div v-if="agent.nom" class="infoNom">
                            Nom: {{ agent.nom }}
                        </div>
                        <div v-if="agent.prenom" class="infoPrenom">
                            Prenom: {{ agent.prenom }}
                        </div>
                        <template class="font-weight-bold" v-if="agent.fonction">
                            <div v-if="agent.fonction.Selectlabel" class="infoFonction">
                                Fonction: {{ agent.fonction.Selectlabel }}
                            </div>
                            <template class="font-weight-bold" v-if="agent.fonction.service">
                                <div v-if="agent.fonction.service.Selectlabel" class="infoService">
                                    Service: {{ agent.fonction.service.Selectlabel }}
                                </div>
                            </template>
                        </template>

                        <template class="font-weight-bold" v-if="agent.direction">
                            <div v-if="agent.direction.Selectlabel" class="infoService">
                                Direction {{ agent.direction.Selectlabel }}
                            </div>
                        </template>
                        <div  class="infoMatricule">
                            Matricule :     <span v-if="agent.matricule">{{ agent.matricule }}</span>
                        </div>
                    </div>



                </div>
            </div>


            <!--      <div class=" badge-parent">-->

            <!--&lt;!&ndash;        <div class="text-center" style="margin:10px">&ndash;&gt;-->

            <!--&lt;!&ndash;          <div class="btn btn-primary" @click="download(`badge_verso${agent.id}`,'verso')">Telecharger le verso</div>&ndash;&gt;-->
            <!--&lt;!&ndash;        </div>&ndash;&gt;-->

            <!--        <div :id="'badge_verso'+agent.id" class="badge-recto-min badge-element badge-element-verso">-->

            <!--&lt;!&ndash;          <img :src="require('@/assets/images/verso.png')">&ndash;&gt;-->

            <!--          <div v-if="agent.date_naissance" class="infoDateNaissance">-->
            <!--            {{ date(agent.date_naissance) }}-->
            <!--          </div>-->
            <!--          <div v-if="agent.date_embauche"  class="infoDateEmbauche">-->
            <!--            {{date(agent.date_embauche)  }}-->
            <!--          </div>-->
            <!--          <div v-if="agent.nationalite"  class="infoNationalite">-->

            <!--            {{ agent.nationalite.Selectlabel }}-->

            <!--          </div>-->
            <!--          <div v-if="agent.num_cnss" class="infoNumeroCnss">-->
            <!--            {{ agent.num_cnss }}-->
            <!--          </div>-->
            <!--          <div v-if="agent.num_cnamgs"  class="infoNumeroCnamgs">-->
            <!--            {{ agent.num_cnamgs }}-->
            <!--          </div>-->


            <!--        </div>-->
            <!--      </div>-->
        </div>
    </div>
</template>
<script>
import * as htmlToImage from 'html-to-image';
import download from 'downloadjs'
import moment from 'moment';

export default {
    props: ['agent'],
    data() {
        return {
            show: true,
            badge: '',
            base64: '',
            error: ''
        }
    },
    mounted() {

        this.show = true;

    },
    methods: {
        imprimer(){
            let that = this

            function filter(node) {
                return (node.tagName !== 'img');
            }

            let node=document.getElementById(`badge_recto${this.agent.id}`);
            // let node1=document.getElementById(`badge_verso${this.agent.id}`);
            htmlToImage.toJpeg(node, {filter: filter})
                .then(function (dataUrl) {
                    let win = window.open('');
                    win.document.write('<img src="' + dataUrl + '" onload="window.print();window.close()" />');
                    win.focus();
                    // htmlToImage.toJpeg(node1, {filter: filter})
                    //     .then(function (dataUrl1) {
                    //       let win = window.open('');
                    //       win.document.write('<img src="' + dataUrl + '" onload="window.print();window.close()" />');
                    //       win.document.write('<img src="' + dataUrl1 + '" onload="window.print();window.close()" />');
                    //       win.focus();
                    //     })
                })
                .catch(function (error) {
                    console.error('oops, something went wrong!', error);
                });


        },
        telecharger(){
            let that = this

            function filter(node) {
                return (node.tagName !== 'img');
            }

            let node=document.getElementById(`badge_recto${this.agent.id}`);
            let node1=document.getElementById(`badge_verso${this.agent.id}`);
            htmlToImage.toJpeg(node, {filter: filter})
                .then(function (dataUrl) {
                    download(dataUrl, `agent-verso-badge.png`);
                    // htmlToImage.toJpeg(node1, {filter: filter})
                    //     .then(function (dataUrl1) {
                    //       download(dataUrl, `agent-verso-badge.png`);
                    //       download(dataUrl1, `agent-recto-badge.png`);
                    //     })
                })
                .catch(function (error) {
                    console.error('oops, something went wrong!', error);
                });


        },
        returnDateFormat(date) {
            if (date != null) {
                let newDate = new Date(date)
                return newDate.toLocaleDateString("fr");
            }
        },

        generateBase64() {
            let canvas = document.createElement('CANVAS')
            let img = document.createElement('img')
            img.src = this.$store.getters['general/apiUrl'] + '/' + this.agent.photo
            img.onload = () => {
                canvas.height = img.height
                canvas.width = img.width
                this.base64 = canvas.toDataURL('image/png')
                canvas = null
            }

            img.onerror = error => {
                this.error = 'Could not load image, please check that the file is accessible and an image!'
            }
        },
        download(id, type) {

            this.generateBase64()
            let that = this

            function filter(node) {
                return (node.tagName !== 'img');
            }

            // console.log('voci limage en base 64',this.getBase64Image(document.getElementById("rectophoto")))
            let node = document.getElementById(id);
            // { cacheBust: true }
            htmlToImage.toJpeg(node, {filter: filter})
                .then(function (dataUrl) {
                    download(dataUrl, `agent-${that.agent.matricule}-badge-${type}.png`);
                })
                .catch(function (error) {
                    console.error('oops, something went wrong!', error);
                });
        },
        date(brute){
            let data=brute;
            try{
                data=moment(brute,'YYYY-MM-DD').format('DD/MM/YYYY')
            }catch (e) {

            }
            return data
        }

    }
}
</script>

<style scoped>

.badges {
    font-weight: bold !important;
    width: 100%
}

.allButtons {
    display: flex !important;
    justify-content: space-around !important;
}

.badges td {
    border: none !important ;
    white-space: nowrap !important ;
}

.badge-parent {
    background: #bdbdbd !important;
    padding: 5px !important;
    margin: 0 auto !important;
}
#rectophoto{
    position: absolute !important;
    left: 54.8px !important;
    width: 156.5px !important;
    height: 213.4px !important;
    border-radius: 5px !important;
    top: 208.0px !important;
}
.detail{
    position: absolute !important;
    top: 178.3px !important;
    left: 350px !important;
    width: 450px !important ;
    display: flex !important;
    flex-direction: column !important;
    gap: 10px !important;
}
.infoNom{
    /*position: absolute !important;*/
    top: 200.2px !important;
    color: black !important;
    font-weight: bold !important;
    font-size: 28.1px !important;
    left: 450.8px !important;
}
.infoPrenom{
    /*position: absolute !important;*/
    top: 250.2px !important;
    color: black !important;
    font-weight: bold !important;
    font-size: 28.1px !important;
    left: 450.8px !important;
}
.infoFonction{
    /*position: absolute !important;*/
    top: 280.2px !important;
    color: black !important;
    font-weight: bold !important;
    font-size: 28.1px !important;
    left: 450.8px !important;
}
.infoService{
    /*position: absolute !important;*/
    top: 355.2px !important;
    color: black !important;
    font-weight: bold !important;
    font-size: 28.1px !important;
    left: 450.8px !important;
}
.infoMatricule{
    /*position: absolute !important;*/
    top: 435.2px !important;
    color: black !important;
    font-weight: bold !important;
    font-size: 28.1px !important;
    left: 450.8px !important;
}

.infoDateNaissance{
    position: absolute !important;
    top: 250.2px !important;
    color: black !important;
    font-weight: bold !important;
    font-size: 28.1px !important;
    left: 450.8px !important;
}
.infoDateEmbauche{
    position: absolute !important;
    top: 280px !important;
    color: black !important;
    font-weight: bold !important;
    font-size: 28.1px !important;
    left: 450.8px !important;
}
.infoNationalite{
    position: absolute !important;
    top: 310px !important;
    color: black !important;
    font-weight: bold !important;
    font-size: 28.1px !important;
    left: 450.8px !important;
}
.infoNumeroCnss{
    position: absolute !important;
    top: 340.2px !important;
    color: black !important;
    font-weight: bold !important;
    font-size: 28.1px !important;
    left: 450.8px !important;
}
.infoNumeroCnamgs{
    position: absolute !important;
    top: 370.2px !important;
    color: black !important;
    font-weight: bold !important;
    font-size: 28.1px !important;
    left: 450.8px !important;
}

.badge-element {
    /*min-width: 500px !important;*/
    /*max-width: 500px !important;*/
    /*min-height: 850px !important;*/
    /*max-height: 850px !important;*/
    position: relative !important;
    height: 550px !important;
    width: 850px !important;
    /*margin: 10px !important;*/
    background: #fff !important;
    border-radius: 5px !important;
    display: flex !important;
    gap: 10px !important;
    flex-direction: column !important;
}

.infos-badge-min1 {
    font-size: calc(200%) !important ;
}

.badge-element-verso {
    /*min-width: 500px !important;*/
    /*max-width: 500px !important;*/
    /*min-height: 850px !important;*/
    /*max-height: 850px !important;*/
    background: #fff !important;
    border-radius: 5px !important;
    display: flex !important;
    justify-content: space-between !important;
}

.badge-element .header {
    display: flex !important;
    flex-direction: row !important;
    height: 18.7% !important;
    gap: 2%
}

.badge-element .header div {
    width: 100% !important;
    display: flex !important;
    align-items: center !important;
}

.badge-element .header div span {
    font-size: calc(200%) !important;
    font-weight: bold !important;
}

.badge-element .header img {
    border-style: none !important;
    width: 30% !important;
    height: 80% !important;
    justify-content: center !important;
    align-items: center !important;
    align-self: center !important;
}

.badge-element .body {
    width: 100% !important;
    position: relative !important;
    margin: 10% auto !important;


}

.badge-element .body img {
    width: 80% !important;
    heigth: 70% !important;
    margin: 0 auto !important;


}

.infos-badge-min {
    font-size: 125% !important ;
}

.images {
    width: 45%;
    height: 60%;

}

.footer table {
    font-size: calc(100%);
}

.body table {
    font-size: calc(140%);
}
</style>
