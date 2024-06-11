<template>
    <div>
        <CkeditorInput
            :disable="disable"
            :donnes="donnes"
            @changeData="updateData"
        >
        </CkeditorInput>

    </div>
</template>


<script>
import CkeditorInput from "./Ckeditor/CkeditorInput.vue"

export default {
    name: "Messages",
    components: {CkeditorInput},
    props: {
        disable: {
            default: false,
            type: Boolean
        },
        donnes: {
            type: String
        }
    },
    data() {
        return {}


    },
    methods: {
        updateData(data) {
            this.$emit('changeData', data)
        }
    },
    mounted() {
    }
}
</script>

<style scoped>

</style>
