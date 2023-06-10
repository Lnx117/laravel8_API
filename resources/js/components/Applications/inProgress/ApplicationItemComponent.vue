<template>
    <div class="container">
        <div class="col-md-12">
            <div class="card-body">
                <div v-for="application in data.applications" :key="application.id" :id="'app' + application.id" class="col-md-12 appItemcard">
                    <div class="col-md-8">
                        <p>Номер заявки: <strong>{{ application.id }}</strong></p>
                        <p>Фио клиента: <strong>{{ application.customer_last_name + ' ' + application.customer_first_name 
                        + ' ' + application.customer_patronymic  }}</strong></p>
                        <p>Адрес клиента: <strong>{{ "город " + application.app_city + ', улица ' + application.app_street 
                        + ' дом/строение ' + application.app_house_number + '/' +  application.app_house_building + ', этаж ' + 
                        application.app_floor_num + ', квартира ' + application.app_flat_num}}</strong></p>
                        <p>Телефонный номер клиента: <strong>{{ application.customer_phone }}</strong></p>
                        <p>Статус заявки: <strong>{{ application.app_status }}</strong></p>
                        <p>Назначена мастеру: <strong>{{ application.master_id }}</strong></p>
                    </div>
                    <div class="col-md-4">
                        <select-master-component 
                            :options="data['masters']" 
                            :prev_master_id="application.master_id"
                            :appKey="application.id" 
                            :token="data['token']"
                            @show-popUp="showPopUpMethod">
                        </select-master-component>
                    </div>
                    <div v-if="showPopUp" class="appPopUpBlock-overlay" :class="{ active: showPopUp }">
                        <div class="appPopUpBlock">
                            <div><strong>{{ PopUpMessage }}</strong></div>
                            <br>
                            <div class="button" @click="closePopUpMessage">
                                ЗАКРЫТЬ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SelectComponent from './SelectComponent.vue';
    export default {
        props: ['data'],
        data() {
            return {
                showPopUp: false,
                PopUpMessage: '',
            };
        },
        components: {
            'select-master-component': SelectComponent,
        },
        mounted() {
            console.log(this.data);
        },
        watch: {

        },
        methods: {
            closePopUpMessage() {
                this.showPopUp = false;
            },
            showPopUpMethod(PopUpMessage) {
                this.PopUpMessage = "Заявление принято в работу. Задача создана и поставлена мастеру.";
                this.showPopUp = true;
            }
        }
    }
</script>
