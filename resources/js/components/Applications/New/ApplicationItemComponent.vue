<template>
    <div class="container">
        <div class="col-md-12">
            <div class="card-body">
                <div v-for="application in data.applications" :key="application.id" :id="'app' + application.id" class="col-md-12 appItemcard">
                    <div class="col-md-8">
                        <p>Фио клиента: <strong>{{ application.customer_last_name + ' ' + application.customer_first_name 
                        + ' ' + application.customer_patronymic  }}</strong></p>
                        <p>Адрес клиента: <strong>{{ "город " + application.app_city + ', улица ' + application.app_street 
                        + ' дом/строение ' + application.app_house_number + '/' +  application.app_house_building + ', этаж ' + 
                        application.app_floor_num + ', квартира ' + application.app_flat_num}}</strong></p>
                        <p>Телефонный номер клиента: <strong>{{ application.customer_phone }}</strong></p>
                    </div>
                    <div class="col-md-4">
                        <select-master-component 
                            :options="data['masters']" 
                            :appKey="application.id" 
                            :token="data['token']"
                            @assign-master="removeApplication"
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
                message: 'Привет',
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
            removeApplication(appKey) {
                // Удалить заявку из списка по appKey
                document.querySelector('#app'+ appKey).style.display = "none";
            },
            showPopUpMethod(PopUpMessage) {
                this.PopUpMessage = "Заявление принято в работу. Задача создана и поставлена мастеру.";
                this.showPopUp = true;
            }
        }
    }
</script>
