<template>
    <section>
        <loading v-show="loading"></loading>
        <main>
            <div class="inner">
                <section class="top_20 bottom_20">
                    <h2 class="font_20 border_title p_left10 l_height20">会社情報</h2>
                </section>

                <section class="search_color p1020">
                    <div>
                        <span class="right_10">登録日</span>
                        <input type="text"
                               class="w_100 right_20"
                               :placeholder="registered_at"
                               v-model="filter.registered_at">
                        <span class="right_10">SB請求先番号</span>
                        <input type="text"
                               class="w_110 right_20"
                               v-model="filter.sb_payment_no">
                        <span class="right_10">会社名</span>
                        <input type="text"
                               class="w_320 right_20"
                               v-model="filter.company_name">
                        <span class="right_10">電話番号</span>
                        <input type="text"
                               class="w_110"
                               placeholder="ハイフンなし"
                               v-model="filter.phone_number">
                        <button v-on:click="search" class="create_btn ss_btn left_20">検索</button>
                    </div>
                </section>

                <pager :items="companies"
                       :register="true"
                       v-on:paginate="changePage"
                       v-on:register_modal="show"
                       class="pager bottom_10 top_20 position_r">
                </pager>

                <section class="top_10">
                    <table>
                        <tr>
<!--                            <th class="w_70">No</th>-->
                            <th class="w_120">登録日</th>
                            <th class="w_120">SB請求先番号</th>
                            <th class="w_250">会社名</th>
                            <th class="w_440">住所</th>
                            <th class="w_120">電話番号</th>
                            <th class="w_80"></th>
                        </tr>
                        <tr v-for="company in companies.data">
<!--                            <td>{{company.id}}</td>-->
                            <td>{{company.created_at_date}}</td>
                            <td>{{company.sb_payment_no}}</td>
                            <td class="text_cut">{{company.name}}</td>
                            <td class="text_cut">{{company.address}}</td>
                            <td>{{company.phone}}</td>
                            <td>
                                <a :href="'/company/' + company.id + '/history'"
                                   class="ss_btn details_btn">詳細</a>
                            </td>
                        </tr>
                    </table>
                </section>
            </div>
        </main>

        <pager :items="companies"
                       v-on:paginate="changePage"
                       class="pager bottom_10 top_20 position_r">
                </pager>
                
        <div class="pop modal-content pop-box company-making-modal" id="modal">
			<div class="pop_title">
				<span class="pop_title_box">新規作成</span>
			</div>
            <table>
                <tr class="h_39">
                    <th class="w_200 text_l p_left6">SB請求先番号</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['sb_payment_no']">
                                <input type="text"
                                       class="w_110"
                                       v-model="company.sb_payment_no"
                                       name="sb_payment_no">
                            </error_display>
                        </div>
                    </td>
                </tr>

                <tr class="h_39">
                    <th class="w_200 text_l p_left6">会社名</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['name']">
                                <input type="text" class="w_350" name="name" v-model="company.name">
                            </error_display>
                        </div>
                    </td>
                </tr>

                <tr class="h_39">
                    <th class="w_200 text_l p_left6">住所</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['address']">
                                <input type="text" class="w_350" name="address" v-model="company.address">
                            </error_display>
                        </div>
                    </td>
                </tr>

                <tr class="h_39">
                    <th class="w_200 text_l p_left6">電話番号</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['phone']">
                                <input type="text" class="w_110" name="phone" v-model="company.phone">
                            </error_display>
                        </div>
                    </td>
                </tr>

                <tr class="h_39">
                    <th class="w_200 text_l p_left6">郵便番号</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['postcode']">
                                <input type="text" class="w_110" name="postcode" v-model="company.postcode">
                            </error_display>
                        </div>
                    </td>
                </tr>

                <tr class="h_39">
                    <th class="w_200 text_l p_left6">総責任者名</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['owner_name']">
                                <input type="text" class="w_350" name="owner_name" v-model="company.owner_name">
                            </error_display>
                        </div>
                    </td>
                </tr>

                <tr class="h_39">
                    <th class="w_200 text_l p_left6">総責任者メールアドレス</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['owner_mail']">
                                <input type="email" class="w_350" name="owner_mail" v-model="company.owner_mail">
                            </error_display>
                        </div>
                    </td>
                </tr>

                <tr class="h_39">
                    <th class="w_200 text_l p_left6">ログインID</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['login_id']">
                                <input type="text" class="w_350" name="login_id" v-model="company.login_id">
                            </error_display>
                        </div>
                    </td>
                </tr>

                <tr class="h_39">
                    <th class="w_200 text_l p_left6">パスワード</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['password']">
                                <input type="password" class="w_350" name="password" v-model="company.password">
                            </error_display>
                        </div>
                    </td>
                </tr>

                <tr class="h_39" v-if="isAdmin">
                    <th class="w_200 text_1 p_left6"><div class="ds_flex">支社ID</div></th>
                    <td class="text_1">
                        <div class="p_left6">
                            <div class="ds_flex">
                                <select v-model="company.user_id" class="w_110">
                                    <option v-for="(branch, index) in branches" v-bind:value="branch['id']">{{ branch['login_id'] }}</option>
                                </select>
                            </div>
                        </div>
                    </td>     
                </tr>           
            </table>
            <div class="top_20">
                <div class="text_c space">
                    <button class="details_btn l_btn space_normal right_5" @click="register">保存</button>
                    <a class="return_btn l_btn space_normal left_5 modal-close">キャンセル</a>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    import Loading from './Loading';
    import Pager from "./Pager";
    import validation_error_display from './validation_error_display';

    let current_date = moment().format('YYYY/MM/DD')

    export default {
        data() {
            return {
                company: {},
                companies: typeof companies === 'undefined' ? [] : companies,
                filter: typeof filter !== 'undefined' ? filter : {
                    registered_at: '',
                    sb_payment_no: '',
                    company_name: '',
                    phone_number: '',
                    user_id: '',
                },
                branches: branches.length == 0 ? [] : branches,
                isAdmin: typeof isAdmin === 'undefined' ? false : isAdmin,
                registered_at: current_date,
                validationErrors: {},
                loading: false,
            }
        },
        computed: {},
        methods: {
            query: function (page) {

            },
            search: async function () {
                this.loading = true;

                let res = await axios.get('/company/search', {params: this.filter});

                if (res.data.success) {
                    console.log("company:search", res.data);
                    this.companies = res.data.data;
                }

                this.loading = false;
            },
            changePage: function (page) {
                window.location.href = '/company?page=' + page;
            },
            show: function () {
                let modal_id = '#modal';
                show_modal(modal_id)
            },
            // 登録
            register: function () {
                this.company.action = 'register';
                axios.post('/company/register', this.company)
                    .then(res => {
                        // console.log("company.register", res.data);
                        window.location.href = '/company'
                    })
                    .catch(e => {
                        console.log(e.response.data.errors);
                        this.assignValidationErrors(e.response.data.errors);
                    })
            },
            assignValidationErrors: function (responseErrorData) {
                this.validationErrors = {};

                for (let key in responseErrorData) {
                    if (responseErrorData.hasOwnProperty(key)) {
                        this.$set(this.validationErrors, key, _.head(responseErrorData[key]));
                    }
                }
            }
        },
        mounted() {

        },
        components: {
            Loading,
            Pager,
            'error_display': validation_error_display,
        },
    }
</script>

<style scoped>
    .ds_flex {
        display: flex;
    }
</style>