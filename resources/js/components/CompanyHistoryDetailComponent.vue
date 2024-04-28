<template>
    <div>
        <loading v-show="loading"></loading>
        <form action="/history/update" method="post">
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="id" :value="history.id">
            <input v-if="company_id" type="hidden" name="company_id" :value="company_id"/>

            <div class="inner">
                <section class="top_10 bottom_20">
                    <div class="bottom_20">
                        <div id="map"></div>
                        <!-- <iframe :src="'https://www.google.com/maps?&output=embed&q=' + history.lat + ',' + history.lng"
                                width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="">
                        </iframe> -->
                    </div>
                    <div class="text_c bottom_20" v-if="positioningEnabled">
                        <a @click="initPositionRequest" class="block l_btn create_btn">位置情報問い合わせ</a>
                        <span class="loading-icon" v-if="positionRequested">
                            <vue-loading
                                type="spiningDubbles"
                                color="#aaa"
                                :size="{ width: '30px', height: '30px' }"
                            >
                            </vue-loading>
                        </span>
                        <span
                            class="manual-request-error"
                            v-if="positionRequestError && !positionRequested"
                            >{{ positionRequestError }}</span
                        >
                        <a class="block s_btn create_btn left_10 modal-open" data-target="stop">ブザー停止</a>
                        <a class="block m_btn create_btn left_10 modal-open" data-target="pronouncement">確認ブザー発報</a>
                    </div>                    
                    <table class="details">
                        <tbody>
                            <tr class="h_39">
                                <th class="item w_200" style="border-bottom: 0">種類</th>
                                <td class="item" style="border-bottom: 0">
                                    <signal-icon v-if="history.device_signal"
                                                 :signal="history.device_signal.signal_int" custom="w_100 text_c"></signal-icon>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="details">
                        <tbody>
                        <tr class="h_39">
                            <th class="item w_200">日付</th>
                            <td class="item">{{history.created_at_date}}</td>
                            <th class="item w_200">着信可能設定01</th>
                            <td class="item">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{getPhoneInfo(0, 'phone')}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{getPhoneInfo(0, 'name')}}</span>
                                </div>
                            </td>
                        </tr>

                        <tr class="h_39">
                            <th class="item">時刻</th>
                            <td class="item">{{history.created_at_time}}</td>
                            <th class="item">着信可能設定02</th>
                            <td class="item ">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{getPhoneInfo(1, 'phone')}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{getPhoneInfo(1, 'name')}}</span>
                                </div>
                            </td>
                        </tr>

                        <tr class="h_39">
                            <th class="item">架.No</th>
                            <td class="item">{{history.device_assignment.mount_no}}</td>
                            <th class="item">着信可能設定04</th>
                            <td class="item ">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{getPhoneInfo(2, 'phone')}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{getPhoneInfo(2, 'name')}}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="item">IMEI番号</th>
                            <td class="item">{{history.device_assignment.device.imei}}</td>
                            <th class="item">着信可能設定05</th>
                            <td class="item ">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{getPhoneInfo(3, 'phone')}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{getPhoneInfo(3, 'name')}}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="item">SB請求先番号</th>
                            <td class="item">{{history.device_assignment.company.sb_payment_no}}</td>
                            <th class="item">着信可能設定06</th>
                            <td class="item ">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{getPhoneInfo(4, 'phone')}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{getPhoneInfo(4, 'name')}}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="item">グループ名</th>
                            <td class="item ">
                                <span>{{history.device_assignment.device_group.name}}</span>
                            </td>
                            <th class="item">着信可能設定07</th>
                            <td class="item ">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{getPhoneInfo(5, 'phone')}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{getPhoneInfo(5, 'name')}}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="item">会社名</th>
                            <td class="item">{{history.device_assignment.company.name}}</td>
                            <th class="item">着信可能設定08</th>
                            <td class="item ">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{getPhoneInfo(6, 'phone')}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{getPhoneInfo(6, 'name')}}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="item">端末電話番号</th>
                            <td class="item ">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{history.device_assignment.sim.msn}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{history.device_assignment.name}}</span>
                                </div>
                            </td>
                            <th class="item">着信可能設定09</th>
                            <td class="item ">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{getPhoneInfo(7, 'phone')}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{getPhoneInfo(7, 'name')}}</span>
                                </div>
                            </td>
                        </tr>

                        <tr class="h_39">
                            <th class="item">端末発信設定</th>
                            <td class="item ">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{getPhoneInfo(8, 'phone')}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{getPhoneInfo(8, 'name')}}</span>
                                </div>
                            </td>
                            <th class="item">着信可能設定09</th>
                            <td class="item ">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{getPhoneInfo(9, 'phone')}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{getPhoneInfo(9, 'name')}}</span>
                                </div>
                            </td>
                        </tr>

                        <tr class="h_39">
                            <th class="item">対応済</th>
                            <td class="item">
                                <div>
                                    <!-- <div class="check_onle_wrap">
                                        <label class="checkbox_box">
                                            <input name="dealt_with" v-model="history.dealt_with" type="checkbox"
                                                   :disabled="!isAdmin && parent !== 'notice'">
                                        </label>
                                    </div> -->
                                    <div class="check_onle_wrap">
                                        <div class="w_20 left_5 auto" 
                                            v-if="history.dealt_with">       
                                            <img src="/img/check.png">
                                        </div>
                                        <div class="w_20 left_5 auto" 
                                            v-else>                               
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <th class="item">着信可能設定10</th>
                            <td class="item ">
                                <span class="right_5">番号</span>
                                <span class="right_20">{{getPhoneInfo(10, 'phone')}}</span>
                                <div class="inblock">
                                    <span class="right_5">名称</span>
                                    <span>{{getPhoneInfo(10, 'name')}}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="h_39">
                            <th class="item">内容</th>
                            <td class="item">{{history.device_signal ? history.device_signal.description :
                                null}}がありました。
                            </td>
                            <th class="item">補足</th>
                            <td class="item">
                                <textarea name="supplement" class="auto-resize textarea resize"
                                          v-model="history.supplement" :disabled="!isAdmin && parent !== 'notice'"></textarea>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </section>
                <section class="bottom_20">
                    <div class="text_c">
                        <button v-show="isAdmin" class="details_btn l_btn space_normal right_5 modal-close">保存</button>
                        <a @click="back" class="return_btn l_btn space_normal left_5 modal-close">戻る</a>
                    </div>
                </section>
            </div>
            <div class="inner">
                <div class="bottom_20" v-if="positionLength > 0">
                    <h3 class="section-title bottom_10">位置測位履歴</h3>
                    <table>
                        <tr class="h_32">
                            <th style="width: 40%">日時</th>
                            <th>位置情報</th>
                        </tr>
                        <tr v-for="position in positions" v-bind:key="position.id">
                            <td>{{ position.created_at }}</td>
                            <td>{{ position.lat }} , {{ position.lng }}</td>
                        </tr>
                    </table>
                </div>            
            </div>
        </form>
        <section class="pop modal-content" id="stop">
            <div class="pop-box top_20 position_auto auto">
                <p class="text_c">現状作動しているブザーを遠隔で停止さいたします。<br>ブザー停止させる端末はこちらでよろしいですか？</p>
                <div class="top_20">
                    <div class="text_c">
                        <a @click="stopBuzzer()" class="details_btn l_btn space_normal right_5 modal-close">はい</a>
                        <a class="return_btn l_btn space_normal left_5 modal-close">いいえ</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="pop modal-content" id="pronouncement">
            <div class="pop-box top_20 position_auto auto">
                <p class="text_c">この端末の確認ブザーをこちらの管理画面から発報いたします。<br>この端末でよろしいですか？</p>
                <div class="top_20">
                    <div class="text_c">
                        <a @click="startBuzzer()" class="details_btn l_btn space_normal right_5 modal-close">はい</a>
                        <a class="return_btn l_btn space_normal left_5 modal-close">いいえ</a>
                    </div>
                </div>
            </div>
        </section>        
    </div>
