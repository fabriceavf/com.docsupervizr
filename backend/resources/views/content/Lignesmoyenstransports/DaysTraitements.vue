<template>
    <div>
        <b-overlay :show="isLoading">
            <div class="parentListingsTraitements">
                <span v-if="isCheck" :class="{ disabled: params.disabled === 0 }" class="fakeCheckBox cocher"
                      @click.prevent="params.disabled !== 0 && addAbscence()"></span>
                <span v-else :class="{ disabled: params.disabled === 0 }" class="fakeCheckBox"
                      @click.prevent="params.disabled !== 0 && addPresence()"></span>
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
            this.axios.post('/api/lignesmoyenstransports/' + data.id + '/update', donnes)
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
            this.axios.post('/api/lignesmoyenstransports/' + data.id + '/update', donnes)
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

.disabled {
    opacity: 0.5; /* Vous pouvez ajuster l'apparence pour montrer qu'il est désactivé */
    cursor: not-allowed;
}
</style>
