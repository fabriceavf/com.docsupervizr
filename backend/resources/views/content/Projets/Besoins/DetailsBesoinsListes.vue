<template>
    <b-overlay>
        <div style="padding:10px;margin:0 auto;width:95%">
            <div class="row">
                <div class="col-sm-12">
                    <ActionsprevisionellesView :parentId="params.data.id"></ActionsprevisionellesView>
                </div>

            </div>


        </div>

    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import VSelect from 'vue-select'
import ActionsprevisionellesView from "./Actionsprevisionelles/ActionsprevisionellesView.vue";
import ActionsrealisesView from "./Actionsrealises/ActionsrealisesView.vue";

export default {
    name: 'DetailsBesoinsListes',
    components: {VSelect, CustomSelect, Files, ActionsprevisionellesView, ActionsrealisesView},
    props: [],
    data() {
        return {}
    },

    mounted() {

    },
    methods: {}
}
</script>
<style>
.dataBlock {
    box-shadow: rgba(0, 0, 0, 0.24) 2px 1px 9px;
    width: 98%;
    margin: 0 auto;
    padding: 10px;
    border: 1px solid #04040438;
    border-radius: 5px;
}
</style>
