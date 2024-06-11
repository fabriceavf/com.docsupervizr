<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div class="form-group">
                    <label>rand </label>
                    <input v-model="form.rand" :class="errors.rand?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.rand" class="invalid-feedback">
                        <template v-for=" error in errors.rand"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour01 </label>
                    <input v-model="form.jour01" :class="errors.jour01?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour01" class="invalid-feedback">
                        <template v-for=" error in errors.jour01"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour02 </label>
                    <input v-model="form.jour02" :class="errors.jour02?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour02" class="invalid-feedback">
                        <template v-for=" error in errors.jour02"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour03 </label>
                    <input v-model="form.jour03" :class="errors.jour03?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour03" class="invalid-feedback">
                        <template v-for=" error in errors.jour03"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour04 </label>
                    <input v-model="form.jour04" :class="errors.jour04?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour04" class="invalid-feedback">
                        <template v-for=" error in errors.jour04"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour05 </label>
                    <input v-model="form.jour05" :class="errors.jour05?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour05" class="invalid-feedback">
                        <template v-for=" error in errors.jour05"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour06 </label>
                    <input v-model="form.jour06" :class="errors.jour06?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour06" class="invalid-feedback">
                        <template v-for=" error in errors.jour06"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour07 </label>
                    <input v-model="form.jour07" :class="errors.jour07?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour07" class="invalid-feedback">
                        <template v-for=" error in errors.jour07"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour08 </label>
                    <input v-model="form.jour08" :class="errors.jour08?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour08" class="invalid-feedback">
                        <template v-for=" error in errors.jour08"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour09 </label>
                    <input v-model="form.jour09" :class="errors.jour09?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour09" class="invalid-feedback">
                        <template v-for=" error in errors.jour09"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour10 </label>
                    <input v-model="form.jour10" :class="errors.jour10?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour10" class="invalid-feedback">
                        <template v-for=" error in errors.jour10"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour11 </label>
                    <input v-model="form.jour11" :class="errors.jour11?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour11" class="invalid-feedback">
                        <template v-for=" error in errors.jour11"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour12 </label>
                    <input v-model="form.jour12" :class="errors.jour12?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour12" class="invalid-feedback">
                        <template v-for=" error in errors.jour12"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour13 </label>
                    <input v-model="form.jour13" :class="errors.jour13?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour13" class="invalid-feedback">
                        <template v-for=" error in errors.jour13"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour14 </label>
                    <input v-model="form.jour14" :class="errors.jour14?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour14" class="invalid-feedback">
                        <template v-for=" error in errors.jour14"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour15 </label>
                    <input v-model="form.jour15" :class="errors.jour15?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour15" class="invalid-feedback">
                        <template v-for=" error in errors.jour15"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour16 </label>
                    <input v-model="form.jour16" :class="errors.jour16?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour16" class="invalid-feedback">
                        <template v-for=" error in errors.jour16"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour17 </label>
                    <input v-model="form.jour17" :class="errors.jour17?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour17" class="invalid-feedback">
                        <template v-for=" error in errors.jour17"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour18 </label>
                    <input v-model="form.jour18" :class="errors.jour18?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour18" class="invalid-feedback">
                        <template v-for=" error in errors.jour18"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour19 </label>
                    <input v-model="form.jour19" :class="errors.jour19?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour19" class="invalid-feedback">
                        <template v-for=" error in errors.jour19"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour20 </label>
                    <input v-model="form.jour20" :class="errors.jour20?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour20" class="invalid-feedback">
                        <template v-for=" error in errors.jour20"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour21 </label>
                    <input v-model="form.jour21" :class="errors.jour21?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour21" class="invalid-feedback">
                        <template v-for=" error in errors.jour21"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour22 </label>
                    <input v-model="form.jour22" :class="errors.jour22?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour22" class="invalid-feedback">
                        <template v-for=" error in errors.jour22"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour23 </label>
                    <input v-model="form.jour23" :class="errors.jour23?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour23" class="invalid-feedback">
                        <template v-for=" error in errors.jour23"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour24 </label>
                    <input v-model="form.jour24" :class="errors.jour24?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour24" class="invalid-feedback">
                        <template v-for=" error in errors.jour24"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour25 </label>
                    <input v-model="form.jour25" :class="errors.jour25?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour25" class="invalid-feedback">
                        <template v-for=" error in errors.jour25"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour26 </label>
                    <input v-model="form.jour26" :class="errors.jour26?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour26" class="invalid-feedback">
                        <template v-for=" error in errors.jour26"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour27 </label>
                    <input v-model="form.jour27" :class="errors.jour27?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour27" class="invalid-feedback">
                        <template v-for=" error in errors.jour27"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour28 </label>
                    <input v-model="form.jour28" :class="errors.jour28?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour28" class="invalid-feedback">
                        <template v-for=" error in errors.jour28"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour29 </label>
                    <input v-model="form.jour29" :class="errors.jour29?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour29" class="invalid-feedback">
                        <template v-for=" error in errors.jour29"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour30 </label>
                    <input v-model="form.jour30" :class="errors.jour30?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour30" class="invalid-feedback">
                        <template v-for=" error in errors.jour30"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>jour31 </label>
                    <input v-model="form.jour31" :class="errors.jour31?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.jour31" class="invalid-feedback">
                        <template v-for=" error in errors.jour31"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache01 </label>
                    <input v-model="form.tache01" :class="errors.tache01?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache01" class="invalid-feedback">
                        <template v-for=" error in errors.tache01"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache02 </label>
                    <input v-model="form.tache02" :class="errors.tache02?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache02" class="invalid-feedback">
                        <template v-for=" error in errors.tache02"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache03 </label>
                    <input v-model="form.tache03" :class="errors.tache03?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache03" class="invalid-feedback">
                        <template v-for=" error in errors.tache03"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache04 </label>
                    <input v-model="form.tache04" :class="errors.tache04?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache04" class="invalid-feedback">
                        <template v-for=" error in errors.tache04"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache05 </label>
                    <input v-model="form.tache05" :class="errors.tache05?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache05" class="invalid-feedback">
                        <template v-for=" error in errors.tache05"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache06 </label>
                    <input v-model="form.tache06" :class="errors.tache06?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache06" class="invalid-feedback">
                        <template v-for=" error in errors.tache06"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache07 </label>
                    <input v-model="form.tache07" :class="errors.tache07?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache07" class="invalid-feedback">
                        <template v-for=" error in errors.tache07"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache08 </label>
                    <input v-model="form.tache08" :class="errors.tache08?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache08" class="invalid-feedback">
                        <template v-for=" error in errors.tache08"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache09 </label>
                    <input v-model="form.tache09" :class="errors.tache09?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache09" class="invalid-feedback">
                        <template v-for=" error in errors.tache09"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache10 </label>
                    <input v-model="form.tache10" :class="errors.tache10?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache10" class="invalid-feedback">
                        <template v-for=" error in errors.tache10"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache11 </label>
                    <input v-model="form.tache11" :class="errors.tache11?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache11" class="invalid-feedback">
                        <template v-for=" error in errors.tache11"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache12 </label>
                    <input v-model="form.tache12" :class="errors.tache12?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache12" class="invalid-feedback">
                        <template v-for=" error in errors.tache12"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache13 </label>
                    <input v-model="form.tache13" :class="errors.tache13?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache13" class="invalid-feedback">
                        <template v-for=" error in errors.tache13"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache14 </label>
                    <input v-model="form.tache14" :class="errors.tache14?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache14" class="invalid-feedback">
                        <template v-for=" error in errors.tache14"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache15 </label>
                    <input v-model="form.tache15" :class="errors.tache15?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache15" class="invalid-feedback">
                        <template v-for=" error in errors.tache15"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache16 </label>
                    <input v-model="form.tache16" :class="errors.tache16?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache16" class="invalid-feedback">
                        <template v-for=" error in errors.tache16"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache17 </label>
                    <input v-model="form.tache17" :class="errors.tache17?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache17" class="invalid-feedback">
                        <template v-for=" error in errors.tache17"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache18 </label>
                    <input v-model="form.tache18" :class="errors.tache18?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache18" class="invalid-feedback">
                        <template v-for=" error in errors.tache18"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache19 </label>
                    <input v-model="form.tache19" :class="errors.tache19?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache19" class="invalid-feedback">
                        <template v-for=" error in errors.tache19"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache20 </label>
                    <input v-model="form.tache20" :class="errors.tache20?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache20" class="invalid-feedback">
                        <template v-for=" error in errors.tache20"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache21 </label>
                    <input v-model="form.tache21" :class="errors.tache21?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache21" class="invalid-feedback">
                        <template v-for=" error in errors.tache21"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache22 </label>
                    <input v-model="form.tache22" :class="errors.tache22?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache22" class="invalid-feedback">
                        <template v-for=" error in errors.tache22"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache23 </label>
                    <input v-model="form.tache23" :class="errors.tache23?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache23" class="invalid-feedback">
                        <template v-for=" error in errors.tache23"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache24 </label>
                    <input v-model="form.tache24" :class="errors.tache24?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache24" class="invalid-feedback">
                        <template v-for=" error in errors.tache24"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache25 </label>
                    <input v-model="form.tache25" :class="errors.tache25?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache25" class="invalid-feedback">
                        <template v-for=" error in errors.tache25"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache26 </label>
                    <input v-model="form.tache26" :class="errors.tache26?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache26" class="invalid-feedback">
                        <template v-for=" error in errors.tache26"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache27 </label>
                    <input v-model="form.tache27" :class="errors.tache27?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache27" class="invalid-feedback">
                        <template v-for=" error in errors.tache27"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache28 </label>
                    <input v-model="form.tache28" :class="errors.tache28?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache28" class="invalid-feedback">
                        <template v-for=" error in errors.tache28"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache29 </label>
                    <input v-model="form.tache29" :class="errors.tache29?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache29" class="invalid-feedback">
                        <template v-for=" error in errors.tache29"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache30 </label>
                    <input v-model="form.tache30" :class="errors.tache30?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache30" class="invalid-feedback">
                        <template v-for=" error in errors.tache30"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>tache31 </label>
                    <input v-model="form.tache31" :class="errors.tache31?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.tache31" class="invalid-feedback">
                        <template v-for=" error in errors.tache31"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>identifiants_sadge </label>
                    <input v-model="form.identifiants_sadge"
                           :class="errors.identifiants_sadge?'form-control is-invalid':'form-control'"
                           type="text">

                    <div v-if="errors.identifiants_sadge" class="invalid-feedback">
                        <template v-for=" error in errors.identifiants_sadge"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>listesappels </label>
                    <CustomSelect
                        :key="form.listesappel"
                        :columnDefs="['libelle']"
                        :oldValue="form.listesappel"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.listesappel_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/listesappels-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.listesappel_id" class="invalid-feedback">
                        <template v-for=" error in errors.listesappel_id"> {{ error[0] }}</template>

                    </div>
                </div>


                <div class="form-group">
                    <label>users </label>
                    <CustomSelect
                        :key="form.user"
                        :columnDefs="['nom','prenom','matricule']"
                        :oldValue="form.user"
                        :renderCallBack="(data)=>`${data.Selectlabel}`"
                        :selectCallBack="(data)=>form.user_id=data.id"
                        :url="`${axios.defaults.baseURL}/api/users-Aggrid`"
                        filter-key=""
                        filter-value=""
                    />
                    <div v-if="errors.user_id" class="invalid-feedback">
                        <template v-for=" error in errors.user_id"> {{ error[0] }}</template>

                    </div>
                </div>

            </div>

            <button class="btn btn-primary" type="submit">
                <i class="fas fa-floppy-disk"></i> Créer
            </button>
        </form>
    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

