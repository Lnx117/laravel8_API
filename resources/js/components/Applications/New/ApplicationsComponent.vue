<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Заявки
                    </div>
                    <!-- 
                    <div class="card-body">
                        I'm an example component.
                    </div>
                    <div>
                        <ul>
                            <li v-for="application in applications" :key="application.id">{{ application.customer_first_name }}</li>
                        </ul>
                    </div>

                    <div class="card-footer">
                        I'm an example component.
                    </div> -->
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
