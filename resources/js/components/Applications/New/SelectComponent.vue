<template>
    <div class="">
        <div>
            <input type="checkbox" class="custom-checkbox" :id="'checkbox_free_id_' + appKey" :name="'checkbox_free_id_' + appKey" value="yes" v-model="freeIsChecked">
            <label :for="'checkbox_free_id_' + appKey">Свободные мастера</label>
        </div>
        <div>
            <input type="checkbox" class="custom-checkbox" :id="'checkbox_not_free_id_' + appKey" :name="'checkbox_not_free_id_' + appKey" value="yes" v-model="workingMasters">
            <label :for="'checkbox_not_free_id_' + appKey">Занятые мастера</label>
        </div>
        <br>
        <div class="v-select-form">
            <p
            @click="openCloseOptions()" :id="masterId" class="v-select">{{ selectedOption }}</p>
            <div class="v-select v-select-open scrollable-container"
            v-if="showOptions">
                <p v-for="master in masterList" :v-model="selectedOption" :id="master.id" @click="selectChoose($event)" class="option"> {{ master.user_lastname + " " + master.user_firstname }} </p>
            </div>
        </div>
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

        <div v-if="!buttonBlock" class="button" @click="selectMaster">
            Назначить мастера
        </div>
        <div v-else class="buttonDisabled">
            Назначить мастера
        </div>
        <div class="deleteApp" @click="deleteAppFunc"></div>
        <div v-if="deleteApp" class="appPopUpBlock-overlay" :class="{ active: deleteApp }">
            <div class="appPopUpBlock">
                <div><strong>Вы уверены что хотите удалить заявку?</strong></div>
                <br>
                <div class="button" @click="agreeDeleteApp">
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
import axios from 'axios';

