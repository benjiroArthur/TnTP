<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-8 c0l-sm-12">
                <div class="card">
                    <div class="card-header"><h3>My Profile</h3></div>

                    <div class="card-body">

                        <form @submit.prevent="updateProfile" ref="form">
                            <div class="modal-body">
                                <div class="login-logo">
                                    <img :src="this.transport.image" width="100" height="auto" alt="user" class="userImage img-circle">
                                    <span class="fas fa-camera" data-toggle="modal" data-target="#profileModal" tooltip="Edit Profile Picture"
                                          style="position: absolute; transform: translate(-70%, 200%); -ms-transform: translate(-70%, 200%); width:20px;"></span>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input v-model="form.last_name" type="text" name="last_name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }">
                                            <has-error :form="form" field="last_name"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input v-model="form.first_name" type="text" name="first_name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
                                            <has-error :form="form" field="first_name"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label>Other Name</label>
                                            <input v-model="form.other_name" type="text" name="other_name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('other_name') }">
                                            <has-error :form="form" field="other_name"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input v-model="form.email" type="email" name="email"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" readonly>
                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Vehicle Number</label>
                                            <input v-model="form.vehicle_number" type="text" name="vehicle_number"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('vehicle_number') }">
                                            <has-error :form="form" field="vehicle_number"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label>Vehicle Brand</label>
                                            <input v-model="form.vehicle_brand" type="text" name="vehicle_brand"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('vehicle_brand') }">
                                            <has-error :form="form" field="vehicle_brand"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label>Vehicle Colour</label>
                                            <input v-model="form.colour" type="text" name="colour"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('colour') }">
                                            <has-error :form="form" field="colour"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input v-model="form.phone_number" type="text" name="phone_number"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('phone_number') }">
                                            <has-error :form="form" field="phone_number"></has-error>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-danger" v-on:click="resetFields('profile')">Cancel</button>
                                <button type="submit" class="btn bg-trip">Update <i class="fas fa-upload"></i></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 c0l-sm-12">
                <div class="card">
                    <div class="card-header"><h3>Address</h3></div>

                    <div class="card-body">

                        <form @submit.prevent="updateAddress" ref="address">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Region</label>
                                            <select v-model="address.region" name="region" v-on:change="getCity"
                                                    class="form-control" :class="{ 'is-invalid': address.errors.has('region') }" >
                                                <option disabled value="">Select Region</option>
                                                <option v-for="region in regions">{{region.name}}</option>


                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>City</label>
                                            <select v-model="address.city" name="city"
                                                    class="form-control" :class="{ 'is-invalid': address.errors.has('city') }" >
                                                <!--<option selected>{{address.city}}</option>-->
                                                <option v-if="address.city !== ''" selected>{{address.city}}</option>
                                                <option v-else disabled value="">Select City</option>
                                                <option v-for="city in cities">{{city.name}}</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Ghana Post GPS Address</label>
                                            <input v-model="address.gp_digital_address" type="text" name="gp_digital_address"
                                                   class="form-control" :class="{ 'is-invalid': address.errors.has('gp_digital_address') }">
                                            <has-error :form="address" field="gp_digital_address"></has-error>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-danger" v-on:click="resetFields('address')">Cancel</button>
                                <button type="submit" class="btn bg-trip">Update <i class="fas fa-upload"></i></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!--modal for profile image starts here-->
        <div class="modal" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title">Upload Profile Picture</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label>Profile Picture</label>

                                    <input ref="image"  id="image" type="file" name="image" accept="image/*" class="form-control" style="border: none" @change="loadImage($event)">
                                </div>
                                <div class="col-6">
                                    <img :src="this.image_file" class="uploading-image img-thumbnail" height="128" alt="Preview" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-trip" @click="submitImage">Upload <i class="fas fa-user-plus"></i></button>
                    </div>

                </div>
            </div>
        </div>
        <!--modal for profile image ends here-->
    </div>
</template>

<script>
    import DatePicker from "vue-bootstrap-datetimepicker/src/component";
    export default {

        components: {DatePicker},
        data(){
            return{
                formData: new FormData(),
                transport: {},
                file: null,
                image_file: '',
                regions:{},
                region:'',
                cities:{},
                city:'',
                form: new Form({
                    id: '',
                    last_name: '',
                    first_name: '',
                    other_name: '',
                    email: '',
                    vehicle_number: '',
                    vehicle_brand: '',
                    phone_number: '',
                    colour:''
                }),
                address: new Form({
                    region: '',
                    city: '',
                    gp_digital_address: '',

                }),
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent:false
                },
            };
        },
        methods:{
            profileInfo(){
                this.loading = true;
                axios
                    .get('/data/profile')
                    .then(response => {
                        this.loading = false;
                        let data1 = response.data;
                        this.transport = data1.userable;
                        this.form.fill(this.transport);
                        this.address.fill(data1.address);

                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },
            loadImage(e){
                //
                this.file = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(this.file);
                reader.onload = e =>{
                    this.image_file = e.target.result;

                };

            },
            submitImage(){

                //Initialize the form data
                this.formData.append('image', this.file);

                //Add the form data we need to submit

                //Make the request to the POST /single-file URL
                axios.post( '/data/user/profile/image',
                    this.formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    },
                    this.$Progress.start()
                ).then((response) => {
                    Fire.$emit('profileUpdate');
                    if(response.data === 'Success'){
                        swal.fire(
                            'Update',
                            'Profile Picture Updated Successfully',
                            'success'
                        );
                    }
                    else{
                        swal.fire(
                            'Update',
                            response.data,
                            'warning'
                        );
                    }
                    this.$Progress.finish();

                })
                    .catch(function(error){

                    });
                $('#profileModal').modal('hide');
            },
            updateProfile(){
                this.$Progress.start();
                this.form.put('/data/profile')
                    .then((response) => {
                        Fire.$emit('profileUpdate');
                        console.log(response.data);

                        swal.fire(
                            'Update',
                            'User Profile Updated Successfully',
                            'success'
                        );
                        this.$Progress.finish();
                    })
                    .catch((error) => {
                        console.log(error.message);
                    });
            },
            updateAddress(){
                this.$Progress.start();
                this.address.post('/data/address')
                    .then((response) => {
                        console.log(response.data);
                        if(response.data === 'success')
                        {
                            Fire.$emit('profileUpdate');
                            swal.fire(
                                'Update',
                                'User Address Updated Successfully',
                                'success'
                            );
                        }
                        this.$Progress.finish();
                    })
                    .catch((error) => {
                        console.log(error.message);
                    });
            },
            getRegion(){
                this.loading = true;
                axios
                    .get('/data/region')
                    .then(response => {
                        this.loading = false;
                        this.regions = response.data;

                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },
            getCity(){
                let re = this.address.region;
                this.loading = true;
                axios
                    .get('/data/city/'+re)
                    .then(response => {
                        this.loading = false;
                        this.cities = response.data;

                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },

            resetFields(choice){
                if(choice === 'address'){
                    this.address.reset();
                    this.profileInfo();
                }
                else if(choice === 'profile'){
                    this.form.reset();
                    this.profileInfo();
                }
            },

        },
        created(){

            this.profileInfo();
            this.getRegion();
            Fire.$on('profileUpdate', () => {
                this.profileInfo();
            });

        }
    }
</script>

<style scoped>

</style>
