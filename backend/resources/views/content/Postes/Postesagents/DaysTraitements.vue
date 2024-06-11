<template>
    <div>
        <b-overlay :show="isLoading">
            <div class="parentListingsTraitements">
                <span v-if="isCheck" class="fakeCheckBox cocher " @click.prevent="addAbscence()"></span>
                <span v-else class="fakeCheckBox " @click.prevent="addPresence()"></span>
            </div>
        </b-overlay>

    </div>


</template>

<script>
import AgGridSearch from "@/components/AgGridSearch.vue";
import VSelect from 'vue-select'


export default {
    name: 'DaysTraitements',
    components: {AgGridSearch, VSelect},
    props: [],
    data() {
        return {
            status: 'non',
            isLoading: false,
            etats: false,
        }
    },
    computed: {
        isCheck: function () {
            return this.etats == 1

        },
    },
    watch: {},
    created() {
        let day = this.params.day.toLowerCase()
        let data = this.params.data
        this.etats = data[day]


    },
    mounted() {
        let day = this.params.day.toLowerCase()
        let data = this.params.data
        // console.log('voici les params passer en props pour la mise en place manuel ==>', day, data, data[day], this.params)
    },
    methods: {
        addPresence() {
            let data = this.params.data
            let day = this.params.day.toLowerCase()
            this.isLoading = true
            let donnes = {}
            donnes[day] = 1
            this.axios.post('/api/postesagents/' + data.id + '/update', donnes)
                .then(response => {
                    this.isLoading = false
                    this.etats = response.data[day]
                })
                .catch(error => {
                    this.isLoading = false
                })
        },
        addAbscence() {
            let data = this.params.data
            let day = this.params.day.toLowerCase()
            this.isLoading = true
            let donnes = {}
            donnes[day] = 2
            this.axios.post('/api/postesagents/' + data.id + '/update', donnes)
                .then(response => {
                    this.isLoading = false
                    this.etats = response.data[day]
                })
                .catch(error => {
                    this.isLoading = false
                })
        },

    }
}
</script>
<style scoped>
.fakeCheckBox {
    width: 25px;
    height: 25px;
    border-radius: 5px;
    border-color: red;
    display: inline-block;
    border: 2px solid #867f7f;
    cursor: pointer
}

.cocher {
    background: green;

}
</style>
