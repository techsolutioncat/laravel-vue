<template>
    <div class="inner">
        <div class="border_b top_20">
            <a v-if="history_type=='device'" href="/history" class="inblock tab tab_active">端末履歴</a>
            <a v-else href="/history" class="inblock tab">端末履歴</a>
            <a v-if="history_type=='setting'" href="/history/setting" class="inblock tab tab_active">設定履歴</a>
            <a v-else href="/history/setting" class="inblock tab">設定履歴</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "HistoryHeader",
        props: {
            history_type: null,
        },
    }
</script>

<style scoped>

</style>
