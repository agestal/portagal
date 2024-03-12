var canvas = document.getElementById(""),
ctx = canvas.getContext("2d");

var background = new Image();
// The image needs to be in your domain.
background.src = "http://dkpopnews.fooyoh.com/files/attach/images4/14989425/2015/1/14995985/thumbnail_725x300_ratio.jpg";

// Make sure the image is loaded first otherwise nothing will draw.
background.onload = function() {
    ctx.drawImage(background, 0, 0);
};
function action() {
    // draw the image on the canvas
    ctx.drawImage(background, 0, 0);

    //// Then continue with your code 
    var wrapper = document.getElementById("signature-pad"),
        clearButton = wrapper.querySelector("[data-action=clear]"),
        saveButton = wrapper.querySelector("[data-action=save]"),
        canvas = wrapper.querySelector("canvas"),
        signaturePad;

    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }

    window.onresize = resizeCanvas;
    resizeCanvas();

    signaturePad = new SignaturePad(canvas);
    var signaturePad = new SignaturePad(canvas);
    signaturePad.minWidth = 1;
    signaturePad.maxWidth = 1;
    signaturePad.penColor = "rgb(66, 133, 244)";

    clearButton.addEventListener("click", function(event) {
        signaturePad.clear();
    });

    saveButton.addEventListener("click", function(event) {
        if (signaturePad.isEmpty()) {
            alert("Please do not blank.");
        } else {
            //document.getElementById("hfSign").value = signaturePad.toDataURL();
            window.open(signaturePad.toDataURL());
        }
    });
}