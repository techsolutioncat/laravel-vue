<template>
    <div>
        <loading v-show="loading"></loading>
        <div class="inner">

            <section class="top_20 bottom_20">
                <h2 class="font_20 border_title p_left10 l_height20">端末管理（ゴミ箱）</h2>
            </section>

            <section class="search_color p1020">
                <div class="check_box_wrap bottom_10">
                    <span class="right_10">利用開始日</span>
                    <input type="text" v-model="filter.started_at" class="w_100 right_20" placeholder="2019/02/02">
                    <span class="right_10">機種</span>
                    <select class="w_110" v-model="filter.device_model">
                        <option value=""></option>
                        <option v-for="device_type in device_types" :value="device_type.type">{{device_type.type}}</option>
                    </select>
                    <span class="left_20 right_10">IMEI番号</span>
                    <input type="text" v-model="filter.imei_number" class="w_140">
                    <span class="left_20 right_10">会社名</span>
                    <input type="text" class="w_320 right_20" v-model="filter.company_name">
                </div>
                <div class="check_box_wrap bottom_10">
                    <span class="right_10">グループ名</span>
                    <input type="text" v-model="filter.group_name" class="w_350 right_20">
                    <span class="right_10">SB請求先番号</span>
                    <input type="text" class="w_110 right_20" v-model="filter.sb_billing_number">
                    <span class="right_10">架.No</span>
                    <input type="text" v-model="filter.mount_no" class="w_100 right_20">
                </div>
                <div>
                    <span class="right_10">端末名称</span>
                    <input type="text" v-model="filter.name" class="w_100 right_20">
                    <span class="right_10">端末電話番号</span>
                    <input
                            type="text"
                            class="w_120 right_20"
                            placeholder="ハイフンなし"
                            v-model="filter.msn">
                    <span class="right_10">端末発信設定</span>
                    <input
                            type="text"
                            class="w_120 right_20"
                            placeholder="ハイフンなし"
                            v-model="filter.command_center">
                    <span class="right_10">着信可能設定</span>
                    <input
                            type="text"
                            class="w_120 right_20"
                            placeholder="ハイフンなし"
                            v-model="filter.receiver_number">
                    <a @click="search" class="create_btn ss_btn">検索</a>
                </div>
            </section>

            <pager :items="device_assignments"
                   v-on:paginate="changePage"
                   :undo="true"
                   class="pager bottom_10 top_20 position_r"></pager>

            <section class="top_10 clearfix">
                <div class="table_left_scroll float_l w_1120">
                    <table>
                        <tr class="h_32">
                            <th class="w_60">休止</th>
                            <th class="w_60">未更新</th>
                            <th class="w_90">利用開始日</th>
                            <th class="w_90">利用終了日</th>
                            <th class="w_90">読込日</th>
                            <th class="w_50">状態</th>
                            <th class="w_50">残量</th>
                            <th class="w_120">機種</th>
                            <th class="w_160">IMEI番号</th>
                            <th class="w_120">SB請求先番号</th>
                            <th class="w_250">グループ名</th>
                            <th class="w_250">会社名</th>
                            <th class="w_110">端末電話番号</th>
                            <th class="w_110">端末発信設定</th>
                            <th class="w_110">着信可能設定01</th>
                            <th class="w_110">着信可能設定02</th>
                            <th class="w_110">着信可能設定03</th>
                            <th class="w_90">更新日</th>
                        </tr>
                        <tr class="h_39" v-for="d in device_assignments.data">
                            <td>
                                <div class="w_20 text_c auto">
                                    <img v-show="d.rest" src="/img/pause.png">
                                </div>
                            </td>
                            <td>
                                <div v-show="d.applied_at == null" class="w_20 text_c auto">
                                    <img src="/img/note.png">
                                </div>
                            </td>
                            <td>{{d.started_at}}</td>
                            <td>{{d.ended_at}}</td>
                            <td>{{d.applied_at}}</td>
                            <td>{{d.active ? "ON" : "OFF"}}</td>
                            <td>{{d.battery}}%</td>
                            <td><span v-if="d.device.device_type == null"></span>
                                <span v-else>{{d.device.device_type.type}}</span></td>
                            <td>{{d.device.imei}}</td>
                            <td>{{d.company.sb_payment_no}}</td>
                            <td class="text_cut">{{d.device_group.name}}</td>
                            <td class="text_cut">{{d.company.name}}</td>
                            <td>{{d.sim.msn}}</td>
                            <td>{{d.phones[0].phone}}</td>
                            <td>{{d.phones[1].phone}}</td>
                            <td>{{d.phones[2].phone}}</td>
                            <td>{{d.phones[3].phone}}</td>
                            <td>{{d.date}}</td>
                        </tr>
                    </table>
                </div>

                <div class="w_80 float_r">
                    <table>
                        <tr class="h_32">
                            <th class="w_150"></th>
                        </tr>
                        <tr v-for="d in device_assignments.data">
                            <td>
                                <form action="/device/restore" method="post">
                                    <input type="hidden" name="_token" :value="csrf">
                                    <input type="hidden" name="id" :value="d.id">
                                    <a :href="'/device/' + d.id + '/detail/garbage'" class="ss_btn details_btn">詳細</a>
                                    <button type="submit" class="ss_btn create_btn left_5">復元</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>

            <pager :items="device_assignments" v-on:paginate="changePage" class="pager bottom_10 top_20 position_r"></pager>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Loading from './Loading';
    import Pager from "./Pager";
    import moment from "moment";

    let current_date = moment().format('YYYY/MM/DD')

    export default {
        name: 'DeviceComponent',
        components: {
            Loading,
            Pager,
        },
        data() {
            return {
                modal_type: 'import',
                device_assignment: {},
                device_types: typeof device_types === 'undefined' ? [] : device_types,
                device_assignments: typeof device_assignments === 'undefined' ? [] : device_assignments,
                filter: typeof filter === 'undefined' ? {} : filter,
                now: current_date,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

                loading: false,
            }
        },
        methods: {
            changePage: function(page){
               window.location.href = '/device/garbage?page=' + page;
            },
            search: async function() {
                this.loading = true;
                this.filter.garbage = true;
                let res = await axios.get('/device/search', {params: this.filter});

                if(res.data.success){
                    this.device_assignments = res.data.data;
                }
                this.loading = false;
            },
            show_import_modal: function() {
                show_modal();
            },
            export_excel: function() {
                window.location.href = '/device/export';
            },
            init: function(){
                console.log("device:garbage", this.device_assignments);
            }
        },
        mounted() {
            this.init();
        }
    }
</script>

