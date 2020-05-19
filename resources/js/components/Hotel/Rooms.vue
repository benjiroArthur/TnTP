<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">Rooms</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm">

                                <button class="btn btn-primary btn-sm mr-2 bg-trip" title="Add New Room" data-toggle="modal" data-target="#roomModal"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table table-responsive table-striped p-0">
                        <bootstrap-table :data="rooms" :options="myOptions" :columns="myColumns" sticky-header responsive />
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- form modal Add User -->
        <div class="modal fade" id="roomModal" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title">Add Room</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createRoom">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Basic Information</h4>
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
                                        <label>Cover Image</label>
                                        <div class="col-md-12">
                                            <input type="file" accept="image/*" class="form-control" style="border: none" @change="loadImage($event)">
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">
                                            <img :src="this.image_file" class="uploading-image img-thumbnail" style="max-height: 128px" alt="" />
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Add <i class="fas fa-upload"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




    </div>
</template>

<script>
    import BootstrapTable from 'bootstrap-table/dist/bootstrap-table-vue.min.js';
    export default {
        name: "Rooms",
        components: {
            'bootstrap-table': BootstrapTable,
        },
        data(){
            return{
                rooms: {},
                image_file: '',
                file: '',
                form: new Form({
                    room_number: '',
                    price: '',
                    description: '',
                }),
                image: new FormData(),
                myOptions: {
                    search: true,
                    pagination: true,
                    showColumns: true,
                    showPrint: true,
                    showExport: true,
                    filterControl: true,
                    toolbar: '#toolbar',
                    clickToSelect: true,
                    idField: 'id',
                    selectItemName: 'id',
                    index: true,

                },
                myColumns: [
                    { field: 'index', title: 'ID',  formatter: function(row, cell, index){

                            return `<p>${index+1}</p>`;
                        }},
                    { field: 'room_number', title: 'Room Number', sortable: true},
                    { field: 'price', title: 'Price (GH¢)', sortable: true},
                    { field: 'status', title: 'Status', sortable: true},
                    { field: 'description', title: 'Description', sortable: true},
                    {
                        field: 'action',
                        title: 'Actions',
                        align: 'center',
                        clickToSelect: false,
                        render: function(e, value, row){},
                        formatter: function (e, value, row){

                            return ` <router-link :to="'/room/details/'+${row.id}" class="btn btn-sm show">
                                      <i class="fas fa-edit text-info"></i>
                                    </router-link>`
                        },
                        events: {
                            'click .show': function (e, value, row){

                                //return vm.$router.push('/tourist-site/details/'+row.id)
                                //return router.push({name:'tourist-site-details', params: {id:row.id}})
                                //return window.location.assign('/room/details/'+row.id)
                                Fire.$emit('room-details', row);

                            },
                            'click .edit': function (e, value, row){
                                //return window.location.assign('/admin/show/'+row.id)

                            },
                            'click .destroy': function (e, value, row){
                                swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.value) {
                                        axios.delete('/data/admin/' + row.id).then((response) => {
                                            if(response.data === "success")
                                            {
                                                Fire.$emit('tableUpdate');
                                                swal.fire(
                                                    'Deleted!',
                                                    'User Deleted Successfully',
                                                    'success'
                                                );

                                            }
                                            else{
                                                swal.fire(
                                                    'Failed!',
                                                    response.data,
                                                    'warning'
                                                )
                                            }
                                        }).catch(() => {
                                            swal.fire(
                                                'Failed!',
                                                'Room Could Not Be Deleted.',
                                                'error'
                                            )
                                        });
                                    }

                                });
                            },
                        }
                    }
                ],
            }
        },
        methods:{
            createRoom(){
                this.image.append('image', this.file);
                $('#roomModal').modal('hide');
                this.$Progress.start();
                this.form.post('/data/rooms')
                    .then((response)=>{

                        let newRoom = response.data;

                        axios.post('/data/rooms/image/'+newRoom.id,
                            this.image,
                            {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            },)
                            .then((response) => {
                                this.rooms.push(response.data);
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
                                    title: 'Room Added Successfully'
                                });
                                this.form.reset();
                                this.file = '';
                                Fire.$emit('tableUpdate');
                                this.$Progress.finish();
                            })
                            .catch(
                                (error) => {
                                    this.$Progress.fail();
                                    this.error = error.response.message || error.message;
                                }
                            )

                    })
                    .catch((error) => {
                        this.$Progress.fail();
                        this.error = error.response.message || error.message;
                    });
            },
            index() {
                this.error = this.rooms = null;
                this.loading = true;
                axios
                    .get('/data/rooms')
                    .then((response) => {
                        this.loading = false;
                        this.rooms = response.data;
                    }).catch((error) => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },

            loadImage(event){
                //
                this.file = event.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(this.file);
                reader.onload = event =>{
                    this.image_file = event.target.result;

                };

            },
        },
        created(){
            this. index();
            Fire.$on('room-details', (row) => {
                this.$router.push({path: `/room/details/${row.id}`});
            });
            Fire.$on('tableUpdate', () => {
                this.index();
            });
        },
        mounted(){},
    }
</script>

<style scoped>

</style>
