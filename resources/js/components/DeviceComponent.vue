<template>
    <div>
        <loading v-show="loading"></loading>
        <div class="inner">

            <section class="top_20 bottom_20">
                <h2 class="font_20 border_title p_left10 l_height20">端末管理</h2>
            </section>

            <section class="search_color p1020">
                <div class="check_box_wrap bottom_10">
                    <span class="right_10">利用開始日</span>
                    <input type="text"
                           class="w_100 right_20"
                           v-model="filter.started_at"
                           :placeholder="now">
                    <span class="right_10">機種</span>
                    <select v-model="filter.device_model" class="w_110">
                        <option value=""></option>
                        <option v-for="device_type in device_types" v-bind:key="device_type.id" :value="device_type.type">{{device_type.type}}
                        </option>
                    </select>
                    <span class="left_20 right_10">IMEI番号</span>
                    <input type="text" v-model="filter.imei_number" class="w_140">
                    <span v-show="isAdmin && company_id !== null" class="left_20 right_10">会社名</span>
                    <input v-show="isAdmin && company_id !== null" type="text" v-model="filter.company_name"
                           class="w_320 right_20">
                </div>
                <div class="bottom_10">
                    <span class="right_10">グループ名</span>
                    <input type="text" v-model="filter.group_name" class="w_350 right_20">
                    <span v-if="!company_id && isAdmin" class="right_10">SB請求先番号</span>
                    <input v-if="!company_id && isAdmin" type="text" v-model="filter.sb_billing_number" class="w_100 right_20">
                    <span class="right_10">架.No</span>
                    <input type="text" v-model="filter.mount_no" class="w_100 right_20">
                    <span class="right_10">端末バージョン</span>
                    <input type="text" v-model="filter.version" class="w_100 right_20" placeholder="210204">
                </div>
                <div>
                    <span class="right_10">端末名称</span>
                    <input type="text" v-model="filter.name" class="w_100 right_20">
                    <span class="right_10">端末電話番号</span>
                    <input type="text" v-model="filter.msn" class="w_120 right_10" placeholder="ハイフンなし">
                    <span class="right_10">端末発信設定</span>
                    <input type="text"
                           v-model="filter.command_center"
                           class="w_120 right_20"
                           placeholder="ハイフンなし">
                    <span class="right_10">着信可能設定</span>
                    <input type="text"
                           v-model="filter.receiver_number"
                           class="w_120 right_20"
                           placeholder="ハイフンなし">
                    <button type="button" v-on:click="search" class="create_btn ss_btn">検索</button>
                </div>
            </section>

            <pager :items="device_assignments"
                   v-on:paginate="changePage"
                   v-on:show_import_modal="show_import_modal"
                   v-on:export="export_excel"
                   :garbage="isAdmin ? garbage: null"
                   :excel="isAdmin ? excel: null"
                   class="pager bottom_10 top_20 position_r"></pager>

            <section v-if="device_assignments.data" class="top_10 clearfix">
                <div class="table_left_scroll float_l w_1120">
                    <table>
                        <tr class="h_32">
                            <th class="w_60">休止</th>
                            <th class="w_60">未更新</th>
                            <th class="w_90">利用開始日</th>
                            <th class="w_90">利用終了日</th>
                            <th class="w_90">読込日</th>
                            <th class="w_90">電源状態</th>
                            <th class="w_90">BAT残量</th>
                            <th class="w_110">架.No</th>
                            <th class="w_120">端末電話番号</th>
                            <th class="w_160">IMEI番号</th>
                            <th class="w_160">端末名称</th>
                            <th class="w_250">グループ名</th>
                            <th class="w_120">SB請求先番号</th>
                            <th class="w_110">端末発信設定</th>
                            <th class="w_110">着信可能設定01</th>
                            <th class="w_110">着信可能設定02</th>
                            <th class="w_110">着信可能設定03</th>
                            <th class="w_90">更新日</th>
                            <th class="w_110">端末バージョン</th>
                        </tr>
                        <tr class="h_39" v-for="(d, index) in device_assignments.data" v-bind:key="index">
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
                            <td>{{d.mount_no}}</td>
                            <td>{{d.sim.msn}}</td>
                            <td>{{d.device.imei}}</td>
                            <td class="text_cut">{{d.name}}</td>
                            <td class="text_cut">{{d.device_group.name}}</td>
                            <td >{{d.company.sb_payment_no}}</td>
                            <td>{{d.phones[0] ? d.phones[0].phone : null}}</td>
                            <td>{{d.phones[1] ? d.phones[1].phone : null}}</td>
                            <td>{{d.phones[2] ? d.phones[2].phone : null}}</td>
                            <td>{{d.phones[3] ? d.phones[3].phone : null}}</td>
                            <td>{{d.updated_at_date}}</td>
                            <td>{{d.device.version}}</td>
                        </tr>
                    </table>
                </div>

                <div class="w_80 float_r">
                    <table>
                        <tr class="h_32">
                            <th class="w_80"></th>
                        </tr>
                        <tr v-for="(d, index) in device_assignments.data" class="h_39" v-bind:key="index">
                            <td>
                                <a v-if="company_id" :href="'/company/' + company_id + '/device/' + d.id + '/detail'"
                                   class="ss_btn details_btn">詳細</a>
                                <a v-else :href="'/device/' + d.id + '/detail'" class="ss_btn details_btn">詳細</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>

            <pager :items="device_assignments" v-on:paginate="changePage"
                   class="pager bottom_10 top_20 position_r"></pager>

            <div class="pop modal-content pop-box import-modal" id="modal">
                <form action="/device/import" method="post" enctype="multipart/form-data">
                    <csrf></csrf>
                    <table>
                        <tr class="h_39">
                            <th class="w_200 text_l p_left6">ファイル名</th>
                            <td class="text_l">
                                <input id="import_filename" readonly type="text" value="" class="w_200">
                                <button type="button" id="import_file_button" class="ss_btn create_btn">選択</button>
                                <input id="import_file" name="import_file" type="file" accept=".xlsx"/>
                            </td>
                        </tr>
                    </table>
                    <p class="top_10 bottom_20">指定されたファイルをインポートします。よろしいですか？</p>
                    <div class="top_20">
                        <div class="text_c space">
                            <button class="details_btn l_btn space_normal right_5" onclick="return false"
                                    v-on:click="import_check">はい
                            </button>
                            <a class="return_btn l_btn space_normal left_5 modal-close"
                               onclick="$('#modal').fadeOut('slow')">いいえ</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Loading from './Loading';
    import Pager from "./Pager";
    import moment from "moment";
    import Csrf from "./Csrf";

    let current_date = moment().format('YYYY/MM/DD')

    export default {
        name: 'DeviceComponent',
        components: {
            Csrf,
            Loading,
            Pager,
        },
        props: {
            'company_id': null,
            'garbage': null,
            'excel': null,
            'isAdmin': false,
        },
        data() {
            return {
                modal_type: 'import',
                device_assignment: {},
                device_types: typeof device_types === 'undefined' ? [] : device_types,
                device_assignments: typeof device_assignments === 'undefined' ? [] : device_assignments,
                filter: typeof filter === 'undefined' ? {} : filter,
                now: current_date,
                loading: false,
                current_page: typeof current_page !== 'undefined' ? current_page : 1,
                
            }
        },
        computed: {},
        methods: {
            search: async function () {
                if (this.company_id) {
                    this.filter.company_id = this.company_id;
                }
                let res = await axios.get('/device/search', {params: this.filter});
                console.log("device:search", res);
                this.device_assignments = res.data.data;
            },
            changePage(page) {
                console.log("changePage", page, this.company_id);
                
                if(this.company_id){
                    window.location.href = '/company/' + this.company_id + '/device?page=' + page;
                    return;
                }

                window.location.href = '/device?page=' + page;
            },
            import_check: function () {
                if (document.getElementById('import_filename').value == '') {
                    window.alert('ファイルを選択してください。');
                    return false;
                }
                $('form').submit();
            },
            show_import_modal: function () {
                show_modal();
            },
            export_excel: function () {
                window.location.href = '/device/export';
            },
            init: function () {
                console.log('device', this.company_id, this.garbage)
                let page = new URL(location.href).searchParams.get('page');
            }
        },
        mounted() {
            this.init();
        }
    }
</script>

