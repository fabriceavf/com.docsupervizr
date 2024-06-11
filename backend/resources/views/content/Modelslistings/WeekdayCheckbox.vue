<template>
    <div class="weekday-checkbox">
        <label
            v-for="(day, index) in days"
            :key="index"
            class="btn btn-warning"
        >
            <input
                :checked="isChecked(day)"
                class="badgebox"
                type="checkbox"
                @change="toggleCheckbox(day)"
            />
            {{ day }}
            <span class="badge">&check;</span>
        </label>
    </div>
</template>

<script>

export default {
    props: {
        value: Array, // Array of selected days from the database
    },
    data() {
        return {
            days: [
                "Lundi",
                "Mardi",
                "Mercredi",
                "Jeudi",
                "Vendredi",
                "Samedi",
                "Dimanche",
            ],
        };
    },
    methods: {
        isChecked(day) {
            return this.value.includes(day);
        },
        toggleCheckbox(day) {
            if (this.isChecked(day)) {
                this.$emit(
                    "input",
                    this.value.filter((item) => item !== day)
                );
            } else {
                this.$emit("input", [...this.value, day]);
            }
        },
    },
    watch: {
        value: {
            handler(newVal) {
                this.selectedDays = newVal;
            },
            immediate: true,
        },
    },
};
</script>

<style scoped>
.weekday-checkbox {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
}

.badgebox {
    opacity: 0;
}

.badgebox + .badge {
    /* Move the check mark away when unchecked */
    text-indent: -999999px;
    /* Makes the badge's width stay the same checked and unchecked */
    width: 27px;
}

.badgebox:focus + .badge {
    /* Set something to make the badge looks focused */
    /* This really depends on the application, in my case it was: */

    /* Adding a light border */
    box-shadow: inset 0px 0px 5px;
    /* Taking the difference out of the padding */
}

.badgebox:checked + .badge {
    /* Move the check mark back when checked */
    text-indent: 0;
}
</style>
