<template>
    <div>
        <paginate
                v-model="items.current_page"
                :page-count="getPageCount"
                :click-handler="paginate"
                :prev-text="'＜'"
                :next-text="'＞'"
                :container-class="'pagination'"
                :page-class="'page-item'">
        </paginate>

        <div class="position_a t0r0">
            <button v-show="excel" v-on:click="$emit('show_import_modal')" data-target="modal" class="create_btn m_btn modal-open right_5">Excelインポート</button>
            <button v-show="excel" v-on:click="$emit('export')" class="create_btn m_btn right_5">Excelエクスポート</button>
            <button v-show="register" v-on:click="$emit('register_modal')" class="s_btn create_btn right_5">新規作成</button>
            <a v-show="garbage!=null" :href="garbage" class="create_btn sm_btn">
                <div class="d_flex_center">
                    <div class="w_13 l_height28">
                        <img src="/img/garbage.png">
                    </div>
                    <div class="l_height28">
                        <span class="font_white">ゴミ箱</span>
                    </div>
                </div>
            </a>
        </div>

        <div v-show="undo" class="position_a t0l0">
            <a href="/device" class="return_btn sm_btn">
                <div class="d_flex_center">
                    <div class="w_13 l_height28 right_5">
                        <img src="/img/uturn.png">
                    </div>
                    <div class="l_height28">
                        <span class="font_white">戻る</span>
                    </div>
                </div>
            </a>
        </div>

    </div>
</template>

<script>
    import paginate from 'vuejs-paginate'

    export default {
        name: "Pager",
        components: {
            paginate
        },
        props: {
            'items': {},
            'garbage': '',
            'excel': false,
            'register': false,
            'undo': false,
        },
        data() {
            return {
            }
        },
        methods: {
            paginate: function (page) {
                this.$emit('paginate', page);
            }
        },
        computed: {
            getPageCount: function() {
                return Math.ceil(this.items.total / this.items.per_page);
            }
        },
        mounted() {
        }
    }
</script>

<style scoped>
</style>
