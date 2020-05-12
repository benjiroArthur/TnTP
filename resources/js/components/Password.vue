<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="login-box">
                <!-- /.login-logo -->
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Change Password</p>

                        <form class="main-login-form loginBox" @submit.prevent="updatePassword">


                            <div class="input-group mb-3">
                                <input v-model="form.old_password" type="password" class="form-control" placeholder="Old Password"
                                      :class="{ 'is-invalid': form.errors.has('old_password') }" name="old_password" id="old_password">
                                <div class="input-group-append">
                                    <div class="input-group-text divBor">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                 <has-error :form="form" field="old_password"></has-error>
                            </div>
                            <div class="input-group mb-3">
                                <input v-model="form.password" placeholder="New Password" id="password" type="password"
                                      :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" name="password" required autocomplete="new-password">
                                <div class="input-group-append">
                                    <div class="input-group-text divBor">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                 <has-error :form="form" field="password"></has-error>
                            </div>
                            <div class="input-group mb-3">
                                <input v-model="form.password_confirmation" placeholder="Confirm Password" id="password-confirm" type="password"
                                      :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <div class="input-group-append">
                                    <div class="input-group-text divBor">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                 <has-error :form="form" field="password_confirmation"></has-error>
                            </div>
                            <div class="row">
                                <!-- /.col -->

                                    <button type="submit" class="btn btn-primary bg-health btn-block">Submit</button>

                                <!-- /.col -->
                            </div>
                        </form>


                        <!--<form @submit.prevent="updatePassword">

                            <div class="form-group">
                                <label>Old Password</label>
                                <input v-model="form.old_password" type="password" name="old_password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('old_password') }">
                                <has-error :form="form" field="old_password"></has-error>
                            </div>

                            <div class="form-group">
                                <label>New Password</label>
                                <input v-model="form.password" type="password" name="password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input v-model="form.password_confirmation" type="password" name="password_confirmation"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
                                <has-error :form="form" field="password_confirmation"></has-error>
                            </div>

                            <button :disabled="form.busy" type="submit" class="btn btn-primary">Log In</button>
                        </form>-->

                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
            <!-- /.login-box -->
        </div>
    </div>
</template>

<script>

    export default {
        name: "Password",
        data(){
            return{
                form: new Form({
                    old_password: '',
                    password: '',
                    password_confirmation: ''
                }),
            }
        },
        methods:{
            updatePassword(){
                this.form
                    .post(`/data/password/update/${this.$parent.userId}`, this.form)
                    .then((response) => {
                        if(response.data === 'success'){
                            Swal.fire(
                                'Update',
                                'Password Updated Successfully',
                                'success'
                            );
                        }
                        else{
                            Swal.fire(
                                'Error',
                                response.data,
                                'error'
                            );
                        }
                    })
                    .catch((error) => {
                       this.form.errors = error.message
                    })
            },
        },
        mounted() {

        }
    }
</script>

<style scoped>

</style>
