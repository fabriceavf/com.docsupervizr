<template>
    <div>
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='showDetailDay'">Details</div>
            </template>

            <div v-if="formState=='showDetailDay'">3
                <DetailDaysView
                    :key="programmes.id"
                    :data="programmes"
                ></DetailDaysView>

            </div>


            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <b-overlay :show="isLoading">
            <template v-if="!canAdmin()">
                <div v-if="isPresent" class="present" disabled @click="detailDay()">
                    <span> <i class="fa-solid fa-lock"></i>Present ({{ pointages.length }} )Pts</span>

                </div>


                <div v-else class="danger" disabled @click="detailDay()"><i class="fa-solid fa-lock"></i> Abscent
                    ({{ pointages.length }} )Pts
                </div>
            </template>
            <template v-else>
                <div v-if="isPresent" class="present" @click.prevent="addAbscence()"> Present</div>
                <div v-else class="danger" @click.prevent="addPresence()"> Abscent</div>
            </template>

        </b-overlay>

    </div>


</template>

<script>
import DetailDaysView from "./DetailDaysView.vue";

export default {
    name: 'Preuves',
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
            return this.pointages.length >= 1

        }

    },
    watch: {},
    created() {
        this.id = "ListingsTraitements" + Date.now()
        this.formId = 'Preuves' + "_" + Date.now()
    },
    mounted() {
        console.log('voici les params ==>', this.params)
    },
    methods: {
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
                // this.axios.post('/api/listingsetats/action?action=presence', data)
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
    padding: 5px;
    background: #69b76d;

    justify-content: center;
    text-align: center;
    color: #fff;
    /*border-radius: 5px;*/
}
</style>
