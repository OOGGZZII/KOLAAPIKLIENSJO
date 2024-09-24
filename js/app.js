$(document).ready(function(){

    $('#btn-add').click(function(){
        $('#editor').show();
    });

    $('#btn-cancel-county').click(function(){
        $('#name').val("");
        $('#id').val("");
        $('#editor').hide();
    });

    $('#btn-cancel-city').click(function(){
        $('#id').val("");
        $('#name').val("");
        $('#zip').val("");
        $('#id_county').val("");
        $('#editor').hide();
    });

    $('#btn-import').click(function(){
        $('#import').show();
    });

    $('#btn-cancel-import').click(function(){
        $('#import').hide();
    });

});

function btnEditCountyOnClick(id, name)
{
    $('#editor').show();
    $('#id').val(id);
    $('#name').val(name);
}

function btnEditCityOnClick(entity)
{
    $('#editor').show();
    $('#id').val(entity.id);
    $('#id_county').val(entity.id_county);
    $('#zip').val(entity.zip);
    $('#name').val(entity.name);
}
