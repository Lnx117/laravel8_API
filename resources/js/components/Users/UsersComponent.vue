<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Мастера</div>
                    <users-item-component :users="users"></users-item-component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UsersItemComponent from './UsersItemComponent.vue';

    export default {
        props: ['users'],
        components: {
            'users-item-component': UsersItemComponent,
        },
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
