<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>

                    <div class="card-footer">
                        I'm an example component.
                    </div>           
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: 'Привет',
            };
        },
        mounted() {
            console.log('Component mounted.');
        },
        watch: {
            message(newMessage, oldMessage) {
                console.log('Новое сообщение:', newMessage);
                console.log('Старое сообщение:', oldMessage);
            },
        },
    }
</script>
