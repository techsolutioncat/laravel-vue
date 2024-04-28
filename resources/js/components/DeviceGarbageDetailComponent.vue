<template v-slot:default>
    <div>
        <Loading v-show="loading"></Loading>
        <form :action="action" method="post">
            <csrf/>
            <input type="hidden" name="id" :value="device_assignment.id">
            <input type="hidden" name="garbage" value="/garbage">

            <div class="inner">
                <section class="top_20 bottom_20">
                    <h2 class="font_20 border_title p_left10 l_height20">端末詳細</h2>
                </section>
                <section class="pager bottom_10 top_20 text_r">
                    <button class="m_btn create_btn modal-open2" data-target="clone">クローン</button>
                </section>
                <section class="top_10">
                    <table>
                        <tr class="h_39">
                            <th class="w_200 text_l p_left6">休止設定</th>
                            <td class="w_400 text_l">
                                <div class="radio p_left6">
                                    <input type="radio"
                                           name="state"
                                           class="radio-input"
                                           id="state_enable"
                                           value="休止"
                                           v-model="device_assignment.rest">
                                    <label for="state_enable">
                                        <span class="p_left10">有効</span>
                                    </label>
                                    <input type="radio"
                                           name="state"
                                           class="radio-input"
                                           value="利用中"
                                           id="state_disable">
                                    <label for="state_disable">
                                        <span class="p_left10">無効</span>
                                    </label>
                                </div>
                            </td>
                            <th class="w_200 item">SB請求先番号</th>
                            <td class="w_400 item">
                                {{device_assignment.sb_payment_no}}
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">未更新</th>
                            <td class="w_400 item">
                                <div class="w_20 text_l left_6">
                                    <img src="/img/note.png">
                                </div>
                            </td>
                            <th class="w_200 item">端末電話番号</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text" class="w_110" v-model="device_assignment.sim.msn">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">架.No</th>
                            <td class="w_400 item">
                                <span>123456789</span>
                            </td>
                            <th class="w_200 item">端末発信設定</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text"
                                       class="w_110"
                                       v-model="device_assignment.device_phones[0].phone">
                                <span class="right_5 left_10">名称</span>
                                <input type="text"
                                       class="w_190"
                                       v-model="device_assignment.device_phones[0].name">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">利用開始日</th>
                            <td class="w_400 item">
                                <span>{{device_assignment.started_at}}</span>
                            </td>
                            <th class="w_200 item">着信可能設定01</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text"
                                       class="w_110"
                                       v-model="device_assignment.device_phones[1].phone">
                                <span class="right_5 left_10">名称</span>
                                <input type="text"
                                       class="w_190"
                                       v-model="device_assignment.device_phones[1].name">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">利用終了日</th>
                            <td class="w_400 item">
                                <span>{{device_assignment.ended_at}}</span>
                            </td>
                            <th class="w_200 item">着信可能設定02</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text"
                                       class="w_110"
                                       v-model="device_assignment.device_phones[2].phone">
                                <span class="right_5 left_10">名称</span>
                                <input type="text"
                                       class="w_190"
                                       v-model="device_assignment.device_phones[2].name">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">読込日</th>
                            <td class="w_400 item">
                                <span>{{device_assignment.applied_at}}</span>
                            </td>
                            <th class="w_200 item">着信可能設定03</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text"
                                       class="w_110"
                                       v-model="device_assignment.device_phones[3].phone">
                                <span class="right_5 left_10">名称</span>
                                <input type="text"
                                       class="w_190"
                                       v-model="device_assignment.device_phones[3].name">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">更新日</th>
                            <td class="w_400 item">
                                <span>{{device_assignment.updated_at}}</span>
                            </td>
                            <th class="w_200 item">着信可能設定04</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text"
                                       class="w_110"
                                       v-model="device_assignment.device_phones[4].phone">
                                <span class="right_5 left_10">名称</span>
                                <input type="text"
                                       class="w_190"
                                       v-model="device_assignment.device_phones[4].name">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">電源状態</th>
                            <td class="w_400 item">
                                <span>{{device_assignment.active ? 'ON' : 'OFF'}}</span>
                            </td>
                            <th class="w_200 item">受信可能番号05</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text"
                                       class="w_110"
                                       v-model="device_assignment.device_phones[5].phone">
                                <span class="right_5 left_10">名称</span>
                                <input type="text"
                                       class="w_190"
                                       v-model="device_assignment.device_phones[5].name">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">残量</th>
                            <td class="w_400 item">
                                <span>{{device_assignment.battery}}%</span>
                            </td>
                            <th class="w_200 item">着信可能設定06</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text"
                                       class="w_110"
                                       v-model="device_assignment.device_phones[6].phone">
                                <span class="right_5 left_10">名称</span>
                                <input type="text"
                                       class="w_190"
                                       v-model="device_assignment.device_phones[6].name">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">機種</th>
                            <td class="w_400 item">
                                <span v-if="device_assignment.device.device_type == null"></span>
                                <span v-else>{{device_assignment.device.device_type.type}}</span>
                            </td>
                            <th class="w_200 item">着信可能設定07</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text"
                                       class="w_110"
                                       v-model="device_assignment.device_phones[7].phone">
                                <span class="right_5 left_10">名称</span>
                                <input type="text"
                                       class="w_190"
                                       v-model="device_assignment.device_phones[7].name">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">IMEI番号</th>
                            <td class="w_400 item">
                                <span>{{device_assignment.device.imei}}</span>
                            </td>
                            <th class="w_200 item">着信可能設定08</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text"
                                       class="w_110"
                                       v-model="device_assignment.device_phones[8].phone">
                                <span class="right_5 left_10">名称</span>
                                <input type="text"
                                       class="w_190"
                                       v-model="device_assignment.device_phones[8].name">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">グループ名</th>
                            <td class="w_400 item">
                                <textarea
                                        class="auto-resize textarea resize">{{device_assignment.device_group.name}}</textarea>
                            </td>
                            <th class="w_200 item">着信可能設定09</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text"
                                       class="w_110"
                                       v-model="device_assignment.device_phones[9].phone">
                                <span class="right_5 left_10">名称</span>
                                <input type="text"
                                       class="w_190"
                                       v-model="device_assignment.device_phones[9].name">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">会社名</th>
                            <td class="w_400 item">
                                <span>株式会社テストテスト</span>
                            </td>
                            <th class="w_200 item">着信可能設定10</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <input type="text"
                                       class="w_110"
                                       v-model="device_assignment.device_phones[9].phone">
                                <span class="right_5 left_10">名称</span>
                                <input type="text"
                                       class="w_190"
                                       v-model="device_assignment.device_phones[9].name">
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">緊急通報</th>
                            <td class="w_400 item">
                                <textarea class="auto-resize textarea resize"
                                          v-model="device_assignment.emergency_call.message"></textarea>
                            </td>
                            <th class="w_200 item">バッテリー低下</th>
                            <td class="w_400 item">
                                <textarea class="auto-resize textarea resize"
                                          v-model="device_assignment.battery_low.message"></textarea>
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 item">非常ブザー</th>
                            <td class="w_400 item">
                                <textarea class="auto-resize textarea resize"
                                          v-model="device_assignment.emergency_buzzer.message"></textarea>
                            </td>
                            <th class="w_200 item">電源OFF</th>
                            <td class="w_400 item">
                                <textarea class="auto-resize textarea resize"
                                          v-model="device_assignment.power_off.message"></textarea>
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="w_200 text_l p_left6">利用状況</th>
                            <td class="text_l" colspan="3">
                                <div class="radio p_left6">
                                    <input type="radio" name="radio" class="radio-input" id="enable">
                                    <label for="enable">
                                        <span class="p_left10">利用中</span>
                                    </label>
                                    <input type="radio" name="radio" class="radio-input" id="disable">
                                    <label for="disable">
                                        <span class="p_left10">利用停止</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="text_c space top_20 bottom_20">
                        <button v-on:click="destroy" class="delete_btn l_btn space_normal right_10 modal-close">削除
                        </button>
                        <button v-on:click="update" class="details_btn l_btn space_normal right_10">保存</button>
                        <a href="/device/garbage" class="return_btn l_btn space_normal right_10">戻る</a>
                    </div>
                </section>
            </div>
        </form>

    </div>
