<template>
    <div>
        <div>
            <p>
                <span v-if="movingTime.days()">{{movingTime.days()}}day</span>
                <span v-if="movingTime.hours()">{{movingTime.hours()}}hours</span>
                <span v-if="movingTime.minutes()">{{movingTime.minutes()}}min</span>
                <span>{{movingTime.seconds()}}sec</span>
            </p>
        </div>
    </div>
</template>

<script>

    import moment from 'moment';
    export default {
        name: "MomentTest",
        data(){
            return {
                interval:null,

                startTime:moment(),
                endTime:moment(),
                startedAt:moment(),
                hasStarted:false,

                movingTime:moment.duration(0,'s'),

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
                    // vm.startLoading();
                    axios.post(param.url,param)

                        .then(response => {
                            problem = false;
                            // vm.stopLoading();
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
            loadTime(){
                let vm = this;
                let data = {

                        errorMessage:"safasfsa",
                        errorCode:"",
                         url:"/load-time",

                    }
                this.loadSomething(data).then(function (response) {
                        // console.log(response.created_at);
                        vm.startTime = moment(response.start_time);
                        vm.endTime = moment(response.end_time);
                        vm.startedAt = moment(response.started_at);
                        vm.hasStarted = response.has_started;

                        if (vm.hasStarted){
                            // alert("has started");
                            vm.startWork();
                            let nowTime = moment();
                            let differenceInTimeInSeconds = nowTime.diff(vm.startedAt,'s');
                            vm.movingTime.add(differenceInTimeInSeconds,'s');
                            // console.log(differenceInTimeInSeconds);
                        }else {
                        //    Stop the timer
                            clearInterval(this.interval);

                        //    reset the timer to 00
                            this.movingTime = moment.duration();
                        }

                    });
            },
            startWork(){
                // Add one second to the moving time every second.
                this.interval = setInterval( () => {
                    this.movingTime.add(1,"s");
                },1000);
            },
        },
        created() {
            this.loadTime();
        }
    }
</script>

<style scoped>

</style>
