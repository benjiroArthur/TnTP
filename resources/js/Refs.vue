<template>

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

            makeSomething(param = null){
                if (6===6){
                    return "card-primary";
                }else if(this.show ){
                //    ...
                }else if(param === 5){
                //    ...
                }
            }


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
