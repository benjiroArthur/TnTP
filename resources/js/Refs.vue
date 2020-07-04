<template>

    //Travellers Nav
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <router-link :to="{name:'user.my.trips'}" class="nav-link">
                My Trips
            </router-link>
        </li>

        <li class="nav-item">
            <router-link :to="{name:'user.sites'}" class="nav-link">
                ALL Sites
            </router-link>

        </li>

        <li class="nav-item">
            <router-link :to="{name:'user.regions'}" class="nav-link">
                Sites By Region
            </router-link>

        </li>
    </ul>
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-justified">
                        <li class="nav-item"><router-link :to="'/user/my-trips'" class="nav-link text-lancer text-bold">
                            My Trips
                        </router-link></li>

                        <li class="nav-item"><router-link :to="{name:'user.sites'}" class="nav-link text-lancer text-bold">
                            ALL Tourist Sites
                        </router-link>

                        </li><li class="nav-item"><router-link :to="{name:'user.regions'}" class="nav-link text-lancer text-bold">
                        Tourist Sites By Region
                    </router-link></li>


                    </ul>
                </div>
            </div>
        </div>

    </div>
    <button @click="!show">Toggel</button>
    <slick v-if="show">

    </slick>



    <div class="alert " :class="makeSomething">

    </div>



</template>

<script>
    export default {
        name: "Refs",
        data(){
            return {
                show:false,
            }
        },
        methods:{

            loadSomething(param) {
                let vm = this;
                return new Promise(function (resolve, reject) {

                    // alert("am loading something.");
                    // let data = {
                    //     mode: "add-to-near-site",
                    //     errorMessage:"",
                    //     errorCode:"",
                    //      url:"",
                    //
                    // }
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
                        });

                });
            },
            // makeSomething(param = null){
            //     if (6===6){
            //         return "card-primary";
            //     }else if(this.show ){
            //     //    ...
            //     }else if(param === 5){
            //     //    ...
            //     }
            // }


            // Helpers.reloadPage();

            /*Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: true,
                timer: 5000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);},
                icon: 'success',
                title: 'Tourist Site Added Successfully'
            });*/

            /*Swal.fire({
                title: 'Are you sure?',
                text: '<h2>Hello World!</h2>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value){
                    alert("Nice you pressed Yes, delete it!");
                }else {
                    alert("You pressed Cancel");
                }
            });*/

            /*toast.fire({
                title: 'Are you sure?',
                icon: 'warning',
            });*/
        }
    }
</script>

<style scoped>

</style>
