<template>
    <div class="container">
        <div class="col-md-12">
            <div class="card-body">
                <div v-for="user in data.users" :key="user.id">
                    <div class="col-md-12 appItemcard pos_relative">
                        <div class="col-md-8">
                            <p>ID мастера: <strong>{{ user.id}}</strong></p>
                            <p>Фио мастера: <strong>{{ user.user_lastname}} {{ user.user_firstname}} {{ user.user_patronumic}}</strong></p>
                            <p>Статус мастера: <strong>{{ user.user_status}}</strong></p>
                            <p>Заявка в работе: <strong>
                                <template v-if="user.tasks_to_do"> {{ user.tasks_to_do }} </template>
                                <template v-else> - </template>
                            </strong></p>
                            <p>Заявки в очереди: <strong> <template v-for=" app in JSON.parse(user.app_ids)">{{" | " + app + " | "}}</template></strong></p>
                            <p>Электронная почта: <strong>{{ user.email }}</strong></p>
                        </div>

                        <delete-master-component v-if='!data.isDeletePage' :masterId="user.id" :token="data.token"></delete-master-component>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import DeleteMasterComponent from './DeleteMasterComponent.vue';

    export default {
        props: ['data'],
        components: {
            'delete-master-component': DeleteMasterComponent,
        },
        data() {
            return {

            };
        },
        methods: {
            closePopUpMessage() {
                this.showPopUp = false;
                window.location.reload();
            },
        }
    }
</script>
