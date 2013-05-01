var currentInstance;
var previousBackgroundCss;
var previouszIndex;
// The "instanceCreated" event is fired for every editor instance created.
CKEDITOR.config.allowedContent = true;
CKEDITOR.on( 'currentInstance', function(event){
    editor = CKEDITOR.currentInstance;
    if(editor == null){
        inlineEditInfo = currentInstance.element.getAttribute('data-tsm-inline-edit-info');
        data = { editInfo: inlineEditInfo, contents: currentInstance.getData() };
        $.post('index.php?com=edit&ajax=inlineSave',data,function(e){
            if(e == "1"){
                currentInstance.element.setAttribute("class",currentInstance.element.getAttribute("class") + " doneEditing");
                $("#__msg_overlay").remove();
                $(".currentlyEditing").css({"background": previousBackgroundCss, "zIndex": previouszIndex}).removeClass("currentlyEditing");
                $(".doneEditing").effect("highlight",{color: "#91FA94", duration: 800}).removeClass("doneEditing");
            } else {
                alert("Your changes could not be saved. Please try again.");
                currentInstance.element.setAttribute("class",currentInstance.element.getAttribute("class") + " doneEditing");
                $("#__msg_overlay").remove();
                $(".currentlyEditing").css({"background": previousBackgroundCss, "zIndex": previouszIndex}).removeClass("currentlyEditing");
                $(".doneEditing").effect("highlight",{color: "#F54242", duration: 800}).removeClass("doneEditing");
            }
        });
    } else {
        currentInstance = editor;
        currentInstance.element.setAttribute("class",currentInstance.element.getAttribute("class") + " currentlyEditing");
        $('<div id="__msg_overlay">').css({
            "width" : "100%"
            , "height" : "100%"
            , "background" : "#000"
            , "position" : "fixed"
            , "top" : "0"
            , "left" : "0"
            , "zIndex" : "50"
            , "MsFilter" : "progid:DXImageTransform.Microsoft.Alpha(Opacity=60)"
            , "filter" : "alpha(opacity=60)"
            , "MozOpacity" : 0.6
            , "KhtmlOpacity" : 0.6
            , "opacity" : 0.6

        }).appendTo(document.body);
        previousBackgroundCss = $(".currentlyEditing").css("background");
        previouszIndex = $(".currentlyEditing").css("zIndex");
        $('.currentlyEditing').css({zIndex: "51","background":"#fff"});
    }
});

