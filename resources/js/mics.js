// axios.interceptors.request.use(function (config) {
//     $('#globalLoader').show();
//     return config;
// }, function (error) {
//     return Promise.reject(error);
// });
//
// axios.interceptors.response.use(function (response) {
//     $('#globalLoader').hide();
//     return response;
// }, function (error) {
//     $('#globalLoader').hide();
//     return Promise.reject(error);
// });
//
// window.axios_without_loading = axios.create();
// axios_without_loading.interceptors.request.use(function (config) {
//     return config;
// }, function (error) {
//     return Promise.reject(error);
// });
// axios_without_loading.interceptors.response.use(function (response) {
//     return response;
// }, function (error) {
//     return Promise.reject(error);
// });

$(document).ready(function() {

    //// Some extended utility function ////
    // Check exists
    $.fn.exists = function () {
        return this.length !== 0;
    }

    // Get the url
    $.companyCodeIncludedUrl = function(url) {
        let currentCompanyCode = _.split(window.location.pathname, '/')[1];
        return '/' + currentCompanyCode + url;
    }

    // // When an iput has an error, and when that input's value was changed, remove the error class so that the style change
    // $('.input_wrapper.error > input, .input_wrapper.error > select, .input_wrapper.error.radioes input').change(function() {
    //     $(this).parents('.input_wrapper.error').removeClass('error');
    // });
    //
    // $("#pageTop").hide();
    // //◇ボタンの表示設定
    // $(window).scroll(function(){
    //     if($(this).scrollTop()>80){
    //         //---- 画面を80pxスクロールしたら、ボタンを表示する
    //         $('#pageTop').fadeIn();
    //     }else{
    //         //---- 画面が80pxより上なら、ボタンを表示しない
    //         $('#pageTop').fadeOut();
    //     }
    // });
    //
    // // ◇ボタンをクリックしたら、スクロールして上に戻る
    // $('#pageTop').click(function(){
    // $('body,html').animate({scrollTop: 0},500);
    //     return false;
    // });
    //
    // $('#get_file, #customfileupload').click(function(){
    //     $('#my_file').click();
    // });
    //
    // // ＠TuyenDD　「#frm-kyuyo-upload 」を追加されました。
    // $('#frm-kyuyo-upload input[type=file]').change(function (e) {
    //     $('#customfileupload').val($(this)[0].files[0].name);
    // });
    //
    // // ＠TuyenDD javascriptは賞与を処理する
    // $('#get_bonus, #custombonusupload').click(function () {
    //     $('#my_bonus').click();
    // });
    // $('#frm-shouyo-upload input[type=file]').change(function (e) {
    //     $('#custombonusupload').val($(this)[0].files[0].name);
    // });
    //
    // $("input"). keydown(function(e) {
    //     if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
    //         return false;
    //     } else {
    //         return true;
    //     }
    // });
});
