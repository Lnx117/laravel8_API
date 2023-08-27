<template>
    <div class="container">
        <div class="deleteApp" @click="deleteManagerPopUp"></div>

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

        <div v-if="deleteApp" class="appPopUpBlock-overlay" :class="{ active: deleteApp }">
            <div class="appPopUpBlock">
                <div><strong>Вы уверены что хотите удалить менеджера?</strong></div>
                <br>
                <div class="button" @click="agreeDeleteManager">
                    ДА
                </div>
                <div class="button" @click="closeDeleteManager">
                    НЕТ
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['managerId', 'token'],
        data() {
            return {
                showPopUp: false,
                PopUpMessage: '',
                showLoader: false,
                deleteApp: false,
            };
        },
        mounted() {

        },
        watch: {

        },
        methods: {
            deleteManagerPopUp() {
                this.deleteApp = true;
            },
            closeDeleteManager() {
                this.deleteApp = false;
            },
            closePopUpMessage() {
                this.showPopUp = false;
                window.location.reload();
            },
            agreeDeleteManager() {
                this.deleteApp = false;
                this.showLoader = true;
                let userUpdate = {
                    user_status: 'Удален',
                };
                let url = '/api/sanctum/updateUserByIdOrEmail/' + this.managerId;

                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                axios.put(url, userUpdate, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    // Обработка успешного ответа
                    this.showLoader = false;
                    this.PopUpMessage = "Менеджер удален!";
                    this.showPopUp = true;
                })
                .catch(error => {
                    // Обработка ошибки
                    this.showLoader = false;
                    this.PopUpMessage = "Ошибка при удалении менеджера";
                    this.showPopUp = true;
                });
            },
        }
    }
</script>
