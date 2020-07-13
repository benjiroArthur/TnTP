export default {
    reloadPage,
    loadSomething

}


function reloadPage() {
    location.assign(location.href);
}

function loadSomething(param) {
    let vm = this;
    return new Promise(function (resolve, reject) {

        /*alert("am loading something.");
        let data = {
            mode: "add-to-near-site",
            errorMessage:"",
            errorCode:"",
             url:"",

        }*/
        let problem = true;
        vm.startLoading();
        axios.post(param.url,param)
            .then(response => {
                problem = false;
                vm.stopLoading();
                resolve(response.data);
                // this.alertSuccess();
            })
            .catch(error => {
                if (error.response.status === 419) {
                    let message = "Please you have been logged out because you were inactive."
                    vm.registerError(419, null, message)

                } else {
                    vm.registerError(776, param, param.errorMessage)
                }
                reject(error);
            });
    });
}
