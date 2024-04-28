<template>
    <div>
        <loading v-show="loading && initialDisplayLoading"></loading>
        <!-----modal---------->
        <div class="pop modal-content pop-box" style="margin-top:30px!important" id="showalert-modal">
            <div style="width:100%;height:20%">
                <span style="font-size:18px;">このページの内容</span>
            </div>
            <div style="width:100%;height:50%">
                <span style="font-size:18px;">コード追加の端末コード追加で発報があったのでnカメラに連携しますか</span>
            </div>
            <div style="width:100%;height:30%;overflow:hidden">
                <div style="width:30%;height:100%;float:left"></div>
                <a style="width:32%;float:left" class="return_btn l_btn space_normal right_5 modal-close">キャンセル</a>
                <a style="margin-left:3%;width:32%;float:left" class="details_btn l_btn space_normal left_5" @click="rpaGo">OK</a>
            </div>
        </div>
        <div class="inner">

            <section class="top_20 bottom_20">
                <h2 class="font_20 border_title p_left10 l_height20">端末履歴</h2>
            </section>

            <section class="search_color p1020">
                <div class="check_box_wrap bottom_10">
                    <div class="check_box_wrap inblock">
						<label class="checkbox_text right_10" for="all">
							<input type="checkbox" name="allChecked" id="all" checked>全選択
						</label>
						<div id="boxes" class="check-wrapper">
                            <div class="check_box_wrap inblock right_20">
                                <label class="checkbox_text">
                                    <input type="checkbox" name="chk[]" v-model="filter.emergency_call">緊急通報
                                </label>
                            </div>
                            <div class="check_box_wrap inblock right_20">
                                <label class="checkbox_text">
                                    <input type="checkbox" name="chk[]" v-model="filter.emergency_buzzer">非常ブザー
                                </label>
                            </div>
                            <div class="check_box_wrap inblock right_20">
                                <label class="checkbox_text">
                                    <input type="checkbox" name="chk[]" v-model="filter.battery_low">バッテリー低下
                                </label>
                            </div>
                            <div class="check_box_wrap inblock right_20">
                                <label class="checkbox_text">
                                    <input type="checkbox" name="chk[]" v-model="filter.power_off">電源OFF
                                </label>
                            </div>
                            <div class="check_box_wrap inblock right_20">
                                <label class="checkbox_text">
                                    <input type="checkbox" name="chk[]" v-model="filter.power_on">電源ON
                                </label>
                            </div>
                            <div class="check_box_wrap inblock right_20">
                                <label class="checkbox_text">
                                    <input type="checkbox" name="chk[]" v-model="filter.call_received">電話着信
                                </label>
                            </div>
                            <div class="check_box_wrap inblock right_20">
                                <label class="checkbox_text">
                                    <input type="checkbox" name="chk[]" v-model="filter.location_inquiry">位置問い合わせ
                                </label>
                            </div>
							<div class="check_box_wrap inblock right_20">
								<label class="checkbox_text">
									<input type="checkbox" name="chk[]" v-model="filter.connection_error">通信エラー
								</label>
							</div>
							<div class="check_box_wrap inblock">
								<label class="checkbox_text">
									<input type="checkbox" name="chk[]" v-model="filter.connection_restore">通信復旧
								</label>
							</div>
                        </div>
                    </div>
                </div>
                <div class="bottom_10">
                    <span class="right_10">日付</span>
                    <input type="text"
                           class="w_100 right_20"
                           :placeholder="registered_at"
                           v-model="filter.date">
                    <span class="right_10">機種</span>
                    <select class="w_110 right_20" v-model="filter.device_model">
                        <option value=""></option>
                        <option v-for="(device_type, index) in device_types" :value="device_type.type" v-bind:key="index">{{device_type.type}}</option>
                    </select>
                    <span class="right_10">IMEI番号</span>
                    <input type="text" class="w_140 right_20" v-model="filter.imei_number">
                    <span v-if="isAdmin && !company_id" class="right_10">SB請求先番号</span>
                    <input v-if="isAdmin && !company_id" type="text" class="w_110" v-model="filter.sb_billing_number">
                    <span v-if="isAdmin" class="right_10 left_20">架.No</span>
                    <span v-if="!isAdmin" class="right_10">架.No</span>
                    <input type="text" class="w_110" v-model="filter.mount_no">
                </div>
                <div class="bottom_10">
                    <span class="right_10">グループ名</span>
                    <input type="text" class="w_320" v-model="filter.group_name">
                    <span v-if="isAdmin && !company_id" class="right_10 left_20">会社名</span>
                    <input v-if="isAdmin && !company_id" type="text" class="w_320" v-model="filter.company_name">
                </div>
                <div>
                    <span class="right_10">端末電話番号</span>
                    <input type="text"
                           class="w_120 right_20"
                           placeholder="ハイフンなし"
                           v-model="filter.msn">
                    <span class="right_10">端末発信設定</span>
                    <input type="text"
                           class="w_120"
                           placeholder="ハイフンなし"
                           v-model="filter.command_center">
                    <span class="right_10 left_20">着信可能設定</span>
                    <input type="text"
                           class="w_120"
                           placeholder="ハイフンなし"
                           v-model="filter.receiver_number">
                    <div class="check_box_wrap inblock left_20 right_20">
                        <label class="checkbox_text">
                            <input type="checkbox" v-model="filter.positioning_with_at_true">測位中
                        </label>
                        <label class="checkbox_text">
                            <input type="checkbox" v-model="filter.positioning_with_at_false">測位済
                        </label>
                    </div>
                    <button class="create_btn ss_btn" v-on:click="search">検索</button>
                </div>
            </section>

            <pager :items="histories" v-on:paginate="changePage" class="pager bottom_10 top_20 position_r"></pager>

            <section class="top_10 clearfix">
                <div class="table_left_scroll float_l w_930">
                    <table>
                        <tr class="h_32">
                            <th class="w_110">端末電話番号</th>
							<th class="w_120">名称</th>
							<th class="w_180">グループ名</th>
							<th class="w_90">日付</th>
							<th class="w_70">時刻</th>
							<th class="w_110"></th>
							<th class="w_70">BAT残量</th>
							<th class="w_110">架.No</th>
							<th class="w_200">補足</th>
							<th class="w_140">IMEI番号</th>
                            <th class="w_140">接続カメラ名</th>
                            <th class="w_140">カメラシリアル番号</th>
                            <th class="w_140">カメラシステム連携</th>
                        </tr>
                        <tr v-for="history in histories.data" class="h_39" v-bind:key="history.id">
                            <template v-if="!!history.device_setting">
                                <td>{{history.device_setting.sim.msn}}</td>
                                <td class="text_cut">{{history.device_setting.name}}</td>
                                <td class="text_cut">{{history.device_setting.device_group.name}}</td>
                                <td>{{history.created_at_date}}</td>
                                <td>{{history.created_at_time}}</td>
                                <td>
                                    <signal-icon v-if="history.device_signal" :signal="history.device_signal.signal_int"></signal-icon>
                                </td>
                                <td>{{history.battery}}%</td>
                                <td>{{history.device_setting.mount_no}}</td>
                                <td class="text_cut">{{history.supplement}}</td>
                                <td>{{history.device_setting.device.imei}}</td>
                                <td>{{history.device_assignment.camera_name}}</td>
                                <td>{{history.device_assignment.camera_serial}}</td>
                                <td>{{(history.device_assignment.camera_enabled==1)?"ON":"OFF"}}</td>
                                <td>{{history.roles}}</td>
                            </template>
                            <template v-else>
                                <td>{{history.device_assignment.sim.msn}}</td>
                                <td class="text_cut">{{history.device_assignment.connect_camera_name}}</td>
                                <td class="text_cut">{{history.device_assignment.device_group.name}}</td>
                                <td>{{history.created_at_date}}</td>
                                <td>{{history.created_at_time}}</td>
                                <td>
                                    <signal-icon v-if="history.device_signal" :signal="history.device_signal.signal_int"></signal-icon>
                                </td>
                                <td>{{history.battery}}%</td>
                                <td>{{history.device_assignment.mount_no}}</td>
                                <td class="text_cut">{{history.supplement}}</td>
                                <td>{{history.device_assignment.device.imei}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </template>
                        </tr>
                    </table>
                </div>

                <div class="w_270 float_r">
                    <table v-if="company_id">
                        <tr class="h_32">
                            <th class="w_60">受信数</th>
                            <th class="w_60">対応済</th>
                            <th class="w_80"></th>
                        </tr>
                        <tr v-for="history in histories.data" class="receive_color h_39" v-bind:key="history.id">
                            <td>
                                <a v-if="history.device_signal && history.device_signal.signal_int <= 4" :href="'/history/'+ history.id +'/message'">
                                    <span class="receive_color">{{history.received_messages.length}}</span>
                                    <span class="receive_color">|</span>
                                    <span class="receive_color">{{history.messages.length}}</span>
                                </a>
                            </td>
                            <!-- <td>
                                <div class="positioning" v-if="history.positioning"></div>
                            </td> -->
                            <td>
                                <div class="check_onle_wrap">
                                    <div class="w_20 text_c auto"
                                        v-if="history.dealt_with">
                                        <img src="/img/check.png">
                                    </div>
                                    <!-- <div class="w_20 text_c auto" >
                                        <label class="checkbox_box">
                                            <input name="dealt_with" v-model="history.dealt_with" type="checkbox" :disabled="!isAdmin" @change="updateHistory(history)">
                                        </label>
                                    </div> -->
                                </div>
                            </td>
                            <td>
                                <a v-if="company_id" :href="'/company/' + company_id + '/history/' + history.id + '/detail'" class="ss_btn details_btn">詳細</a>
                                <a v-else :href="'/history/' + history.id + '/detail'" class="ss_btn details_btn">詳細</a>
                            </td>
                        </tr>
                    </table>
                    <table v-else>
                        <tr class="h_32">
                            <th class="w_60">受信数</th>
                            <th class="w_60">測位中</th>
                            <th class="w_60">対応済</th>
                            <th class="w_80"></th>
                        </tr>
                        <tr v-for="history in histories.data" class="receive_color h_39" v-bind:key="history.id">
                            <td>
                                <a v-if="history.device_signal && history.device_signal.signal_int <= 4" :href="'/history/'+ history.id +'/message'">
                                    <span class="receive_color">{{history.received_messages.length}}</span>
                                    <span class="receive_color">|</span>
                                    <span class="receive_color">{{history.messages.length}}</span>
                                </a>
                            </td>
                            <!-- <td>
                                <div class="positioning" v-if="history.positioning"></div>
                            </td> -->
                            <td>
                                <div class="check_onle_wrap">
                                    <div class="w_20 text_c auto"
                                        v-if="history.positioning">
                                        <img src="/img/circle.png">
                                    </div>
                                    <div class="w_20 text_c auto"
                                        v-else>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="check_onle_wrap">
                                    <div class="w_20 text_c auto"
                                        v-if="history.dealt_with">
                                        <img src="/img/check.png">
                                    </div>
                                    <!-- <div class="w_20 text_c auto" >
                                        <label class="checkbox_box">
                                            <input name="dealt_with" v-model="history.dealt_with" type="checkbox" :disabled="!isAdmin" @change="updateHistory(history)">
                                        </label>
                                    </div> -->
                                </div>
                            </td>
                            <td>
                                <a v-if="company_id" :href="'/company/' + company_id + '/history/' + history.id + '/detail'" class="ss_btn details_btn">詳細</a>
                                <a v-else :href="'/history/' + history.id + '/detail'" class="ss_btn details_btn">詳細</a>
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
    import HistoryHeader from "./HistoryHeader";
    import moment from "moment";
    import SignalIcon from "./SignalIcon";


    let current_date = moment().format('YYYY/MM/DD')
    var serial_num = 0;
    export default {
        name: 'HistoryComponent',
        components: {
            SignalIcon,
            Loading,
            Pager,
            HistoryHeader,
        },
        props: {
            company_id: {
                request: false,
                type: String,
                default: null,
            }
        },
        timers: {
            getList: { time: 10000, autostart: true, repeat: true }
        },
        data() {
            return {
                filter: !!filter ? filter : {
                    date: '',
                    rtc_time: '',
                    emergency_call: true,
                    emergency_buzzer: true,
                    call_received: true,
                    power_off: true,
                    power_on: true,
                    location_inquiry: true,
                    connection_error: true,
                    connection_restore: true,
                    battery_low: true,
                    device_model: '',
                    imei: '',
                    // connect_camera_name: '',
                    // camera_serial_num: '',
                    // camera_connect: '',
                    sb_billing_number: '',
                    group_name: '',
                    company_name: '',
                    msn: '',
                    command_center: '',
                    receiver_number: '',
                    positioning_with_at_true: true,
                    positioning_with_at_false: true,
                    company_id: '',
                },
                searchFilter: {},
                isAdmin: typeof isAdmin !== 'undefined' ? isAdmin : false,
                registered_at: current_date,
                history: {},
                device_types: typeof device_types === 'undefined' ? [] : device_types,
                histories: typeof histories === 'undefined' ? [] : histories,
                loading: false,
                initialDisplayLoading: true,
                currentPage: typeof currentPage !== 'undefined' ? currentPage : 1,
                perPage: 20,
            }
        },
        computed: {
        },
        methods: {
            getList: function() {
                if(this.loading) return;

                if(this.company_id){
                    this.searchFilter.company_id = this.company_id;
                }
                this.searchFilter.positioning_with_at_true = this.searchFilter.positioning_with_at_false = true;
                this.loading = true;
                axios.get('/history/search/?page=' + this.currentPage, {params: this.searchFilter})
                    .then( res => res.data )
                    .then( data => {
                        if( data.success ) {
                            this.histories = data.data;
                        }
                    })
                    .finally( () => {
                        this.loading = false;
                        this.initialDisplayLoading = false;
                    });
            },
            search: function() {
                this.searchFilter = { ... this.filter };
                this.currentPage = 1;
                this.getList();
            },
            changePage(page){
                this.currentPage = page;
                this.getList()

            },
            updateHistory: function(history) {
                if(this.isAdmin)
                {
                    this.loading = true;
                    axios.post('/api/history/update', {id:history.id, dealt_with:history.dealt_with})
                        .then(res => res.data)
                        .then(data => {
                            // this.histories = data
                            this.loading = false;
                            this.getList();
                        })
                        .finally(_ => {
                            this.loading = false;
                        })
                }
            },
            rpaGo:function(){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    var response = xmlhttp.responseText; //if you need to do something with the returned value
                }
                }

                xmlhttp.open("GET",'http://localhost/auto/auto.php?sn=' + serial_num,true);
                //xmlhttp.open("GET",'http://191.101.211.239/auto/auto.php?sn=' + serial_num,true);
                xmlhttp.send();

                //var win = window.open('http://localhost/auto/auto.php?sn=' + serial_num, '_blank');
                //var win = window.open('http://191.101.211.239/auto/auto.php?sn=' + serial_num, '_blank');
                //win.close();
                //window.open('https://safie.link/app/devices/camera?sn=' + serial_num, '_blank');
                //window.location.href = '/history';

                hide_modal("#showalert-modal");
            },
            getIPAddress:function() {
                $.getJSON('https://ipinfo.io/json', function(data) {
                    alert(data);
                });
            },
        },
        mounted() {
            this.searchFilter = { ...this.filter }
            this.getList();
            console.log({ filter });

            //let res = axios.get('/history/monitor');
            // setInterval(() => { 
            //     axios.get('/history/monitor')
            //             .then(res => res.data)
            //             .then(data => {
            //                 if(data != -1 && data != 0){                                                                                          ;                                
            //                     serial_num = data;                                
            //                     show_modal("#showalert-modal");                                
            //                 }
            //                 else if(data == 0){
            //                     window.location.href = '/history';     
            //                 }
            //             })
            //             .finally(_ => {                            
            //                 this.loading = false;                            
            //             })
            // },2000);            
        }
    }
</script>

<style scoped>
.positioning {
    width: 20px;
    height: 20px;
    border: 2px solid #E87461;
    border-radius: 50%;
    margin:auto;
}
</style>
