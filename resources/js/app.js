import "./bootstrap";
import "preline";

document.addEventListener("livewire:navigated", () => {
    window.HSStaticMethods.autoInit();
});
//fade-out alert
$(".alert").show();
setTimeout(function () {
    $(".alert").fadeOut(400);
}, 5000);
