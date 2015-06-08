$('.deleteProduct').on('click', function(e) {
    e.preventDefault();
    var id = (this).id;
    $.ajax({
        url: 'deleteProduct.php',
        type: 'post',
        data: {'id': id},
        cache: false,
        success: function(msg) {
            if (msg === 'new') {
                $('#winkelmandjeTbody').find('tr');
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

