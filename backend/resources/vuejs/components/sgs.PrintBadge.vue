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
                    <img :src="require('@/assets/images/recto.png')">

                    <img id="rectophoto" class="rounded mx-auto images infoPhoto" :src="$store.getters['general/apiUrl']+'/'+agent.photo"
                         cross-origin="Anonymous">
                    <div class="detailBadge">
                        <div v-if="agent.prenom" class="infoPrenom">
                            {{ agent.prenom }}
                        </div>
                        <div v-if="agent.nom" class="infoNom">
                            {{ agent.nom }}
                        </div>

                        <template class="font-weight-bold" v-if="agent.fonction">
                            <div v-if="agent.fonction.Selectlabel" class="infoFonction">
                                {{ agent.fonction.Selectlabel }}
                            </div>
                        </template>
                        <template class="font-weight-bold" v-if="agent.direction">
                            <div v-if="agent.direction.Selectlabel" class="infoService">
                                {{ agent.direction.Selectlabel }}
                            </div>
                        </template>

                        <div  class="infoMatricule">
                            Matricule      <span v-if="agent.matricule">{{ agent.matricule }}</span>
                        </div>
                    </div>

                </div>
            </div>


            <div class=" badge-parent">

                <!--        <div class="text-center" style="margin:10px">-->

                <!--          <div class="btn btn-primary" @click="download(`badge_verso${agent.id}`,'verso')">Telecharger le verso</div>-->
                <!--        </div>-->

                <div :id="'badge_verso'+agent.id" class="badge-recto-min badge-element badge-element-verso">

                    <img :src="require('@/assets/images/verso.png')">

                    <div v-if="agent.date_naissance" class="dateNaissance">
                        {{ date(agent.date_naissance) }}
                    </div>
                    <div v-if="agent.date_embauche"  class="dateEmbauche">
                        {{date(agent.date_embauche)  }}
                    </div>
                    <div v-if="agent.nationalite"  class="nationalite">

                        {{ agent.nationalite.Selectlabel }}

                    </div>
                    <div v-if="agent.num_cnss" class="numeroCnss">
                        {{ agent.num_cnss }}
                    </div>
                    <div v-if="agent.num_cnamgs"  class="numeroCnamgs">
                        {{ agent.num_cnamgs }}
                    </div>


                </div>
            </div>
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
            let node1=document.getElementById(`badge_verso${this.agent.id}`);
            htmlToImage.toJpeg(node, {filter: filter})
                .then(function (dataUrl) {
                    htmlToImage.toJpeg(node1, {filter: filter})
                        .then(function (dataUrl1) {
                            let win = window.open('');
                            win.document.write('<img src="' + dataUrl + '" onload="window.print();window.close()" />');
                            win.document.write('<img src="' + dataUrl1 + '" onload="window.print();window.close()" />');
                            win.focus();
                        })
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
                    htmlToImage.toJpeg(node1, {filter: filter})
                        .then(function (dataUrl1) {
                            download(dataUrl, `agent-verso-badge.png`);
                            download(dataUrl1, `agent-recto-badge.png`);
                        })
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
    font-weight: bold;
    width: 100%
}

.allButtons {
    display: flex;
    justify-content: space-around;
}

.badges td {
    border: none !important;
    white-space: nowrap !important;
}

.badge-parent {
    background: #bdbdbd;
    padding: 5px;
    margin: 0 auto;
}
.infoPhoto{
    position: absolute;
    left: 118.6px;
    width: 315px !important;
    height: 315px !important;
    border-radius: 5px !important;
    top: 150px;
}
.detailBadge{
    top: 500px;
    position: absolute;
    left: 120px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.infoPrenom{
    /*position: absolute;*/
    top: 470.2px;
    color: black;
    font-weight: bold;
    font-size: 28.1px;
    left: 91.8px;
}
.infoFonction{
    /*position: absolute;*/
    top: 557.0px;
    color: black;
    font-weight: bold;
    font-size: 28.1px;
    left: 91.8px;
}
.infoService{
    /*position: absolute;*/
    top: 600.9px;
    color: black;
    font-weight: bold;
    font-size: 28.1px;
    left: 91.8px;
}
.infoNom{
    /*position: absolute;*/
    top: 512.7px;
    color: black;
    font-weight: bold;
    font-size: 28.1px;
    left: 91.8px;
}
.infoMatricule{
    /*position: absolute;*/
    top: 672.7px;
    color: black;
    font-weight: bold;
    font-size: 28.1px;
    left: 91.8px;
}
.dateNaissance{
    position: absolute;
    top: 214px;
    left: 150px;
    color: black;
    font-weight: bold;
    font-size: 28.1px;
}
.dateEmbauche{
    position: absolute;
    top: 282.5px;
    color: black;
    font-weight: bold;
    font-size: 28.1px;
    left: 227px;
}
.nationalite{
    position: absolute;
    top: 350.9px;
    color: black;
    font-weight: bold;
    font-size: 28.1px;
    left: 227px;
}
.numeroCnss{
    position: absolute;
    top: 417.0px;
    color: black;
    font-weight: bold;
    font-size: 28.1px;
    left: 227px;
}
.numeroCnamgs{
    position: absolute;
    top: 482.9px;;
    color: black;
    font-weight: bold;
    font-size: 28.1px;
    left: 196.5px;
}
.badge-element {
    /*min-width: 500px;*/
    /*max-width: 500px;*/
    /*min-height: 850px;*/
    /*max-height: 850px;*/
    position: relative;
    width: 550px;
    height: 850px;
    /*margin: 10px;*/
    background: #fff;
    border-radius: 5px;
    display: flex;
    gap: 10px;
    flex-direction: column;
}

.infos-badge-min1 {
    font-size: calc(200%) !important;
}

.badge-element-verso {
    /*min-width: 500px;*/
    /*max-width: 500px;*/
    /*min-height: 850px;*/
    /*max-height: 850px;*/
    background: #fff;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
}

.badge-element .header {
    display: flex;
    flex-direction: row;
    height: 18.7%;
    gap: 2%
}

.badge-element .header div {
    width: 100%;
    display: flex;
    align-items: center;
}

.badge-element .header div span {
    font-size: calc(200%);
    font-weight: bold;
}

.badge-element .header img {
    border-style: none;
    width: 30%;
    height: 80%;
    justify-content: center;
    align-items: center;
    align-self: center;
}

.badge-element .body {
    width: 100%;
    position: relative;
    margin: 10% auto;


}

.badge-element .body img {
    width: 80%;
    heigth: 70%;
    margin: 0 auto;


}

.infos-badge-min {
    font-size: 125% !important;
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
