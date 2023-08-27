<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Активные менеджеры
                    </div>
                    <managers-item-component :data="data"></managers-item-component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ManagersItemComponent from './ManagersItemComponent.vue';

    export default {
        props: ['data'],
        components: {
            'managers-item-component': ManagersItemComponent,
        },
        data() {
            return {
            };
        },
        mounted() {
        },
        watch: {

        },
    }
</script>
