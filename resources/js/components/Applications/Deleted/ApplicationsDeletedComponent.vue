<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Заявки</div>
                    <appliactions-item-component :data="data"></appliactions-item-component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ApplicationItemComponent from './ApplicationItemComponent.vue';

    export default {
        props: ['data'],
        components: {
            'appliactions-item-component': ApplicationItemComponent,
        },
        data() {
            return {
                message: 'Привет',
            };
        },
        mounted() {
            console.log(this);
        },
        watch: {

        },
    }
</script>
