<template>
    <div class="inner">
        <section class="top_20 bottom_20">
            <h2 class="font_25 text_c">{{company_name}}</h2>
        </section>
        <div class="border_b" style="display: flex;">
            <a v-if="path==0" :href="'/company/' + company_id + '/history'" class="inblock tab  tab_active">端末履歴</a>
            <a v-else :href="'/company/' + company_id + '/history'" class="inblock tab">端末履歴</a>
            <a v-if="path==1" :href="'/company/' + company_id + '/device'" class="inblock tab  tab_active">端末管理</a>
            <a v-else :href="'/company/' + company_id + '/device'" class="inblock tab">端末管理</a>
            <div v-if="role != 0">
                <a v-if="path==2" :href="'/company/' + company_id + '/detail'" class="inblock tab tab_active">会社詳細</a>
                <a v-else :href="'/company/' + company_id + '/detail'" class="inblock tab ">会社詳細</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CompanyHeader",
        props: {
            company_id: 0,
            company_name: null,
            role: 0,
            path: 0,
        },
    }
</script>

<style scoped>

</style>
