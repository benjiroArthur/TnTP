<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-center">{{this.room.room_number}}</h3>
                            <div class="card-tools">
                            <img :src="this.image_file" class="uploading-image img-thumbnail" style="max-height: 128px" alt="hthth" />
                                <span class="fas fa-camera" data-toggle="modal" data-target="#coverImageModal" title="Edit Picture"
                                      style="position: absolute; transform: translate(-70%, 0%); -ms-transform: translate(-70%, 0%); width:20px; border: 1px solid white">
                                </span>
                            </div>
                        </div>
                        <!-- /.card-header -->
                    <div class="card-body ">

                            <div class="row">
                                <div class="col-md-6">
                                    <form @submit.prevent="updateRoom" ref="form">
                                    <div class="form-group">
                                        <label>Room Number</label>
                                        <input v-model="form.room_number" type="text" name="room_number"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('room_number') }">
                                        <has-error :form="form" field="room_number"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input v-model="form.price" type="text" name="price"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                                        <has-error :form="form" field="price"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea v-model="form.description" type="text" name="description"
                                                  class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                                        <has-error :form="form" field="description"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select v-model="form.status" name="status"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('status') }" >
                                            <option v-if="form.status !== ''" selected>{{form.status}}</option>
                                            <option v-else disabled value="">Select Status</option>
                                            <option disabled value="booked">Booked</option>
                                            <option disabled value="available">Available</option>
                                        </select>
                                        <has-error :form="form" field="description"></has-error>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-danger" v-on:click="resetFields">Cancel</button>
                                                <button type="submit" class="btn bg-trip">Update <i class="fas fa-upload"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5">
                                <span class="file-cta btn btn-success" data-toggle="modal" data-target="#otherImageModal">
                                    <span class="file-icon">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span class="file-label">
                                        Upload Images
                                    </span>
                                </span>
                                        </div>
                                        <div class="col-md-7">
                                            <h6 class="text-center">List Of All Related Images</h6>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-3 col-lg-3" v-for="img in image_files">
                                                    <div class="card mt-2 mr-1">
                                                        <div class="properties text-center m-1">
                                                            <div class="image-holder">
                                                                <img :src="img.name" class="img-thumbnail" alt="">
                                                                <a class="bg-none" @click.prevent="takeAction(img.id)" style="position: absolute; transform: translate(0%, 0%); -ms-transform: translate(0%, 0%); width:30px;">
                                                        <span class="fas fa-times-circle text-danger" title="Remove Picture" style="width:30px">
                                                    </span>
                                                                </a>
                                                            </div>

                                                            <p class="h5">{{img.description}}</p><hr>
                                                            <h5>{{img.id}}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>


                </div>
            </div>
        </div>

        <!--modal for Cover image starts here-->
        <div class="modal" id="coverImageModal" tabindex="-1" role="dialog" aria-labelledby="coverImageModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title">Upload New Cover Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label>Cover Image</label>

                                    <input ref="image"  id="image" type="file" name="image" accept="image/*" class="form-control" style="border: none" @change="loadImage($event)">
                                </div>
                                <div class="col-6">
                                    <img :src="this.new_image" class="uploading-image img-thumbnail" height="128" alt="Preview" />
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
        <!--modal for Cover image ends here-->



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
                                        <div v-for="(file, index) in this.files" :key="index" :class="`level ${file.invalidMessage && 'text-danger'}`">

                                            <div class="row">
                                                <div class="col-10">
                                                    {{ file.name }}
                                                    <span v-if="file.invalidMessage">&nbsp;- {{file.invalidMessage}}</span>
                                                </div>
                                                <div class="col-2">
                                                    <a @click.prevent="files.splice(index, 1); uploadFiles.splice(index, 1)" >
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


    </div>
</template>

<script>
    import _ from 'lodash';
    export default {
        name: "RoomDetails",
        data(){
            return{
                id:'',
                uploadFiles:[],
                path: '',
                room:[],
                room_data:[],
                new_image:'',
                image_file:'',
                image_files:[],
                file:'',
                files:[],
                form: new Form({
                    room_number: '',
                    price: '',
                    description: '',
                    status: '',
                }),
                formData : new FormData(),
                allroom:{},
                //formData: new FormData(),
            }
        },
        methods:{
            getData(){
                axios.get('/data/rooms/'+this.id).then((response) => {
                    this.allroom = response.data;
                    this.image_files = [];
                    this.image_file = '';
                    this.room = this.allroom.room;
                    this.room_data = this.allroom.room_data;
                    this.image_file = this.room.thumbnail;
                    this.image_files = this.room.images;
                    this.form.reset();
                    this.form.fill(this.room_data);
                }).catch(console.log());
            },

            updateRoom(){
                axios.put('/data/rooms/'+this.id, this.form)
                    .then((response)=>{
                        if(response.data === 'success'){
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                onOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer);
                                    toast.addEventListener('mouseleave', Swal.resumeTimer);},
                                icon: 'success',
                                title: 'Hotel Room Updated Successfully'
                            });
                            Fire.$emit('tableUpdate');
                        }
                        this.$Progress.finish();
                    })
                    .catch((error) => {
                        this.$Progress.fail();
                        this.error = error.response.message || error.message;
                    });
            },
            loadImage(e){
                //
                this.file = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(this.file);
                reader.onload = e =>{
                    this.new_image = e.target.result;
                };
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


            submitImage(){


                //Add the form data we need to submit
                this.formData.append('image', this.file);

                //Make the request to the POST /single-file URL
                axios.post('/data/rooms/image/'+this.id,
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
                            'Cover Image Updated Successfully',
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
                $('#coverImageModal').modal('hide');
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
                    this.formData.append('type', 'hotel_room');

                //Make the request to the POST /single-file URL
                axios.post('/data/image',
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
                this.formData = [];
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
            resetFields(){
                this.form.reset();
                this.getData();
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
        },
        created() {
            this.id = this.$route.params.id;
            this.path = this.$route.path;
            this.getData();
            Fire.$on('profileUpdate', () => {
                this.getData();

            });
        },
    }
</script>

<style scoped>

</style>
