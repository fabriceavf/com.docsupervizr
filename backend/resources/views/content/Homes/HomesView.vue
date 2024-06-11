<template>
    <div class="container-fluid">


        <b-row>
            <b-col v-if="$domaine == 'sgs'" lg="4" sm="8">


                <statistic-card-horizontal-sgs-poste :donner1="$routeData.meta.effectifsPosteClientCountZone"
                                                     :donner2="$routeData.meta.effectifsPosteOperationnelCountZone"
                                                     :donner3="$routeData.meta.effectifsPosteInterneCountZone"
                                                     :donner4="$routeData.meta.remplacantCount"
                                                     :donner5="$routeData.meta.congeCount"
                                                     :statistic="'Importé le: ' + formattedDatePoste"
                                                     :statistic-title="$routeData.meta.effectifsPosteClientCountZone + $routeData.meta.effectifsPosteOperationnelCountZone + $routeData.meta.effectifsPosteInterneCountZone"
                                                     Title="TOTAL POSTES SGS" Titledonner1="Postes client facturé"
                                                     Titledonner2="Postes opération" Titledonner3="Postes Interne"
                                                     Titledonner4="Remplacant/Baladeur"
                                                     Titledonner5="Dont Congés" background="rgb(40, 167, 69)"
                                                     color="danger"
                                                     icon="ActivityIcon"/>
            </b-col>
            <!-- <b-col lg="4" sm="8">
                <statistic-card-horizontal-sgs-poste :donner2="$routeData.meta.usersSalariesAffectesCount"
                    :donner3="usersNonAffectesCount" :statistic="'Importé le: ' + formattedDateAgents"
                    :statistic-title="$routeData.meta.usersSalariesCount" Title="SALARIES" Titledonner1=""
                    Titledonner2="Affectés" Titledonner3="Non affectés" Titledonner4="" Titledonner5="" Titledonner6=""
                    background="#00cfe8" color="success" icon="UserCheckIcon" />
            </b-col>
            <b-col lg="4" sm="8">
                <statistic-card-horizontal-sgs-poste :donner2="$routeData.meta.usersONEAffectesCount"
                    :donner3="usersONENonAffectesCount" :statistic="'Importé le: ' + formattedDateAgentsONE"
                    :statistic-title="$routeData.meta.usersONECount" Title="ONE" Titledonner1=""
                    Titledonner2="Affectés " Titledonner3="Non affectés" Titledonner4="" Titledonner5="" Titledonner6=""
                    background="rgb(255, 159, 67)" color="success" icon="UsersIcon" />
            </b-col> -->
            <!-- <div > -->
            <b-col v-for="item in typeseffectifsget" :key="item.id" lg="4" sm="8">
                <statistic-card-horizontal-sgs-poste v-if="$domaine == 'sgs'" :Title="item.libelle"
                                                     :donner2="item.TotalAffecterCount"
                                                     :donner3="item.TotalNonAffecterCount"
                                                     :statistic="'Importé le: ' + item.DateImports"
                                                     :statistic-title="item.TotalAffecterCount+item.TotalNonAffecterCount"
                                                     Titledonner1=""
                                                     Titledonner2="Affectés"
                                                     Titledonner3="Non affectés (sur effectif total)" Titledonner4=""
                                                     Titledonner5=""
                                                     Titledonner6=""
                                                     background="rgb(255, 159, 67)" color="success" icon="UsersIcon"/>

                <statistic-card-horizontal-sgs-poste v-else :Title="item.libelle" :donner2="item.TotalAffecterCount"
                                                     :donner3="item.TotalNonAffecterCount"
                                                     :statistic="'Importé le: ' + item.DateImports"
                                                     :statistic-title="item.TotalCount" Titledonner1=""
                                                     Titledonner2="Affectés"
                                                     Titledonner3="Non affectés" Titledonner4="" Titledonner5=""
                                                     Titledonner6=""
                                                     background="rgb(255, 159, 67)" color="success" icon="UsersIcon"/>
            </b-col>

            <!-- </div> -->
        </b-row>
        <div class="col-sm-12 card">
            <div class="card-body allBoutons">
                <!-- <input v-model="dateselectioner" class="form-control" placeholder="Veuillez selectioner la date"
                       style="width: auto !important" type="date"/> -->
                <input v-model="week" class="form-control" placeholder="Veuillez selectioner le mois"
                       style="width: auto !important" type="week"/>
                <button v-b-tooltip.hover :style="actualPage == '0' ? 'border: 3px solid  green' : ''" class="btn"
                        style="" @click.prevent="togglePage('0')">
                    <div class="iconParent">
                        <span> <i class="fa-solid fa-filter"></i> Presence validé 0
                        </span>
                    </div>
                </button>

                <button v-b-tooltip.hover :style="actualPage == '1' ? 'border:3px solid  green' : ''" class="btn"
                        style="" @click.prevent="togglePage('1')">
                    <div class="iconParent">

                        <span> <i class="fa-solid fa-filter"></i> Presence validé 1</span>

                    </div>
                </button>


                <button v-b-tooltip.hover :style="actualPage == '2' ? 'border:3px solid  green' : ''" class="btn"
                        style="" @click.prevent="togglePage('2')">
                    <div class="iconParent">

                        <span> <i class="fa-solid fa-filter"></i> Presence validé 2</span>

                    </div>
                </button>
            </div>
        </div>
        <template>
            <div class="col-sm-12">
                <!-- <div v-for="items  in zonesget"
                    v-if="$routeData.meta.usersconnect == '5' || $routeData.meta.usersconnect == '7' || $routeData.meta.usersconnect == '6' || $routeData.meta.usersconnecttype == '4'"
                    class="row" style="justify-content:space-between"> -->
                <div v-for="items  in zonesget" class="row" style="justify-content:space-between">
                    <!-- <div v-if="hasDataForWeek(items)"  v-for="number in [1, 2, 3]" class="card col-sm custom-card"> -->
                    <div v-for="number in [1, 2, 3]" class="card col-sm custom-card">
                        <div class="card-body" style="padding: 2px !important;">
                            <div class="row">
                                <div class="col-12">
                                    <p class="card-text h4 text-center font-weight-bold">{{
                                            items[`nom${number}`]
                                        }} </p>
                                </div>
                                <div v-if="hasDataForJour(items, number)"
                                     :class="hasDataForNuit(items, number) ? 'col-6' : 'col-12'"
                                     style="text-align:center">

                                    <!-- <vue-apex-charts
                                        :key="`client-${items.id}-${number}`"
                                        :height="120"
                                        :options=" camenber.chartOptions"
                                        :series="[ items[`presentJour${number}`],items[`abscentJour${number}`]]"
                                        :width="120"
                                        title="jour"
                                    /> -->

                                    <div style="height: 300px">
                                        <ag-charts-vue :key="number"
                                                       :options="items[`optionJour${number}`]"></ag-charts-vue>
                                    </div>
                                    <!-- <span
                                        style="font-size:13px">Jour {{ items[`presentJour${number}`] }} / {{ items[`abscentJour${number}`] }}</span> -->

                                </div>
                                <div v-if="hasDataForNuit(items, number)"
                                     :class="hasDataForJour(items, number) ? 'col-6' : 'col-12'"
                                     style="text-align:center">
                                    <!-- <vue-apex-charts
                                        :height="120"
                                        :options="camenber.chartOptions"
                                        :series="[items[`presentNuit${number}`],items[`abscentNuit${number}`]]"
                                        :width="120"
                                    /> -->
                                    <div style="height: 300px">
                                        <ag-charts-vue :key="number"
                                                       :options="items[`optionNuit${number}`]"></ag-charts-vue>
                                    </div>
                                    <!-- <span style="font-size:13px">{{ items.NuitClient }}</span> -->
                                    <!-- <span
                                        style="font-size:13px">Nuit {{ items[`presentNuit${number}`] }} / {{ items[`abscentNuit${number}`] }}</span> -->

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </template>


        <div class="row col-sm-12" style="display: flex;justify-content: space-around">

            <div v-if="$domaine != 'sobraga'" class="col-sm-6">
                <div class="col-sm-12">
                    <h3>Statistique de pointage</h3>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Mois </label>
                                <input v-model="month" class="form-control" type="month"/>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label>pointeuses </label>
                                <CustomSelect :key="{}" :columnDefs="['libelle']" :oldValue="{}"
                                              :renderCallBack="(data) => `${data.Selectlabel}`"
                                              :selectCallBack="(data) => pointeuses = data.id"
                                              :url="`${axios.defaults.baseURL}/api/pointeuses-Aggrid`" filter-key=""
                                              filter-value=""/>
                            </div>
                        </div>


                    </div>
                    <div style="height: 500px">
                        <ag-charts-vue :key="optionsKey" :options="options"></ag-charts-vue>
                    </div>
                </div>

            </div>
            <div v-if="$domaine != 'sobraga'" class="col-sm-6">
                <div class="col-sm-12">
                    <h3>Statistique de Presences</h3>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Mois </label>
                                <input v-model="month2" class="form-control" type="month"/>
                            </div>
                        </div>
                        <!-- <div class="col">
                            <div class="form-group">
                                <label>pointeuses </label>
                                <CustomSelect :key="{}" :columnDefs="['libelle']" :oldValue="{}"
                                    :renderCallBack="(data) => `${data.Selectlabel}`"
                                    :selectCallBack="(data) => pointeuses2 = data.id"
                                    :url="`${axios.defaults.baseURL}/api/pointeuses-Aggrid`" filter-key=""
                                    filter-value="" />
                            </div>
                        </div> -->
                        <div class="col">
                            <label>validation </label>
                            <!-- <v-select
                                v-model="validation"
                                :options="validationsData"
                                label="Selectlabel"
                                multiple
                            /> -->
                            <v-select v-model="validation" :options="validationsData" label="Selectlabel"/>
                        </div>
                    </div>
                    <div style="height: 500px">
                        <ag-charts-vue :key="optionsKey2" :options="options2"></ag-charts-vue>
                    </div>
                </div>

            </div>
            <div v-if="$domaine == 'sobraga'" class="col-sm">
                <div class="col-sm-12">
                    <h3>Statistique de Rondes</h3>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Mois {{ month3 }} </label>
                                <input v-model="month3" class="form-control" type="month"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Sites </label>
                                <CustomSelect :key="site" :columnDefs="['libelle']" :oldValue="site"
                                              :renderCallBack="(data) => `${data.Selectlabel}`"
                                              :selectCallBack="(data) => site3 = data.id"
                                              :url="`${axios.defaults.baseURL}/api/sites-Aggrid`" filter-key=""
                                              filter-value=""/>
                            </div>
                        </div>
                    </div>
                    <div style="height: 500px">
                        <ag-charts-vue :key="optionsKey3" :options="options3"></ag-charts-vue>
                    </div>
                </div>

            </div>
            <div v-if="$domaine == 'sgs'" class="col-sm-12 mb-2">

                <h3>listings non validé</h3>
                <AgGridTable :id="id" :key="tableKey" :cacheBlockSize="cacheBlockSize" :columnDefs="columnDefs5"
                             :extrasData="extrasData3" :maxBlocksInCache="maxBlocksInCache" :pagination="pagination"
                             :paginationPageSize="paginationPageSizeclient" :rowData="rowData"
                             :rowModelType="rowModelType"
                             :show-export="false" :url="url2" className="ag-theme-alpine" domLayout="autoHeight"
                             rowSelection="multiple" @gridReady="onGridReady">
                    <template #header_buttons>
                        <div v-if="!$routeData.meta.hideCreate" class="btn btn-primary" @click="openCreate">
                            <i class="fa fa-plus"></i>
                            Nouveau
                        </div>
                    </template>
                </AgGridTable>

            </div>

        </div>
    </div>
