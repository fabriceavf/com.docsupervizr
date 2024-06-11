<template>
    <slot name="clickable" @click=""></slot>
    <b-modal :id="formId" :size="formWidth">
        <template #modal-title>
            <slot name="clickable" @click=""></slot>
            <div>Ajouter des agents a la liste</div>
        </template>

        <AgGridSearch
            :columnDefs="add.columnDefs"
            :extrasData="add.extrasData"
            :filterFields="['nom','prenom','matricule']"
            :url="add.url"
            filter-key="type_id"
            filter-value="2"
            @destruction="finishAddUser"
        >
        </AgGridSearch>


        <template #modal-footer>
            <div></div>
        </template>
    </b-modal>
</template>

<script>
export default {
    name: "Popups",
    methods:{

    }
}
</script>

<style scoped>

</style>