import Files from "@/components/Files.vue"
import VSelect from 'vue-select'

export default {
    name: 'CreateListesappelsjours',
    components: {VSelect, CustomSelect, Files},
    props: [
        'gridApi',
        'modalFormId',
        'listesappelsData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                rand: "",

                jour01: "",

                jour02: "",

                jour03: "",

                jour04: "",

                jour05: "",

                jour06: "",

                jour07: "",

                jour08: "",

                jour09: "",

                jour10: "",

                jour11: "",

                jour12: "",

                jour13: "",

                jour14: "",

                jour15: "",

                jour16: "",

                jour17: "",

                jour18: "",

                jour19: "",

                jour20: "",

                jour21: "",

                jour22: "",

                jour23: "",

                jour24: "",

                jour25: "",

                jour26: "",

                jour27: "",

                jour28: "",

                jour29: "",

                jour30: "",

                jour31: "",

                tache01: "",

                tache02: "",

                tache03: "",

                tache04: "",

                tache05: "",

                tache06: "",

                tache07: "",

                tache08: "",

                tache09: "",

                tache10: "",

                tache11: "",

                tache12: "",

                tache13: "",

                tache14: "",

                tache15: "",

                tache16: "",

                tache17: "",

                tache18: "",

                tache19: "",

                tache20: "",

                tache21: "",

                tache22: "",

                tache23: "",

                tache24: "",

                tache25: "",

                tache26: "",

                tache27: "",

                tache28: "",

                tache29: "",

                tache30: "",

                tache31: "",

                listesappel_id: "",

                user_id: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                identifiants_sadge: "",
            }
        }
    },
    methods: {
        createLine() {
            this.isLoading = true
            this.axios.post('/api/listesappelsjours', this.form).then(response => {
                this.isLoading = false
                this.resetForm()
                this.gridApi.applyServerSideTransaction({
                    add: [
                        response.data
                    ],
                });
                this.gridApi.refreshServerSide()
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
        resetForm() {
            this.form = {
                id: "",
                rand: "",
                jour01: "",
                jour02: "",
                jour03: "",
                jour04: "",
                jour05: "",
                jour06: "",
                jour07: "",
                jour08: "",
                jour09: "",
                jour10: "",
                jour11: "",
                jour12: "",
                jour13: "",
                jour14: "",
                jour15: "",
                jour16: "",
                jour17: "",
                jour18: "",
                jour19: "",
                jour20: "",
                jour21: "",
                jour22: "",
                jour23: "",
                jour24: "",
                jour25: "",
                jour26: "",
                jour27: "",
                jour28: "",
                jour29: "",
                jour30: "",
                jour31: "",
                tache01: "",
                tache02: "",
                tache03: "",
                tache04: "",
                tache05: "",
                tache06: "",
                tache07: "",
                tache08: "",
                tache09: "",
                tache10: "",
                tache11: "",
                tache12: "",
                tache13: "",
                tache14: "",
                tache15: "",
                tache16: "",
                tache17: "",
                tache18: "",
                tache19: "",
                tache20: "",
                tache21: "",
                tache22: "",
                tache23: "",
                tache24: "",
                tache25: "",
                tache26: "",
                tache27: "",
                tache28: "",
                tache29: "",
                tache30: "",
                tache31: "",
                listesappel_id: "",
                user_id: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
                identifiants_sadge: "",
            }
        }
    }
}
</script>
