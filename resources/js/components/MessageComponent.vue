<template>
    <div>
        <loading v-show="loading"></loading>
        <main>
            <div class="inner">
                <section class="top_20 bottom_20">
                    <h2 class="font_20 border_title p_left10 l_height20">受信詳細</h2>
                </section>
                <section class="search_color p1020">
                    <div>
                        <div class="check_box_wrap inblock right_20">
                            <label class="checkbox_text">
                                <input type="checkbox" v-model="filter.not_receievd">未受信
                            </label>
                        </div>
                        <div class="check_box_wrap inblock right_20">
                            <label class="checkbox_text">
                                <input type="checkbox" v-model="filter.received">受信済
                            </label>
                        </div>
                        <button v-on:click="index" class="create_btn ss_btn">検索</button>
                    </div>
                </section>
                <section class="top_20 clearfix">
                    <div>
                        <table>
                            <tr class="h_32">
                                <th class="w_100">受信状況</th>
                                <th class="w_110"></th>
                                <th class="w_110">架.No</th>
                                <th class="w_160">IMEI番号</th>
                                <th class="w_110">端末電話番号</th>
                                <th>グループ名</th>
                            </tr>
                            <tr v-for="message in device_report_messages_buff">
                                <td>
                                    <span v-show="message.received">受信済</span>
                                    <span v-show="!message.received" class="not_received_color">未受信</span>
                                </td>
                                <td>
                                    <signal-icon v-if="signal" :signal="signal" custom="w_100 text_c"></signal-icon>
                                </td>
                                <td>
                                    <span>{{message.device_assignment.mount_no}}</span>
                                </td>
                                <td>
                                    <span>{{message.device_assignment.device.imei}}</span>
                                </td>
                                <td>
                                    <span>{{message.device_assignment.sim.msn}}</span>
                                </td>
                                <td>
                                    <span>{{message.device_assignment.device_group.name}}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </section>
                <div class="text_c top_20 bottom_20">
                    <a href="/history" class="return_btn l_btn space_normal left_5 modal-close">戻る</a>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import Loading from './Loading';
    import moment from "moment";
    import axios from "axios";

    let current_date = moment().format('YYYY/MM/DD')

    export default {
        name: 'MessageComponent',
        components: {
            Loading,
        },
        data() {
            return {
                filter: {
                    received: true,
                    not_receievd: true,
                },
                device_report_messages: typeof messages === 'undefined' ? [] : messages,
                signal: typeof signal === 'undefined' ? null : signal,
                device_report_messages_buff: [],
                now: current_date,
                loading: false,
            }
        },
        methods: {
            index: function() {
                console.log("history:message", this.device_report_messages);
                console.log("history:signal", this.signal);
                // this.received = this.filter.received;
                // this.not_received = this.filter.not_received;

                if(this.filter.received && this.filter.not_receievd){
                    this.device_report_messages_buff = this.device_report_messages;
                }else if(this.filter.received){
                    this.device_report_messages_buff = this.device_report_messages.filter(message => message.received)
                }else if(this.filter.not_receievd){
                    this.device_report_messages_buff = this.device_report_messages.filter(message => !message.received)
                }else{
                    this.device_report_messages_buff = [];
                }
            },
        },
        mounted() {
            this.index();
        }
    }
</script>

