<template>
    <b-overlay :show="isLoading">
        <form @submit.prevent="createLine()">
            <div class="mb-3">


                <div v-if="canShowFilter('lat')" class="form-group">
                    <label>lat </label>
                    <input v-model="form.lat" class="form-control"
                           type="text">

                    <div v-if="errors.lat" class='div-error' show variant="danger">
                        {{ errors.lat }}
                    </div>
                </div>


                <div v-if="canShowFilter('lon')" class="form-group">
                    <label>lon </label>
                    <input v-model="form.lon" class="form-control"
                           type="text">

                    <div v-if="errors.lon" class='div-error' show variant="danger">
                        {{ errors.lon }}
                    </div>
                </div>


                <div v-if="canShowFilter('name')" class="form-group">
                    <label>name </label>
                    <input v-model="form.name" class="form-control"
                           type="text">

                    <div v-if="errors.name" class='div-error' show variant="danger">
                        {{ errors.name }}
                    </div>
                </div>


                <div v-if="canShowFilter('title')" class="form-group">
                    <label>title </label>
                    <input v-model="form.title" class="form-control"
                           type="text">

                    <div v-if="errors.title" class='div-error' show variant="danger">
                        {{ errors.title }}
                    </div>
                </div>


                <div v-if="canShowFilter('speed')" class="form-group">
                    <label>speed </label>
                    <input v-model="form.speed" class="form-control"
                           type="text">

                    <div v-if="errors.speed" class='div-error' show variant="danger">
                        {{ errors.speed }}
                    </div>
                </div>


                <div v-if="canShowFilter('icon_color')" class="form-group">
                    <label>icon_color </label>
                    <input v-model="form.icon_color" class="form-control"
                           type="text">

                    <div v-if="errors.icon_color" class='div-error' show variant="danger">
                        {{ errors.icon_color }}
                    </div>
                </div>


                <div v-if="canShowFilter('moyenstransportid')" class="form-group">
                    <label>moyenstransportid </label>
                    <input v-model="form.moyenstransportid" class="form-control"
                           type="text">

                    <div v-if="errors.moyenstransportid" class='div-error' show variant="danger">
                        {{ errors.moyenstransportid }}
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


                <div v-if="canShowFilter('date')" class="form-group">
                    <label>date </label>
                    <input v-model="form.date" class="form-control"
                           type="text">

                    <div v-if="errors.date" class='div-error' show variant="danger">
                        {{ errors.date }}
                    </div>
                </div>


                <div v-if="canShowFilter('tracername')" class="form-group">
                    <label>tracername </label>
                    <input v-model="form.tracername" class="form-control"
                           type="text">

                    <div v-if="errors.tracername" class='div-error' show variant="danger">
                        {{ errors.tracername }}
                    </div>
                </div>


                <div v-if="canShowFilter('traceruniqueid')" class="form-group">
                    <label>traceruniqueid </label>
                    <input v-model="form.traceruniqueid" class="form-control"
                           type="text">

                    <div v-if="errors.traceruniqueid" class='div-error' show variant="danger">
                        {{ errors.traceruniqueid }}
                    </div>
                </div>


                <div v-if="canShowFilter('sim')" class="form-group">
                    <label>sim </label>
                    <input v-model="form.sim" class="form-control"
                           type="text">

                    <div v-if="errors.sim" class='div-error' show variant="danger">
                        {{ errors.sim }}
                    </div>
                </div>


                <div class="form-group">
                    <label>balises </label>
                    <v-select
                        v-model="form.balise_id"
                        :options="balisesData"
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
import Files from "@/components/Files.vue"
import CustomSelect from "@/components/CustomSelect.vue"

export default {
    name: 'FiltrePositions',
    components: {CustomSelect, Files},
    props: [
        'table',
        'balisesData',
    ],
    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                lat: "",

                lon: "",

                name: "",

                title: "",

                speed: "",

                icon_color: "",

                moyenstransportid: "",

                creat_by: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",

                date: "",

                tracername: "",

                traceruniqueid: "",

                sim: "",

                balise_id: "",
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
