<template>
    <div class="container">
        <div class="col-md-12">
            <div class="card-body">
                <div v-for="user in users" :key="user.id">
                    <div class="appItemcard">
                        <!-- Проверка на наличие?? -->
                        <p>{{ user.user_lastname}} {{ user.user_firstname}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['users'],
        data() {
            return {
                message: 'Привет',
            };
        },
        mounted() {

        },
        watch: {

        },
    }
</script>
