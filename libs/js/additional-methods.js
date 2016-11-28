jQuery.validator.addMethod("music163url", function(value, element) {
    var tel = /http:\/\/music\.163\.com\/#\/playlist\?id=[1-9]{1,}[0-9]{1,}/;
    return this.optional(element) || (tel.test(value));
}, "请填写正确的云音乐歌单URL!<br/>例如：http://music.163.com/#/playlist?id=509022042");
