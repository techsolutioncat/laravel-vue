@extends('layouts.app')

@include('layouts.head')

@section('title')
管理者管理
@endsection

@section('content')
<link rel="stylesheet" href="{{URL::asset('css/admin.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="inner" id="detail_data">
    <section class="top_20 bottom_20"><h2 class="font_20 border_title p_left10 l_height20"><?php echo ($auth == 3)? 'ユーザー管理': '管理者管理';?></h2></section>
    <table data-v-a603f2ce="" class="data-table" id="edit_table">
         
        <tr data-v-a603f2ce="" class="h_39">
            <th data-v-a603f2ce="" class="w_200 text_l p_left6 hidden">ID</th>
            <td data-v-a603f2ce="" class="text_l">
            <?php if ((Session::get("role") == 5) && ($user["auth"] == 10)) :?>   
                <div data-v-a603f2ce="" class="p_left6">
                    <?php echo($user['login_id'])?>
                </div>
            <?php else:?>
                <div data-v-a603f2ce="" class="p_left6">
                    <div data-v-0c6bad10="" data-v-a603f2ce="" class="input_wrapper">
                    <input data-v-a603f2ce="" data-v-0c6bad10="" type="text" name="login_id" class="w_110" value="<?php echo (isset($user))? $user['login_id']: '';?>"> <!---->
                </div>
            </div>
            <?php endif;?>
            </td>
        </tr>
        <tr data-v-a603f2ce="" class="h_39">
            <th data-v-a603f2ce="" class="w_300 text_l p_left6 hidden">権限者名</th>
            <td data-v-a603f2ce="" class="text_l">
            <?php if ((Session::get("role") == 5) && ($user["auth"] == 10)) :?>   
                <div data-v-a603f2ce="" class="p_left6">
                    <?php echo($user['name'])?>
                </div>
            <?php else:?>
                <div data-v-a603f2ce="" class="p_left6">
                    <div data-v-0c6bad10="" data-v-a603f2ce="" class="input_wrapper">
                    <input data-v-a603f2ce="" data-v-0c6bad10="" type="text" name="name" class="w_110" value="<?php echo (isset($user))? $user['name']: '';?>"> <!---->
                    </div>
                </div>
            <?php endif;?>
            </td>
        </tr>
        <tr data-v-a603f2ce="" class="h_39">
            <th data-v-a603f2ce="" class="w_200 text_l p_left6 hidden">パスワード</th>
            <td data-v-a603f2ce="" class="text_l">
            <?php if ((Session::get("role") == 5) && ($user["auth"] == 10)) :?>   
                <div data-v-a603f2ce="" class="p_left6">
                    
                </div>
            <?php else:?>
                <div data-v-a603f2ce="" class="p_left6">
                    <div data-v-0c6bad10="" data-v-a603f2ce="" class="input_wrapper">
                    <input data-v-a603f2ce="" data-v-0c6bad10="" id="password" name="password" type="password" class="w_110"> <!---->
                    </div>
                </div>
            <?php endif;?>
            </td>
        </tr>
        <tr data-v-a603f2ce="" class="h_39">
            <th data-v-a603f2ce="" class="w_200 text_l p_left6 hidden">パスワード再入力</th>
            <td data-v-a603f2ce="" class="text_l">
            <?php if ((Session::get("role") == 5) && ($user["auth"] == 10)) :?>   
                <div data-v-a603f2ce="" class="p_left6">
                    
                </div>
            <?php else:?>
                <div data-v-a603f2ce="" class="p_left6">
                    <div data-v-0c6bad10="" data-v-a603f2ce="" class="input_wrapper">
                    <input data-v-a603f2ce="" data-v-0c6bad10="" id="confirm" name="password_confirmation" type="password" class="w_110"> <!---->
                    </div>
                </div>
            <?php endif;?>
            </td>
        </tr>
        <tr data-v-a603f2ce="" class="h_39">
            <th data-v-a603f2ce="" class="w_200 text_1 p_left6 hidden">
                <div data-v-a603f2ce="" class="ds_flex">権限</div>
            </th>
            <td data-v-a603f2ce="" class="text_1">
            <?php if (($user["auth"] == 10) || ($user["auth"] == 5) || ($user["auth"] == 3)) :?>   
                <div data-v-a603f2ce="" class="p_left6" style="float:left">
                    <?php echo($user["role_name"])?>
                </div>
            <?php else:?>
                <div data-v-a603f2ce="" class="p_left6">
                    <div data-v-a603f2ce="" class="ds_flex">
                    <select data-v-a603f2ce="" name="role" class="w_110">
                        <?php
                            if(count($role) > 0)
                            {
                                foreach ($role as $opt) {
                                $selected = (isset($user) && $opt['id'] == $user['user_role_id'])? 'selected': '';
                        ?>
                        <option data-v-a603f2ce="" <?php echo $selected;?> value="<?php echo $opt['id'];?>"><?php echo $opt['role_name'];?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    </div>
                </div>
            <?php endif;?>
            </td>
        </tr>
    </table>
    <div data-v-a603f2ce="" class="top_20">
        <div data-v-a603f2ce="" class="text_c space action-group">
            <a data-v-a603f2ce="" data-id="<?php echo $user_id;?>" class="return_btn l_btn space_normal btn-remove left_5">削除</a>
            <a data-v-a603f2ce="" data-id="<?php echo $user_id;?>" class="details_btn l_btn space_normal btn-save right_5">保存</a> 
            <a data-v-a603f2ce="" data-id="<?php echo $user_id;?>" href="/admin" class="return_btn l_btn space_normal btn-back left_5">戻る</a>
        </div>
    </div>

    <!-- Taken from https://www.w3.org/TR/wai-aria-practices/examples/tabs/tabs-1/tabs.html -->
    <?php
        if(isset($user_list) && $auth >= 3 && $row_auth > 0) {
    ?>
    <div class="tabs">
        <div role="tablist" aria-label="Entertainment">
            <button disabled style="cursor: not-allowed! important;pointer-events: none;" disabled role="tab"
                    aria-selected="true"
                    aria-controls="nils-tab"
                    id="nils">
                    <?php 
                        if($auth == 10) {
                            echo "管理者管理";  
                        }
                        if($auth == 5) {
                            echo "支社紐付権限";  
                        }
                        if($auth == 3) {
                            echo "ユーザー管理";  
                        }
                        if($auth == 2) {
                            echo "マネジャー";  
                        }
                        if($auth == 1) {
                            echo "ユーザーマネージャー";  
                        }
                    
                    ?>
            </button>
        </div>
        <div tabindex="0"
            role="tabpanel"
            id="nils-tab"
            aria-labelledby="nils">

            <button data-v-0802cee8="" onclick="show_dialog(0, 'register')" id="add_new_user" class="s_btn create_btn left_5">新規作成</button>
            
                <table data-v-a603f2ce="">
                    <tr data-v-a603f2ce="">
                        <th data-v-a603f2ce="" class="w_120">状態</th>
                        <th data-v-a603f2ce="" class="w_280">ID</th>
                        <th data-v-a603f2ce="" class="w_300">権限者名</th>
                        <th data-v-a603f2ce="" class="w_150"></th>
                    </tr>
                    <?php
                        if(isset($user_list) && count($user_list) > 0) {
                            foreach ($user_list as $row) {
                    ?>
                    <tr data-v-a603f2ce="">
                        <td data-v-a603f2ce="">有効</td>
                        <td data-v-a603f2ce=""><?php echo $row['login_id'];?></td>
                        <td data-v-a603f2ce="" class="text_cut"><?php echo $row['name'];?></td>
                        <td data-v-a603f2ce="">
                            <a data-v-a603f2ce="" data-id="<?php echo $row['id'];?>" onclick="show_dialog(<?php echo $row['id'];?>, 'update')" class="ss_btn details_btn btn-edit right_5">詳細</a> 
                            <a data-v-a603f2ce=""  data-id="<?php echo $row['id'];?>" onclick="show_dialog(<?php echo $row['id'];?>, 'delete')"  class="ss_btn delete_btn btn-remove left_5">削除</a>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </table>

                <div class="d-flex justify-content-center">
                    {!!$user_list->links()!!}
                </div>
        </div>
    </div>      
    <?php
        }
    ?>    
</div>
@endsection

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
                <div class="p_left6" id="user_id"></div>
            </td>
        </tr>
        <tr class="h_39">
            <th class="w_300 text_l p_left6 hidden">権限者名</th>
            <td class="text_l">
                <div class="p_left6" id="user_name"></div>
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
    <table>
        <!-- <tr v-if="action === 'update'" class="h_39">
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
        </tr> -->                           
        
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
            <th class="w_200 text_l p_left6 hiddenn"><div class="ds_flex">権限</div></th>
            <td class="text_1">
                <div class="p_left6">
                    <div class="ds_flex" style="float: left;">
                        <select name="role" v-model="user.user_role_id" class="w_110">
                        </select>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    

    <div class="top_20">
        <div class="text_c space action-group">
            <a class="details_btn l_btn space_normal right_5 btn-save" data-id=""></a>
            <a class="return_btn l_btn space_normal left_5 modal-close" @click="close">キャンセル</a>
        </div>
    </div>
</div>

@section('script')
<script type="text/javascript" src="{{URL::asset('js/admin.js')}}"></script>
<script !src="">
</script>
@endsection


