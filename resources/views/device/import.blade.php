<div class="pop modal-content pop-box top_20 position_auto auto" id="modal">
    <form action="/device/import" method="post" enctype="multipart/form-data">
        @csrf
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
                <button class="details_btn l_btn space_normal right_5" onclick="check()">はい</button>
                <a class="return_btn l_btn space_normal left_5 modal-close">いいえ</a>
            </div>
        </div>
    </form>
</div>
