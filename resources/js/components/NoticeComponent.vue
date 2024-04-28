<template>
    <div>

        <loading v-show="loading"></loading>

        <div class="inner">
            <section class="top_20 bottom_20">
                <h2 class="font_20 border_title p_left10 l_height20">受信一覧</h2>
            </section>

            <section class="search_color p1020">
                <div class="check_box_wrap inblock right_20">
                    <label class="checkbox_text">
                        <input type="checkbox" v-model="filter.emergency_call">緊急通報
                    </label>
                </div>
                <div class="check_box_wrap inblock right_20">
                    <label class="checkbox_text">
                        <input type="checkbox" v-model="filter.emergency_buzzer">非常ブザー
                    </label>
                </div>
                
                
                <div class="check_box_wrap inblock right_20">
                    <label class="checkbox_text">
                        <input type="checkbox" v-model="filter.power_off">電源OFF
                    </label>
                </div>
                <div class="check_box_wrap inblock right_20">
                    <label class="checkbox_text">
                        <input type="checkbox" v-model="filter.battery_low">バッテリー低下
                    </label>
                </div>
                <button class="create_btn ss_btn" v-on:click="search">検索</button>
            </section>

            <pager :items="histories" v-on:paginate="changePage" class="pager bottom_10 top_20 position_r"></pager>

            <section class="top_10">
                <table>
                    <tr>
                        <th class="w_110">端末電話番号</th>
						<th class="w_110">名称</th>
						<th class="w_180">グループ名</th>
						<th class="w_90">日付</th>
						<th class="w_70">時刻</th>
						<th class="w_110"></th>
						<th class="w_70">BAT残量</th>
						<th class="w_120">架.No</th>
						<th class="w_200">補足</th>
						<th class="w_60">対応済</th>
						<th class="w_80"></th>
                    </tr>

                    <tr v-for="history in histories.data" class="h_39" v-bind:key="history.id">
                        <td>{{history.device_assignment.sim ? history.device_assignment.sim.msn : null}}</td>    
                        <td class="text_cut">{{history.device_assignment.name}}</td>
                        <td class="text_cut">{{history.device_assignment.device_group.name}}</td>
                        <td>{{history.created_at_date}}</td>
                        <td>{{history.created_at_time}}</td>
                        <td>
                            <signal-icon v-if="history.device_signal" :signal="history.device_signal.signal_int" :listed="true"></signal-icon>
                        </td>
                        <td>{{history.battery}}%</td>
                        <td>{{history.device_assignment.mount_no ? history.device_assignment.mount_no : null}}</td>
                        <td class="text_cut">{{history.supplement}}</td>
                        
                        <td>
                            <div class="check_onle_wrap">
                                <div class="w_20 text_c auto" 
                                    v-if="history.dealt_with">       
                                    <img src="/img/check.png">
                                </div>
                                <div class="w_20 text_c auto" 
                                    v-else>                               
                                </div>
                            </div>
                        </td>
                        <td>
                            <a :href="'/notice/' + history.id + '/detail'" class="ss_btn details_btn">詳細</a>
                        </td>
                    </tr>

                </table>
            </section>

            <pager :items="histories" v-on:paginate="changePage" class="pager bottom_10 top_20 position_r"></pager>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Loading from './Loading';
    import Pager from "./Pager";
    import SignalIcon from "./SignalIcon";

    export default {
        name: 'NoticeComponent',
        components: {
            Loading,
            Pager,
            SignalIcon,
        },
        data() {
            return {
                modal_type: 'update',
                history: {},
                histories: typeof notices !== 'undefined' ? notices : [],
                filter: typeof filter !== 'undefined' ? filter : {
                    emergency_call: true,
                    battery_low: true,
                    emergency_buzzer: true,
                    power_off: true,
                },

                isAdmin: typeof isAdmin !== 'undefined' ? isAdmin : false,
                current_page: typeof current_page !== 'undefined' ? current_page : 1,
                loading: false,
            }
        },
        computed: {
        },
        methods: {
            search: async function() {
                this.loading = true;
                let res = await axios.get('/notice/search', {params: this.filter})
                if(res.data.success){
                    this.histories = res.data.data;
                }

                this.loading = false;
            },
            updateHistory: async function(history) {
                // post when user_role is admin

                if (this.isAdmin) {
                    let res = await axios.post('/notice/check', {id:history.id, dealt_with:history.dealt_with})
                }

                //if(res.data.success){
                //    location.href = '/notice/' + history.id + '/detail';
                //}
            },
            changePage: function(page){
                this.current_page = page;
                window.location.href = 'notice?page=' + this.current_page;
            },
            init(){
                console.log("notice:init", this.histories)
            }
        },
        mounted() {
            this.init();
        }
    }
</script>
