jQuery.fn.center = function () { //used the centre something in the middle of the screen
    this.css("position", "absolute");
    this.css("top", ($(window).height() - this.height()) / 2 + $(window).scrollTop() + "px");
    this.css("left", ($(window).width() - this.width()) / 2 + $(window).scrollLeft() + "px");
    return this;
};

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    beforeSend:function(){
        console.log('before');
        $('.loader').append('<div id="progress"><img src="/loader.gif"><br><span class="loadertext">Loading...</span></div>');
        $('#progress').center();
    },
    complete:function(data){
        $('.loader').empty();
    },
});
