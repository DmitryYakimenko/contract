$(document).ready(function(){
    function objDump(object) {
        var out = "";
        if(object && typeof(object) == "object"){
            for (var i in object) {
                out += i + ": " + object[i] + "\n";
            }
        } else {
            out = object;
        }
        alert(out);
    }
    var id_contract = '';

    $('#id_contract').keyup(function () {
        var filterInt = function (value) {
            if (/[0-9]/.test(value))
                return Number(value);
            return NaN;
        }
        id_contract = $('#id_contract').val();
        if( Number.isInteger( filterInt(id_contract) ) === false ){
            $('#msg').text('В поле id можно вводить только цифры');
        }else {
            $('#msg').text('');
        }
    });


    var work = '';
    var connecting = '';
    var disconnected = '';

    $('#submit').click(function(){
        id_contract = $('#id_contract').val();
        if( $('#work').prop("checked") ) {
            work = 'work';
        }else{
            work = '';
        }
        if( $('#connecting').prop("checked") ) {
            connecting = 'connecting';
        }else{
            connecting = '';
        }
        if( $('#disconnected').prop("checked") ) {
            disconnected = 'disconnected';
        }else{
            disconnected = ''
        }
        if(id_contract == ''){
            alert('Please, put data to all email');
        }else{
            $.ajax({
                type: 'POST',
                url:'index.php',
                dataType: 'json',
                data:{  id_contract:id_contract,
                        work:work,
                        connecting:connecting,
                        disconnected:disconnected
                        },
                success:function(data){
                    if(data.msg != 'Нет клиента') {
                        $('#msg').text('');
                        $('#table').css("display", "block");
                        $('#services_name').text('');
                        $('#name_customer').text(data.name_customer);
                        $('#company').text(data.company);
                        $('#number').text(data.number);
                        $('#date_sign').text(data.date_sign);
                        services_name = data.services_name.split(',');
                        services_name.forEach(function (service_name, i, services_name) {
                            $('#services_name').append(service_name + "<br/>");
                        })
                    }else{
                        $('#msg').text(data.msg);
                        $('#table').css("display", "none");
                    }


                }
            });
        }
    });
});