<template>
    <div>
        <loading v-show="loading"></loading>

        <div class="inner">
            <section class="top_20 bottom_20">
                <h2 class="font_20 border_title p_left10 l_height20">設定履歴</h2>
            </section>

            <section class="search_color p1020">
                <div class="check_box_wrap">
                    <span class="right_10">日付</span>
                    <input v-model="filter.report_date_start" type="text" class="w_100 right_5" :placeholder="date_format">
                    <span class="right_5">~</span>
                    <input v-model="filter.report_date_end" type="text" class="w_100" :placeholder="date_format">
                    <span class="right_10 left_20">架.No</span>
                    <input v-model="filter.mount_no" type="text" class="w_110">
                    <span class="right_10 left_20">IMEI番号</span>
                    <input v-model="filter.imei" type="text" class="w_140">
                    <span class="right_10 left_20">端末電話番号</span>
                    <input v-model="filter.msn" type="text" class="w_140 right_20">
                    <button v-on:click="search" class="create_btn ss_btn">検索</button>
                </div>
            </section>

            <pager :items="histories" v-on:paginate="changePage" class="pager bottom_10 top_20 position_r"></pager>

            <section class="top_10 clearfix">
                <div class="table_left_scroll w_100p float_l">
                    <table>
                        <tr class="h_32">
                            <th class="w_90">設定日</th>
                            <th class="w_90">設定時刻</th>
                            <th class="w_110">設定者</th>
                            <th class="w_60">休止</th>
                            <th class="w_90">利用状況</th>
                            <th class="w_90">利用開始日</th>
                            <th class="w_90">利用終了日</th>
                            <th class="w_90">復元日</th>
                            <th class="w_90">削除日</th>
                            <th class="w_250">会社名</th>
                            <th class="w_110">架No</th>
                            <th class="w_120">機種</th>
                            <th class="w_140">IMEI番号</th>
                            <th class="w_110">端末電話番号</th>
                            <th class="w_110">端末発信設定</th>
                            <th class="w_110">着信可能設定01</th>
                            <th class="w_110">着信可能設定02</th>
                            <th class="w_110">着信可能設定03</th>
                            <th class="w_110">着信可能設定04</th>
                            <th class="w_110">着信可能設定05</th>
                            <th class="w_110">着信可能設定06</th>
                            <th class="w_110">着信可能設定07</th>
                            <th class="w_110">着信可能設定08</th>
                            <th class="w_110">着信可能設定09</th>
                            <th class="w_110">着信可能設定10</th>
                            <th class="w_180">定型文 (緊急通報)</th>
                            <th class="w_180">定型文 (非常ブザー)</th>
                            <th class="w_180">定型文 (バッテリー低下)</th>
                            <th class="w_180">定型文 (電源OFF)</th>
                            <th class="w_180">端末バージョン</th>
                            <th class="w_180">権限種類</th>
                        </tr>
                        <tr v-for="history in histories.data" class="h_39">
                            <td>{{history.created_at_date}}</td>
                            <td>{{history.created_at_time}}</td>
                            <td class="text_cut">{{history.company.owner_name}}</td>
                            <td>
                                <div v-show="history.rest" class="w_20 text_c auto">
                                    <img src="/img/pause.png">
                                </div>
                            </td>
                            <td>
                                <span v-if="history.device_assignment.ended_at == null">利用中</span>
                                <span v-else>利用停止</span>
                            </td>
                            <td>{{history.started_at}}</td>
                            <td>{{history.ended_at}}</td>
                            <td>{{history.restored_at}}</td>
                            <td>{{history.deleted_at}}</td>
                            <td class="text_cut">{{history.company.name}}</td>
                            <td>{{history.device_assignment.mount_no}}</td>
                            <td><span v-if="history.device.device_type == null"></span>
                                <span v-else>{{history.device.device_type.type}}</span></td>
                            <td>{{history.device.imei}}</td>
                            <td>{{history.sim.msn}}</td>
                            <td>{{getPhone(history.phones[0])}}</td>
                            <td>{{getPhone(history.phones[1])}}</td>
                            <td>{{getPhone(history.phones[2])}}</td>
                            <td>{{getPhone(history.phones[3])}}</td>
                            <td>{{getPhone(history.phones[4])}}</td>
                            <td>{{getPhone(history.phones[5])}}</td>
                            <td>{{getPhone(history.phones[6])}}</td>
                            <td>{{getPhone(history.phones[7])}}</td>
                            <td>{{getPhone(history.phones[8])}}</td>
                            <td>{{getPhone(history.phones[9])}}</td>
                            <td>{{getPhone(history.phones[10])}}</td>
                            <td class="text_cut">{{history.device_assignment.emergency_call.message}}</td>
                            <td class="text_cut">{{history.device_assignment.emergency_buzzer.message}}</td>
                            <td class="text_cut">{{history.device_assignment.battery_low.message}}</td>
                            <td class="text_cut">{{history.device_assignment.power_off.message}}</td>
                            <td>{{history.device.version}}</td>
                            <td>
                                <div v-for='role in roles' >
                                    <div v-if="history.user_id == role.user_id">
                                        {{ role.role_name }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>

            <pager :items="histories" v-on:paginate="changePage" class="pager bottom_10 top_20 position_r"></pager>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Loading from './Loading';
    import Pager from "./Pager";
    import moment from "moment";

    export default {
        name: 'SettingHistoryComponent',
        components: {
            Loading,
            Pager,
        },
        data() {
            return {
                modal_type: 'update',
                history: {},
                histories: typeof histories === 'undefined' ? [] : histories,
                roles: typeof roles === 'undefined' ? [] : roles,
                loading: false,
                filter: typeof filter === 'undefined' ? {} : filter,
                date_format: moment().format('YYYY/MM/DD'),
            }
        },
        methods: {
            changePage: function(page){
                location.href = "/history/setting?page=" + page;
            },
            search: async function(page) {
                this.loading = true;
                let res = await axios.get('/history/setting/search', {params: this.filter});

                if(res.data.success){
                    this.histories = res.data.data;
                    this.roles = res.data.roles;
                    if(res.data.roles.length > 0 && this.histories.data.length > 0)
                    {
                        for(var i = 0; i < this.histories.data.length; i ++) {
                            this.histories.data[i].roles = "";
                            for(var j = 0; j < res.data.roles.length; j ++) {
                                if(this.histories.data[i].user_id == res.data.roles[j].user_id){
                                    this.histories.data[i].roles = res.data.roles[j].role;
                                    break;
                                }
                            }
                        }
                    }

                    this.loading = false;
                }
            },
            getPhone: function(model)
            {
               return model ? model.phone : null;
            },
            init:function(){
                console.log(this.histories);
            },
        },
        mounted() {
            this.init();
        }
    }
</script>

<style scoped>

</style>
