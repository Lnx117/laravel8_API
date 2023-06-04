<template>
    <div class="select">
        <p>{{ selectedOption }}</p>
    </div>
    <div class="selectOptions">
        <p v-for="option in options" :v-model="selectedOption" class="option"> {{ option.user_lastname + " " + option.user_firstname }}</p>
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
        };
    },
    mounted() {

    },
    watch: {

    },
}
</script>
