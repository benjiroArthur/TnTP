<template>
    <div class="container-fluid">
        <!--modal for other image starts here-->
        <div class="modal" id="otherImageModal" tabindex="-1" role="dialog" aria-labelledby="otherImageModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title">Upload Other Related Images</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label>UploadImage</label>

                                    <input type="file" accept="image/*" class="form-control-file btn btn-success" multiple @change="pushImages" ref="files">

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div v-for="(file, index) in files" :key="index" :class="`level ${file.invalidMessage && 'text-danger'}`">

                                        <div class="row">
                                            <div class="col-10">
                                                {{ file.name }}
                                                <span v-if="file.invalidMessage">&nbsp;- {{file.invalidMessage}}</span>
                                            </div>
                                            <div class="col-2">
                                                <a @click.prevent="files.splice(index, 1), uploadFiles.splice(index, 1)" >
                                                    <span class="fas fa-times"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-trip" @click="submitImages">Upload <i class="fas fa-user-plus"></i></button>
                    </div>

                </div>
            </div>
        </div>
        <!--modal for other image ends here-->


        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-header"><h3>My Profile</h3></div>

                    <div class="card-body">

                        <form @submit.prevent="updateProfile" ref="form">
                            <div class="modal-body">
                                <div class="login-logo">
                                    <img :src="this.user.image" width="100" height="auto" alt="user" class="userImage img-circle">
                                    <span class="fas fa-camera" data-toggle="modal" data-target="#profileModal" tooltip="Edit Profile Picture"
                                          style="position: absolute; transform: translate(-70%, 200%); -ms-transform: translate(-70%, 200%); width:20px;"></span>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Hotel Name</label>
                                            <input v-model="form.name" type="text" name="name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label>Hotel Code</label>
                                            <input v-model="form.code" type="text" name="code"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('code') }" readonly>
                                            <has-error :form="form" field="code"></has-error>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input v-model="form.email" type="email" name="email"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" readonly>
                                            <has-error :form="form" field="email"></has-error>
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
            <div class="col-md-12 col-lg-6 col-sm-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header"><h3>Hotel Address</h3></div>

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
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header"><h3>Map Details</h3></div>
                            <div class="card-body">
                                <form @submit.prevent="updateMap" ref="map">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label>Latitude</label>
                                                    <input v-model="mapForm.lat" type="text" name="lat"
                                                           class="form-control" :class="{ 'is-invalid': mapForm.errors.has('lat') }">
                                                    <has-error :form="mapForm" field="lat"></has-error>
                                                </div>
                                                <div class="form-group">
                                                    <label>Longitude</label>
                                                    <input v-model="mapForm.long" type="text" name="long"
                                                           class="form-control" :class="{ 'is-invalid': mapForm.errors.has('long') }">
                                                    <has-error :form="mapForm" field="long"></has-error>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="button" class="btn btn-danger" v-on:click="resetFields('mapForm')">Cancel</button>
                                        <button type="submit" class="btn bg-trip">Update <i class="fas fa-upload"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 ">
                    <span class="file-cta btn btn-success" data-toggle="modal"
                          data-target="#otherImageModal">
                        <span class="file-icon">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="file-label">
                            Upload Images Of {{user.name}}
                        </span>
                    </span>
            </div>
            <viewer  ref="viewer" :trigger="image_files"  :options="viewerOptions">
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3" v-for="img in image_files" :key="img.id">
                        <div class="card mt-2 mr-1">
                            <div class="properties text-center m-1">
                                <div class="image-holder">
                                    <img :src="img.thumbnail" class="img-thumbnail" alt="" :data-src="img.source">
                                    <a class="bg-none" @click.prevent="takeAction(img.id)" style="position: absolute; transform: translate(0%, 0%); -ms-transform: translate(0%, 0%); width:30px;">
                                            <span class="fas fa-times-circle text-danger" title="Remove Picture" style="width:30px">
                                        </span>
                                    </a>
                                </div>

                                <!--<p class="h5">{{img.description}}</p><hr>
                                <h5>{{img.id}}</h5>-->
                            </div>
                        </div>
                    </div>
                </div>
            </viewer>


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
                                    <img :src="image_file" class="uploading-image img-thumbnail" height="128" alt="Preview" />
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
    import _ from "lodash";
    export default {
        components: {DatePicker},
        data(){
            return{
                formData: new FormData(),

                id:"",

                uploadFiles:[],
                image_files:[],

                user: {},
                file: null,
                image_file: '',
                regions:{},
                region:'',
                cities:{},
                viewerOptions:{
                    url: 'data-src'
                },
                city:'',
                form: new Form({
                    name: '',
                    email: '',
                    code: '',
                    phone_number: ''
                }),

                mapForm: new Form({
                    lat: '',
                    long: '',
                }),

                files:[],

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
                    .get('/data/profile/')
                    .then(response => {
                        this.loading = false;
                        let data1 = response.data;
                        this.user = data1.userable;
                        this.form.fill(this.user);
                        this.address.fill(data1.address);
                        this.mapForm.fill(this.user.map);

                        this.id = data1.userable.id;
                        this.image_files = data1.userable.images;

                    }).catch(error => {
                    this.loading = false;
                    this.error = error.message;
                });
            },
            takeAction(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/data/image/' + id).then((response) => {
                            if(response.data === "success")
                            {
                                Fire.$emit('profileUpdate');
                                Swal.fire(
                                    'Deleted!',
                                    'Image Deleted Successfully',
                                    'success'
                                );
                            }
                            else{
                                Swal.fire(
                                    'Failed!',
                                    response.data,
                                    'warning'
                                )
                            }
                        }).catch(() => {
                            Swal.fire(
                                'Failed!',
                                'Image Could Not Be Deleted.',
                                'warning'
                            )
                        });
                    }
                })
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
                        Swal.fire(
                            'Update',
                            'Profile Picture Updated Successfully',
                            'success'
                        );
                    }
                    else{
                        Swal.fire(
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

                        Swal.fire(
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
            updateMap(){
                this.$Progress.start();
                this.mapForm.post('/data/hotel/map')
                    .then((response) => {
                        console.log(response.data);
                        this.mapForm.reset();
                        this.mapForm.fill(response.data);
                        Swal.fire(
                            'Update',
                            'Map Data Updated Successfully',
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
                            Swal.fire(
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
                    this.error = error.message;
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
                    this.error = error.message;
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
                else if(choice === 'map'){
                    this.mapForm.reset();
                    this.profileInfo();
                }
            },

            pushImages(e){
                //const files = this.$refs.files.files;
                const files = e.target.files;

                this.uploadFiles = [...this.uploadFiles, ...files];
                this.files = [
                    ...this.files,
                    ..._.map(files, file => ({
                        name: file.name,
                        size: file.size,
                        type: file.type,
                        invalidMessage: this.validate(file),

                    }))
                ];


            },
            submitImages(){
                if(this.uploadFiles.length > 0){
                    //Add the form data we need to submit
                    for(let i = 0; i < this.uploadFiles.length; i++){
                        if(this.validate(this.uploadFiles[i]) === ""){
                            let file = this.uploadFiles[i];
                            this.formData.append('images[]', file);
                        }
                    }

                    this.formData.append('id', this.id);
                    this.formData.append('type', 'hotel');

                    //Make the request to the POST /single-file URL
                    axios.post( '/data/image',
                        this.formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        },
                        this.$Progress.start()
                    ).then((response) => {
                        Fire.$emit('profileUpdate');

                        if(response.data === 'success'){
                            Swal.fire(
                                'Upload',
                                'Images Uploaded Successfully',
                                'success'
                            );
                        }
                        else{
                            Swal.fire(
                                'Update',
                                response.data,
                                'warning'
                            );
                        }
                        this.$Progress.finish();

                    })
                        .catch(function(error){

                        });
                    this.uploadFiles = [];
                    this.files = [];
                    this.formData = new FormData();
                    $('#otherImageModal').modal('hide');
                }
                else{
                    $('#otherImageModal').modal('hide');
                    Swal.fire(
                        'Warning',
                        'No File Selected',
                        'warning'
                    );
                }
            },
            validate(file){
                const MAX_SIZE = 2000000;
                const allowed_types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if(file.size > MAX_SIZE){
                    return `Max Size: ${MAX_SIZE/1000}mb`
                }
                if(!allowed_types.includes(file.type)){
                    return `Not an image`
                }

                return "";
            },

        },
        created(){
            // this.id = this.$route.params.id;
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
