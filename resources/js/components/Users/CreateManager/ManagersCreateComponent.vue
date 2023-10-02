<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Создать менеджера</div>
                    <div class="card-body">
                        
                        <div v-if="showLoader" class="preloader-overlay" :class="{ active: showLoader }">
                            <div class="preloader-spinner">
                                <!-- Код спиннера или другого изображения прелоадера -->
                            </div>
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
        
                        <div>
                            <p>Создание менеджера:</p>
                        </div>
                        <form>
                            <div class="custom_row row">
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
                                
                            <div class="custom_row my_row col-md-4">
                                <label for="phone">Пароль</label>
                                <input v-model="password" type="password" class="form-control" id="phone" placeholder="Пароль" required>
                            </div>

                            <div class="custom_row my_row col-md-4">
                                <label for="city">Email</label>
                                <input v-model="email" class="form-control" id="city" placeholder="Email" required>
                            </div>

                            <div class="button" @click="createUser">
                                Создать менеджера
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
        props: ['data'],
        components: {

        },
        data() {
            return {
                customerLastName: "",
                customerFirstName: "",
                customerPatronymic: "",
                email: "",
                password: "",
                showLoader: false,
                showPopUp: false,
            };
        },
        mounted() {

        },
        watch: {

        },
        methods: {
            createUser() {
                this.showLoader = true;

                let userData = {
                    "name": this.customerFirstName,
                    "email": this.email,
                    "password": this.password,
                    "user_firstname": this.customerFirstName,
                    "user_lastname": this.customerLastName,
                    "user_patronymic": this.customerPatronymic,
                };

                let url = '/api/sanctum/registerManager';

                console.log(this.data);
                console.log(this.data.token);
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.data.token}`;
                axios.post(url, userData, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    // Обработка успешного ответа
                    console.log(response);
                    this.showLoader = false;
                    this.PopUpMessage = "Менеджер успешно зарегистрирован";
                    this.showPopUp = true;
                })
                .catch(error => {
                    // Обработка ошибки
                    console.log(error);
                    this.showLoader = false;
                    this.PopUpMessage = "Ошибка при регистрации менеджера";
                    this.showPopUp = true;
                });
            },
            closePopUpMessage() {
                this.showPopUp = false;
                window.location.reload();
            },
        }
    }
</script>
