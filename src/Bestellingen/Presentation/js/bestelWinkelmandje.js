$("#bestelWinkelmandje").on('click', function(e) {
    e.preventDefault();
    var afhaaldatum = $('#afhaaldatum').val();
    $.ajax({
        url: 'bestelWinkelmandje.php',
        type: 'post',
        data: {'afhaaldatum': afhaaldatum},
        success: function(data) {
            
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
});