</template>


<script>
import CustomFiltre from "@/components/CustomFiltre.vue";
import CustomSelect from "@/components/CustomSelect.vue";
import VueApexCharts from 'vue-apexcharts'
// import {BCol, BRow} from 'bootstrap-vue'
import moment from "moment";
import StatisticCardVertical from "@core/components/statistics-cards/StatisticCardVertical.vue";
import StatisticCardHorizontal from "@core/components/statistics-cards/StatisticCardHorizontal.vue";
import StatisticCardWithAreaChart from "@core/components/statistics-cards/StatisticCardWithAreaChart.vue";
import StatisticCardWithLineChart from "@core/components/statistics-cards/StatisticCardWithLineChart.vue";
import StatisticCardHorizontalSgs from "@core/components/statistics-cards/StatisticCardHorizontalSGS.vue";
import StatisticCardHorizontalSgsPoste from "@core/components/statistics-cards/StatisticCardHorizontalSGSPoste.vue";

import AgGridTable from "@/components/AgGridTable.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";
import DataTable from "@/components/DataTable.vue";
import {BCol, BRow} from "bootstrap-vue";
import VSelect from "vue-select";
import Chart from "chart.js/auto";
import {AgChartsVue} from 'ag-charts-vue';

const $earningsStrokeColor2 = 'rgba(2,255,114,0.4)'
const $earningsStrokeColor3 = '#d1124a'
export default {
    name: "HomeView",
    components: {
        DataTable,
        AgGridTable,
        AgGridBtnClicked,
        BCol,
        BRow,
        VSelect, CustomSelect,
        StatisticCardVertical,
        StatisticCardHorizontal,
        StatisticCardWithAreaChart,
        StatisticCardWithLineChart,
        CustomFiltre,
        StatisticCardHorizontalSgs,
        StatisticCardHorizontalSgsPoste,
        'ag-charts-vue': AgChartsVue,
        VueApexCharts,
    },
    data() {
        return {
            camenber: {
                series: [53, 16, 31],
                chartOptions1: {
                    chart: {
                        type: 'donut',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {show: false,},
                    labels: ['Present', 'Abscent'],
                    stroke: {width: 0},
                    colors: [$earningsStrokeColor2, $earningsStrokeColor3],
                    grid: {
                        padding: {
                            right: -20,
                            bottom: -8,
                            left: -20,
                        },
                    },
                    plotOptions: {
                        pie: {
                            startAngle: -10,
                            donut: {
                                labels: {
                                    show: true,
                                    name: {
                                        offsetY: -15,
                                    },
                                    value: {
                                        offsetY: -15,
                                        formatter(val) {
                                            // eslint-disable-next-line radix
                                            return `${parseInt(val)}%`
                                        },
                                    },
                                    // total: {
                                    //     show: true,
                                    //     offsetY: 15,
                                    //     label: 'App',
                                    //     formatter() {
                                    //         return '53%'
                                    //     },
                                    // },
                                },
                            },
                        },
                    },
                    responsive: [],
                },
                chartOptions: {
                    chart: {
                        width: '100%',
                        type: 'pie',
                    },
                    labels: ["Present", "Abscent"],

                    colors: [$earningsStrokeColor2, $earningsStrokeColor3],
                    plotOptions: {
                        pie: {
                            dataLabels: {
                                offset: 5
                            },
                        }
                    },
                    dataLabels: {
                        enabled: false,
                        formatter(val, opts) {
                            const name = opts.w.globals.labels[opts.seriesIndex]
                            return [name, val.toFixed(1) + '%']
                        }
                    },
                    legend: {
                        show: false
                    }
                },


            },
            id: 'Dom10',
            nb_employes: 0,
            nb_enrolements: 0,
            nb_taches: 0,
            exceptions: 0,
            nb_absences: 0,
            zoneselectionner: [],
            directionselectionner: [],
            nb_presences: 0,
            onChange: 1,
            formId: "transactions",
            formState: "",
            formData: {},
            formWidth: "lg",
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            tableKey1: 0,
            validationsData: [],
            url: "http://127.0.0.1:8000/api/transactions-Aggrid",
            url2: "http://127.0.0.1:8000/api/programmations-Aggrid",
            table: "transactions",
            requette: 2,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 10,
            paginationPageSizeclient: 10,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            zonesData: [],
            zonesget: [],
            dateImportAgents: [],
            dateImportAgentsOne: [],
            dateImportPoste: [],
            directionsget: [],
            typeseffectifsget: [],
            usersNonAffectesCount: [],
            usersNonAffectesCountZone: [],
            usersONENonAffectesCount: [],
            usersONENonAffectesCountZone: [],
            postesData: [],
            clientsData: [],
            factionsData: [],
            pointeusesData: [],
            month: "",
            faction: "",
            month2: "",
            month3: "",
            validation: "",
            faction2: "",
            zones: "",
            actualZone: "",
            actualDirection: "",
            postes: "",
            clients: "",
            actualPage: '',
            pointeuses: "",
            jourselectioner: null,
            dateselectioner: null,
            week: null,
            pointeuses2: "",
            site3: "",
            extrasData1: {
                debut: "",
                fin: "",
                zoneselectionner: [],
                directionselectionner: [],

            },
            options: null,
            optionsKey: 0,
            options2: null,
            optionsKey2: 0,
            options3: null,
            optionsKey3: 0,
            maxElement: []
        };
    },
    computed: {

        $domaine: function () {
            let domaine = 'supervizr';
            try {
                domaine = window.domaine
            } catch (e) {
            }

            console.log('voila le domaine ==>', domaine)
            return domaine;
        },
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != "undefined") {
                    router = window.routeData;
                }
            } catch (e) {
            }

            return router;
        },
        taille: function () {
            let result = "col-sm-12";
            if (this.filtre) {
                result = "col-sm-9";
            }
            return result;
        },
        extrasData: function () {
            let params = {}
            if (this.month) {
                params.month = this.month
            }
            if (this.pointeuses) {
                params.pointeuses = this.pointeuses
            }
            if (this.postes) {
                params.postes = this.postes
            }
            if (this.clients) {
                params.clients = this.clients
            }
            if (this.zones) {
                params.zones = this.zones
            }
            if (this.faction) {
                params.faction = this.faction
            }
            if (this.faction2) {
                params.faction2 = this.faction2
            }
            if (this.month2) {
                params.month2 = this.month2
            }
            if (this.validation) {
                params.validation = this.validation
            }
            if (this.pointeuses2) {
                params.pointeuses2 = this.pointeuses2
            }
            if (this.directionselectionner) {
                params.directionselectionner = this.directionselectionner
            }

            return params;

        },
        extrasData4: function () {
            let params = {}

            if (this.month3) {
                params.month = this.month3
            }
            if (this.site3) {
                params.site = this.site3
            }
            return params;
        },
        extrasData2: function () {

            let params = {};
            if (!this.zoneselectionner) {
                // params["id"] = { values: [0], filterType: "set" };
            } else {
                this.tableKey++;
                this.tableKey1++;

                return {
                    baseFilter: params,
                    jourselectioner: this.jourselectioner,
                    zoneselectionner: this.zoneselectionner,
                    directionselectionner: this.directionselectionner,
                };
            }


            if (!this.jourselectioner) {
                // params["id"] = { values: [0], filterType: "set" };
            } else {
                this.tableKey1++;

                return {
                    baseFilter: params,
                    jourselectioner: this.jourselectioner,
                    zoneselectionner: this.zoneselectionner,
                    directionselectionner: this.directionselectionner,
                };
            }

        },
        extrasData3: function () {

            let params = {};
            params["typelistings"] = {values: ['a-valider'], filterType: "set"};
            return {
                baseFilter: params
            };

        },
        formattedDatePoste() {
            // Utilisez Moment.js pour formater la date

            try {
                return moment(this.dateImportPoste).format('DD/MM/YYYY');
            } catch (e) {
                return 'date inconnu';
            }
            // Vous pouvez ajuster le format en fonction de vos besoins
        },
    },
    watch: {
        $route: {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null);
                this.gridApi.refreshServerSide();
                this.tableKey++;
                this.tableKey1++;
            },
            deep: true,
        },
        dateselectioner: {
            handler: function (after, before) {
                if (after !== before) {
                    let inputUrl = new URL(window.location.href);
                    inputUrl.searchParams.append('date', after)
                    window.location.href = inputUrl.href
                }
            },
            deep: true,
        },
        week: {
            handler: function (after, before) {
                console.log('okk', after, before, this.week)

                console.log('okk3', after, this.week)
                let inputUrl = new URL(window.location.href);
                // Supprimer le paramètre 'week'
                inputUrl.searchParams.delete('week')
                inputUrl.searchParams.append('week', after)
                if (before) {
                    window.location.href = inputUrl.href
                }
                if (after == this.week) {
                    console.log('okk4', after, before, this.week)
                }
            },
            deep: true,
        },
        month: {
            handler: function (after, before) {
                this.getStats();
            },
            deep: true,
        },
        month2: {
            handler: function (after, before) {
                this.getStats2();
            },
            deep: true,
        },
        month3: {
            handler: function (after, before) {
                this.getStats3();
            },
            deep: true,
        },
        site3: {
            handler: function (after, before) {
                this.getStats3();
            },
            deep: true,
        },
        validation: {
            handler: function (after, before) {
                this.getStats2();
            },
            deep: true,
        },
        clients: {
            handler: function (after, before) {
                this.getStats();
            },
            deep: true,
        },
        postes: {
            handler: function (after, before) {
                this.getStats();
            },
            deep: true,
        },
        directionselectionner: {
            handler: function (after, before) {
                this.getStats();
            },
            deep: true,
        },
        zones: {
            handler: function (after, before) {
                this.getStats();
            },
            deep: true,
        },
        pointeuses: {
            handler: function (after, before) {
                this.getStats();
            },
            deep: true,
        },
        faction: {
            handler: function (after, before) {
                this.getStats();
            },
            deep: true,
        },
        pointeuses2: {
            handler: function (after, before) {
                this.getStats2();
            },
            deep: true,
        },
        faction2: {
            handler: function (after, before) {
                this.getStats2();
            },
            deep: true,
        },
    },
    created() {
        (this.url = this.axios.defaults.baseURL + "/api/transactions-Aggrid"),
            (this.url2 = this.axios.defaults.baseURL + "/api/programmations-Aggrid"),
            (this.url3 = this.axios.defaults.baseURL + "/api/zones-Aggrid"),
            (this.url4 = this.axios.defaults.baseURL + "/api/clients-Aggrid"),
            (this.formId = this.table + "_" + Date.now());
        this.rowBuffer = 0;
        this.rowModelType = "serverSide";
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;
        this.extrasData1.debut = new Date().toISOString().slice(0, 11) + '00:00';
        this.extrasData1.fin = new Date().toISOString().slice(0, 11) + '23:59';
        let i = 0
        while (i <= 100) {
            let donnes = {}
            donnes.index = i
            donnes.ouverture = Math.floor(Math.random() * 11)
            donnes.cloture = Math.floor(Math.random() * 11)
            donnes.taille = Math.abs(donnes.cloture - donnes.ouverture) * 100 / 10 * 150 / 100
            donnes.tailleBas = Math.min(donnes.cloture, donnes.ouverture) * 100 / 10 * 150 / 100
            donnes.tailleHaut = Math.abs(150 - (donnes.taille + donnes.tailleBas))
            console.log('voici la taille', donnes)

            this.maxElement.push(donnes)
            i = i + 1
        }
        // Récupérez la date depuis l'URL lorsque le composant est créé
        //   const urlParams = new URLSearchParams(window.location.search);
        //     const dateFromUrl = urlParams.get('date');
        //     if (dateFromUrl) {
        //       this.dateselectioner = dateFromUrl;
        //     }
    },
    beforeMount() {
        this.columnDefs = [
            {
                field: "punch_time",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Heure",
                valueFormatter: (params) => {
                    let retour = params.value;
                    try {
                        retour = moment(params.value).format(
                            "DD/MM/YYYY à HH:mm"
                        );
                    } catch (e) {
                    }
                    return retour;
                },
            },
            {
                field: "matricule",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "matricule",
            },
            {
                field: "nom",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Nom",
            },
            {
                field: "Site",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "site",
            },
        ];
        this.columnDefs2 = [
            {
                field: "semaine ",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Semaine",
            },
            {
                field: "tache.libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Tache",
            },
            {
                field: "superviseur",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "Superviseur",
            },
        ];

        this.columnDefs3 = [
            {
                field: "province.libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "province",
            },
            {
                field: "libelle",
                sortable: true,
                filter: "agTextColumnFilter",
                filterParams: {suppressAndOrCondition: true},
                headerName: "zone",
            },
            {
                field: "total_contrat_jour",
                sortable: true,
                headerName: "Effectifs Contrat Jour",
                width: 150
            },
            {
                field: "total_contrat_nuit",
                sortable: true,
                headerName: "Effectifs Contrat Nuit",
                width: 150
            },
            {
                field: "total_effectif_jour",
                sortable: true,
                headerName: "Effectifs Affecté Jour",
                width: 150
            },
            {
                field: "total_effectif_nuit",
                sortable: true,
                headerName: "Effectifs Affecté Nuit",
                width: 150
            },
            {
                field: "total_present_jour",
                sortable: true,
                headerName: "Validé 0 Jour",
                width: 150
            },
            {
                field: "total_present_nuit",
                sortable: true,
                headerName: "Validé 0 Nuit",
                width: 150
            },
            {
                field: "total_vacation_jour",
                sortable: true,
                headerName: "Validé 2 Jour",
                width: 150
            },
            {
                field: "total_vacation_nuit",
                sortable: true,
                headerName: "Validé 2 Nuit",
                width: 150
            },
        ];

        this.columnDefs4 = [
            {
                field: "libelle",
                sortable: true,
                width: 400,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'libelle',
            },
            {
                field: "CountPresentJour",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'P J',
            }, {
                field: "CountPresentNuit",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'P N',
            }, {
                field: "CountAbsentJour",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'Abs J',
            }, {
                field: "CountAbsentNuit",
                sortable: true,
                filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                headerName: 'Abs N',
            },
            // {

            //     filter: 'agTextColumnFilter', filterParams: { suppressAndOrCondition: true, },
            //     headerName: 'libelle',
            // },
            {
                hide: true,
                suppressColumnsToolPanel: true,

                headerName: 'zone',
                field: 'zone_id',
                valueFormatter: params => {
                    let retour = ''
                    try {
                        return params.data['zone']['Selectlabel']
                    } catch (e) {


                    }
                    return retour
                },

                filter: "CustomFiltre",
                filterParams: {
                    url: this.axios.defaults.baseURL + '/api/zones-Aggrid',
                    columnDefs: [
                        {
                            field: "",
                            sortable: true,
                            filter: "agTextColumnFilter",
                            filterParams: {suppressAndOrCondition: true},
                            headerName: "",
                            cellStyle: {fontSize: '11px'},
                            valueFormatter: (params) => {
                                let retour = "";
                                try {
                                    return `${params.data["Selectlabel"]}`;
                                } catch (e) {
                                }
                                return retour;


                            },
                        },
                    ],
                    filterFields: ['libelle'],
                },
            },
        ];
        this.columnDefs5 =
            [
                {
                    field: "date_debut",
                    minWidth: 120, maxWidth: 120,
                    sortable: true,
                    headerName: 'date ',
                    valueFormatter: params => {
                        let retour = params.value
                        try {
                            retour = params.value.split(' ')[0]
                        } catch (e) {

                        }
                        return retour
                    }
                },
                {
                    field: 'faction',
                    headerName: 'faction',
                    minWidth: 100, maxWidth: 100,
                    suppressCellSelection: true,

                },
                // {
                //     hide: true,
                //     suppressColumnsToolPanel: true,

                //     headerName: 'zone',
                //     field: 'zone_id',
                //     valueFormatter: params => {
                //         let retour = ''
                //         try {
                //             return params.data['zone']['Selectlabel']
                //         } catch (e) {

                //         }
                //         return retour
                //     },
                //     filter: "CustomFiltre",
                //     filterParams: {
                //         url: this.axios.defaults.baseURL + '/api/zones-Aggrid',
                //         columnDefs: [
                //             {
                //                 field: "",
                //                 sortable: true,
                //                 filter: "agTextColumnFilter",
                //                 filterParams: {suppressAndOrCondition: true},
                //                 headerName: "",
                //                 cellStyle: {fontSize: '11px'},
                //                 valueFormatter: (params) => {
                //                     let retour = "";
                //                     try {
                //                         return `${params.data["Selectlabel"]}`;
                //                     } catch (e) {
                //                     }
                //                     return retour;
                //                 },
                //             },
                //         ],
                //         filterFields: ['libelle'],
                //     },
                // },
                {
                    field: "libelle",
                    sortable: true,
                    width: 400,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'libelle',
                },
                {
                    field: 'present',
                    headerName: 'Prs',
                    suppressCellSelection: true,
                    maxWidth: 85,
                },
                {
                    field: 'abscent',
                    headerName: 'Abs',
                    suppressCellSelection: true,
                    maxWidth: 85,
                },
                {
                    headerName: 'Valideur 1',
                    field: 'valideur1.Selectlabel',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'Valideur 1',
                    field: 'valideur_1',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['user']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/users-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['matricule', 'nom', 'prenom'],
                    },
                },
                {
                    field: "valider1",
                    sortable: true,
                    headerName: 'Validation 1',
                    valueFormatter: params => {
                        let retour = params.value
                        try {
                            if (retour) {
                                retour = moment(params.value).format('DD/MM/YYYY à HH:mm')

                            } else {
                                retour = 'Non Validé'
                            }
                        } catch (e) {

                        }
                        return retour
                    }
                },
                {
                    headerName: 'Valideur 2',
                    field: 'valideur2.Selectlabel',
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,

                    headerName: 'Valideur 2',
                    field: 'valideur_2',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['user']['Selectlabel']
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: "CustomFiltre",
                    filterParams: {
                        url: this.axios.defaults.baseURL + '/api/users-Aggrid',
                        columnDefs: [
                            {
                                field: "",
                                sortable: true,
                                filter: "agTextColumnFilter",
                                filterParams: {suppressAndOrCondition: true},
                                headerName: "",
                                cellStyle: {fontSize: '11px'},
                                valueFormatter: (params) => {
                                    let retour = "";
                                    try {
                                        return `${params.data["matricule"]} ${params.data["nom"]} ${params.data["prenom"]} `;
                                    } catch (e) {
                                    }
                                    return retour;
                                },
                            },
                        ],
                        filterFields: ['matricule', 'nom', 'prenom'],
                    },
                },
                {
                    field: "valider2",
                    sortable: true,
                    headerName: 'Validation 2',
                    valueFormatter: params => {
                        let retour = params.value
                        try {
                            if (retour) {
                                retour = moment(params.value).format('DD/MM/YYYY à HH:mm')

                            } else {
                                retour = 'Non Validé'
                            }
                        } catch (e) {

                        }
                        return retour
                    }
                },
                {
                    hide: true,
                    suppressColumnsToolPanel: true,
                    suppressFilter: this.$routeData.meta.validation,
                    headerName: 'validation',
                    field: 'validation',
                    valueFormatter: params => {
                        let retour = ''
                        try {
                            return params.data['validation']['Selectlabel']
                            // return params.data
                        } catch (e) {

                        }
                        return retour
                    },
                    filter: 'agSetColumnFilter',
                    filterParams: {
                        suppressAndOrCondition: true,
                        keyCreator: params => params.value,
                        valueFormatter: params => params.value,
                        values: params => {
                            params.success(this.validationsData);
                        },
                        refreshValuesOnOpen: true,
                    },
                },
                // {
                //     field: "valider1",
                //     headerName: 'Validation 1',
                //     suppressCellSelection: true,
                //     minWidth: 80,maxWidth: 80,
                //     // pinned: 'left',
                //     cellRendererSelector: params => {
                //         return {
                //             component: 'AgGridBtnClicked',
                //             params: {
                //                 clicked: field => {
                //                     this.valider1()
                //                     this.showForm('Validation', field, params.api, 'l')
                //                 },
                //                 render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-circle-check"></i></div>`
                //             }
                //         };
                //     },
                // },
                // {
                //     field: "valider2",
                //     sortable: true,
                //     headerName: 'Validation 2',
                //     suppressCellSelection: true,
                //     minWidth: 80,maxWidth: 80,
                //     cellRendererSelector: params => {
                //         return {
                //             component: 'AgGridBtnClicked',
                //             params: {
                //                 clicked: field => {
                //                     this.valider2()
                //                     this.showForm('Validation', field, params.api, 'l')
                //                 },
                //                 render: `<div class="" style="width:100%;height:100%;background:#28a745;color:#fff;border-radius:5px;text-align:center;cursor:pointer"> <i class="fa-solid fa-circle-check"></i></div>`
                //             }
                //         };
                //     },
                // },
            ];
    },
    mounted() {
        if (this.requette > 0) {
            // this.$store.commit('setIsLoading', true)
        }

        this.factionsData = ["Jour", "Nuit"]
        this.validationsData = ["0", "1", "2"]
        this.getStats();
        this.getStats2();
        this.getStats3();

        this.zonesget = this.$routeData.meta.zonesGet
        this.dateImportAgents = this.$routeData.meta.dateImportAgents
        this.dateImportAgentsOne = this.$routeData.meta.dateImportAgentsOne
        this.dateImportPoste = this.$routeData.meta.dateImportPoste
        this.directionsget = this.$routeData.meta.directionsGet
        this.typeseffectifsget = this.$routeData.meta.typeseffectifsGet
        this.usersNonAffectesCount = this.$routeData.meta.usersSalariesCount - this.$routeData.meta.usersSalariesAffectesCount
        this.usersNonAffectesCountZone = this.$routeData.meta.usersSalariesCountZone - this.$routeData.meta.usersSalariesAffectesCountZone
        this.usersONENonAffectesCountZone = this.$routeData.meta.usersOneCountZone - this.$routeData.meta.usersONEAffectesCountZone
        this.usersONENonAffectesCount = this.$routeData.meta.usersONECount - this.$routeData.meta.usersONEAffectesCount
        // console.log('okk', searchParams.get("week"))
        console.log('okk2', this.typeseffectifsget[0].libelle)
        this.actualPage = this.$routeData.meta.valider
        this.week = this.$routeData.meta.weeks
    },
    methods: {
        analyseStats(stat) {
            let data = [1, 100];
            try {
                let stats = stat.split('/')
                let first = parseInt(stats[0])
                let dernier = parseInt(stats[1])
                if (dernier == 0) {
                    dernier = 1
                }
                let pourcentage = first * 100 / dernier
                pourcentage = Number((pourcentage).toFixed(1))
                data = [pourcentage, 100 - pourcentage]
            } catch (e) {
                data = [0, 100]

            }

            return data
            // return [1, 0, 100]
        },
        analyseOptions(options, value) {
            options['title'] = {
                text: value
            }
            return options
            // return [1, 0, 100]
        },
        onGridReady(params) {
            console.log("on demarre", params);
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false;
            this.gridApi.sizeColumnsToFit();
        },
        getpostes() {
            this.axios.get('/api/postes').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.postesData = response.data
                // console.log('yannfiltreP=>', response.data)

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        getzones() {
            this.axios
                .get("/api/zones")
                .then((response) => {
                    this.requette--;
                    if (this.requette == 0) {
                        // this.$store.commit('setIsLoading', false)
                    }
                    this.zonesData = response.data;
                })
                .catch((error) => {
                    console.log(error.response.data);
                    // this.$store.commit('setIsLoading', false)
                    this.$toast.error(
                        "Erreur survenue lors de la récuperation"
                    );
                });
        },
        getclients() {
            this.axios.get('/api/clients').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.clientsData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },

        getpointeuses() {
            this.axios.get('/api/pointeuses').then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.pointeusesData = response.data

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        async getDatas() {
            // this.$store.commit('setIsLoading', true)
            await this.axios
                .get(
                    "/api/users?filter[actif_id]=1&filter[type_id]=2&filter[null]=deleted_at&count=1"
                )
                .then((response) => {
                    this.nb_employes = response.data;
                    // // this.$store.commit('setIsLoading', false)
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    // // this.$store.commit('setIsLoading', false)
                });

            // this.$store.commit('setIsLoading', true)
            await this.axios
                .get(
                    "/api/users?filter[actif_id]=2&filter[type_id]=2&filter[null]=deleted_at&count=1"
                )
                .then((response) => {
                    this.nb_enrolements = response.data;
                    // // this.$store.commit('setIsLoading', false)
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    // // this.$store.commit('setIsLoading', false)
                });

            // this.$store.commit('setIsLoading', true)
            await this.axios
                .get("/api/pointages/action?action=exceptions")
                .then((response) => {
                    this.exceptions = response.data.length;
                    // // this.$store.commit('setIsLoading', false)
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    // // this.$store.commit('setIsLoading', false)
                });

            // this.$store.commit('setIsLoading', true)
            await this.axios
                .get("/api/taches?count=1")
                .then((response) => {
                    this.nb_taches = response.data;
                    // // this.$store.commit('setIsLoading', false)
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    // // this.$store.commit('setIsLoading', false)
                });

            /*// this.$store.commit('setIsLoading', true)
            await this.axios.get('/api/pointages?filter[date]=debut_prevu/like/' + moment(String(new Date())).format('YYYY-MM-DD') + '&filter[debut_realise]=&count=1').then((response) => {
              this.nb_absences = response.data
              this.onChange++
              // // this.$store.commit('setIsLoading', false)
            }).catch(error => {
              this.errors = error.response.data.errors
              // // this.$store.commit('setIsLoading', false)
            })

            // this.$store.commit('setIsLoading', true)
            await this.axios.get('/api/pointages?filter[date]=debut_prevu/like/' + moment(String(new Date())).format('YYYY-MM-DD') + '&filter[not_null]=debut_realise&count=1').then((response) => {
              this.nb_presences = response.data
              this.onChange++
              // // this.$store.commit('setIsLoading', false)
            }).catch(error => {
              this.errors = error.response.data.errors
              // // this.$store.commit('setIsLoading', false)
            })*/
        },
        getStats() {
            let extra = this.extrasData
            extra.action = 'getPointagesStats'
            let donnes = Object.keys(extra).map(key => `${key}=${extra[key]}`).join('&')
            console.log('voici les donne ==>', donnes)
            let url = "/api/pointages/action?" + donnes;
            this.axios
                .get(url)
                .then((response) => {
                    this.options = {
                        autoSize: true,
                        data: response.data,
                        theme: {
                            palette: {
                                fills: ['#43a72c', '#d7114b', '#9BC53D', '#E55934', '#FA7921'],
                                strokes: ['#4086a4', '#b1a235', '#6c8a2b', '#a03e24', '#af5517'],
                            },
                            overrides: {
                                bar: {
                                    series: {
                                        strokeWidth: 0,
                                    },
                                },
                            },
                        },
                        title: {
                            text: 'Statistiques des pointages',
                            fontSize: 18,
                            spacing: 25,
                        },
                        footnote: {},
                        series: [
                            {
                                type: 'column',
                                stacked: true,
                                yName: 'Pointages Connu',
                                xKey: 'jour',
                                yKey: 'pointagesConnu',
                            },
                            {
                                type: 'column',
                                stacked: true,
                                yName: 'Pointages Inconnu',
                                xKey: 'jour',
                                yKey: 'pointagesInConnu',
                            },
                        ],
                        axes: [
                            {
                                type: 'number',
                                position: 'left',
                            },
                            {
                                type: 'category',
                                position: 'bottom',
                                label: {
                                    rotation: 40,
                                },
                                title: {
                                    enabled: true,
                                    text: 'Jour de la semaine',
                                },
                            },
                        ],
                    }
                    this.optionsKey++;
                    console.log('this.optionsKey', this.optionsKey);

                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getStats2() {
            let extra = this.extrasData
            extra.action = 'GetPointagesStats2'
            let donnes = Object.keys(extra).map(key => `${key}=${extra[key]}`).join('&')

            let url = "/api/pointages/action?" + donnes;
            this.axios
                .get(url)
                .then((response) => {
                    this.options2 = {
                        autoSize: true,
                        data: response.data,
                        theme: {
                            palette: {
                                fills: ['#43a72c', '#d7114b', '#9BC53D', '#E55934', '#FA7921'],
                                strokes: ['#4086a4', '#b1a235', '#6c8a2b', '#a03e24', '#af5517'],
                            },
                            overrides: {
                                bar: {
                                    series: {
                                        strokeWidth: 0,
                                    },
                                },
                            },
                        },
                        title: {
                            text: 'Presences/Abscences collecter au travers des listings',
                            fontSize: 18,
                            spacing: 25,
                        },
                        footnote: {},
                        series: [
                            {
                                type: 'column',
                                stacked: true,
                                yName: 'Present',
                                xKey: 'jour',
                                yKey: 'pointagesConnu',
                            },
                            {
                                type: 'column',
                                stacked: true,
                                yName: 'Abscent',
                                xKey: 'jour',
                                yKey: 'pointagesInConnu',
                            },
                        ],
                        axes: [
                            {
                                type: 'number',
                                position: 'left',
                            },
                            {
                                type: 'category',
                                position: 'bottom',
                                label: {
                                    rotation: 40,
                                },
                                title: {
                                    enabled: true,
                                    text: 'Jour de la semaine',
                                },
                            },
                        ],
                    }
                    this.optionsKey2++;


                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getStats3() {
            let extra = this.extrasData4
            extra.action = 'GetPointagesStats3'
            let donnes = Object.keys(extra).map(key => `${key}=${extra[key]}`).join('&')
            console.log('voici les donne ==>', donnes, this.extrasData4)
            let url = "/api/pointages/action?" + donnes;

            console.log('voici les donne ==>', donnes, url)
            this.axios
                .get(url)
                .then((response) => {
                    this.options3 = {
                        autoSize: true,
                        data: response.data,
                        theme: {
                            palette: {
                                fills: ['#43a72c', '#d7114b', '#ffeb00', '#9BC53D', , '#FA7921'],
                                strokes: ['#4086a4', '#b1a235', '#6c8a2b', '#a03e24', '#af5517'],
                            },
                            overrides: {
                                bar: {
                                    series: {
                                        strokeWidth: 0,
                                    },
                                },
                            },
                        },
                        title: {
                            text: '',
                            fontSize: 18,
                            spacing: 25,
                        },
                        footnote: {},
                        series: [
                            {
                                type: 'column',
                                stacked: true,
                                yName: 'Ronde complete',
                                xKey: 'jour',
                                yKey: 'pointagesConnu',
                                label: {
                                    enabled: true,
                                    fontSize: 13,
                                    color: 'white',
                                    position: 'top',
                                    formatter: function (params) {
                                        if (params.value === 0) {
                                            return ''; // Retourner une chaîne vide si la valeur est 0
                                        } else {
                                            return params.value.toString(); // Sinon, retourner la valeur normale
                                        }
                                    }
                                },
                            },
                            {
                                type: 'column',
                                stacked: true,
                                yName: 'Ronde non faite',
                                xKey: 'jour',
                                yKey: 'pointagesNonDemarrer',
                                label: {
                                    enabled: true,
                                    fontSize: 13,
                                    color: 'white',
                                    position: 'top',
                                    formatter: function (params) {
                                        if (params.value === 0) {
                                            return ''; // Retourner une chaîne vide si la valeur est 0
                                        } else {
                                            return params.value.toString(); // Sinon, retourner la valeur normale
                                        }
                                    }
                                },
                            },
                            {
                                type: 'column',
                                stacked: true,
                                yName: 'Ronde incomplete',
                                xKey: 'jour',
                                yKey: 'pointagesInConnu',
                                label: {
                                    enabled: true,
                                    fontSize: 13,
                                    color: 'white',
                                    position: 'top',
                                    formatter: function (params) {
                                        if (params.value === 0) {
                                            return ''; // Retourner une chaîne vide si la valeur est 0
                                        } else {
                                            return params.value.toString(); // Sinon, retourner la valeur normale
                                        }
                                    }
                                },
                            },
                        ],
                        axes: [
                            {
                                type: 'number',
                                position: 'left',
                            },
                            {
                                type: 'category',
                                position: 'bottom',
                                label: {
                                    rotation: 40,
                                },
                                title: {
                                    enabled: true,
                                    text: 'Jour de la semaine',
                                },
                            },
                        ],
                    }
                    this.optionsKey3++;


                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getStatsZones() {
            let extra = {}
            extra.action = 'getCouvertureStats'
            let donnes = Object.keys(extra).map(key => `${key}=${extra[key]}`).join('&')
            console.log('voici les donne ==>', donnes)
            let url = "/api/postes/action?" + donnes;
            this.axios
                .get(url)
                .then((response) => {
                    let canvasId = "Canvas" + "_" + Date.now();
                    $("#parent").empty();
                    $("#parent").append(
                        `<div style="width: 100%;"><canvas id="${canvasId}"></canvas></div>`
                    );
                    let dataConnu = response.data.connu;
                    let dataInconnu = response.data.inconnu;
                    new Chart(document.getElementById(`${canvasId}`), {
                        type: "bar",
                        data: {
                            labels: dataConnu.map((row) => row.jour),
                            datasets: [
                                {
                                    label: "Pointages des agents connu",
                                    data: dataConnu.map((row) => row.pointages),
                                    backgroundColor: "#85ea44",
                                },
                                {
                                    label: "Pointages des agents inconnu",
                                    data: dataInconnu.map(
                                        (row) => row.pointages
                                    ),
                                    backgroundColor: "#e62278",
                                },
                            ],
                        },
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getStatsClients(clients) {
            // this.axios
            //     .get("/api/pointages/action?action=getPointagesForClients&clients=" +
            //     clients)
        },
        onBtPrint() {
            const api = this.gridApi;
            setTimeout(function () {
                print();
            }, 2000);
        },
        setPrinterFriendly(api) {
            const eGridDiv = document.querySelector(`#${this.id}`);
            // api.setDomLayout('print');
        },
        setNormal(api) {
            const eGridDiv = document.querySelector(`#${this.id}`);
            eGridDiv.style.width = '700px';
            eGridDiv.style.height = '200px';
            api.setDomLayout();
        },
        //     zoneselect(zone) {
        //         // console.log('okkk', zone)
        //         // let params
        //         // this.actualZone = zone
        //         // //table zone
        //         // this.zoneselectionner = zone
        //         // //table client
        //         // this.extrasData1.zoneselectionner = this.zoneselectionner


        //         this.actualZone = zone;
        //   if (!this.zoneselectionner.includes(zone)) {
        //     this.zoneselectionner.push(zone);
        //   }
        //   console.log('this.zoneselectionner',this.zoneselectionner)
        // },
        zoneselect(zone) {
            //   this.actualZone = zone;
            if (this.zoneselectionner.includes(zone)) {
                // Zone is already selected, so we want to deselect it
                const index = this.zoneselectionner.indexOf(zone);
                if (index !== -1) {
                    this.zoneselectionner.splice(index, 1); // Remove the zone from the array
                }
            } else {
                // Zone is not selected, so we want to select it
                this.zoneselectionner.push(zone);
            }
            this.extrasData1.zoneselectionner = this.zoneselectionner

            // console.log('this.zoneselectionner', this.zoneselectionner)
        },
        directionsselect(direction) {

            if (this.directionselectionner.includes(direction)) {
                const index = this.directionselectionner.indexOf(direction);
                if (index !== -1) {
                    this.directionselectionner.splice(index, 1);
                }
            } else {
                this.directionselectionner.push(direction);
            }

            this.extrasData1.directionselectionner = this.directionselectionner

        },
        togglePage(page) {
            let inputUrl = new URL(window.location.href);
            inputUrl.searchParams.delete('valider')
            if (this.actualPage == page) {
                // inputUrl.searchParams.append('valider', 3)
                window.location.href = inputUrl.href
            } else {

                inputUrl.searchParams.append('valider', page)
                window.location.href = inputUrl.href
            }
            // // console.log('okk', inputUrl.searchParams.get("week") === this.$routeData.meta.weeks)
            // let inputUrl = new URL(window.location.href);
            // // console.log('okk', inputUrl.searchParams.get("week") === "2024-W07" ,this.$routeData.meta.semaine)
            // inputUrl.searchParams.delete('valider')
            // inputUrl.searchParams.append('valider', page)
            // window.location.href = inputUrl.href
        },
        hasDataForJour(items, number) {
            const optionJour = items[`optionJour${number}`];
            // console.log("Option jour:", optionJour);

            // Vérifiez si l'option jour contient des données pour la semaine
            const hasData = optionJour && optionJour.data.some(data => data.pointagesConnu > 0 || data.pointagesInConnu > 0);
            // console.log("Has data for jour:", hasData);
            return hasData;
        },
        hasDataForNuit(items, number) {
            const optionNuit = items[`optionNuit${number}`];
            // console.log("Option nuit:", optionNuit);

            // Vérifiez si l'option nuit contient des données pour la semaine
            const hasData = optionNuit && optionNuit.data.some(data => data.pointagesConnu > 0 || data.pointagesInConnu > 0);
            // console.log("Has data for nuit:", hasData);
            return hasData;
        },
        formattedDateAgents(items) {
            // Utilisez Moment.js pour formater la date
            if (items == 'ONE') {
                try {
                    return moment(this.dateImportAgentsOne).format('DD/MM/YYYY');
                } catch (e) {
                    return 'date inconnu';
                }
            } else if (items == 'Salaries') {

                try {
                    return moment(this.dateImportAgents).format('DD/MM/YYYY');
                } catch (e) {
                    return 'date inconnu';
                }
            } else {
                return 'date inconnu';
            }

            // Vous pouvez ajuster le format en fonction de vos besoins
        },
        usersNonAffectesCounts(items) {
            // Utilisez Moment.js pour formater la date
            if (items == 'ONE') {
                return this.usersONENonAffectesCount;
            } else if (items == 'Salaries') {

                return this.usersNonAffectesCount;
            } else {
                // return '0';
            }

            // Vous pouvez ajuster le format en fonction de vos besoins
        },

    },
};
</script>

<style>
.haut,
.bas {
    display: flex
}

.allBoutons {
    display: flex;
    gap: 10px
}
</style>
