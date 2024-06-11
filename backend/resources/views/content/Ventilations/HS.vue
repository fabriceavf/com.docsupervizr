<template>
    <div>
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='showDetailDay'">Details</div>
            </template>

            <div v-if="formState=='showDetailDay'">
                {{ programmes.id }}
                <DetailDaysView
                    :key="programmes.id"
                    :data="programmes"
                    @refresh="refresh"
                ></DetailDaysView>

            </div>


            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <b-overlay :show="isLoading">
            <template>
                <div :style="style" disabled @click="detailDay()">
                    <span> {{ volumeHoraire }} </span>

                </div>

            </template>


        </b-overlay>

    </div>


</template>

<script>
import DetailDaysView from "./../Programmations/DetailDaysView.vue";
import {getPointageState} from '@/libs/utils.js'

export default {
    name: 'HS',
    components: {DetailDaysView},
    props: [],
    data() {
        return {
            formId: "programmations",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            status: 'non',
            isLoading: false,
            cloturer: false
        }
    },
    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
                }
            } catch (e) {
            }

            return router;
        },
        programmes: function () {
            let programmes = {}
            try {
                programmes = this.params.data.programmes.filter(ele => {
                    let _date = ele.date.split(' ')[0]
                    return _date == this.params.actualDate
                })
                programmes = programmes[0]
            } catch (e) {

            }
            console.log('voici le programmes actual', programmes)

            return programmes
        },
        pointages: function () {
            let pointages = []
            try {
                let programmes = this.params.data.programmes.filter(ele => {
                    let _date = ele.date.split(' ')[0]
                    return _date == this.params.actualDate
                })
                pointages = programmes[0].preuves
            } catch (e) {

            }
            console.log('voici le programmes actual', pointages)

            return pointages
        },
        isPresent: function () {
            return this.pointages.length > 1

        },
        volumeHoraire: function () {
            let volume = 0;
            try {
                volume = (this.programmes.hs_in_faction + this.programmes.hs_hors_faction) * 60
            } catch (e) {
            }
            return this.toHoursAndMinutes(volume)
        },
        style: function () {
            let style = ["padding: 5px", "justify-content: center", "text-align: center", "color: #fff"]


            let etat = this.state
            switch (etat) {
                case 'ABSCENCESNONJUSTIFIER':
                    style.push("background: red")
                    break;
                case 'ABSCENCESJUSTIFIER':
                    style.push("background: #69b76d")
                    break;
                case 'INCOMPLETTRAITER':
                    style.push("background: #69b76d")
                    break;
                case 'INCOMPLETNONTRAITER':
                    style.push("background: #ff9f43")
                    break;
                case 'DEPASSEMENTNONTRAITER':
                    style.push("background: red")
                    break;
                case 'DEPASSEMENTREFUSER':
                    style.push("background: #69b76d")
                    break;
                case 'DEPASSEMENTACCEPTER':
                    style.push("background: #69b76d")
                    break;
                default:
                    style.push("background: #69b76d")
                // code block
            }
            console.log('on veut determiner', etat)
            return style.join(';')
        },
        state() {
            return getPointageState(this.programmes)

        },

    },
    watch: {
        'programmes': {
            handler: function (after, before) {
                console.log('voici les params1 ==>', after, before)
            },
            deep: true
        },
    },
    created() {
        this.id = "ListingsTraitements" + Date.now()

        this.formId = 'Preuves' + "_" + Date.now()
        // let _etats = 'non'
        // if (this.params.data.present == 'oui') {
        //     _etats = 'oui'
        // }
        // if (this.params.etats == "manuel-cloturer" || this.params.etats == "automatique-cloturer") {
        //     this.cloturer = true
        // }
        // this.status = _etats

    },
    mounted() {
    },
    methods: {
        toHoursAndMinutes(totalMinutes) {
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;

            return `${this.padToTwoDigits(hours)}H:${this.padToTwoDigits(minutes.toFixed(0))}`;
        },
        padToTwoDigits(num) {
            return num.toString().padStart(2, '0');
        },
        btnClickedHandler() {
            this.params.clicked(this.params.data);
        },
        addPresence() {
            this.isLoading = true
            let data = {}
            data.user_id = this.params.data.id_user
            data.date_id = this.params.data.id_date
            data.presence = 'oui'
            this.axios.post('/api/listingsetatsActionPresence', data)
                // this.axios.post('/api/listingsetats/action?action=presence', data)
                .then(response => {
                    this.status = 'oui'
                })
                .finally(() => {
                    this.isLoading = false
                })
        },
        addAbscence() {

            this.isLoading = true
            let data = {}
            data.user_id = this.params.data.id_user
            data.date_id = this.params.data.id_date
            data.presence = 'non'
            this.axios.post('/api/listingsetatsActionPresence', data)
                .then(response => {
                    this.status = 'non'
                })
                .finally(() => {
                    this.isLoading = false
                })
        },
        canAdmin() {
            // fonction utiliser pour verifier si je peux encore changer le status dun agent
            return this.params.etats == 'manuel'
        },
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('showDetailDay', {}, this.gridApi)
        },
        refresh() {
            this.params.refresh()
        },
        detailDay() {
            console.log('voici les pointage ===>', this.pointages)
            this.showForm('showDetailDay', {}, this.gridApi)
        },
        showForm(type, data, gridApi, width = 'lg') {
            this.formKey++
            this.formWidth = width
            this.formState = type
            this.formData = data
            this.formGridApi = gridApi
            this.$bvModal.show(this.formId)
        },
    }
}
</script>
<style>
.danger {
    padding: 5px;
    background: #dc8282;

    justify-content: center;
    text-align: center;
    color: #fff;
    /*border-radius: 5px;*/
}

.present {

    /*border-radius: 5px;*/
}
</style>
