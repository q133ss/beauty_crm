let social_count = 0;
function addSocial() {
    social_count++;
    $('#additional-contacts').append(
        "<div class=\"input-group mb-3\" id='social_row_"+social_count+"'>\n" +
        "                    <input type=\"text\" class=\"form-control\" name=\"social_name[]\" placeholder=\"Название\" aria-label=\"Название\" aria-describedby=\"basic-addon2\">\n" +
        "                    <input type=\"text\" class=\"form-control\" name=\"social_val[]\" placeholder=\"Ссылка/Номер\" aria-label=\"Ссылка/Номер\" aria-describedby=\"basic-addon2\">\n" +
        "                    <div class=\"input-group-append\">\n" +
        "                        <button class=\"btn btn-outline-warning\" onclick=\"removeSocial("+social_count+")\" type=\"button\">Удалить</button>\n" +
        "                    </div>\n" +
        "                </div>"
    );
}

function removeSocial(number){
    $('#social_row_'+number).remove()
}
