// additional jquery functions
$(document).ready(function(){
    $('#RouteCheckAllAuto').click(function() {
        $("INPUT[type='checkbox']").attr('checked', $('#RouteCheckAllAuto').is(':checked'));    
    });
});