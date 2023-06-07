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
        <div class="v-select-form">
            <p
            @click="openCloseOptions()" class="v-select">{{ selectedOption }}</p>
            <div class="v-select v-select-open scrollable-container"
            v-if="showOptions">
                <p v-for="master in masterList" :v-model="selectedOption" @click="selectChoose($event)" class="option"> {{ master.user_lastname + " " + master.user_firstname }} </p>
            </div>
        </div>
        <div v-if="showLoader" class="preloader-overlay" :class="{ active: showLoader }">
            <div class="preloader-spinner">
                <!-- Код спиннера или другого изображения прелоадера -->
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
        };
    },
    mounted() {
        console.log(this.appKey);
    },
    watch: {
        freeIsChecked(newVal) {
            this.workingMasters = !newVal;
            let free = {
                user_status: 'Свободен',
                user_role: "master"
            };
            if (newVal == true) {
                this.fetchData('/api/sanctum/getUsersByField', free);
            };
        },
        workingMasters(newVal) {
            this.freeIsChecked = !newVal;
            let workingMasters = {
                user_status: 'В работе',
                user_role: "master"
            };
            if (newVal == true) {
                this.fetchData('/api/sanctum/getUsersByField', workingMasters);
            };
        },
    },
    methods: {
        openCloseOptions() {
            this.showOptions = !this.showOptions;
        },
        selectChoose(event) {
            this.selectedOption = event.target.textContent;
            this.showOptions = !this.showOptions;
        },
        fetchData(url, fields) {
            console.log(this.showLoader);
            this.showLoader = true;
            console.log(this.showLoader);
            axios.defaults.headers.common['Authorization'] = `Bearer ${'6|fq7N0YKEqtAQibA9xNgPopCj8pATEhOsl1T9BB0a'}`;
            axios.post(url, fields, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                // Обработка успешного ответа
                this.masterList = response.data.data;
            })
            .catch(error => {
                // Обработка ошибки
                console.error(error);
            });
            this.showLoader = false;
            console.log(this.showLoader);
        }
    }
}
</script>
