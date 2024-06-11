<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('libelle')" class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" class="form-control"
                           type="text">

                    <div v-if="errors.libelle" class='div-error' show variant="danger">
                        {{ errors.libelle }}
                    </div>
                </div>


                <div v-if="canShowFilter('parent')" class="form-group">
                    <label>parent </label>
                    <input v-model="form.parent" class="form-control"
                           type="text">

                    <div v-if="errors.parent" class='div-error' show variant="danger">
                        {{ errors.parent }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle0')" class="form-group">
                    <label>cle0 </label>
                    <input v-model="form.cle0" class="form-control"
                           type="text">

                    <div v-if="errors.cle0" class='div-error' show variant="danger">
                        {{ errors.cle0 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle1')" class="form-group">
                    <label>cle1 </label>
                    <input v-model="form.cle1" class="form-control"
                           type="text">

                    <div v-if="errors.cle1" class='div-error' show variant="danger">
                        {{ errors.cle1 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle2')" class="form-group">
                    <label>cle2 </label>
                    <input v-model="form.cle2" class="form-control"
                           type="text">

                    <div v-if="errors.cle2" class='div-error' show variant="danger">
                        {{ errors.cle2 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle3')" class="form-group">
                    <label>cle3 </label>
                    <input v-model="form.cle3" class="form-control"
                           type="text">

                    <div v-if="errors.cle3" class='div-error' show variant="danger">
                        {{ errors.cle3 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle4')" class="form-group">
                    <label>cle4 </label>
                    <input v-model="form.cle4" class="form-control"
                           type="text">

                    <div v-if="errors.cle4" class='div-error' show variant="danger">
                        {{ errors.cle4 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle5')" class="form-group">
                    <label>cle5 </label>
                    <input v-model="form.cle5" class="form-control"
                           type="text">

                    <div v-if="errors.cle5" class='div-error' show variant="danger">
                        {{ errors.cle5 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle6')" class="form-group">
                    <label>cle6 </label>
                    <input v-model="form.cle6" class="form-control"
                           type="text">

                    <div v-if="errors.cle6" class='div-error' show variant="danger">
                        {{ errors.cle6 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle7')" class="form-group">
                    <label>cle7 </label>
                    <input v-model="form.cle7" class="form-control"
                           type="text">

                    <div v-if="errors.cle7" class='div-error' show variant="danger">
                        {{ errors.cle7 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle8')" class="form-group">
                    <label>cle8 </label>
                    <input v-model="form.cle8" class="form-control"
                           type="text">

                    <div v-if="errors.cle8" class='div-error' show variant="danger">
                        {{ errors.cle8 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle9')" class="form-group">
                    <label>cle9 </label>
                    <input v-model="form.cle9" class="form-control"
                           type="text">

                    <div v-if="errors.cle9" class='div-error' show variant="danger">
                        {{ errors.cle9 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle10')" class="form-group">
                    <label>cle10 </label>
                    <input v-model="form.cle10" class="form-control"
                           type="text">

                    <div v-if="errors.cle10" class='div-error' show variant="danger">
                        {{ errors.cle10 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle11')" class="form-group">
                    <label>cle11 </label>
                    <input v-model="form.cle11" class="form-control"
                           type="text">

                    <div v-if="errors.cle11" class='div-error' show variant="danger">
                        {{ errors.cle11 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle12')" class="form-group">
                    <label>cle12 </label>
                    <input v-model="form.cle12" class="form-control"
                           type="text">

                    <div v-if="errors.cle12" class='div-error' show variant="danger">
                        {{ errors.cle12 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle13')" class="form-group">
                    <label>cle13 </label>
                    <input v-model="form.cle13" class="form-control"
                           type="text">

                    <div v-if="errors.cle13" class='div-error' show variant="danger">
                        {{ errors.cle13 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle14')" class="form-group">
                    <label>cle14 </label>
                    <input v-model="form.cle14" class="form-control"
                           type="text">

                    <div v-if="errors.cle14" class='div-error' show variant="danger">
                        {{ errors.cle14 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle15')" class="form-group">
                    <label>cle15 </label>
                    <input v-model="form.cle15" class="form-control"
                           type="text">

                    <div v-if="errors.cle15" class='div-error' show variant="danger">
                        {{ errors.cle15 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle16')" class="form-group">
                    <label>cle16 </label>
                    <input v-model="form.cle16" class="form-control"
                           type="text">

                    <div v-if="errors.cle16" class='div-error' show variant="danger">
                        {{ errors.cle16 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle17')" class="form-group">
                    <label>cle17 </label>
                    <input v-model="form.cle17" class="form-control"
                           type="text">

                    <div v-if="errors.cle17" class='div-error' show variant="danger">
                        {{ errors.cle17 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle18')" class="form-group">
                    <label>cle18 </label>
                    <input v-model="form.cle18" class="form-control"
                           type="text">

                    <div v-if="errors.cle18" class='div-error' show variant="danger">
                        {{ errors.cle18 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle19')" class="form-group">
                    <label>cle19 </label>
                    <input v-model="form.cle19" class="form-control"
                           type="text">

                    <div v-if="errors.cle19" class='div-error' show variant="danger">
                        {{ errors.cle19 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle20')" class="form-group">
                    <label>cle20 </label>
                    <input v-model="form.cle20" class="form-control"
                           type="text">

                    <div v-if="errors.cle20" class='div-error' show variant="danger">
                        {{ errors.cle20 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle21')" class="form-group">
                    <label>cle21 </label>
                    <input v-model="form.cle21" class="form-control"
                           type="text">

                    <div v-if="errors.cle21" class='div-error' show variant="danger">
                        {{ errors.cle21 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle22')" class="form-group">
                    <label>cle22 </label>
                    <input v-model="form.cle22" class="form-control"
                           type="text">

                    <div v-if="errors.cle22" class='div-error' show variant="danger">
                        {{ errors.cle22 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle23')" class="form-group">
                    <label>cle23 </label>
                    <input v-model="form.cle23" class="form-control"
                           type="text">

                    <div v-if="errors.cle23" class='div-error' show variant="danger">
                        {{ errors.cle23 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle24')" class="form-group">
                    <label>cle24 </label>
                    <input v-model="form.cle24" class="form-control"
                           type="text">

                    <div v-if="errors.cle24" class='div-error' show variant="danger">
                        {{ errors.cle24 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle25')" class="form-group">
                    <label>cle25 </label>
                    <input v-model="form.cle25" class="form-control"
                           type="text">

                    <div v-if="errors.cle25" class='div-error' show variant="danger">
                        {{ errors.cle25 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle26')" class="form-group">
                    <label>cle26 </label>
                    <input v-model="form.cle26" class="form-control"
                           type="text">

                    <div v-if="errors.cle26" class='div-error' show variant="danger">
                        {{ errors.cle26 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle27')" class="form-group">
                    <label>cle27 </label>
                    <input v-model="form.cle27" class="form-control"
                           type="text">

                    <div v-if="errors.cle27" class='div-error' show variant="danger">
                        {{ errors.cle27 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle28')" class="form-group">
                    <label>cle28 </label>
                    <input v-model="form.cle28" class="form-control"
                           type="text">

                    <div v-if="errors.cle28" class='div-error' show variant="danger">
                        {{ errors.cle28 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle29')" class="form-group">
                    <label>cle29 </label>
                    <input v-model="form.cle29" class="form-control"
                           type="text">

                    <div v-if="errors.cle29" class='div-error' show variant="danger">
                        {{ errors.cle29 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle30')" class="form-group">
                    <label>cle30 </label>
                    <input v-model="form.cle30" class="form-control"
                           type="text">

                    <div v-if="errors.cle30" class='div-error' show variant="danger">
                        {{ errors.cle30 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle31')" class="form-group">
                    <label>cle31 </label>
                    <input v-model="form.cle31" class="form-control"
                           type="text">

                    <div v-if="errors.cle31" class='div-error' show variant="danger">
                        {{ errors.cle31 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle32')" class="form-group">
                    <label>cle32 </label>
                    <input v-model="form.cle32" class="form-control"
                           type="text">

                    <div v-if="errors.cle32" class='div-error' show variant="danger">
                        {{ errors.cle32 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle33')" class="form-group">
                    <label>cle33 </label>
                    <input v-model="form.cle33" class="form-control"
                           type="text">

                    <div v-if="errors.cle33" class='div-error' show variant="danger">
                        {{ errors.cle33 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle34')" class="form-group">
                    <label>cle34 </label>
                    <input v-model="form.cle34" class="form-control"
                           type="text">

                    <div v-if="errors.cle34" class='div-error' show variant="danger">
                        {{ errors.cle34 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle35')" class="form-group">
                    <label>cle35 </label>
                    <input v-model="form.cle35" class="form-control"
                           type="text">

                    <div v-if="errors.cle35" class='div-error' show variant="danger">
                        {{ errors.cle35 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle36')" class="form-group">
                    <label>cle36 </label>
                    <input v-model="form.cle36" class="form-control"
                           type="text">

                    <div v-if="errors.cle36" class='div-error' show variant="danger">
                        {{ errors.cle36 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle37')" class="form-group">
                    <label>cle37 </label>
                    <input v-model="form.cle37" class="form-control"
                           type="text">

                    <div v-if="errors.cle37" class='div-error' show variant="danger">
                        {{ errors.cle37 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle38')" class="form-group">
                    <label>cle38 </label>
                    <input v-model="form.cle38" class="form-control"
                           type="text">

                    <div v-if="errors.cle38" class='div-error' show variant="danger">
                        {{ errors.cle38 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle39')" class="form-group">
                    <label>cle39 </label>
                    <input v-model="form.cle39" class="form-control"
                           type="text">

                    <div v-if="errors.cle39" class='div-error' show variant="danger">
                        {{ errors.cle39 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle40')" class="form-group">
                    <label>cle40 </label>
                    <input v-model="form.cle40" class="form-control"
                           type="text">

                    <div v-if="errors.cle40" class='div-error' show variant="danger">
                        {{ errors.cle40 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle41')" class="form-group">
                    <label>cle41 </label>
                    <input v-model="form.cle41" class="form-control"
                           type="text">

                    <div v-if="errors.cle41" class='div-error' show variant="danger">
                        {{ errors.cle41 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle42')" class="form-group">
                    <label>cle42 </label>
                    <input v-model="form.cle42" class="form-control"
                           type="text">

                    <div v-if="errors.cle42" class='div-error' show variant="danger">
                        {{ errors.cle42 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle43')" class="form-group">
                    <label>cle43 </label>
                    <input v-model="form.cle43" class="form-control"
                           type="text">

                    <div v-if="errors.cle43" class='div-error' show variant="danger">
                        {{ errors.cle43 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle44')" class="form-group">
                    <label>cle44 </label>
                    <input v-model="form.cle44" class="form-control"
                           type="text">

                    <div v-if="errors.cle44" class='div-error' show variant="danger">
                        {{ errors.cle44 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle45')" class="form-group">
                    <label>cle45 </label>
                    <input v-model="form.cle45" class="form-control"
                           type="text">

                    <div v-if="errors.cle45" class='div-error' show variant="danger">
                        {{ errors.cle45 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle46')" class="form-group">
                    <label>cle46 </label>
                    <input v-model="form.cle46" class="form-control"
                           type="text">

                    <div v-if="errors.cle46" class='div-error' show variant="danger">
                        {{ errors.cle46 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle47')" class="form-group">
                    <label>cle47 </label>
                    <input v-model="form.cle47" class="form-control"
                           type="text">

                    <div v-if="errors.cle47" class='div-error' show variant="danger">
                        {{ errors.cle47 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle48')" class="form-group">
                    <label>cle48 </label>
                    <input v-model="form.cle48" class="form-control"
                           type="text">

                    <div v-if="errors.cle48" class='div-error' show variant="danger">
                        {{ errors.cle48 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle49')" class="form-group">
                    <label>cle49 </label>
                    <input v-model="form.cle49" class="form-control"
                           type="text">

                    <div v-if="errors.cle49" class='div-error' show variant="danger">
                        {{ errors.cle49 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle50')" class="form-group">
                    <label>cle50 </label>
                    <input v-model="form.cle50" class="form-control"
                           type="text">

                    <div v-if="errors.cle50" class='div-error' show variant="danger">
                        {{ errors.cle50 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle51')" class="form-group">
                    <label>cle51 </label>
                    <input v-model="form.cle51" class="form-control"
                           type="text">

                    <div v-if="errors.cle51" class='div-error' show variant="danger">
                        {{ errors.cle51 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle52')" class="form-group">
                    <label>cle52 </label>
                    <input v-model="form.cle52" class="form-control"
                           type="text">

                    <div v-if="errors.cle52" class='div-error' show variant="danger">
                        {{ errors.cle52 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle53')" class="form-group">
                    <label>cle53 </label>
                    <input v-model="form.cle53" class="form-control"
                           type="text">

                    <div v-if="errors.cle53" class='div-error' show variant="danger">
                        {{ errors.cle53 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle54')" class="form-group">
                    <label>cle54 </label>
                    <input v-model="form.cle54" class="form-control"
                           type="text">

                    <div v-if="errors.cle54" class='div-error' show variant="danger">
                        {{ errors.cle54 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle55')" class="form-group">
                    <label>cle55 </label>
                    <input v-model="form.cle55" class="form-control"
                           type="text">

                    <div v-if="errors.cle55" class='div-error' show variant="danger">
                        {{ errors.cle55 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle56')" class="form-group">
                    <label>cle56 </label>
                    <input v-model="form.cle56" class="form-control"
                           type="text">

                    <div v-if="errors.cle56" class='div-error' show variant="danger">
                        {{ errors.cle56 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle57')" class="form-group">
                    <label>cle57 </label>
                    <input v-model="form.cle57" class="form-control"
                           type="text">

                    <div v-if="errors.cle57" class='div-error' show variant="danger">
                        {{ errors.cle57 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle58')" class="form-group">
                    <label>cle58 </label>
                    <input v-model="form.cle58" class="form-control"
                           type="text">

                    <div v-if="errors.cle58" class='div-error' show variant="danger">
                        {{ errors.cle58 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle59')" class="form-group">
                    <label>cle59 </label>
                    <input v-model="form.cle59" class="form-control"
                           type="text">

                    <div v-if="errors.cle59" class='div-error' show variant="danger">
                        {{ errors.cle59 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle60')" class="form-group">
                    <label>cle60 </label>
                    <input v-model="form.cle60" class="form-control"
                           type="text">

                    <div v-if="errors.cle60" class='div-error' show variant="danger">
                        {{ errors.cle60 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle61')" class="form-group">
                    <label>cle61 </label>
                    <input v-model="form.cle61" class="form-control"
                           type="text">

                    <div v-if="errors.cle61" class='div-error' show variant="danger">
                        {{ errors.cle61 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle62')" class="form-group">
                    <label>cle62 </label>
                    <input v-model="form.cle62" class="form-control"
                           type="text">

                    <div v-if="errors.cle62" class='div-error' show variant="danger">
                        {{ errors.cle62 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle63')" class="form-group">
                    <label>cle63 </label>
                    <input v-model="form.cle63" class="form-control"
                           type="text">

                    <div v-if="errors.cle63" class='div-error' show variant="danger">
                        {{ errors.cle63 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle64')" class="form-group">
                    <label>cle64 </label>
                    <input v-model="form.cle64" class="form-control"
                           type="text">

                    <div v-if="errors.cle64" class='div-error' show variant="danger">
                        {{ errors.cle64 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle65')" class="form-group">
                    <label>cle65 </label>
                    <input v-model="form.cle65" class="form-control"
                           type="text">

                    <div v-if="errors.cle65" class='div-error' show variant="danger">
                        {{ errors.cle65 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle66')" class="form-group">
                    <label>cle66 </label>
                    <input v-model="form.cle66" class="form-control"
                           type="text">

                    <div v-if="errors.cle66" class='div-error' show variant="danger">
                        {{ errors.cle66 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle67')" class="form-group">
                    <label>cle67 </label>
                    <input v-model="form.cle67" class="form-control"
                           type="text">

                    <div v-if="errors.cle67" class='div-error' show variant="danger">
                        {{ errors.cle67 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle68')" class="form-group">
                    <label>cle68 </label>
                    <input v-model="form.cle68" class="form-control"
                           type="text">

                    <div v-if="errors.cle68" class='div-error' show variant="danger">
                        {{ errors.cle68 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle69')" class="form-group">
                    <label>cle69 </label>
                    <input v-model="form.cle69" class="form-control"
                           type="text">

                    <div v-if="errors.cle69" class='div-error' show variant="danger">
                        {{ errors.cle69 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle70')" class="form-group">
                    <label>cle70 </label>
                    <input v-model="form.cle70" class="form-control"
                           type="text">

                    <div v-if="errors.cle70" class='div-error' show variant="danger">
                        {{ errors.cle70 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle71')" class="form-group">
                    <label>cle71 </label>
                    <input v-model="form.cle71" class="form-control"
                           type="text">

                    <div v-if="errors.cle71" class='div-error' show variant="danger">
                        {{ errors.cle71 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle72')" class="form-group">
                    <label>cle72 </label>
                    <input v-model="form.cle72" class="form-control"
                           type="text">

                    <div v-if="errors.cle72" class='div-error' show variant="danger">
                        {{ errors.cle72 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle73')" class="form-group">
                    <label>cle73 </label>
                    <input v-model="form.cle73" class="form-control"
                           type="text">

                    <div v-if="errors.cle73" class='div-error' show variant="danger">
                        {{ errors.cle73 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle74')" class="form-group">
                    <label>cle74 </label>
                    <input v-model="form.cle74" class="form-control"
                           type="text">

                    <div v-if="errors.cle74" class='div-error' show variant="danger">
                        {{ errors.cle74 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle75')" class="form-group">
                    <label>cle75 </label>
                    <input v-model="form.cle75" class="form-control"
                           type="text">

                    <div v-if="errors.cle75" class='div-error' show variant="danger">
                        {{ errors.cle75 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle76')" class="form-group">
                    <label>cle76 </label>
                    <input v-model="form.cle76" class="form-control"
                           type="text">

                    <div v-if="errors.cle76" class='div-error' show variant="danger">
                        {{ errors.cle76 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle77')" class="form-group">
                    <label>cle77 </label>
                    <input v-model="form.cle77" class="form-control"
                           type="text">

                    <div v-if="errors.cle77" class='div-error' show variant="danger">
                        {{ errors.cle77 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle78')" class="form-group">
                    <label>cle78 </label>
                    <input v-model="form.cle78" class="form-control"
                           type="text">

                    <div v-if="errors.cle78" class='div-error' show variant="danger">
                        {{ errors.cle78 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle79')" class="form-group">
                    <label>cle79 </label>
                    <input v-model="form.cle79" class="form-control"
                           type="text">

                    <div v-if="errors.cle79" class='div-error' show variant="danger">
                        {{ errors.cle79 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle80')" class="form-group">
                    <label>cle80 </label>
                    <input v-model="form.cle80" class="form-control"
                           type="text">

                    <div v-if="errors.cle80" class='div-error' show variant="danger">
                        {{ errors.cle80 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle81')" class="form-group">
                    <label>cle81 </label>
                    <input v-model="form.cle81" class="form-control"
                           type="text">

                    <div v-if="errors.cle81" class='div-error' show variant="danger">
                        {{ errors.cle81 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle82')" class="form-group">
                    <label>cle82 </label>
                    <input v-model="form.cle82" class="form-control"
                           type="text">

                    <div v-if="errors.cle82" class='div-error' show variant="danger">
                        {{ errors.cle82 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle83')" class="form-group">
                    <label>cle83 </label>
                    <input v-model="form.cle83" class="form-control"
                           type="text">

                    <div v-if="errors.cle83" class='div-error' show variant="danger">
                        {{ errors.cle83 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle84')" class="form-group">
                    <label>cle84 </label>
                    <input v-model="form.cle84" class="form-control"
                           type="text">

                    <div v-if="errors.cle84" class='div-error' show variant="danger">
                        {{ errors.cle84 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle85')" class="form-group">
                    <label>cle85 </label>
                    <input v-model="form.cle85" class="form-control"
                           type="text">

                    <div v-if="errors.cle85" class='div-error' show variant="danger">
                        {{ errors.cle85 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle86')" class="form-group">
                    <label>cle86 </label>
                    <input v-model="form.cle86" class="form-control"
                           type="text">

                    <div v-if="errors.cle86" class='div-error' show variant="danger">
                        {{ errors.cle86 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle87')" class="form-group">
                    <label>cle87 </label>
                    <input v-model="form.cle87" class="form-control"
                           type="text">

                    <div v-if="errors.cle87" class='div-error' show variant="danger">
                        {{ errors.cle87 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle88')" class="form-group">
                    <label>cle88 </label>
                    <input v-model="form.cle88" class="form-control"
                           type="text">

                    <div v-if="errors.cle88" class='div-error' show variant="danger">
                        {{ errors.cle88 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle89')" class="form-group">
                    <label>cle89 </label>
                    <input v-model="form.cle89" class="form-control"
                           type="text">

                    <div v-if="errors.cle89" class='div-error' show variant="danger">
                        {{ errors.cle89 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle90')" class="form-group">
                    <label>cle90 </label>
                    <input v-model="form.cle90" class="form-control"
                           type="text">

                    <div v-if="errors.cle90" class='div-error' show variant="danger">
                        {{ errors.cle90 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle91')" class="form-group">
                    <label>cle91 </label>
                    <input v-model="form.cle91" class="form-control"
                           type="text">

                    <div v-if="errors.cle91" class='div-error' show variant="danger">
                        {{ errors.cle91 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle92')" class="form-group">
                    <label>cle92 </label>
                    <input v-model="form.cle92" class="form-control"
                           type="text">

                    <div v-if="errors.cle92" class='div-error' show variant="danger">
                        {{ errors.cle92 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle93')" class="form-group">
                    <label>cle93 </label>
                    <input v-model="form.cle93" class="form-control"
                           type="text">

                    <div v-if="errors.cle93" class='div-error' show variant="danger">
                        {{ errors.cle93 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle94')" class="form-group">
                    <label>cle94 </label>
                    <input v-model="form.cle94" class="form-control"
                           type="text">

                    <div v-if="errors.cle94" class='div-error' show variant="danger">
                        {{ errors.cle94 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle95')" class="form-group">
                    <label>cle95 </label>
                    <input v-model="form.cle95" class="form-control"
                           type="text">

                    <div v-if="errors.cle95" class='div-error' show variant="danger">
                        {{ errors.cle95 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle96')" class="form-group">
                    <label>cle96 </label>
                    <input v-model="form.cle96" class="form-control"
                           type="text">

                    <div v-if="errors.cle96" class='div-error' show variant="danger">
                        {{ errors.cle96 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle97')" class="form-group">
                    <label>cle97 </label>
                    <input v-model="form.cle97" class="form-control"
                           type="text">

                    <div v-if="errors.cle97" class='div-error' show variant="danger">
                        {{ errors.cle97 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle98')" class="form-group">
                    <label>cle98 </label>
                    <input v-model="form.cle98" class="form-control"
                           type="text">

                    <div v-if="errors.cle98" class='div-error' show variant="danger">
                        {{ errors.cle98 }}
                    </div>
                </div>


                <div v-if="canShowFilter('cle99')" class="form-group">
                    <label>cle99 </label>
                    <input v-model="form.cle99" class="form-control"
                           type="text">

                    <div v-if="errors.cle99" class='div-error' show variant="danger">
                        {{ errors.cle99 }}
                    </div>
                </div>


                <div v-if="canShowFilter('creat_by')" class="form-group">
                    <label>creat_by </label>
                    <input v-model="form.creat_by" class="form-control"
                           type="text">

                    <div v-if="errors.creat_by" class='div-error' show variant="danger">
                        {{ errors.creat_by }}
                    </div>
                </div>


                <div class="form-group">
                    <label>forms </label>
                    <v-select
                        v-model="form.form_id"
                        :options="formsData"
                        :reduce="ele => ele.id"
                        label="Selectlabel"
                        multiple
                    />
                </div>

            </div>

            <button class="btn btn-primary" type="submit">
                <i class="fas fas fa-search"></i> Appliquer
            </button>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'FiltreFormsdatas',
    components: {VSelect, CustomSelect, Files},
    props: [
        'table',
        'formsData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                parent: "",

                form_id: "",

                cle0: "",

                cle1: "",

                cle2: "",

                cle3: "",

                cle4: "",

                cle5: "",

                cle6: "",

                cle7: "",

                cle8: "",

                cle9: "",

                cle10: "",

                cle11: "",

                cle12: "",

                cle13: "",

                cle14: "",

                cle15: "",

                cle16: "",

                cle17: "",

                cle18: "",

                cle19: "",

                cle20: "",

                cle21: "",

                cle22: "",

                cle23: "",

                cle24: "",

                cle25: "",

                cle26: "",

                cle27: "",

                cle28: "",

                cle29: "",

                cle30: "",

                cle31: "",

                cle32: "",

                cle33: "",

                cle34: "",

                cle35: "",

                cle36: "",

                cle37: "",

                cle38: "",

                cle39: "",

                cle40: "",

                cle41: "",

                cle42: "",

                cle43: "",

                cle44: "",

                cle45: "",

                cle46: "",

                cle47: "",

                cle48: "",

                cle49: "",

                cle50: "",

                cle51: "",

                cle52: "",

                cle53: "",

                cle54: "",

                cle55: "",

                cle56: "",

                cle57: "",

                cle58: "",

                cle59: "",

                cle60: "",

                cle61: "",

                cle62: "",

                cle63: "",

                cle64: "",

                cle65: "",

                cle66: "",

                cle67: "",

                cle68: "",

                cle69: "",

                cle70: "",

                cle71: "",

                cle72: "",

                cle73: "",

                cle74: "",

                cle75: "",

                cle76: "",

                cle77: "",

                cle78: "",

                cle79: "",

                cle80: "",

                cle81: "",

                cle82: "",

                cle83: "",

                cle84: "",

                cle85: "",

                cle86: "",

                cle87: "",

                cle88: "",

                cle89: "",

                cle90: "",

                cle91: "",

                cle92: "",

                cle93: "",

                cle94: "",

                cle95: "",

                cle96: "",

                cle97: "",

                cle98: "",

                cle99: "",

                extra_attributes: "",

                creat_by: "",

                deleted_at: "",

                created_at: "",

                updated_at: "",
            }
        }
    },
    methods: {
        createLine() {
            this.$emit('applyfilter', this.form)
        },
        canShowFilter(name) {
            let can = true
            const queryString = window.location.search
            const urlParams = new URLSearchParams(queryString);
            if (urlParams.has(`filter_${name}`)) {
                can = false
            }
            return can
        }
    }
}
</script>
