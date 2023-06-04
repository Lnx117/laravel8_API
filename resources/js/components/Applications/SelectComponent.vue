<template>
    <div class="">
        <p
        @click="openOptions()" class="v-select">{{ selectedOption }}</p>
        <div class="v-select"
        v-if="showOptions">
            <p v-for="option in options" :v-model="selectedOption" class="option"> {{ option.user_lastname + " " + option.user_firstname }}</p>
        </div>
    </div>
</template>

<script>

export default {
    props: ['options'],
    components: {

    },
    data() {
        return {
            selectedOption: 'Назначить мастера',
            showOptions: false,
        };
    },
    mounted() {

    },
    watch: {

    },
    methods: {
        openOptions() {
            this.showOptions = !this.showOptions;
        }
    }
}
</script>
