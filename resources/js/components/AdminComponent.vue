<template>
    <section class="container">

        <loading v-show="loading"></loading>

        <main>
            <div class="inner">
                <section class="top_20 bottom_20">
                    <h2 class="font_20 border_title p_left10 l_height20" v-if="auth_role === 3">ユーザー管理</h2>
                    <h2 class="font_20 border_title p_left10 l_height20" v-if="auth_role !== 3">管理者管理</h2>
                </section>

                <pager :items="users"
                       v-on:paginate="changePage"
                       :register=true
                       v-on:register_modal="show(null, 'register')"
                       class="pager bottom_10 top_20 position_r"></pager>
                
                <div class="top_10">
                    <table>
                        <tr>
                            <th class="w_120">状態</th>
                            <th class="w_280">ID</th>
                            <th class="w_300">権限者名</th>
                            <th class="w_300">権限種類</th>
                            <th class="w_150"></th>
                        </tr>
                        <tr v-for="user in users.data" :key="user.id">
                            <td v-show="user.enabled">有効</td>
                            <td v-show="!user.enabled">無効</td>
                            <td>{{user.login_id}}</td>
                            <td class="text_cut">{{user.name}}</td>
                            <!--<td class="text_cut"><a v-on:click="show(user, 'update')" href="Javascript:;">{{user.role_name}}</a></td>-->
                            <td class="text_cut">{{user.role_name}}</td>
                            <td>
                                <a v-on:click="show(user, 'update')" class="ss_btn details_btn right_5">詳細</a>
                                <!--<a v-on:click="show(user, 'delete')" class="ss_btn delete_btn left_5">削除</a>-->
                            </td>
                        </tr>
                    </table>
                </div>

                <pager :items="users"
                       v-on:paginate="changePage"
                       class="pager bottom_10 top_20 position_r"></pager>
            </div>
        </main>

        <div class="pop modal-content pop-box admin-modal" id="delete">
                <table>
                    <tr class="h_39">
                        <th class="w_200 text_l p_left6">状態</th>
                        <td class="text_l">
                            <div class="radio p_left6 hidden">
                                <input type="radio" name="enabled" class="radio-input" id="d_enable" value="1"
                                       v-model="user.enabled" disabled>
                                <label for="d_enable">
                                    <span class="p_left10">有効</span>
                                </label>
                                <input type="radio" name="enabled" class="radio-input" id="d_disable" value="0"
                                       v-model="user.enabled" disabled>
                                <label for="d_disable">
                                    <span class="p_left10">無効</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="h_39">
                        <th class="w_200 text_l p_left6 hidden">ID</th>
                        <td class="text_l">
                            <div class="p_left6">
                                <!--                                    <input id="login_id" type="text" class="w_110" v-model="user.login_id" disabled>-->
                                {{user.login_id}}
                            </div>
                        </td>
                    </tr>
                    <tr class="h_39">
                        <th class="w_300 text_l p_left6 hidden">権限者名</th>
                        <td class="text_l">
                            <div class="p_left6">
                                <!--                                    <input id="name" type="text" class="w_110" v-model="user.name" disabled>-->
                                {{user.name}}
                            </div>
                        </td>
                    </tr>
                </table>

                <p class="top_10 bottom_20">指定されたアカウントを削除します。よろしいですか？</p>


                <div class="top_20">
                    <div class="text_c space">
                        <button class="details_btn l_btn space_normal right_5" @click="save">はい</button>
                        <a class="return_btn l_btn space_normal left_5 modal-close">いいえ</a>
                    </div>
                </div>
        </div>

        <div class="pop modal-content pop-box admin-modal" id="update">
			<div v-if="action === 'register'" class="pop_title">
				<span class="pop_title_box">新規作成</span>
			</div>            
            <table>
                <tr v-if="action === 'update'" class="h_39">
                    <th class="w_200 text_l p_left6">状態</th>
                    <td class="text_l">
                        <div class="radio p_left6 hidden">
                            <input type="radio" name="enabled" class="radio-input" id="u_enable" value="1"
                                   v-model="user.enabled">
                            <label for="u_enable">
                                <span class="p_left10">有効</span>
                            </label>
                            <input type="radio" name="enabled" class="radio-input" id="u_disable" value="0"
                                   v-model="user.enabled">
                            <label for="u_disable">
                                <span class="p_left10">無効</span>
                            </label>
                        </div>
                    </td>
                </tr>
                <tr class="h_39">
                    <th class="w_200 text_l p_left6 hidden">ID</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['login_id']">
                                <input type="text" name="login_id" class="w_110" v-model="user.login_id">
                            </error_display>
                        </div>
                    </td>
                </tr>
                <tr class="h_39">
                    <th class="w_300 text_l p_left6 hidden">権限者名</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['name']">
                                <input type="text" name="name" class="w_110" v-model="user.name">
                            </error_display>
                        </div>
                    </td>
                </tr>

                <tr class="h_39">
                    <th class="w_200 text_l p_left6 hidden">パスワード</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['password']">
                                <input id="password" name="password" type="password" v-model="user.password" class="w_110">
                            </error_display>
                        </div>
                    </td>
                </tr>
                <tr v-if="action === 'register'" class="h_39">
                    <th class="w_200 text_l p_left6 hidden">パスワード再入力</th>
                    <td class="text_l">
                        <div class="p_left6">
                            <error_display :message="validationErrors['password_confirmation']">
                                <input id="confirm" name="password_confirmation" v-model="user.password_confirmation" type="password" class="w_110">
                            </error_display>
                        </div>
                    </td>
                </tr>

                <tr class="h_39">
                    <th class="w_200 text_1 p_left6 hidden"><div class="ds_flex">権限</div></th>
                    <td class="text_1">
                        <div class="p_left6">
                            <div v-if="auth_role==10" class="ds_flex">
                                <select v-model="user.user_role_id" class="w_110">
                                    <option v-bind:value="1" :selected="user.user_role_id == '1'">システム</option>
                                    <option v-bind:value="2" :selected="user.user_role_id == '2'">admin</option>
                                    <option v-bind:value="4" :selected="user.user_role_id == '4'">支社</option>
                                </select>
                            </div>
                            <div v-if="auth_role==5" class="ds_flex">
                                <select v-model="user.user_role_id" class="w_110">
                                    <option v-bind:value="2" :selected="user.user_role_id == '2'">admin</option>
                                    <option v-bind:value="4" :selected="user.user_role_id == '4'">支社</option>
                                </select>
                            </div>
                            <div v-if="auth_role==3" class="ds_flex">
                                <select v-model="user.user_role_id" class="w_110">
                                    <option v-bind:value="5" :selected="user.user_role_id == '5'">管理者</option>
                                    <option v-bind:value="6" :selected="user.user_role_id == '6'">ユーザー管理者</option>
                                </select>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="top_20">
                <div class="text_c space">
                    <a class="details_btn l_btn space_normal right_5" @click="save">{{action === 'register' ? '登録' : '保存'}}</a>
                    <a class="return_btn l_btn space_normal left_5 modal-close" @click="close">キャンセル</a>
                </div>
            </div>
        </div>

    </section>
