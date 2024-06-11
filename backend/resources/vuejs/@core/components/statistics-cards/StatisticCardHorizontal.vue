<template>
    <b-card no-body>
        <b-card-body class="align-content-center"
            :style="`background:${background};border-radius:5px`">
                    <h3 class="mb-25 font-weight-bolder" :style="`color:${textColor}`">
                        {{ statistic }}
                    </h3>
                        <!-- <li class="h5" v-if="donner1" :style="`color:${textColor}`" >{{ donner1 }}</li>
                        <li class="h5" :style="`color:${textColor}`" >{{ donner2 }}</li>
                        <li class="h5" :style="`color:${textColor}`" >{{ donner3 }}</li>
                <i  :style="`color:${textColor}`">( {{ statistic }} )</i> -->

            <!-- </div> -->
            <!-- <b-avatar :variant="`light-${color}`" size="45">
                <feather-icon :style="`color:${iconColor}`" size="21" :icon="icon" />
            </b-avatar> -->

<span  :style="`color:${textColor}`">{{ statisticTitle }}  </span>

        </b-card-body>
    </b-card>
</template>

<script>
import { BCard, BCardBody, BAvatar } from 'bootstrap-vue'

export default {
    components: {
        BCard,
        BCardBody,
        BAvatar,
    },
    props: {
        icon: {
            type: String,
            required: true,
        },
        iconColor: {
            type: String,
            default: "#fff"
        },
        statistic: {
            type: [Number, String],
            required: true,
        },
        donner1: {
            type: [Number, String],
            required: true,
        },
        donner2: {
            type: [Number, String],
            required: true,
        },
        donner3: {
            type: [Number, String],
            required: true,
        },
        statisticTitle: {
            type: String,
            default: '',
        },
        Title: {
            type: String,
            default: '',
        },
        Titledonner1: {
            type: String,
            default: '',
        },
        Titledonner2: {
            type: String,
            default: '',
        },
        Titledonner3: {
            type: String,
            default: '',
        },
        color: {
            type: String,
            default: 'primary',
        },
        textColor: {
            type: String,
            default: '#fff',
        },
        background: {
            type: String,
            default: '#fff',
        },
    },
}
</script>
<style></style>
