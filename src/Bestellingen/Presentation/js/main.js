$(document).ready(function($){
   $("#reLogin").validate({
    rules: {
        paswoord : "required"
    },
    messages:{
        paswoord : "Vul paswoord in aub"
    }
}); 
});