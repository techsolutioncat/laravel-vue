<template v-slot:default>
  <div>
    <Loading v-show="loading"></Loading>
    <form :action="action" method="post">
      <input type="hidden" name="_token" :value="csrf">
      <input type="hidden" name="id" :value="id">

      <div class="inner">
        <section class="top_20 bottom_20">
          <h2 class="font_20 border_title p_left10 l_height20">端末詳細
            <span v-if="isGarbage">[削除済み]</span>
          </h2>
        </section>

        <section v-if="!isGarbage && isAdmin" class="pager bottom_10 top_20 text_r">
          <a class="block s_btn create_btn right_10 modal-open" data-target="stop">ブザー停止</a>
          <a class="block m_btn create_btn right_10 modal-open" data-target="pronouncement">確認ブザー発報</a>
          <a class="s_btn create_btn modal-open" data-target="clone">クローン</a>
        </section>

        <section class="top_10">
          <table>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">休止設定</th>
              <td class="w_400 text_l">
                <div class="radio p_left6">
                  <input type="radio"
                         name="rest"
                         class="radio-input"
                         id="rest_enable"
                         value="1"
                         v-model="device_assignment.rest"
                         v-bind:disabled="!using || !isAdmin">
                  <label for="rest_enable">
                    <span class="p_left10">有効</span>
                  </label>
                  <input type="radio"
                         name="rest"
                         class="radio-input"
                         value="0"
                         id="rest_disable"
                         v-model="device_assignment.rest"
                         checked="checked"
                         v-bind:disabled="!isAdmin">
                  <label for="rest_disable">
                    <span class="p_left10">無効</span>
                  </label>
                </div>
              </td>
              <th class="w_200 item">SB請求先番号</th>
              <td class="w_400 item">
                {{ device_assignment.company.sb_payment_no }}
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">未更新</th>
              <td class="w_400 item">
                <div v-show="device_assignment.applied_at == null" class="w_20 text_l left_6">
                  <img src="/img/note.png">
                </div>
              </td>
              <th class="w_200 item">端末電話番号</th>
              <td class="item">
                <span class="right_5">番号</span>
                <span class="w_110 d_inline_flex" v-text="phoneNumber"></span>
                <span class="pager bottom_10 top_20 text_r">
                                    <a v-on:click="clear_tel_number" v-if="isAdmin" class="delete_btn ss_btn">クリア</a>
                                </span>
                <input type="text" name="msn" style="display:none;" v-model="device_assignment.sim.msn"/>
                <br>
                <div class="top_10">
                  <span class="right_5">名称</span>
                  <input type="text"
                         class="w_190"
                         name="name"
                         v-model="device_assignment.name"
                         v-bind:disabled="!using || isGarbage || !isAdmin">
                </div>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">架.No</th>
              <td class="w_400 item">
                <!-- <span>{{ device_assignment.mount_no }}</span> -->
                <input name="mount_no" type="text" class="w_110" v-model="device_assignment.mount_no" v-bind:disabled="!using || isGarbage || !isAdmin">
              </td>
              <th class="w_200 item">端末発信設定</th>
              <td class="item">
                <phone :editable="using === 1 && !isGarbage && isAdmin"
                       :phone.sync="device_assignment.phones[0]"></phone>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">利用開始日</th>
              <td class="w_400 item">
                <span>{{ device_assignment.started_at }}</span>
              </td>
              <th class="w_200 item">着信可能設定01</th>
              <td class="item">
                <phone :editable="using === 1 && !isGarbage && isAdmin"
                       :phone="device_assignment.phones[1]"></phone>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">利用終了日</th>
              <td class="w_400 item">
                <span>{{ device_assignment.ended_at }}</span>
              </td>
              <th class="w_200 item">着信可能設定02</th>
              <td class="item">
                <phone :editable="using === 1 && !isGarbage && isAdmin"
                       :phone.sync="device_assignment.phones[2]"></phone>

              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">読込日</th>
              <td class="w_400 item">
                <span>{{ device_assignment.applied_at }}</span>
              </td>
              <th class="w_200 item">着信可能設定03</th>
              <td class="item">
                <phone :editable="using === 1 && !isGarbage && isAdmin"
                       :phone="device_assignment.phones[3]"></phone>

              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">更新日</th>
              <td class="w_400 item">
                <span>{{ device_assignment.updated_at_date }}</span>
              </td>
              <th class="w_200 item">着信可能設定04</th>
              <td class="item">
                <phone :editable="using === 1 && !isGarbage && isAdmin"
                       :phone="device_assignment.phones[4]"></phone>

              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">電源状態</th>
              <td class="w_400 item">
                <span name="active">{{ device_assignment.active ? 'ON' : 'OFF' }}</span>
              </td>
              <th class="w_200 item">着信可能設定05</th>
              <td class="item">
                <phone :editable="using === 1 && !isGarbage && isAdmin"
                       :phone="device_assignment.phones[5]"></phone>

              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">BAT残量</th>
              <td class="w_400 item">
                <span>{{ device_assignment.battery }}%</span>
              </td>
              <th class="w_200 item">着信可能設定06</th>
              <td class="item">
                <phone :editable="using === 1 && !isGarbage && isAdmin"
                       :phone="device_assignment.phones[6]"></phone>

              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">機種</th>
              <td class="w_400 item">
                <span v-if="device_assignment.device.device_type == null"></span>
                <span v-else>{{ device_assignment.device.device_type.type }}</span>
              </td>
              <th class="w_200 item">着信可能設定07</th>
              <td class="item">
                <phone :editable="using === 1 && !isGarbage && isAdmin"
                       :phone="device_assignment.phones[7]"></phone>

              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">IMEI番号</th>
              <td class="w_400 item">
                <span>{{ device_assignment.device.imei }}</span>
              </td>
              <th class="w_200 item">着信可能設定08</th>
              <td class="item">
                <phone :editable="using === 1 && !isGarbage && isAdmin"
                       :phone="device_assignment.phones[8]"></phone>

              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">グループ名</th>
              <td class="w_400 item">
                                <textarea name="group_name"
                                          class="auto-resize textarea resize"
                                          autocomplete="off"
                                          v-model="device_assignment.device_group.name"
                                          v-bind:disabled="!using || !editable || isGarbage || !isAdmin">
                                </textarea>
              </td>
              <th class="w_200 item">着信可能設定09</th>
              <td class="item">
                <phone :editable="using === 1 && !isGarbage && isAdmin"
                       :phone="device_assignment.phones[9]"></phone>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">会社名</th>
              <td class="w_400 item">
                <!-- <AutoCompleteText :companyName="this.company_name" v-bind:disabled="!isAdmin"
                ></AutoCompleteText> -->
                <input name="company_name" type="text" v-model="company_name" list="company-list" class="w_100p" placeholder="会社名を入力してください。">
                <datalist id="company-list">
                  <option v-for="(company, index) in companies" :key="index">{{company}}</option>
                </datalist>                
              </td>
              <th class="w_200 item">着信可能設定10</th>
              <td class="item">
                <phone :editable="using === 1 && !isGarbage && isAdmin"
                       :phone="device_assignment.phones[10]"></phone>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">緊急通報</th>
              <td class="w_400 item">
                                <textarea name="emergency_call"
                                          class="auto-resize textarea resize"
                                          autocomplete="off"
                                          v-model="device_assignment.emergency_call.message"
                                          v-bind:disabled="!using || !editable || isGarbage || !isAdmin"></textarea>
              </td>
              <th class="w_200 item">バッテリー低下</th>
              <td class="w_400 item">
                                <textarea name="battery_low"
                                          class="auto-resize textarea resize"
                                          autocomplete="off"
                                          v-model="device_assignment.battery_low.message"
                                          v-bind:disabled="!using || !editable || isGarbage || !isAdmin"></textarea>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 item">非常ブザー</th>
              <td class="w_400 item">
                                <textarea name="emergency_buzzer"
                                          class="auto-resize textarea resize"
                                          autocomplete="off"
                                          v-model="device_assignment.emergency_buzzer.message"
                                          v-bind:disabled="!using || !editable || isGarbage || !isAdmin"></textarea>
              </td>
              <th class="w_200 item">電源OFF</th>
              <td class="w_400 item">
                                <textarea name="power_off"
                                          class="auto-resize textarea resize"
                                          autocomplete="off"
                                          v-model="device_assignment.power_off.message"
                                          v-bind:disabled="!using || !editable ||isGarbage || !isAdmin"></textarea>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">利用状況</th>
              <td class="text_l">
                <div class="radio p_left6">
                  <input type="radio"
                         name="using"
                         class="radio-input"
                         id="using_enable"
                         value="1"
                         v-model="using"
                         disabled>
                  <label for="using_enable">
                    <span class="p_left10">利用中</span>
                  </label>
                  <input type="radio"
                         name="using"
                         class="radio-input"
                         id="using_disable"
                         value="0"
                         v-model="using"
                         checked
                         disabled>
                  <label for="using_disable">
                    <span class="p_left10">利用停止</span>
                  </label>
                </div>
              </td>
              <th class="w_200 item" :rowspan="!isProduction ? 2 : 1">端末バージョン</th>
              <td class="w_400 item" :rowspan="!isProduction ? 2 : 1">
                <div class="bottom_10 p_bottom10 border_d-c d_flex d_flex-center p_top10">
                  <span class="right_5">現状：</span>
                  <span class="inblock font_18 purpose font_bold right_10">{{ this.device_status == 0 ? '運搬用' : '固定用'}}</span>
                  <span class="inblock font_18 right_20">{{ device_assignment.device.version }}</span>
                  <button
                    v-if="(isProduction && isAdmin) || !isProduction"
                    class="create_btn ss_btn"
                    :disabled="commandRequested"
                    @click="resetDevice()"
                  >
                    初期化
                  </button>
                </div>
                <div v-if="isProduction" class="bottom_10">
                  <span class="right_5">運搬用：</span>
                  <button
                    class="create_btn s_btn"
                    :disabled="commandRequested"
                    @click="commandRequest('update/m/prod', 'アップデート')"
                  >
                    アップデート
                  </button>
                </div>
                <div v-else class="bottom_10 d_flex p_bottom10 border_d-c">
                  <span class="right_5">運搬用：</span>
                  <div>
                    <div class="bottom_5">
                      <button
                        class="create_btn ll_btn"
                        :disabled="commandRequested"
                        @click="commandRequest('update/m/prod', 'アップデート')"
                      >
                        アップデート後に本番移行
                      </button>
                    </div>
                    <div>
                      <button
                        class="create_btn ll_btn"
                        :disabled="commandRequested"
                        @click="commandRequest('update/m/test', 'アップデート')"
                      >
                        アップデート後にテスト移行
                      </button>
                    </div>
                  </div>
                </div>                
                <div v-if="isProduction" class="p_bottom10">
                  <span class="right_5">固定用：</span>
                  <button
                    class="create_btn s_btn"
                    :class="`${fixedUpgradable ? '' : 'disabled_btn'}`"
                    :disabled="commandRequested || !fixedUpgradable"
                    @click="commandRequest('update/f/prod', 'アップデート')"
                  >
                    アップデート
                  </button>
                </div>
                <div v-else class="bottom_10 d_flex">
                  <span class="right_5">固定用：</span>
                  <div>
                    <div class="bottom_5">
                      <button
                        class="create_btn ll_btn"
                        :class="`${fixedUpgradable ? '' : 'disabled_btn'}`"
                        :disabled="commandRequested || !fixedUpgradable"
                        @click="commandRequest('update/f/prod', 'アップデート')"
                      >
                        アップデート後に本番移行
                      </button>
                    </div>
                    <div>
                      <button
                        class="create_btn ll_btn"
                        :class="`${fixedUpgradable ? '' : 'disabled_btn'}`"
                        :disabled="commandRequested || !fixedUpgradable"
                        @click="commandRequest('update/f/test', 'アップデート')"
                      >
                        アップデート後にテスト移行
                      </button>
                    </div>
                  </div>
                </div>
                <div class="hitokoto">
                  <p>「固定用」のFWをアップデートするには<br>FWバージョンが<span>「220111」以降</span>の必要がございます</p>
                  <p>一度「運搬用」をアップデート実行後に<br>「固定用」のアップデートを実行してください</p>
                </div>                
              </td>
            </tr>
            <tr class="h_39" v-if="!isProduction">
              <th class="w_200 item">環境紐付け</th>
              <td class="w_400 item">
                <button
                  class="create_btn s_btn right_10"
                  :disabled="commandRequested"
                  @click="resetDevice('prod')"
                >
                  本番に移行
                </button>
                <button
                  class="create_btn s_btn"
                  :disabled="commandRequested"
                  @click="resetDevice('test')"
                >
                  テストに移行
                </button>
              </td>
            </tr>
            <!-- <tr class="h_39" v-if="!isProduction">
              <th class="w_200 item">キッティング時環境紐付け</th>
              <td class="w_400 item">
                <div class="bottom_10 p_bottom10 border_d-c d_flex d_flex-center p_top10">
                  <span class="right_5">現状：</span>
                  <span class="inblock font_18 right_20">{{ device_assignment.device.version }}</span>
                  <button
                    class="create_btn ss_btn"
                    :disabled="commandRequested"
                    @click="resetKittingDevice()"
                  >
                    初期化
                  </button>
                </div>
                <div class="bottom_10">
                  <button
                    class="create_btn ll_btn"
                    :disabled="commandRequested"
                    @click="commandRequest('kitting/prod', 'アップデート')"
                  >
                    アップデート後に本番移行
                  </button>
                </div>
                <div>
                  <button
                    class="create_btn ll_btn"
                    :disabled="commandRequested"
                    @click="commandRequest('kitting/test', 'アップデート')"
                  >
                    アップデート後にテスト移行
                  </button>
                </div>
              </td>
            </tr>             -->
          </table>

          <!----------------------panda add---------------------->
          <div style="width:100%; margin-top:20px; color:#6088c6">
          <h2 class="font_20 border_title p_left10 l_height20" style="color:#6088c6">カメラシステム連携項目
          </h2>
          </div>

          <div style="width:100%; margin-top:10px; overflow:hidden;border:1px solid #d0d0d0;">
            <div style="float:left;width:16.7%;border-right:1px solid #d0d0d0;background:#eff2f5;font-weight:bold;font-size:14px;padding-left:5px;padding-top:10px;padding-bottom:10px;">カメラシステム連携</div>
            <div style="float:left;width:83.3%;font-weight:bold;font-size:14px;padding-left:5px;padding-top:10px;padding-bottom:10px;">
            <input type="radio"
                          name="camera_enabled"
                          class="radio-input"
                          id="camera_enabled_enable"
                          value="1"
                          v-model="device_assignment.camera_enabled"
                          v-bind:disabled="!using || !isAdmin">
                    <label for="camera_enabled_enable">
                      <span class="p_left10">ON</span>
                    </label>
                    <input type="radio"
                          name="camera_enabled"
                          class="radio-input"
                          value="0"
                          id="camera_enabled_disable"
                          v-model="device_assignment.camera_enabled"
                          checked="checked"
                          v-bind:disabled="!isAdmin">
                    <label for="camera_enabled_disable">
                      <span class="p_left10">OFF</span>
                    </label>
            </div>
          </div>
          <div style="width:100%; margin-top:0px; overflow:hidden;border-left:1px solid #d0d0d0;border-right:1px solid #d0d0d0;border-bottom:1px solid #d0d0d0;">
            <div style="float:left;width:16.7%;border-right:1px solid #d0d0d0;background:#eff2f5;font-weight:bold;font-size:14px;padding-left:5px;padding-top:10px;padding-bottom:10px;">接続カメラ名</div>
            <div style="float:left;width:33.4%;font-weight:bold;font-size:14px;padding-left:5px;padding-top:8px;padding-bottom:7px;padding-right:5px;border-right:1px solid #d0d0d0;">
              <input type="text" class="text_l p_left6" style="width:100%" name="camera_name" v-model="device_assignment.camera_name">                
              </input>
            </div>
            <div style="float:left;width:16.7%;border-right:1px solid #d0d0d0;background:#eff2f5;font-weight:bold;font-size:14px;padding-left:5px;padding-top:10px;padding-bottom:10px;">カメラシリアル番号</div>
            <div style="float:left;width:33.2%;font-weight:bold;font-size:14px;padding-left:5px;padding-top:8px;padding-bottom:7px;padding-right:5px;border-right:1px solid #d0d0d0;">
              <input type="text" class="text_l p_left6" style="width:100%" name="camera_serial" v-model="device_assignment.camera_serial">                
              </input>
            </div>
          </div>
          <!----------------------panda add---------------------->
          <div class="text_c space top_20 bottom_20">
            <button v-if="!isGarbage && isAdmin" v-on:click="destroy"
                    class="delete_btn l_btn space_normal right_10" value="del non-default action">削除
            </button>
            <button v-if="!isGarbage && isAdmin" v-on:click="update"
                    class="details_btn l_btn space_normal right_10" value="default action">保存
            </button>
            <button v-if="isGarbage && isAdmin" v-on:click="restore"
                    class="create_btn l_btn space_normal right_10" value="restore non-default action">復元
            </button>
            <a :href="backTo" class="return_btn l_btn space_normal right_10">戻る</a>
          </div>
        </section>
      </div>

      <div class="pop modal-content" id="stop">
        <div class="pop-box top_20 position_auto auto">
          <p class="text_c">現状作動しているブザーを遠隔で停止さいたします。<br>ブザー停止させる端末はこちらでよろしいですか？</p>
          <div class="top_20">
            <div class="text_c">
              <a @click="commandRequest('buzzer/stop', 'ブザー停止')" class="details_btn l_btn space_normal right_5 modal-close">はい</a>
              <a class="return_btn l_btn space_normal left_5 modal-close">いいえ</a>
            </div>
          </div>
        </div>
      </div>
      <div class="pop modal-content" id="pronouncement">
        <div class="pop-box top_20 position_auto auto">
          <p class="text_c">この端末の確認ブザーをこちらの管理画面から発報いたします。<br>この端末でよろしいですか？</p>
          <div class="top_20">
            <div class="text_c">
              <a @click="commandRequest('buzzer/start', '確認ブザー発報')" class="details_btn l_btn space_normal right_5 modal-close">はい</a>
              <a class="return_btn l_btn space_normal left_5 modal-close">いいえ</a>
            </div>
          </div>
        </div>
      </div>
      <!-- modal for clone -->      
      <div class="pop modal-content pop-box terminal_table" id="clone">
        <div>
          <div class="search_color p1020">
            <span class="right_5">端末電話番号</span>
            <input type="text" class="w_110" v-model="msn">
            <span class="right_5 left_20">架.No</span>
            <input type="text" class="w_110" v-model="mount_no">
            <a v-on:click="search" class="create_btn ss_btn left_20" id="search">検索</a>
          </div>

          <!--<div v-show="device_assignment_clone == null" class="top_20" id="cansel">
              <div class="text_c space">
                  <a class="return_btn l_btn space_normal modal-close">キャンセル</a>
              </div>
          </div>-->
        </div>

        <div class="top_20">
          <span class="block font_18 text_c bottom_5">対象端末情報</span>
          <table>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">架.No</th>
              <td class="text_l p_left6 w_460">
                <span>{{ device_assignment_clone ? device_assignment_clone.mount_no : null }}</span>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">利用開始日</th>
              <td class="text_l p_left6 w_460">
                <span>{{ device_assignment_clone ? device_assignment_clone.started_at : null }}</span>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">利用終了日</th>
              <td class="text_l p_left6 w_460">
                <span>{{ device_assignment_clone ? device_assignment_clone.ended_at : null }}</span>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">機種</th>
              <td class="text_l p_left6 w_460">
                <span>{{ device_assignment_clone ? device_assignment_clone.device.device_type.type : null }}</span>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">IMEI番号</th>
              <td class="text_l p_left6 w_460">
                <span>{{ device_assignment_clone ? device_assignment_clone.device.imei : null }}</span>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">SB請求先番号</th>
              <td class="text_l p_left6 w_460">
                <span>{{ device_assignment_clone ? device_assignment_clone.company.sb_payment_no : null }}</span>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">会社名</th>
              <td class="text_l p_left6 w_460">
                <span>{{ device_assignment_clone ? device_assignment_clone.company.name : null }}</span>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">グループ名</th>
              <td class="text_l p_left6 w_460">
                <span>{{ device_assignment_clone ? device_assignment_clone.device_group.name : null }}</span>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">端末電話番号</th>
              <td class="item">
                <span class="right_5">番号</span>
                <span class="right_20">{{ device_assignment_clone ? device_assignment_clone.sim.msn : null }}</span>
                <div class="inblock">
                  <span class="right_5">名称</span>
                  <div class="inblock">
                    <span>{{ device_assignment_clone ? device_assignment_clone.name : null }}</span>
                  </div>
                </div>
              </td>
            </tr>
            <tr v-for="(value, index) in receiver_array" class="h_39" v-bind:key="index">
              <th class="w_200 text_l p_left6">{{ value }}</th>
              <td class="item">
                <span class="right_5">番号</span>
                <span class="right_20">{{ getDevicePhoneInfo(index, 'phone') }}</span>
                <div class="inblock">
                  <span class="right_5">名称</span>
                  <span>{{ getDevicePhoneInfo(index, 'name') }}</span>
                </div>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">緊急通報</th>
              <td class="item">
                <span>{{ device_assignment_clone ? device_assignment_clone.emergency_call.message : null }}</span>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">非常ブザー</th>
              <td class="item">
                <span>{{ device_assignment_clone ? device_assignment_clone.emergency_buzzer.message : null }}</span>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">バッテリー低下</th>
              <td class="item">
                <span>{{ device_assignment_clone ? device_assignment_clone.battery_low.message : null }}</span>
              </td>
            </tr>
            <tr class="h_39">
              <th class="w_200 text_l p_left6">電源OFF</th>
              <td class="item">
                <span>{{ device_assignment_clone ? device_assignment_clone.power_off.message : null }}</span>
              </td>
            </tr>
          </table>
          <div class="top_20 bottom_20">
            <div class="text_c space">
              <a v-show="device_assignment_clone != null" v-on:click="clone"
                 class="details_btn l_btn space_normal right_10 modal-close" id="close">
                反映
              </a>
              <a class="return_btn l_btn space_normal modal-close" id="close2">キャンセル</a>
            </div>
          </div>
        </div>
      </div>

    </form>


  </div>
