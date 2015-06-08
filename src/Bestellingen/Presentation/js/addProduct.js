$('.addProduct').on('click', function(e) {
    e.preventDefault();
    var id = (this).id;
    var imgsrc = $(this).parent().siblings().children()[0].getAttribute('src');
    var naam = $(this).parent().siblings()[1].innerHTML;
    var eenheidsprijs = $(this).parent().siblings()[2].innerHTML;
    $.ajax({
        url: 'addProduct.php',
        type: 'post',
        data: {'id': id},
        cache: false,
        success: function(msg) {
            if (msg === 'new') {
                var e = $('<tr>').append($('<td>').append($('<img>').attr('src',imgsrc))).end().append($('<td>').text(naam)).end().append($('<td>').text(eenheidsprijs));
                $('#winkelmandjeTbody').before(e);
            }
            if (msg === 'existing') {
                $('#aantal-'+id).text(parseInt(this.text)+1);
                $('#prijs-'+id).text(parseFloat(this.text)+parseFloat($('#eenheidsprijs-'+id).text()));
                $('#totaalprijs').text(parseFloat(this.text)+parseFloat($('#eenheidsprijs-'+id).text()));
            }
            if (msg === 'failed') {
                $.alert('FAILED!');
            }

        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });

});
