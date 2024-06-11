<template>
    <b-card no-body>
        <b-card-body class="align-content-center"
            :style="`background:${background};border-radius:5px`">
                    <!-- <h3 class="mb-25 font-weight-bolder" :style="`color:${textColor}`">
                        {{ statisticTitle }}
                    </h3>
                        <li class="h5" v-if="donner1" :style="`color:${textColor}`" >{{ donner1 }}</li>
                        <li class="h5" :style="`color:${textColor}`" >{{ donner2 }}</li>
                        <li class="h5" :style="`color:${textColor}`" >{{ donner3 }}</li>
                <i  :style="`color:${textColor}`">( {{ statistic }} )</i> -->

            <!-- </div> -->
            <!-- <b-avatar :variant="`light-${color}`" size="45">
                <feather-icon :style="`color:${iconColor}`" size="21" :icon="icon" />
            </b-avatar> -->

            <!-- <table class="table table-borderless table-sm">
    <tr class="h4" :style="`color:${textColor}`">
        <td >{{ Title }} : </td>
        <td>{{ statisticTitle }}</td>
    </tr>
    <tr class="h5" :style="`color:${textColor}`">
        <td v-if="Titledonner1">-{{ Titledonner1 }}  </td>
        <td v-else="" :style="{ opacity: 0  }"> -{{ Titledonner1 }}  </td>

        <td>{{ donner1 }}</td>
    </tr>
    <tr  class="h5" :style="`color:${textColor}`">
        <td>- {{ Titledonner2 }} : </td>
        <td >{{ donner2 }}</td>
    </tr>
    <tr class="h5" :style="`color:${textColor}`">
        <td>- {{ Titledonner3 }} : </td>
        <td >{{ donner3 }}</td>
    </tr>
        <tr  class="h5" :style="`color:${textColor}`">
        <td  v-if="Titledonner4">- {{ Titledonner4 }} : </td>
        <td v-else="" :style="{ opacity: 0  }" >{{ Titledonner4 }}</td>

                <td>{{ donner4 }}</td>
    </tr>
    <tr class="h5" :style="`color:${textColor}`">
        <td v-if="Titledonner5">- {{ Titledonner5 }} : </td>
        <td v-else="" :style="{ opacity: 0  }" >{{ Titledonner5 }}</td>

                <td>{{ donner5 }}</td>
    </tr>
</table> -->
<table class="table table-borderless table-sm">
    <tr class="h4" :style="`color:${textColor}`">
        <td>{{ Title }} : </td>
        <td>{{ statisticTitle }}</td>
    </tr>
    <tr class="h5" :style="`color:${textColor}`">
        <td v-if="Titledonner1">- {{ Titledonner1 }}  </td>
        <td v-else :style="{ opacity: 0  }">-</td>
        <td>{{ donner1 }}</td>
    </tr>
    <tr class="h5" :style="`color:${textColor}`">
        <td v-if="Titledonner2">- {{ Titledonner2 }} : </td>
        <td v-else :style="{ opacity: 0  }">-</td>
        <td>{{ donner2 }}</td>
    </tr>
    <tr class="h5" :style="`color:${textColor}`">
        <td v-if="Titledonner3">- {{ Titledonner3 }} : </td>
        <td v-else :style="{ opacity: 0  }">-</td>
        <td>{{ donner3 }}</td>
    </tr>
    <tr class="h5" :style="`color:${textColor}`">
        <td v-if="Titledonner4">- {{ Titledonner4 }} : </td>
        <td v-else :style="{ opacity: 0  }">-</td>
        <td>{{ donner4 }}</td>
    </tr>
    <tr class="h5" :style="`color:${textColor}`">
        <td v-if="Titledonner5">- {{ Titledonner5 }} : </td>
        <td v-else :style="{ opacity: 0  }">-</td>
        <td>{{ donner5 }}</td>
    </tr>
</table>

<i  :style="`color:${textColor}`">( {{ statistic }} )</i>

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
        donner4: {
            type: [Number, String],
            required: true,
        },
        donner5: {
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
        Titledonner4: {
            type: String,
            default: '',
        },
        Titledonner5: {
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
