<template>

    <div>
        <div id="charts">

            <div class="lines"
                 style="width:100%;clip-path: polygon(30% 34%, 70% 34%, 70% 35%, 30% 35%);background:black;opacity:0.3">
            </div>
            <div class="lines"
                 style="width:100%;clip-path: polygon(30% 34%, 70% 34%, 70% 35%, 30% 35%);background:black;opacity:0.3">

            </div>
            <div v-for="ele in charts" class="char">
                <div :style="`height:${ele.bloc3}%`" class="bar third"></div>

                <div v-if="ele.open>ele.close" :style="`height:${ele.bloc2}%`" class="bar second-true"></div>
                <div v-if="ele.open<ele.close" :style="`height:${ele.bloc2}%`" class="bar second-false"></div>
                <div :style="`height:${ele.bloc1}%`" class="bar first"></div>

            </div>
        </div>
    </div>


</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import CreateListesjours from './CreateListesjours.vue'
import EditListesjours from './EditListesjours.vue'
import DataModal from '@/components/DataModal.vue'

import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import anime from "animejs"

export default {
    name: 'ListesjoursView',
    components: {DataTable, AgGridTable, CreateListesjours, EditListesjours, DataModal, AgGridBtnClicked},
    data() {

        return {
            questions: [
                {
                    'couleur': 'red',
                    'background': 'red',
                },
                {
                    'couleur': 'blue',
                    'background': 'blue',
                },
                {
                    'couleur': 'blue',
                    'background': 'green',
                },
                {
                    'couleur': 'blue',
                    'background': 'yellow',
                }

            ],
            select: 0,
            choix: -1,
            score: 0,
            lose: false,
            session: 0,
            charts: [
                {time: '2018-11-01', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-11-02', open: 79.16, high: 70.84, low: 36.16, close: 60.72},
                {time: '2018-11-02', open: 76.16, high: 70.84, low: 36.16, close: 70.72},
                {time: '2018-11-03', open: 75.16, high: 82.84, low: 36.16, close: 80.72},
                {time: '2018-11-04', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-11-05', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-11-06', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-11-07', open: 45.12, high: 53.90, low: 45.12, close: 48.09},
                {time: '2018-11-08', open: 60.71, high: 60.71, low: 53.39, close: 59.29},
                {time: '2018-11-09', open: 68.26, high: 68.26, low: 59.04, close: 60.50},
                {time: '2018-11-10', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-11-11', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-11-12', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-11-13', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-11-14', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-11-15', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-11-16', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-11-17', open: 45.12, high: 53.90, low: 45.12, close: 48.09},
                {time: '2018-11-18', open: 60.71, high: 60.71, low: 53.39, close: 59.29},
                {time: '2018-11-19', open: 68.26, high: 68.26, low: 59.04, close: 60.50},
                {time: '2018-11-20', open: 67.71, high: 105.85, low: 66.67, close: 91.04},
                {time: '2018-11-21', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-11-22', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-11-23', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-11-24', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-11-25', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-11-26', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-11-27', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-11-28', open: 111.51, high: 142.83, low: 103.34, close: 131.25},
                {time: '2018-11-29', open: 131.33, high: 151.17, low: 77.68, close: 96.43},
                {time: '2018-11-30', open: 106.33, high: 110.20, low: 90.39, close: 98.10},
                {time: '2018-12-01', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-02', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-03', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-04', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-05', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-06', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-07', open: 45.12, high: 53.90, low: 45.12, close: 48.09},
                {time: '2018-12-08', open: 60.71, high: 60.71, low: 53.39, close: 59.29},
                {time: '2018-12-09', open: 68.26, high: 68.26, low: 59.04, close: 60.50},
                {time: '2018-12-10', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-11', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-12', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-13', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-14', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-15', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-16', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-17', open: 45.12, high: 53.90, low: 45.12, close: 48.09},
                {time: '2018-12-18', open: 60.71, high: 60.71, low: 53.39, close: 59.29},
                {time: '2018-12-19', open: 68.26, high: 68.26, low: 59.04, close: 60.50},
                {time: '2018-12-20', open: 67.71, high: 105.85, low: 66.67, close: 91.04},
                {time: '2018-12-21', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-22', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-23', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-24', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-25', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-26', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-27', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-28', open: 111.51, high: 142.83, low: 103.34, close: 131.25},
                {time: '2018-12-29', open: 131.33, high: 151.17, low: 77.68, close: 96.43},
                {time: '2018-12-30', open: 106.33, high: 110.20, low: 90.39, close: 98.10},
                {time: '2018-12-31', open: 109.87, high: 114.69, low: 85.66, close: 111.26},
                {time: '2018-12-15', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-16', open: 75.16, high: 82.84, low: 36.16, close: 45.72},
                {time: '2018-12-17', open: 45.12, high: 53.90, low: 45.12, close: 48.09},
                {time: '2018-12-18', open: 60.71, high: 60.71, low: 53.39, close: 59.29},
                {time: '2018-12-19', open: 68.26, high: 68.26, low: 59.04, close: 60.50},
                {time: '2018-12-20', open: 67.71, high: 105.85, low: 66.67, close: 91.04},
                {time: '2018-12-21', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-22', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-23', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-24', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-25', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-26', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-27', open: 91.04, high: 121.40, low: 82.70, close: 111.40},
                {time: '2018-12-28', open: 111.51, high: 142.83, low: 103.34, close: 131.25},
                {time: '2018-12-29', open: 131.33, high: 151.17, low: 77.68, close: 96.43},
                {time: '2018-12-30', open: 106.33, high: 110.20, low: 90.39, close: 98.10},
                {time: '2018-12-31', open: 109.87, high: 114.69, low: 85.66, close: 111.26},
            ],
            dataPoints: [
                {
                    nombre: 25,
                    color: 'white'
                },
                {
                    nombre: 25,
                    color: 'black'
                },
                {
                    nombre: 25,
                    color: 'white'
                },
                {
                    nombre: 25,
                    color: 'black'
                }
            ],
            intervalid: null

        }
    },

    computed: {
        routeData: function () {
            let router = {meta: {}}
            if (window.router) {
                try {
                    router = window.router;
                } catch (e) {
                }
            }


            return router
        },
        taille: function () {
            let result = 'col-sm-12'
            if (this.filtre) {
                result = 'col-sm-9'
            }
            return result
        },
    },
    watch: {
        'routeData': {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null)
                this.gridApi.refreshServerSide()
            },
            deep: true
        },
    },
    created() {
        this.url = this.axios.defaults.baseURL + '/api/listesjours-Aggrid',
            this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;

    },
    beforeMount() {
        this.charts = this.charts.map(data => {

            let min = Math.min(data.open, data.close)
            let max = Math.max(data.open, data.close)
            let bloc1 = Math.ceil((min * 100) / 200)
            let bloc2 = Math.ceil(((max - min) * 100) / 200)
            let bloc3 = 100 - (bloc1 + bloc2)
            data['bloc1'] = bloc1
            data['bloc2'] = bloc2
            data['bloc3'] = bloc3
            return data
        })


    },
    mounted() {

        anime({
            targets: '#animejs .el',
            keyframes: [
                {translateY: -40, rotate: 360},
                {translateX: 250, rotate: 360},
                {translateY: 40, rotate: 360},
                {translateX: 0, rotate: 360},
                {translateY: 0, rotate: 360}
            ],
            duration: 4000,
            easing: 'linear',
            loop: true
        });

        // this.intervalid = setInterval(()=>{
        //    let avantDernier=this.dataPoints[this.dataPoints.length-2]
        //    let last=this.dataPoints[this.dataPoints.length-1]
        //    let first=this.dataPoints[0]
        //     let newPoint=[...this.dataPoints]
        //     if(last.nombre==1){
        //         newPoint[this.dataPoints.length-1]=avantDernier
        //     }else{
        //         newPoint[this.dataPoints.length-1]={...last,'nombre':last.nombre-1}
        //     }
        //     if(first.nombre==1){
        //         newPoint[this.dataPoints.length-1]=avantDernier
        //     }else{
        //         newPoint[this.dataPoints.length-1]={...last,'nombre':last.nombre-1}
        //     }
        //     this.dataPoints=newPoint;
        // }, 1000);


    },
    beforeDestroy() {

        clearInterval(this.intervalid)
    },
    methods: {
        run() {
            console.log('couleur changer', this.select)
            this.select = Math.floor((Math.random() * this.questions.length))
            let time = Math.floor(Math.random() * 3000) + 800
            setTimeout(() => {
                if (this.select == this.choix) {
                    this.score++;
                    this.choix = -1
                    this.next()
                } else {
                    this.lose = true
                }
            }, time);
        },
        next() {
            this.select = -1
            let time = Math.floor(Math.random() * 1000) + 500
            setTimeout(() => {

                this.run()
            }, time);
        },
        demarrer() {
            this.score = 0
            this.lose = false
            this.run()
        },
        verifie() {

            return this.choix == this.select
        },
        selectionerCouleur(index) {

            this.choix = index;
        }

    }
}
</script>
<style>
.bar-element {
    width: 50px
}

.c-first {
    background: #004080
}

.c-second {
    background: #ffffff
}

.c-third {
    background: red
}

.question {
    width: 100%;
    background: red;
    height: 150px;
    border-radius: 5px;
    text-align: center;
    color: #fff;

}

.answers {
    display: flex;
    gap: 10px;
    justify-content: space-around;
    flex-wrap: wrap;
}

.answer {
    padding: 10px;
    cursor: pointer;
}

#charts {
    width: 90%;
    height: 90vh;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: space-around;
    margin: 0 auto;
    position: relative;
}

#charts .second-true {
    background: red;
    border-radius: 3px;
    width: 50%
}

#charts .second-false {
    background: #62e543;
    border-radius: 3px;
    width: 50%
}

#charts .char {
    display: inline-block;
    width: 90%;
}

#charts .lines {
    height: 100%;
    position: absolute;
    width: 100%;
    display: flex;
}

#charts .lines .line {
    height: 100%;
    opacity: 0.2
}

#charts .lines .second {
    background: red;
    opacity: 0.2
}

.container-test {
    overflow: hidden;
    height: 100vh;
    width: 100vw;
    shape-inside: circle(160px at 400px 60px);
}

.shaped {
    shape-outside: polygon(30% 34%, 70% 34%, 70% 35%, 30% 35%);
    shape-margin: 20px;
}

</style>
