<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="EditLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>parent </label>
                    <input v-model="form.parent" :class="errors.parent?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.parent" class="invalid-feedback">
                        <template v-for=" error in errors.parent"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle0 </label>
                    <input v-model="form.cle0" :class="errors.cle0?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle0" class="invalid-feedback">
                        <template v-for=" error in errors.cle0"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle1 </label>
                    <input v-model="form.cle1" :class="errors.cle1?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle1" class="invalid-feedback">
                        <template v-for=" error in errors.cle1"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle2 </label>
                    <input v-model="form.cle2" :class="errors.cle2?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle2" class="invalid-feedback">
                        <template v-for=" error in errors.cle2"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle3 </label>
                    <input v-model="form.cle3" :class="errors.cle3?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle3" class="invalid-feedback">
                        <template v-for=" error in errors.cle3"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle4 </label>
                    <input v-model="form.cle4" :class="errors.cle4?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle4" class="invalid-feedback">
                        <template v-for=" error in errors.cle4"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle5 </label>
                    <input v-model="form.cle5" :class="errors.cle5?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle5" class="invalid-feedback">
                        <template v-for=" error in errors.cle5"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle6 </label>
                    <input v-model="form.cle6" :class="errors.cle6?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle6" class="invalid-feedback">
                        <template v-for=" error in errors.cle6"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle7 </label>
                    <input v-model="form.cle7" :class="errors.cle7?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle7" class="invalid-feedback">
                        <template v-for=" error in errors.cle7"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle8 </label>
                    <input v-model="form.cle8" :class="errors.cle8?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle8" class="invalid-feedback">
                        <template v-for=" error in errors.cle8"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle9 </label>
                    <input v-model="form.cle9" :class="errors.cle9?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle9" class="invalid-feedback">
                        <template v-for=" error in errors.cle9"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle10 </label>
                    <input v-model="form.cle10" :class="errors.cle10?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle10" class="invalid-feedback">
                        <template v-for=" error in errors.cle10"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle11 </label>
                    <input v-model="form.cle11" :class="errors.cle11?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle11" class="invalid-feedback">
                        <template v-for=" error in errors.cle11"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle12 </label>
                    <input v-model="form.cle12" :class="errors.cle12?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle12" class="invalid-feedback">
                        <template v-for=" error in errors.cle12"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle13 </label>
                    <input v-model="form.cle13" :class="errors.cle13?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle13" class="invalid-feedback">
                        <template v-for=" error in errors.cle13"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle14 </label>
                    <input v-model="form.cle14" :class="errors.cle14?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle14" class="invalid-feedback">
                        <template v-for=" error in errors.cle14"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle15 </label>
                    <input v-model="form.cle15" :class="errors.cle15?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle15" class="invalid-feedback">
                        <template v-for=" error in errors.cle15"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle16 </label>
                    <input v-model="form.cle16" :class="errors.cle16?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle16" class="invalid-feedback">
                        <template v-for=" error in errors.cle16"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle17 </label>
                    <input v-model="form.cle17" :class="errors.cle17?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle17" class="invalid-feedback">
                        <template v-for=" error in errors.cle17"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle18 </label>
                    <input v-model="form.cle18" :class="errors.cle18?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle18" class="invalid-feedback">
                        <template v-for=" error in errors.cle18"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle19 </label>
                    <input v-model="form.cle19" :class="errors.cle19?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle19" class="invalid-feedback">
                        <template v-for=" error in errors.cle19"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle20 </label>
                    <input v-model="form.cle20" :class="errors.cle20?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle20" class="invalid-feedback">
                        <template v-for=" error in errors.cle20"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle21 </label>
                    <input v-model="form.cle21" :class="errors.cle21?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle21" class="invalid-feedback">
                        <template v-for=" error in errors.cle21"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle22 </label>
                    <input v-model="form.cle22" :class="errors.cle22?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle22" class="invalid-feedback">
                        <template v-for=" error in errors.cle22"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle23 </label>
                    <input v-model="form.cle23" :class="errors.cle23?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle23" class="invalid-feedback">
                        <template v-for=" error in errors.cle23"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle24 </label>
                    <input v-model="form.cle24" :class="errors.cle24?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle24" class="invalid-feedback">
                        <template v-for=" error in errors.cle24"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle25 </label>
                    <input v-model="form.cle25" :class="errors.cle25?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle25" class="invalid-feedback">
                        <template v-for=" error in errors.cle25"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle26 </label>
                    <input v-model="form.cle26" :class="errors.cle26?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle26" class="invalid-feedback">
                        <template v-for=" error in errors.cle26"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle27 </label>
                    <input v-model="form.cle27" :class="errors.cle27?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle27" class="invalid-feedback">
                        <template v-for=" error in errors.cle27"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle28 </label>
                    <input v-model="form.cle28" :class="errors.cle28?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle28" class="invalid-feedback">
                        <template v-for=" error in errors.cle28"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle29 </label>
                    <input v-model="form.cle29" :class="errors.cle29?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle29" class="invalid-feedback">
                        <template v-for=" error in errors.cle29"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle30 </label>
                    <input v-model="form.cle30" :class="errors.cle30?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle30" class="invalid-feedback">
                        <template v-for=" error in errors.cle30"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle31 </label>
                    <input v-model="form.cle31" :class="errors.cle31?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle31" class="invalid-feedback">
                        <template v-for=" error in errors.cle31"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle32 </label>
                    <input v-model="form.cle32" :class="errors.cle32?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle32" class="invalid-feedback">
                        <template v-for=" error in errors.cle32"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle33 </label>
                    <input v-model="form.cle33" :class="errors.cle33?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle33" class="invalid-feedback">
                        <template v-for=" error in errors.cle33"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle34 </label>
                    <input v-model="form.cle34" :class="errors.cle34?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle34" class="invalid-feedback">
                        <template v-for=" error in errors.cle34"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle35 </label>
                    <input v-model="form.cle35" :class="errors.cle35?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle35" class="invalid-feedback">
                        <template v-for=" error in errors.cle35"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle36 </label>
                    <input v-model="form.cle36" :class="errors.cle36?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle36" class="invalid-feedback">
                        <template v-for=" error in errors.cle36"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle37 </label>
                    <input v-model="form.cle37" :class="errors.cle37?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle37" class="invalid-feedback">
                        <template v-for=" error in errors.cle37"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle38 </label>
                    <input v-model="form.cle38" :class="errors.cle38?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle38" class="invalid-feedback">
                        <template v-for=" error in errors.cle38"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle39 </label>
                    <input v-model="form.cle39" :class="errors.cle39?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle39" class="invalid-feedback">
                        <template v-for=" error in errors.cle39"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle40 </label>
                    <input v-model="form.cle40" :class="errors.cle40?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle40" class="invalid-feedback">
                        <template v-for=" error in errors.cle40"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle41 </label>
                    <input v-model="form.cle41" :class="errors.cle41?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle41" class="invalid-feedback">
                        <template v-for=" error in errors.cle41"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle42 </label>
                    <input v-model="form.cle42" :class="errors.cle42?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle42" class="invalid-feedback">
                        <template v-for=" error in errors.cle42"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle43 </label>
                    <input v-model="form.cle43" :class="errors.cle43?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle43" class="invalid-feedback">
                        <template v-for=" error in errors.cle43"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle44 </label>
                    <input v-model="form.cle44" :class="errors.cle44?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle44" class="invalid-feedback">
                        <template v-for=" error in errors.cle44"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle45 </label>
                    <input v-model="form.cle45" :class="errors.cle45?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle45" class="invalid-feedback">
                        <template v-for=" error in errors.cle45"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle46 </label>
                    <input v-model="form.cle46" :class="errors.cle46?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle46" class="invalid-feedback">
                        <template v-for=" error in errors.cle46"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle47 </label>
                    <input v-model="form.cle47" :class="errors.cle47?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle47" class="invalid-feedback">
                        <template v-for=" error in errors.cle47"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle48 </label>
                    <input v-model="form.cle48" :class="errors.cle48?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle48" class="invalid-feedback">
                        <template v-for=" error in errors.cle48"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle49 </label>
                    <input v-model="form.cle49" :class="errors.cle49?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle49" class="invalid-feedback">
                        <template v-for=" error in errors.cle49"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle50 </label>
                    <input v-model="form.cle50" :class="errors.cle50?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle50" class="invalid-feedback">
                        <template v-for=" error in errors.cle50"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle51 </label>
                    <input v-model="form.cle51" :class="errors.cle51?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle51" class="invalid-feedback">
                        <template v-for=" error in errors.cle51"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle52 </label>
                    <input v-model="form.cle52" :class="errors.cle52?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle52" class="invalid-feedback">
                        <template v-for=" error in errors.cle52"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle53 </label>
                    <input v-model="form.cle53" :class="errors.cle53?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle53" class="invalid-feedback">
                        <template v-for=" error in errors.cle53"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle54 </label>
                    <input v-model="form.cle54" :class="errors.cle54?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle54" class="invalid-feedback">
                        <template v-for=" error in errors.cle54"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle55 </label>
                    <input v-model="form.cle55" :class="errors.cle55?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle55" class="invalid-feedback">
                        <template v-for=" error in errors.cle55"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle56 </label>
                    <input v-model="form.cle56" :class="errors.cle56?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle56" class="invalid-feedback">
                        <template v-for=" error in errors.cle56"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle57 </label>
                    <input v-model="form.cle57" :class="errors.cle57?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle57" class="invalid-feedback">
                        <template v-for=" error in errors.cle57"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle58 </label>
                    <input v-model="form.cle58" :class="errors.cle58?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle58" class="invalid-feedback">
                        <template v-for=" error in errors.cle58"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle59 </label>
                    <input v-model="form.cle59" :class="errors.cle59?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle59" class="invalid-feedback">
                        <template v-for=" error in errors.cle59"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle60 </label>
                    <input v-model="form.cle60" :class="errors.cle60?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle60" class="invalid-feedback">
                        <template v-for=" error in errors.cle60"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle61 </label>
                    <input v-model="form.cle61" :class="errors.cle61?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle61" class="invalid-feedback">
                        <template v-for=" error in errors.cle61"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle62 </label>
                    <input v-model="form.cle62" :class="errors.cle62?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle62" class="invalid-feedback">
                        <template v-for=" error in errors.cle62"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle63 </label>
                    <input v-model="form.cle63" :class="errors.cle63?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle63" class="invalid-feedback">
                        <template v-for=" error in errors.cle63"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle64 </label>
                    <input v-model="form.cle64" :class="errors.cle64?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle64" class="invalid-feedback">
                        <template v-for=" error in errors.cle64"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle65 </label>
                    <input v-model="form.cle65" :class="errors.cle65?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle65" class="invalid-feedback">
                        <template v-for=" error in errors.cle65"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle66 </label>
                    <input v-model="form.cle66" :class="errors.cle66?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle66" class="invalid-feedback">
                        <template v-for=" error in errors.cle66"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle67 </label>
                    <input v-model="form.cle67" :class="errors.cle67?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle67" class="invalid-feedback">
                        <template v-for=" error in errors.cle67"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle68 </label>
                    <input v-model="form.cle68" :class="errors.cle68?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle68" class="invalid-feedback">
                        <template v-for=" error in errors.cle68"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle69 </label>
                    <input v-model="form.cle69" :class="errors.cle69?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle69" class="invalid-feedback">
                        <template v-for=" error in errors.cle69"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle70 </label>
                    <input v-model="form.cle70" :class="errors.cle70?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle70" class="invalid-feedback">
                        <template v-for=" error in errors.cle70"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle71 </label>
                    <input v-model="form.cle71" :class="errors.cle71?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle71" class="invalid-feedback">
                        <template v-for=" error in errors.cle71"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle72 </label>
                    <input v-model="form.cle72" :class="errors.cle72?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle72" class="invalid-feedback">
                        <template v-for=" error in errors.cle72"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle73 </label>
                    <input v-model="form.cle73" :class="errors.cle73?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle73" class="invalid-feedback">
                        <template v-for=" error in errors.cle73"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle74 </label>
                    <input v-model="form.cle74" :class="errors.cle74?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle74" class="invalid-feedback">
                        <template v-for=" error in errors.cle74"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle75 </label>
                    <input v-model="form.cle75" :class="errors.cle75?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle75" class="invalid-feedback">
                        <template v-for=" error in errors.cle75"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle76 </label>
                    <input v-model="form.cle76" :class="errors.cle76?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle76" class="invalid-feedback">
                        <template v-for=" error in errors.cle76"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle77 </label>
                    <input v-model="form.cle77" :class="errors.cle77?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle77" class="invalid-feedback">
                        <template v-for=" error in errors.cle77"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle78 </label>
                    <input v-model="form.cle78" :class="errors.cle78?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle78" class="invalid-feedback">
                        <template v-for=" error in errors.cle78"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle79 </label>
                    <input v-model="form.cle79" :class="errors.cle79?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle79" class="invalid-feedback">
                        <template v-for=" error in errors.cle79"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle80 </label>
                    <input v-model="form.cle80" :class="errors.cle80?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle80" class="invalid-feedback">
                        <template v-for=" error in errors.cle80"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle81 </label>
                    <input v-model="form.cle81" :class="errors.cle81?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle81" class="invalid-feedback">
                        <template v-for=" error in errors.cle81"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle82 </label>
                    <input v-model="form.cle82" :class="errors.cle82?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle82" class="invalid-feedback">
                        <template v-for=" error in errors.cle82"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle83 </label>
                    <input v-model="form.cle83" :class="errors.cle83?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle83" class="invalid-feedback">
                        <template v-for=" error in errors.cle83"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle84 </label>
                    <input v-model="form.cle84" :class="errors.cle84?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle84" class="invalid-feedback">
                        <template v-for=" error in errors.cle84"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle85 </label>
                    <input v-model="form.cle85" :class="errors.cle85?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle85" class="invalid-feedback">
                        <template v-for=" error in errors.cle85"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle86 </label>
                    <input v-model="form.cle86" :class="errors.cle86?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle86" class="invalid-feedback">
                        <template v-for=" error in errors.cle86"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle87 </label>
                    <input v-model="form.cle87" :class="errors.cle87?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle87" class="invalid-feedback">
                        <template v-for=" error in errors.cle87"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle88 </label>
                    <input v-model="form.cle88" :class="errors.cle88?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle88" class="invalid-feedback">
                        <template v-for=" error in errors.cle88"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle89 </label>
                    <input v-model="form.cle89" :class="errors.cle89?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle89" class="invalid-feedback">
                        <template v-for=" error in errors.cle89"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle90 </label>
                    <input v-model="form.cle90" :class="errors.cle90?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle90" class="invalid-feedback">
                        <template v-for=" error in errors.cle90"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle91 </label>
                    <input v-model="form.cle91" :class="errors.cle91?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle91" class="invalid-feedback">
                        <template v-for=" error in errors.cle91"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle92 </label>
                    <input v-model="form.cle92" :class="errors.cle92?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle92" class="invalid-feedback">
                        <template v-for=" error in errors.cle92"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle93 </label>
                    <input v-model="form.cle93" :class="errors.cle93?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle93" class="invalid-feedback">
                        <template v-for=" error in errors.cle93"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle94 </label>
                    <input v-model="form.cle94" :class="errors.cle94?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle94" class="invalid-feedback">
                        <template v-for=" error in errors.cle94"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle95 </label>
                    <input v-model="form.cle95" :class="errors.cle95?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle95" class="invalid-feedback">
                        <template v-for=" error in errors.cle95"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle96 </label>
                    <input v-model="form.cle96" :class="errors.cle96?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle96" class="invalid-feedback">
                        <template v-for=" error in errors.cle96"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle97 </label>
                    <input v-model="form.cle97" :class="errors.cle97?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle97" class="invalid-feedback">
                        <template v-for=" error in errors.cle97"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle98 </label>
                    <input v-model="form.cle98" :class="errors.cle98?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle98" class="invalid-feedback">
                        <template v-for=" error in errors.cle98"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>cle99 </label>
                    <input v-model="form.cle99" :class="errors.cle99?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.cle99" class="invalid-feedback">
                        <template v-for=" error in errors.cle99"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>creat_by </label>
                    <input v-model="form.creat_by" :class="errors.creat_by?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.creat_by" class="invalid-feedback">
                        <template v-for=" error in errors.creat_by"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>forms </label>
                    <CustomSelect
                        :key="form.form"
                        :columnDefs="['libelle']"
                        :oldValue="form.form"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.form_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/forms-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.form_id" class="invalid-feedback">
                        <template v-for=" error in errors.form_id"> {{ error[0] }}</template>

                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-floppy-disk"></i> Mettre à jour
                </button>
                <button class="btn btn-danger" type="button" @click.prevent="DeleteLine()">
                    <i class="fas fa-close"></i> Supprimer
                </button>
            </div>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'EditFormsdatas',
    components: {VSelect, CustomSelect, Files},
    props: ['data', 'gridApi', 'modalFormId',
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

    mounted() {
        this.form = this.data
    },
    methods: {

        EditLine() {
            this.isLoading = true
            this.axios.post('/api/formsdatas/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/formsdatas/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
    }
}
</script>
