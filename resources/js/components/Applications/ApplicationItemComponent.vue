<template>
    <div class="container">
        <div class="col-md-12">
            <div class="card-body">
                <div v-for="application in applications" :key="application.id" class="col-md-12 appItemcard">
                    <div class="col-md-8">
                        <p>Фио клиента: <strong>{{ application.customer_last_name + ' ' + application.customer_first_name 
                        + ' ' + application.customer_patronymic  }}</strong></p>
                        <p>Адрес клиента: <strong>{{ "город " + application.app_city + ', улица ' + application.app_street 
                        + ' дом/строение ' + application.app_house_number + '/' +  application.app_house_building + ', этаж ' + 
                        application.app_floor_num + ', квартира ' + application.app_flat_num}}</strong></p>
                        <p>Телефонный номер клиента: <strong>{{ application.customer_phone }}</strong></p>
                    </div>
                    <div class="col-md-4">
                        <p>Назначить мастера</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['applications'],
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