</template>

<script>
    import axios from 'axios';
    import Loading from './Loading';
    import CompanyHeader from "./CompanyHeader";
    import Csrf from "./Csrf";

    export default {
        name: 'DeviceDetailComponent',
        components: {
            CompanyHeader,
            Loading,
            Csrf,
        },
        data() {
            return {
                modal_type: 'update',
                loading: false,
                action: '/device/update',
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        props: {
            'device_assignment': {
                type: Object,
                required: true,
            }
        },
        methods: {
            // 更新
            update: function () {
                this.action = '/device/update';
                $('form').submit();
                // データの送信
                // axios.post(
                //     '/api/device/update',
                //     {
                //         data: this.device_assignment,
                //     })
                //     .then(res => {
                //         // this.company = res.data;
                //     }).catch(e => console.log(e));
            },
            // 削除
            destroy: function () {
                this.action = '/device/delete';
                $('form').submit();
                // axios.post('/device/delete', { id: this.device_assignment.id })
                //     .then(res => {
                //     });
            },
            undo: function () {
                this.action = '/device';
                $('form').attr('method', 'get');
                $('form').submit();
                // axios.post('/device/delete', { id: this.device_assignment.id })
                //     .then(res => {
                //     });
            },
        },
        mounted() {
        }
    }
</script>
