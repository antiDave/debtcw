document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.querySelector("canvas");
    const signaturePad = new SignaturePad(canvas);
    
    document.getElementById("clear").addEventListener("click", function () {
        signaturePad.clear();
    });

    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();

    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }
});