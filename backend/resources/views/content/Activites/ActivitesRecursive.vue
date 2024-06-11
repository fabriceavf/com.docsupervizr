<template>
    <div>

        <div v-for="(item, index) in comments">
            {{ item.libelle }}
            <ActivitesRecursive v-if="item.comments"
                                v-bind="{
                    comments: item.comments,
                  }"></ActivitesRecursive>

        </div>
    </div>


</template>

<script>

export default {
    name: "ActivitesRecursive",
    props: {
        comments: {
            type: Array,
            required: true,
        }
    },
    computed: {}
}
</script>

<style scoped>

</style>
