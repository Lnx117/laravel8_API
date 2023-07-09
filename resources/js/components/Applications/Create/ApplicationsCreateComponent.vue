<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Создать заявку</div>
                    <div class="card-body">
                        <div>
                            <p>Данные клиента:</p>
                        </div>
                        <form>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="customerLastName">Фамилия</label>
                                    <input v-model="customerLastName" class="form-control" id="customerLastName" placeholder="Фамилия" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="customerFirstName">Имя</label>
                                    <input v-model="customerFirstName" class="form-control" id="customerFirstName" placeholder="Имя" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="customerPatronymic">Отчество</label>
                                    <input v-model="customerPatronymic" class="form-control" id="customerPatronymic" placeholder="Отчество" required>
                                </div>
                            </div>
                                
                            <div class="col-md-6">
                                <label for="phone">Телефон</label>
                                <input v-model="phone" class="form-control" id="phone" placeholder="Телефон" required>
                            </div>

                            <div class="col-md-4">
                                <label for="city">Город</label>
                                <input v-model="city" class="form-control" id="city" placeholder="Город" required>
                            </div>

                            <div class="col-md-4">
                                <label for="street">Улица</label>
                                <input v-model="street" class="form-control" id="street" placeholder="Улица" required>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="houseNumber">Дом</label>
                                    <input v-model="houseNumber" class="form-control" id="houseNumber" placeholder="Дом" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="houseBuilding">Строение</label>
                                    <input v-model="houseBuilding" class="form-control" id="houseBuilding" placeholder="Строение" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="houseEntrance">Подъезд</label>
                                    <input v-model="houseEntrance" class="form-control" id="houseEntrance" placeholder="Подъезд" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="floorNum">Этаж</label>
                                    <input v-model="floorNum" class="form-control" id="floorNum" placeholder="Этаж" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="flatNum">Квартира номер</label>
                                    <input v-model="flatNum" class="form-control" id="flatNum" placeholder="Квартира номер" required>
                                </div>
                            </div>

                            <div style="margin-top:15px;">
                                <label for="problemText">Описание проблемы</label>
                                <textarea rows="5" v-model="problemText" class="form-control" id="problemText" placeholder="Описание проблемы"></textarea>
                            </div>

                            <div v-if="!buttonBlock" class="button" @click="createApp">
                                Создать заявку
                            </div>
                            <div v-else class="buttonDisabled">
                                Создать заявку
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {

        },
        data() {
            return {
                customerLastName: "",
                customerFirstName: "",
                customerPatronymic: "",
                phone: "",
                city: "",
                street: "",
                houseNumber: "",
                houseBuilding: "",
                houseEntrance: "",
                floorNum: "",
                flatNum: "",
                problemText: "",
                buttonBlock: true,
            };
        },
        mounted() {

        },
        watch: {

        },
        methods: {
            createApp() {
                
            },
        }
    }
</script>