export default {
    props: ['options', 'appKey','token'],
    components: {

    },
    data() {
        return {
            selectedOption: 'Назначить мастера',
            showOptions: false,
            workingMasters: false,
            freeIsChecked: true,
            masterList: this.options['free'],
            showLoader: false,
            masterId: -1,
            buttonBlock: true,
            showPopUp: false,
            PopUpMessage: '',
            deleteApp: false,
        };
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
    },
    watch: {
        //Изначально мастер не назначен (id = -1) и кнопка в блоке, когда назначаем мастера - кнопка разблокируется
        masterId() {
            if (this.masterId >= 0) {
                this.buttonBlock = false;
            } else {
                this.buttonBlock = true;
            }
        },
        //При нажатии на чекбокс Свободные мастера - делаем запрос и получаем актуальный список
        freeIsChecked(newVal) {
            //Сбрасываем предыдущий выбор мастера
            this.selectedOption = 'Назначить мастера';
            this.masterId = -1;
            
            this.workingMasters = !newVal;
            let free = {
                user_status: 'Свободен',
                user_role: "master"
            };
            if (newVal == true) {
                this.selectMasterFetch('/api/sanctum/getUsersByField', free);
            };
        },
        //При нажатии на чекбокс Занятые мастера - делаем запрос и получаем актуальный список
        workingMasters(newVal) {
            //Сбрасываем предыдущий выбор мастера
            this.selectedOption = 'Назначить мастера';
            this.masterId = -1;

            this.freeIsChecked = !newVal;
            let workingMasters = {
                user_status: 'В работе',
                user_role: "master"
            };
            if (newVal == true) {
                this.selectMasterFetch('/api/sanctum/getUsersByField', workingMasters);
            };
        },
    },
    methods: {
        deleteAppFunc() {
            this.deleteApp = true;
        },
        closeDeleteApp() {
            this.deleteApp = false;
        },
        agreeDeleteApp() {
            this.showLoader = true;
            let appUpdate = {
                app_status: 'Удалена',
                master_id: "",
            };
            let url = '/api/sanctum/updateApplicationById/' + this.appKey;

            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.put(url, appUpdate, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                // Обработка успешного ответа
                this.showLoader = false;
                this.deleteApp = false;
                this.PopUpMessage = "Заявка удалена!";
                this.showPopUp = true;
            })
            .catch(error => {
                // Обработка ошибки
                this.showLoader = false;
                this.PopUpMessage = "Ошибка при удалении заявки";
                this.showPopUp = true;
            });
        },
        //Метод при нажатии на кнопку Назначить мастера
        //ПО цепочке сначала создаем задачу, далее обновляем заявку, если все ок, то обновляем очередь мастеру
        selectMaster() {
            this.showLoader = true;
            //Если все ок и задача создана, то обновляем заявку
            let appUpdate = {
                app_status: 'Назначена',
                master_id: this.masterId,
            };
            this.updateAppFetch('/api/sanctum/updateApplicationById/' + this.appKey, appUpdate);
        },
        //клик вне зоны селектора закрывает селектор
        handleClickOutside(event) {
            let targetElement = event.target;

            // Проверяем, является ли целевой элемент элементом с классом "v-select" или "option"
            if (
            !targetElement.closest('.v-select') &&
            !targetElement.closest('.option')
            ) {
                this.showOptions = false;
            }
        },
        //Метод для показа/скрытия опций у выпадашки
        openCloseOptions() {
            this.showOptions = !this.showOptions;
        },
        closePopUpMessage() {
            this.showPopUp = false;
            window.location.reload();
        },
        //Метод обновляет текущего мастера для обновления. Если выбрали из выпадашки, то впишет правильный текст в селектор
        //и обновит masterId в data
        selectChoose(event) {
            this.selectedOption = event.target.textContent;
            this.masterId = event.target.id;
            this.showOptions = !this.showOptions;
        },
        //Метод обновления списка свободных или занятых мастеров для выпадашки при переключении чекбоксов
        selectMasterFetch(url, fields) {
            this.showLoader = true;
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.post(url, fields, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                // Обработка успешного ответа
                this.masterList = response.data.data;
                this.showLoader = false;
            })
            .catch(error => {
                // Обработка ошибки
                this.showLoader = false;
            });
        },
        //Метод обновления заявки (ставим ей статус и номер мастера), а также если все ок, то потом обновляем и мастера
        updateAppFetch(url, fields) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.put(url, fields, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                // Обработка успешного ответа
                //Если все окей то обновляем мастера, добавляем ему в оередь задачки

                //Получаем мастера
                // //Добавить поле очереди и обновлять его
                this.getMasterById('/api/sanctum/getUserByIdOrEmail/' + this.masterId);
            })
            .catch(error => {
                // Обработка ошибки
                this.showLoader = false;
                this.PopUpMessage = "Ошибка при обновлении заявки. Была создана задача, но не назначена мастеру и не отображена в заявке. Пропробуйте позже или свяжитесь с технической поддержкой";
                this.showPopUp = true;
            });
        },
        //Метод создания задачи для мастера по id заявки и id мастера. Статус задачи будет Принято
        getMasterById(url) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.get(url, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                // Обработка успешного ответа
                //Если получили мастера то обновляем его, вставляем ему новую задачу в очередь
                let master = response.data;
                let appIds = [];

                if (master.data.app_ids !== undefined && master.data.app_ids !== null && master.data.app_ids !== "") {
                    appIds = JSON.parse(master.data.app_ids);
                };

                appIds.push(this.appKey);

                let masterUpdateData = {
                    app_ids: JSON.stringify(appIds),
                };
                this.updateMasterFetch('/api/sanctum/updateUserByIdOrEmail/' + this.masterId, masterUpdateData);

            })
            .catch(error => {
                // Обработка ошибки
                this.showLoader = false;
                this.PopUpMessage = "Ошибка при попытке получить данные мастера. По заявке была создана задача и номер задачи с номером мастера были отображены в заявке, но задача не назначена мастеру. Пропробуйте позже или свяжитесь с технической поддержкой";
                this.showPopUp = true;
            });
        },
        //Метод обновления мастера(добавляем ему задачи в очередь)
        updateMasterFetch(url, fields) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
            axios.put(url, fields, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                // Обработка успешного ответа
                this.showLoader = false;
                //Событие на удаление отработанной заявки со страницы
                this.PopUpMessage = "Заявление принято в работу. Задача создана и поставлена мастеру.";
                this.$emit('show-popUp', this.PopUpMessage);
            })
            .catch(error => {
                // Обработка ошибки
                this.showLoader = false;
                this.PopUpMessage = "Ошибка при назначении задачи мастеру. По заявке была создана задача и номер задачи с номером мастера были отображены в заявке, но задача не назначена мастеру. Пропробуйте позже или свяжитесь с технической поддержкой";
                this.showPopUp = true;
            });
        },
    }
}
</script>
