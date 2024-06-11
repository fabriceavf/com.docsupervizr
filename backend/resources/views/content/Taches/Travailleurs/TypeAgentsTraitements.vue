<template>
    <div>
        <b-overlay :show="isLoading">
            <div class="parentListingsTraitements">
                <!-- Replace the spans with the v-select component -->
                <!-- <VSelect v-model="selectedOption" :options="dropdownOptions" @input="updateStatus"></VSelect> -->
                <!-- <v-select v-model="selectedOption" :options="dropdownOptions" label="Selectlabel" @input="updateStatus"/> -->

                <label v-for="option in params.dropdownOptions" :key="option.value">
                    <input v-model="selectedOption" :disabled="params.disabled === 0 " :value="option.label"
                           class="fakeCheckBox " type="radio"
                           @change="updateStatus">

                    <!-- <span  class="fakeCheckBox " @click.prevent="addPresence()"></span> -->

                    {{ option.label }}
                </label>
                <!-- <label>
    <input type="radio" v-model="selectedOption" value="1" @change="updateStatus"> Présence
</label>
<label>
    <input type="radio" v-model="selectedOption" value="2" @change="updateStatus"> Absence
</label>
<label>
    <input type="radio" v-model="selectedOption" value="3" @change="updateStatus"> kevin
</label> -->
            </div>
        </b-overlay>
    </div>
</template>

<script>
import AgGridSearch from "@/components/AgGridSearch.vue";
import VSelect from 'vue-select'

export default {
    name: 'TypeAgentsTraitements',
    components: {AgGridSearch, VSelect},
    props: {},
    data() {
        return {
            selectedOption: null, // To store the selected option from the dropdown
            isLoading: false,
            etats: false,
            donnes: {
                typesagents: "",
            }


        };
    },
    computed: {
        isCheck: function () {
            return this.etats === 1;
        },
    },
    watch: {},
    created() {

        // let data = this.params.data;
        this.selectedOption = this.params.data.typesagents;
        // this.selectedOption = this.etats; // Set the default selected option
    },
    mounted() {
        console.log('dropdownOptions', this.selectedOption)
    },
    methods: {
        updateStatus() {
            // Update the status when the dropdown selection changes
            let data = this.params.data;
            this.isLoading = true;
            this.donnes.typesagents = this.selectedOption;
            console.log('dropdownOptions', this.donnes)
            this.axios.post('/api/travailleurs/' + data.id + '/update', this.donnes)
                .then(response => {
                    this.isLoading = false;
                    // this.etats = response.data[day];
                })
                .catch(error => {
                    this.isLoading = false;
                });


        },
    },
};
</script>

<style scoped>
.fakeCheckBox {
    width: 20px;
    height: 20px;
    border-radius: 5px;
    border-color: red;
    display: inline-block;
    border: 2px solid #867f7f;
    cursor: pointer
}
</style>
