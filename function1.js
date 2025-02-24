const input = document.getElementById("qrCodeUrl");
const button = document.getElementById("qrCodeGenerate");
const image = document.getElementById("qrCodeImage");

button.addEventListener("click", async () => {
    const dataUrl = await QRCode.toDataURL(input.value).then(dataUrl => {
    image.src= dataUrl;
    });

});