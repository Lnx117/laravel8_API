<template>
    <div class="container">
        <div class="deleteApp" @click="deleteMasterPopUp"></div>

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
                <div><strong>Вы уверены что хотите удалить мастера?</strong></div>
                <br>
                <div class="button" @click="agreeDeleteMaster">
                    ДА
                </div>
                <div class="button" @click="closeDeleteApp">
                    НЕТ
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['masterId', 'token'],
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
            deleteMasterPopUp() {
                this.deleteApp = true;
            },
            closeDeleteApp() {
                this.deleteApp = false;
            },
            closePopUpMessage() {
                this.showPopUp = false;
                window.location.reload();
            },
            agreeDeleteMaster() {
                this.deleteApp = false;
                this.showLoader = true;

                let url = '/api/sanctum/deleteUserByIdOrEmail/' + this.masterId;
                console.log(url);
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                axios.delete(url, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    // Обработка успешного ответа
                    this.showLoader = false;
                    this.PopUpMessage = "Мастер удален!";
                    this.showPopUp = true;
                })
                .catch(error => {
                    // Обработка ошибки
                    this.showLoader = false;
                    this.PopUpMessage = "Ошибка при удалении мастера";
                    this.showPopUp = true;
                });
            },
        }
    }
</script>
