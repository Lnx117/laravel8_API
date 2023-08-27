<template>
    <div class="container">
        <div class="col-md-12">
            <div class="card-body">
                <div v-for="manager in data.managers" :key="manager.id">
                    <div class="col-md-12 managerItemcard pos_relative">
                        <div class="col-md-8">
                            <p>ID менеджера: <strong>{{ manager.id}}</strong></p>
                            <p>ФИО менеджера: <strong>{{ manager.user_lastname}} {{ manager.user_firstname}} {{ manager.user_patronumic}}</strong></p>
                            <p>Электронная почта: <strong>{{ manager.email }}</strong></p>
                            <p>Статус: <strong>{{ manager.user_status }}</strong></p>
                        </div>
                        <delete-manager-component :managerId="manager.id" :token="data.token"></delete-manager-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DeleteManagerComponent from './DeleteManagerComponent.vue';
    export default {
        props: ['data'],
        data() {
            return {
                showPopUp: false,
                PopUpMessage: '',
            };
        },
        components: {
            'delete-manager-component': DeleteManagerComponent,
        },
        methods: {
            closePopUpMessage() {
                this.showPopUp = false;
                window.location.reload();
            },
        }
    }
</script>
