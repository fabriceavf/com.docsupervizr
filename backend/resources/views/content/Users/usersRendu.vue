<template>
    <div>
        <p v-for="user in data" @click="showUser(user)">
            {{ user.nom }}
        </p>
    </div>


</template>

<script>

export default {
    name: "UsersRendu",
    props: ['api', 'data'],
    mounted() {
        console.log('voici lapi passer en props ==>', this.api)
    },
    methods: {
        showUser(user) {
            alert(user.nom)
        }
    }
}
</script>

<style scoped>

</style>
