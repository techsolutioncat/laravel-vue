$(document).ready(function() {
    $('#detail_data .action-group .btn-save').on('click', function() {
        doSave('#detail_data');
    });

    $('#update .action-group .btn-save').on('click', function() {
        doSave('#update');
    });

    var doSave = function(parent) {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        let login_id = $(parent + ' input[name=login_id]').val();
        let name = $(parent + ' input[name=name]').val();
        let password = $(parent + ' input[name=password]').val();
        let con_password = $(parent + ' input[name=password_confirmation]').val();
        let user_role_id = $(parent + ' select[name=role]').val();
        let user_id = $(parent + ' .btn-save').attr('data-id');
        let url = (user_id == 0)? '/admin/register': '/admin/update';

        $(parent + ' .has-error').removeClass('has-error');
        $(parent + ' span.error').remove();
        let validate = true;

        if(!login_id.trim()){
            $(parent + ' input[name=login_id]').addClass('has-error');
            $(parent + ' input[name=login_id]').parent().append('<span class="error" style="color:#ff0000; margin-left: 10px;">これは要件です。</span>');
            validate = false;
        }

        if(!name.trim()){
            $(parent + ' input[name=name]').addClass('has-error');
            $(parent + ' input[name=name]').parent().append('<span class="error" style="color:#ff0000; margin-left: 10px;">これは要件です。</span>');
            validate = false;
        }

        if(!password.trim()){
            $(parent + ' input[name=password]').addClass('has-error');
            $(parent + ' input[name=password]').parent().append('<span class="error" style="color:#ff0000; margin-left: 10px;">これは要件です。</span>');
            validate = false;
        }

        if(password != con_password){
            $(parent + ' input[name=password_confirmation]').addClass('has-error');
            $(parent + ' input[name=password_confirmation]').parent().append('<span class="error" style="color:#ff0000; margin-left: 10px;">パスワードを正しく入力してください。</span>');
            validate = false;
        }

        if(!validate){
            return false;
        }

        $.ajax({
            type:'POST',
            url: url,
            data:{_token: CSRF_TOKEN, id: user_id, login_id: login_id, name: name, password: password, user_role_id: user_role_id},
            success:function(success) {
                console.log(success);
               if(success) {
                    const detail_id = $('#detail_data .btn-save').attr('data-id');
                    location.href = '/admin/' + detail_id + '/detail';
               }
            }
        });
    }
});


function show_dialog(user_id, modal) {
    $('#update input').val('');
    if(modal === 'register'){
        $('#update a.btn-save').html('登録');
        $('#update .btn-save').attr('data-id', '0');

        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type:'POST',
            dataType:'json',
            url: '/admin/getbyid',
            data:{_token: CSRF_TOKEN, id: user_id},
            success:function(row) {
                var roleHTML = '';
                if(row.role.length > 0){
                    $.each(row.role, function(index, v) {
                        roleHTML += '<option value="'+v.id+'" >' + v.role_name + '</option>';
                    });
                }
                $('#update select[name=role]').html(roleHTML);

                show_modal("#update");             
            }
        });
    }
    
    if(modal === 'update' || modal === 'delete'){
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type:'POST',
            dataType:'json',
            url: '/admin/getbyid',
            data:{_token: CSRF_TOKEN, id: user_id},
            success:function(row) {
                var roleHTML = '';
                if(row.role.length > 0){
                    $.each(row.role, function(index, v) {
                        var selected = (v.id == row.user.user_role_id)? 'selected': '';
                        roleHTML += '<option value="'+v.id+'" '+selected+'>' + v.role_name + '</option>';
                    });
                }
                $('#'+modal+' input[name=login_id]').val(row.user.login_id);
                $('#'+modal+' input[name=name]').val(row.user.name);
                $('#'+modal+' select[name=role]').html(roleHTML);
                $('#'+modal+' a.btn-save').html('保存');

                $('#'+modal+' .btn-save').attr('data-id', user_id);
                $('#'+modal+' #user_id').html(row.user.login_id);
                $('#'+modal+' #user_name').html(row.user.name);

                show_modal("#"+modal);             
            }
        });
    }
}