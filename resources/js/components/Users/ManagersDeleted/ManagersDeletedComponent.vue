<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Удаленные менеджеры
                    </div>
                    <managers-deleted-item-component :data="data"></managers-deleted-item-component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ManagersDeletedItemComponent from './ManagersDeletedItemComponent.vue';

    export default {
        props: ['data'],
        components: {
            'managers-deleted-item-component': ManagersDeletedItemComponent,
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
