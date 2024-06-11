<template>
    <div>
        data

    </div>

</template>

<script>
import AgGridSearch from "@/components/AgGridSearch.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: "CustomSelectRender",
    components: {AgGridSearch, AgGridBtnClicked},
    props: {

    },
    data() {
        return {


        }
    },

    mounted() {




    },

    computed: {

        columns: function () {


        },
    },
    methods: {
    }

}
</script>

<style>
.ag-theme-alpine {

    --ag-font-size: 10px;
}

.deactivate {
    position: absolute;
    right: 5px;
    top: 5px;
    cursor:pointer
}
.noShow{
    display:none
}
.btn-disable{
    background: #cacaca73;
}
.withShow{
    margin: 5px auto;
    width: 98%;
    position: absolute;
    z-index: 1000;
    background: #fff;
    padding: 10px;
    border: 1px solid #cecece;
}
</style>