</template>

<script>
    import axios from 'axios';
    import Loading from './Loading';
    import Pager from "./Pager";
    import SignalIcon from "./SignalIcon";
    import { Loader } from "@googlemaps/js-api-loader";
    import { VueLoading } from "vue-loading-template";

    export default {
        name: 'HistoryDetailComponent',
        components: {
            Loading,
            Pager,
            SignalIcon,
            VueLoading,
        },
        props: {
            'company_id': {
                type: String,
                required: false,
            },
            parent: {
                type: String,
                required: false,
            }
        },
        load: {
            key: typeof google_api_key === "undefined" ? "" : google_api_key,
            libraries: 'places'
        },
        timers: {
            pollingPosition: { time: 10000, autostart: false, repeat: true }, // temporary every 10s, in reality 5min
            getPosition: { time: 5000, autostart: false, repeat: true },
            stopWaiting: { time: 60000, autostart: false, repeat: false },
        },        
        data() {
            return {
                modal_type: 'update',
                loading: false,
                action: '/history/update',
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                history: typeof history_detail === 'undefined' ? {} : history_detail,
                isAdmin: typeof isAdmin === 'undefined' ? false : isAdmin,
                commandRequested: false,
                // google map
                map: null,
                markers: [],
                google_api_key: typeof google_api_key === "undefined" ? "" : google_api_key,
                initial_position: null,
                positions: [],
                positionRequested: false,
                positionRequestNo: null,
                positionRequestError: null,
            }
        },
        computed: {
            positioningEnabled: function () {
                return this.history.device_signal && this.history.device_signal.signal_int < 3;
            },
            positionLength: function () {
                return this.positions.length;
            },            
        },
        watch: {
            positions: function (positions) {
                this.renderPositions();
            },
            positionRequested: function (val) {
                if (val) this.$timer.start("getPosition");
                else this.$timer.stop("getPosition");
            },
        },        
        methods: {
            getPhoneInfo: function (index, field) {
                return this.history.device_assignment.phones[index] ? this.history.device_assignment.phones[index][field] : null;
            },
            back: function () {
                if (this.company_id) {
                    window.location.href = '/company/' + this.company_id + '/history';
                } else if (this.parent === 'notice') {
                    window.location.href = '/notice';
                } else {
                    window.location.href = '/history';
                }
            },
            // google map
            initMap: function () {
                const loader = new Loader({
                    apiKey: this.google_api_key,
                    version: "weekly",
                    region: "JP",
                });
                this.initial_position =
                    typeof history_detail === "undefined"
                        ? { lat: 35.679318, lng: 139.810211 }
                        : { lat: history_detail.lat, lng: history_detail.lng };

                loader.load().then(() => {
                    this.map = new google.maps.Map(document.getElementById("map"), {
                        center: this.initial_position,
                        zoom: 15,
                        maxZoom: 20,
                        minZoom: 3,
                        streetViewControl: true,
                        mapTypeControl: true,
                        fullScreenControl: true,
                        zoomControl: true,
                        scaleControl: true,
                    });

                    this.renderPositions();
                });
            },
            renderPositions() {
                // remove all marker

                if (!this.map) return;
                for (let i = 0; i < this.markers.length; i++) {
                    this.markers[i].setMap(null);
                }
                let rev_pos = this.positions.slice(0).reverse();
                rev_pos.unshift(this.initial_position);

                this.markers = rev_pos.map((position, index) => {
                    return new google.maps.Marker({
                        position: { lat: position.lat, lng: position.lng },
                        map: this.map,

                        label: {
                            text: index.toString(),
                            color: "#00f",
                        },
                    });
                });
            },            
            initPositionRequest: function () {
                // this.positions = [
                //     { lat: 36.002974, lng: 139.974836 }
                // ]
                if (this.positionRequested) return;
                this.positionRequested = true;
                this.$timer.start("stopWaiting");
                axios
                    .get("/api/track/" + this.history.id + "/position_request")
                    .then((res) => res.data)
                    .then((data) => {
                        if (data.success) {
                            this.positionRequestNo = data.request_id;
                        } else {
                            this.positionRequestError = data.msg;
                        }
                    })
                    .catch(() => {
                        this.positionRequested = false;
                        this.positionRequestError = "Request Error";
                    });
            },
            pollingPosition: function () {
                axios
                    .get("/api/track/" + this.history.id + "/positions")
                    .then((res) => res.data)
                    .then((data) => {
                        if (data.stop) {
                            this.$timer.stop("pollingPosition");
                        }
                        if (data.positions) {
                            if (data.positions.length !== this.positions.length)
                                this.positions = data.positions;
                        }
                    })
                    .catch((exception) => {
                        console.log(exception);
                    });
            },
            getPosition() {
                if (!this.positionRequested || !this.positionRequestNo) return;

                axios
                    .get(
                        "/api/track/" +
                            this.history.id +
                            "/request_status/" +
                            this.positionRequestNo
                    )
                    .then((res) => res.data)
                    .then((data) => {
                        if (data.stop) {
                            this.$timer.stop("getPosition");
                            this.positionRequestError = data.msg;
                        } else if (data.success) {
                            this.positionRequested = false;
                            const requestedPosition = data.data;
                            this.positions = [requestedPosition, ...this.positions];
                        }
                    });
            },
            stopWaiting() {
                this.positionRequested = false;
            },
            // start buzzer
            startBuzzer: function () {
                if (this.commandRequested) return;
                const sim = this.history.device_assignment ? this.history.device_assignment.sim : {};
                if (!sim || !sim.msn) return;      
                this.commandRequested = true;
                axios
                    .get(
                        "/api/command/" +
                            sim.msn +
                            "/buzzer/start"
                    )
                    .then((res) => res.data)
                    .then((data) => {
                        if (data.success) {
                            window.alert("ブザー発報リクエストを送信しました");
                        } else {
                            this.commandRequestError = data.msg;
                            console.log(data);
                        }
                    })
                    .catch(() => {
                        this.commandRequestError = "Request Error";
                    })
                    .finally(() => {
                        this.commandRequested = false;
                    });
            },
            // stop buzzer
            stopBuzzer: function () {
                if (this.commandRequested) return;
                const sim = this.history.device_assignment ? this.history.device_assignment.sim : {};
                if (!sim || !sim.msn) return;
                this.commandRequested = true;
                axios
                    .get(
                        "/api/command/" +
                            sim.msn +
                            "/buzzer/stop"
                    )
                    .then((res) => res.data)
                    .then((data) => {
                        if (data.success) {
                            window.alert("ブザー停止リクエストを送信しました");
                        } else {
                            this.commandRequestError = data.msg;
                            console.log(data);
                        }
                    })
                    .catch(() => {
                        this.commandRequestError = "Request Error";
                    })
                    .finally(() => {
                        this.commandRequested = false;
                    });
            },            
            init: function () {
                console.log("history:detail", this.isAdmin, this.parent);
                this.initMap();
                if (this.positioningEnabled) {
                    if (this.history.positioning) this.$timer.start("pollingPosition");
                    this.pollingPosition();
                }
            }
        },
        mounted() {
            this.init();

        },
    }
</script>

<style scoped lang="scss">
.section-title {
    border-left: 8px solid #6088c6;
    padding-left: 5px;
    font-size: 1.5em;
    font-weight: 700;
}
.loading-icon {
    display: inline-block;
}
.manual-request-error {
    color: #f00;
}
#map {
    height: 400px;
}
</style>