</template>

<script>
import axios from 'axios';
import Loading from './Loading';
import CompanyHeader from "./CompanyHeader";
import Phone from "./Phone";
import AutoCompleteText from "./AutoCompleteText";

export default {
  name: 'DeviceDetailComponent',
  components: {
    Phone,
    CompanyHeader,
    Loading,
    AutoCompleteText
  },
  data() {
    return {
      modal_type: 'update',
      loading: false,
      action: this.isGarbage ? '/device/restore' : '/device/update',
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      msn: '',
      mount_no: '',
      device_assignment_clone: null,
      device_assignment: typeof device_assignment === 'undefined' ? null : device_assignment,
      device_status: typeof device_status === 'undefined' ? 0 : device_status,
      isAdmin: typeof isAdmin === 'undefined' ? null : isAdmin,
      isProduction: typeof isProduction === "undefined" ? false : isProduction,

      id: typeof device_assignment === 'undefined' ? null : device_assignment.id,
      company: typeof company === 'undefined' ? null : company,
      message_enabled: typeof company === 'undefined' ? false : company.message_enabled,
      editable: true,
      using: typeof device_assignment === 'undefined' ? 1 : device_assignment.ended_at == null ? 1 : 0,
      receiver_array: [],
      phoneNumber: device_assignment.sim.msn,
      msn_input: true,
      company_name: typeof device_assignment === 'undefined' ? null : device_assignment.company.name,
      companies: typeof companies === 'undefined' ? [] : companies,
      commandRequested: false,
      current_page: typeof current_page === 'undefined' ? 1 : current_page,
    }
  },
  computed: {
    path: function () {
      return window.location.pathname;
    },
    isGarbage: function () {
      return this.path.endsWith('garbage');
    },
    isCompany: function () {
      return this.company !== null;
    },
    backTo: function () {
      if (this.isGarbage) return '/device/garbage';
      else if (this.isCompany) return '/company/' + this.company.id + '/device';
      else return '/device' + '?page=' + this.current_page;
    },
    fixedUpgradable: function () {
      const device = this.device_assignment ? this.device_assignment.device : null;
      const version = device ? parseInt(device.version) : 0;
      return version >= 220111;
    }
  },
  props: {
    'garbage': false,
    'back': '',
  },
  methods: {
    // 更新
    update: function () {
      this.action = '/device/update';
    },
    clone: async function () {
      let id = this.id;
      let clone = true;
      let phones = this.device_assignment_clone.phones.map(item => item.phone);
      let phone_names = this.device_assignment_clone.phones.map(item => item.name);
      let msn = this.device_assignment_clone.sim.msn;
      let name = this.device_assignment_clone.name;
      let rest = this.device_assignment_clone.rest;
      let camera_enabled = this.device_assignment_clone.camera_enabled;
      let camera_name = this.device_assignment_clone.camera_name;
      let camera_serial = this.device_assignment_clone.camera_serial;
      let emergency_call = this.device_assignment_clone.emergency_call.message;
      let battery_low = this.device_assignment_clone.emergency_call.message;
      let emergency_buzzer = this.device_assignment_clone.emergency_buzzer.message;
      let power_off = this.device_assignment_clone.power_off.message;
      let company_name = this.device_assignment_clone.company.name;
      let group_name = this.device_assignment_clone.device_group.name;
      let params = {
        id,
        rest,
        camera_enabled,
        camera_name,
        camera_serial,
        msn,
        name,
        phones,
        phone_names,
        emergency_call,
        battery_low,
        emergency_buzzer,
        power_off,
        clone,
        company_name,
        group_name,
      };
      //this.phoneNumber = msn;
      this.company_name = company_name;
      this.device_assignment.device_group.name = group_name;
      console.log(group_name);

      this.device_assignment.emergency_buzzer = this.device_assignment_clone.emergency_buzzer;
      this.device_assignment.emergency_call = this.device_assignment_clone.emergency_call;
      this.device_assignment.power_off = this.device_assignment_clone.power_off;
      this.device_assignment.battery_low = this.device_assignment_clone.battery_low;

      this.device_assignment.camera_name = this.device_assignment_clone.camera_name;
      this.device_assignment.camera_serial = this.device_assignment_clone.camera_serial;

      for (let i = 0; i < 11; i++) {
        this.device_assignment.phones[i] = this.device_assignment_clone.phones[i];
      }
      //let res = await axios.post('/device/update', params);
      // if (res.data.success) {
      //   window.alert("ローンに成功しました。");
      //   console.log(location.href);
      //   window.location.href = location.href;
      // }

    },
    restore: function () {
      this.action = '/device/restore';
    },
    search: async function () {
      this.loading = true;
      let res = await axios.get('/device/searchforclone', {
        params: {
          msn: this.msn,
          mount_no: this.mount_no
        }
      });
      console.log("deviceDetail:search", res);
      if (res.data.success) {
        this.device_assignment_clone = res.data.data;
        this.loading = false;
        setTimeout(_ => {
          let modal = $('#clone');
          this.modal_resize(modal);
        }, 1);
      }
    },
    getDevicePhoneInfo: function (index, field) {
      if (this.device_assignment_clone == null) return null;
      return this.device_assignment_clone.phones[index] ? this.device_assignment_clone.phones[index][field] : null;
    },
    // 削除
    destroy: function () {
      this.action = '/device/delete';
      //$('form').submit();

    },
    clear_tel_number: function () {
      this.phoneNumber = '';
      this.device_assignment.sim.msn = '';
    },
    resetDevice: function(mode) {
      const type = this.device_status == 0 ? 'm' : 'f';
      const environment = mode == undefined ? this.isProduction ? 'prod' : 'test' : mode;
      const path = 'reset/' + type + '/' + environment;
      this.commandRequest(path, '初期化');

    },
    resetKittingDevice: function() {
      const type = 'm';
      const environment = 'test';
      const path = 'reset/' + type + '/' + environment;
      this.commandRequest(path, '初期化');
    },
    commandRequest: function (path, msg = '') {
      if (this.commandRequested) return;
      this.commandRequested = true;

      const updateStatus = this.needToUpdateDeviceStatus(path);

      axios.get('/api/command/' + this.device_assignment.sim.msn + '/' + path)
          .then(res => res.data)
          .then(data => {
            if (data.success) {
              if (updateStatus) {
                this.updateDeviceStatus(1 - this.device_status);
              }
              this.commandRequested = true
              window.alert(msg+'リクエストを送信しました')
              this.commandRequested = false
            } else {
              this.commandRequested = false
              this.commandRequestError = data.msg
              console.log(data)
            }
          })
          .catch(() => {
            this.commandRequested = false
            this.commandRequestError = "Request Error";
          })
    },
    needToUpdateDeviceStatus: function(path) {
      const params = path.split('/');
      const commands = ['reset', 'update', 'kitting'];

      if (commands.includes(params[0])) {
        let status = params[1] == 'm' ? 0 : params[1] == 'f' ? 1 : undefined;
        if (params[0] == 'kitting') {
          status = 0;
        }
        if (status != undefined && status != this.device_status) {
          return true;
        }
      }
      return false;
    },
    updateDeviceStatus: function(status = 0) {
      let data = { status };

      axios.put('/device/' + this.device_assignment.device.id + '/update_status', data)
        .then(res => res.data)
        .then(data => {
          if (data.success) {
            this.device_status = data.device_status;
          } else {
            console.log(data.error);
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    init: function () {
      this.phoneNumber = device_assignment.sim.msn;
      // console.log("device:detail", this.device_assignment, this.editable, this.isAdmin, this.using);
      if (this.company) {
        this.editable = this.company.message_enabled;
      }
      let suffix_name;
      for (let i = 0; i < 11; i++) {
        if (i == 0) {
          suffix_name = '端末発信設定';
        } else if (i == 10) {
          suffix_name = '受信可能番号' + i;
        } else {
          suffix_name = '受信可能番号' + '0' + i;
        }
        this.receiver_array.push(suffix_name);
      }
      window.addEventListener('keydown', function (e) {
        if (e.keyCode == 13) {
          e.preventDefault();
          this.action = '/device/update';
          $('form').submit();
        }
      });
    }
  },
  mounted() {
    this.init();
    // console.log(this.path)
  }
}
</script>

<style scoped lang="scss">
.btn-manual-fetch {
  padding: 5px 10px;
  border-radius: 5px;
  display: inline-block;
  transition: 0.2s;
  background: #6088C6;
  color: #fff;

  &:focus {
    outline: none;
  }

  &[disabled] {
    opacity: 0.6;
  }

  &:hover:not([disabled]) {
    opacity: 1;
    -webkit-box-shadow: 4px 5px 15px 3px rgba(0, 0, 0, 0.48);
    box-shadow: 4px 5px 15px 3px rgba(0, 0, 0, 0.48);
  }
}

</style>