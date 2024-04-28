<template>
    <div>
        <div class="pop modal-content pop-box" id="message_modal">
            <p class="top_10 bottom_20"></p>
            <p>{{message}}</p>
            <div class="top_20">
                <div class="text_c space">
                    <a class="return_btn l_btn space_normal left_5 modal-close">閉じる</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ModalComponent.vue",
        props: {
            // 'abstract': '',
            'message': '',
        },
        computed: {},
        methods: {
            init: function () {
                show_modal("#message_modal");
            }
        },
        mounted() {
            this.init();
        }
    }
</script>

<style scoped>

</style>
