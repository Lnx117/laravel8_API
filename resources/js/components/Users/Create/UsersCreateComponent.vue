<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Создать мастера</div>
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
                            <p>Создание мастера:</p>
                        </div>
                        <form>
                            <div class="custom_row row">
                                <div class="col-md-4">
                                    <label for="customerLastName">Фамилия</label>
                                    <input v-model="customerLastName" class="form-control" id="customerLastName" placeholder="Фамилия" @blur="$v.customerLastName.$touch()" :class="{ vueErrorInput: !$v.customerLastName.required || !$v.customerLastName.minLength}">
                                    <span v-if="$v.customerLastName.$error" style="color: red">
                                        Поле обязательно, должно содержать не менее 3 символов и состоять из букв.
                                    </span>
                                </div>

                                <div class="col-md-4">
                                    <label for="customerFirstName">Имя</label>
                                    <input v-model="customerFirstName" class="form-control" id="customerFirstName" placeholder="Имя" @blur="$v.customerFirstName.$touch()" :class="{ vueErrorInput: !$v.customerFirstName.required || !$v.customerFirstName.minLength}">
                                    <span v-if="$v.customerFirstName.$error" style="color: red">
                                        Поле обязательно, должно содержать не менее 3 символов и состоять из букв.
                                    </span>
                                </div>

                                <div class="col-md-4">
                                    <label for="customerPatronymic">Отчество</label>
                                    <input v-model="customerPatronymic" class="form-control" id="customerPatronymic" placeholder="Отчество" @blur="$v.customerPatronymic.$touch()" :class="{ vueErrorInput: !$v.customerPatronymic.required || !$v.customerPatronymic.minLength}">
                                    <span v-if="$v.customerPatronymic.$error" style="color: red">
                                        Поле обязательно, должно содержать не менее 3 символов и состоять из букв.
                                    </span>
                                </div>
                            </div>
                                
                            <div class="custom_row my_row col-md-4">
                                <label for="phone">Пароль</label>
                                <input v-model="password" type="password" class="form-control" id="phone" placeholder="Пароль" @blur="$v.password.$touch()" :class="{ vueErrorInput: !$v.password.required || !$v.password.minLength}">
                                <span v-if="$v.password.$error" style="color: red">
                                    Поле обязательно и может содержать русские и английские буквы и цифры и должно быть не менее 8 символов
                                </span>
                            </div>

                            <div class="custom_row my_row col-md-4">
                                <label for="city">Email</label>
                                <input v-model="email" class="form-control" id="city" placeholder="Email" @blur="$v.email.$touch()" :class="{ vueErrorInput: !$v.email.required || !$v.email.email}">
                                <span v-if="$v.email.$error" style="color: red">
                                    Поле обязательно и должно быть в виде "aaaaa@example.com"
                                </span>
                            </div>

                            <div class="button" :disabled="$v.$invalid" @click="createUser">
                                Создать мастера
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { required, email, maxLength, minLength } from 'vuelidate/lib/validators';

    export default {
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
        validations: {
            email: {
                required,
                email,
                maxLength: maxLength(255),
                // unique: (value, vm) => {
                //     // Проверка уникальности email может потребовать дополнительной логики
                //     // Вы можете воспользоваться методом vm.$http или другим способом для проверки уникальности.
                //     return true; // Ваша логика проверки уникальности
                // },
            },
            password: {
                required,
                minLength: minLength(8),
                string: value => /^[A-Za-zА-Яа-я0-9]+$/.test(value), // Проверка на строку с буквами и цифрами
            },
            customerFirstName: {
                required,
                minLength: minLength(3),
                string: value => /^[A-Za-zА-Яа-я]+$/.test(value), // Проверка на строку с буквами и пробелами
            },
            customerLastName: {
                required,
                minLength: minLength(3),
                string: value => /^[A-Za-zА-Яа-я]+$/.test(value), // Проверка на строку с буквами и пробелами
            },
            customerPatronymic: {
                required,
                minLength: minLength(3),
                string: value => /^[A-Za-zА-Яа-я]+$/.test(value), // Проверка на строку с буквами и пробелами
            },
        },
        mounted() {

        },
        watch: {

        },
        methods: {
            createUser() {
                this.showLoader = true;

                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.showLoader = false;
                    return;
                }

                let userData = {
                    "name": this.customerFirstName,
                    "email": this.email,
                    "password": this.password,
                    "user_firstname": this.customerFirstName,
                    "user_lastname": this.customerLastName,
                    "user_patronymic": this.customerPatronymic,
                };

                let url = '/api/sanctum/register';

                axios.post(url, userData, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    // Обработка успешного ответа
                    console.log(response);
                    this.showLoader = false;
                    this.PopUpMessage = "Мастер успешно зарегистрирован";
                    this.showPopUp = true;
                })
                .catch(error => {
                    // Обработка ошибки
                    console.log(error);
                    this.showLoader = false;
                    this.PopUpMessage = "Ошибка при регистрации мастера";
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
