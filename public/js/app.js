
function showToast(message) {

    const toastLiveExample = document.getElementById('liveToast')

    toastLiveExample.getElementsByClassName('toast-body')[0].innerHTML = message;

    const toast = new bootstrap.Toast(toastLiveExample)

    toast.show()

}