</template>

<script>
    import axios from 'axios';
    import Pager from './Pager'
    import Loading from "./Loading";
    import validation_error_display from './validation_error_display';
    export default {
        components: {
            Pager,
            Loading,
            'error_display': validation_error_display,
        },
        data() {
            return {
                loading: false,

                user: {
                    id: null,
                    login_id: null,
                    name: null,
                    user_role_id: null,
                    password: null,
                    password_confirmation: null,
                    enabled: true,
                },
                action: null,
                users: typeof users === "undefined" ? [] : users,
                auth_role: typeof auth_role === "undefined" ? [] : auth_role,
                validationErrors: [],

                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')

            }
        },
        computed: {},
        methods: {
            init: function () {
                console.log("users", this.users);
            },
            show: function (user, modal) {
                //alert(auth_role);
                this.action = modal;
                if(modal === 'register'){
                    //location.href = '/admin/0/detail'; 
                    show_modal("#update");
                }else if(modal === 'update'){
                    this.user = JSON.parse(JSON.stringify(user));
                    if(auth_role > 3){                        
                        location.href = '/admin/' + this.user.id + '/detail';                  
                    }
                    else if(auth_role == 3)
                    {
                        show_modal("#update");
                    }                    
                }else if(modal === 'delete'){
                    this.user = JSON.parse(JSON.stringify(user));
                    show_modal("#delete");
                }
            },
            assignValidationErrors: function (responseErrorData) {
                this.validationErrors = {};

                for (let key in responseErrorData) {
                    if (responseErrorData.hasOwnProperty(key)) {
                        this.$set(this.validationErrors, key, _.head(responseErrorData[key]));
                    }
                }
            },
            changePage: function(page){
                window.location.href = '/admin?page=' + page;
            },
            close: function(){
                this.user = {};
            },
            save: async function(){
                this.user.action = this.action;
                
                axios.post('/admin/' + this.action, this.user)
                    .then(res => {
                        window.location.href = '/admin'
                    })
                    .catch(e => {
                        window.alert(e.response.data.message);
                    })
            }
        },
        mounted() {
            let page = new URL(location.href).searchParams.get('page')
            this.init();
        }
    }
</script>

<style scoped>
    .ds_flex {
        display: flex;
    }
</style>