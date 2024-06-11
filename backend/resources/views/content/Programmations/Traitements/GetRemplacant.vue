<template>
    <div class="parentElement">
        <button class="btn" style="margin:0;padding:0;" @click.prevent="addRemplacant()">{{ actualRemplacant }}</button>

        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='Remplacant'">Remplacement dun agent</div>
            </template>

            <div v-if="formState=='Remplacant'">
                <div class="form-group">
                    <label>Agents</label>
                    <CustomSelect
                        :key="remplacant"
                        :columnDefs="['matricule','nom','prenom']"
                        :filter-key="'baladeur'"
                        :filter-value="this.params.listingId.toString()"
                        :oldValue="remplacantuser"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>{ remplacant=data.id ; remplacantuser=data} "
                        :url="`${axios.defaults.baseURL}/api/users-Aggrid`"
                    />


                </div>
                <div class="form-group">
                    <label>Raison </label>
                    <textarea v-model="description" :class="errors.description?'form-control is-invalid':'form-control'"
                              type="text"></textarea>

                    <div v-if="errors.description" class="invalid-feedback">
                        <template v-for=" error in errors.description"> {{ error[0] }}</template>

                    </div>
                </div>
                <div v-if="canUpdate()" class="d-flex justify-content-between">
                    <button class="btn btn-primary" @click.prevent="saveRemplacement">Valider</button>
                </div>


            </div>


            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>

    </div>


</template>

<script>
import AgGridSearch from "@/components/AgGridSearch.vue";
import VSelect from 'vue-select'

import CustomSelect from "@/components/CustomSelect.vue";

export default {
    name: 'ListingsTraitements',
    components: {AgGridSearch, VSelect, CustomSelect},
    props: [],
    data() {
        return {
            status: 'non',
            isLoading: false,
            cloturer: false,
            oldPointages: [],
            updateOldPointages: 0,
            newProgrammes: false,
            newProgrammesData: {},
            formId: "programmations",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            remplacant: "",
            description: "",
            errors: [],
            usersData: [],
            remplacantkey: 0,
            add: {
                formId: "listings",
                formState: "",
                formData: {},
                formWidth: 'lg',
                formGridApi: {},
                formKey: 0,
                tableKey: 0,
                url: 'http://127.0.0.1:8000/api/listings-Aggrid',
                table: 'Users',
                requette: 18,
                columnDefs: null,
                rowData: null,
                gridApi: null,
                columnApi: null,
                rowModelType: null,
                pagination: true,
                paginationPageSize: 100,
                cacheBlockSize: 10,
                maxBlocksInCache: 1,
                extrasData: {},
            },
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
            console.log('Pointages ==> voici letat actual', this.newProgrammes, this.newProgrammesData)
            if (this.newProgrammes) {
                programmes = this.newProgrammesData
            } else {
                try {
                    programmes = this.params.data.programmes
                        .filter(ele => {
                            let _date = ele.date.split(' ')[0]
                            return _date == this.params.actualDate
                        })
                    programmes = programmes[0]
                } catch (e) {
                }
            }

            console.log('Programmes ==> voici le programmes actual', programmes)

            return programmes
        },
        pointages: function () {
            let pointages = []

            try {
                pointages = this.programmes.preuves
            } catch (e) {
            }

            console.log('Pointages ==> voici le pointages actual', pointages, this.programmes.preuves)

            return pointages
        },
        isPresent: function () {
            return this.pointages.length >= 1 ||
                (this.programmes.debut_realise != null && this.programmes.debut_realise != '') ||
                (this.programmes.fin_realise != null && this.programmes.fin_realise != '')

        },
        agent: function () {
            return this.params.data.user.Selectlabel

        },
        actualRemplacant: function () {
            let data = 'Pas de remplacant'

            try {
                data = this.programmes.remplacant_user.Selectlabel

            } catch (e) {

            }

            return data

        },
        canEdit: function () {

            return this.params.data.programmation.valider2

        },
    },
    watch: {},
    created() {
        this.id = "ListingsTraitements" + Date.now()
        this.formId = 'ListingsTraitements' + "_" + Date.now()


    },
    mounted() {
        console.log('voici les params passer en props pour la mise en place manuel ==>', this.params)

    },
    methods: {
        btnClickedHandler() {
            this.params.clicked(this.params.data);
        },
        canAdmin() {
            // fonction utiliser pour verifier si je peux encore changer le status dun agent
            return this.params.etats == 'manuel'
        },
        canUpdate() {
            // fonction utiliser pour verifier si je peux encore changer le status dun agent
            let can = true;
            try {
                can = this.params.data.programmation.valider2.length < 1
            } catch (e) {
                can = true;
            }
            return can
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
        addRemplacant() {
            try {

                this.remplacant = this.programmes.remplacant
                this.remplacantuser = this.programmes.remplacant_user
                this.description = this.programmes.extra_attributes['extra-data']['description']

            } catch (e) {

            }
            this.remplacantkey++
            this.showForm('Remplacant', {}, this.gridApi)
        },
        saveRemplacement() {

            if (this.description != '') {
                let data = {
                    remplacant: this.remplacant,
                    description: this.description,
                }

                this.axios.post('/api/programmes/' + this.programmes.id + '/update', data).then((response) => {
                    this.newProgrammes = true,
                        this.newProgrammesData = response.data
                    this.$bvModal.hide(this.formId)
                    this.$toast.success('Remplacant effectuer avec success')
                }).catch(error => {

                    this.$toast.error('Remplacant non enregistrer')
                    console.log(error.response.data)
                })
            } else {
                alert('Veuiller preciser la raison ')
            }

        },
        removeRemplacement() {
            let data = {
                remplacant: -1,
                description: "",
            }

            this.axios.post('/api/programmes/' + this.programmes.id + '/update', data).then((response) => {
                this.newProgrammes = true,
                    this.newProgrammesData = response.data

                this.$bvModal.hide(this.formId)
                this.addAbscence()

                this.$toast.success('Remplacant effectuer avec success')
            }).catch(error => {

                this.$toast.error('Remplacant non enregistrer')
                console.log(error.response.data)
            })
        },
        SelectUser(field) {
            this.remplacant = field.id
            this.saveRemplacement();
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
<style scoped>
.parentElement {
    display: flex;
    width: 100%;
    height: 100%;
    align-content: center;
    align-items: center;

}

.boutonAction {
    border: 1px solid #d0d0d0;
    border-radius: 5px;
    padding: 0px 10px;
    cursor: pointer
}

.boutonAction:hover {
    color: green;
    border: 1px solid green;
}
</style>
