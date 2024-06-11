<template>
    <div>
        <form @submit.prevent="createLine()">
            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-12">
                        <div v-if="mise1.good" class="btn btn-success" style="width:100%">Favorable</div>
                        <div v-else class="btn btn-danger" style="width:100%">Defavorable</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Montant initial </label>
                            <input v-model="form.mi" :class="errors.mi?'form-control is-invalid':'form-control'"
                                   type="text">

                            <div v-if="errors.mi" class="invalid-feedback">
                                <template v-for=" error in errors.mi"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Cote 1 </label>
                            <input v-model="form.c1" :class="errors.c1?'form-control is-invalid':'form-control'"
                                   type="text">

                            <div v-if="errors.c1" class="invalid-feedback">
                                <template v-for=" error in errors.c1"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Cote 2 </label>
                            <input v-model="form.c2" :class="errors.c2?'form-control is-invalid':'form-control'"
                                   type="text">
                            <div v-if="errors.c2" class="invalid-feedback">
                                <template v-for=" error in errors.c2"> {{ error[0] }}</template>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Paris 1 </label>
                            <input v-model="mise1.paris1" class="form-control" disabled
                                   type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Paris 2 </label>
                            <input v-model="mise1.paris2" class="form-control" disabled
                                   type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Gain esperer </label>
                            <input v-model="mise1.gain" class="form-control" disabled
                                   type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Mise Total (Depot a faire) </label>
                            <input v-model="mise1.depot" class="form-control" disabled
                                   type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Frais ajouter (% ) </label>
                            <input v-model="form.frais" class="form-control"
                                   type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Gain Payer/Ce que tu recoit (Plus frais ) </label>
                            <input v-model="mise1.recu" class="form-control" disabled
                                   type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Perte /Montant a completer sans frais </label>
                            <input v-model="mise1.perte" class="form-control" disabled type="text">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Perte /Montant a completer avec frais </label>
                            <input v-model="mise1.perteFictif" class="form-control" disabled type="text">
                        </div>
                    </div>

                </div>


            </div>

        </form>
    </div>

</template>

<script>

export default {
    name: "Calcules",
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                mi: 0,
                m1: 0,
                m2: 0,
                Mt: 0,
                c1: 0,
                c2: 0,
                frais: 0.03,

                province_id: "",

                created_at: "",

                updated_at: "",

                extra_attributes: "",

                deleted_at: "",
            }
        }
    },
    methods: {
        createLine() {
            let c1 = parseFloat(this.form.c1)
            let c2 = parseFloat(this.form.c2)
            let mi = parseFloat(this.form.mi)
            let m1 = parseInt(this.form.mi)
            let m2 = parseInt((mi * c1) / c2)
            let response = parseInt(mi * (1 + c1 / c2))
            this.form.Mt = m1 + m2
            this.form.m1 = m1
            this.form.m2 = m2
        }
    },
    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                router = window.routeData
            } catch (e) {
            }

            return router;
        },
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
        mise1: function () {
            let c1 = parseFloat(this.form.c1)
            let c2 = parseFloat(this.form.c2)
            let mi = parseFloat(this.form.mi)
            let m1 = parseInt(this.form.mi)
            let m2 = parseInt((mi * c1) / c2)
            let miseTotal = m1 + m2
            let g1 = m1 * c1
            let g2 = m2 * c2
            let gi = 0
            if (g1 >= g2) {
                gi = g2
            } else {
                gi = g1
            }
            let perte = Math.abs(parseInt(gi - miseTotal))
            let response = parseInt(mi * (1 + c1 / c2))
            let good = miseTotal * 0.06 > perte
            let depot = miseTotal
            let recu = parseInt(parseInt(gi) + parseInt(gi) * this.form.frais)

            let perteFictif = Math.abs(parseInt(recu - depot))
            let mise1 = {
                paris1: `${m1} x ${c1} = ${parseInt(g1)}`,
                paris2: `${m2} x ${c2} = ${parseInt(g2)}`,
                depot: `${depot} Fcfa`,
                recu: `${recu} Fcfa`,
                gain: `${parseInt(gi)} Fcfa`,
                good: good,
                multiplicateur: `${parseInt(miseTotal / perte)} x`,
                perte: `${perte} - ${Math.ceil(perte * 100 / miseTotal)}% - ${parseInt(miseTotal / perte)} x`,
                perteFictif: `${perteFictif} - ${Math.ceil(perteFictif * 100 / miseTotal)}% - ${parseInt(miseTotal / perteFictif)} x`,
            }
            let mise = []
            return mise1
        },

    }
}
</script>

<style scoped>

</style>
