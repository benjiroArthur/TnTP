<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">Hotels</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <!--<button class="btn btn-danger btn-sm mr-2" title="Download template" @click="downloadExcel"><i class="fas fa-download"></i></button>
                                <button class="btn btn-success btn-sm mr-2" title="Add Bulk Users" data-toggle="modal" data-target="#hotelUserModalBulk"><i class="fas fa-file-excel"></i></button>
                                -->
                                <button class="btn btn-primary btn-sm mr-2" title="Add New User" data-toggle="modal" data-target="#hotelUserModal"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table table-responsive table-striped p-0">
                        <bootstrap-table :data="hotels" :options="myOptions" :columns="myColumns" sticky-header responsive small />
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!--Bulk upload modal-->


        <!-- form modal Add User -->
        <div class="modal" id="hotelUserModal" tabindex="-1" role="dialog" aria-labelledby="hotelUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title">Add Hotel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createUser">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Hotel Name</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="email" name="email"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>


                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
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
        <div class="modal" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title text-bold">Hotel Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="login-logo">
                            <img :src="this.hotelUserable.image" width="100" height="auto" alt="user" class="userImage img-circle">

                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Hotel Name</label>
                                    <input v-model="this.hotelUserable.name" type="text" name="name"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Hotel Code</label>
                                    <input v-model="this.hotelUserable.code" type="text" name="code"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input v-model="this.hotelUserable.email" type="email" name="email"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Ghana Post GPS Address</label>
                                    <input v-model="this.hotelAddressable.gp_digital_address" type="text" name="gp_digital_address"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Date Of Registration</label>
                                    <input v-model="this.hotelUserable.registered" type="text" name="city"
                                           class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">

                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input v-model="this.hotelUserable.phone_number" type="text" name="phone_number"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Region</label>
                                    <input v-model="this.hotelAddressable.region" type="text" name="region"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <input v-model="this.hotelAddressable.city" type="text" name="city"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Last Profile Update</label>
                                    <input v-model="this.hotelUserable.updated" type="text" name="city"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Latitude</label>
                                            <input v-model="this.hotelMap.lat" type="text" name="city"
                                                   class="form-control" readonly>
                                        </div>
                                        <div class="col-6">
                                            <label>Longitude</label>
                                            <input v-model="this.hotelMap.long" type="text" name="city"
                                                   class="form-control" readonly>
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
</template>

<script>
    import BootstrapTable from 'bootstrap-table/dist/bootstrap-table-vue.min.js';
    export default {
        name: "Hotel",
        components: {
            'bootstrap-table': BootstrapTable,
        },
        data(){
            return{
                form: new Form({
                    name: '',
                    email: '',
                    role: 'hotel',
                    password: ''
                }),

                props: {
                    adminShow: {}
                },
                hotels: {},
                hotel: {},
                hotelUserable: {},
                hotelAddressable: {},
                hotelMap:{},
                file: '',
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
                    { field: 'index', title: 'ID', formatter: function(row, cell, index){
                            return `<p>${index+1}</p>`;
                        }},
                    { field: 'id', title: 'ID', sortable: true,  visible: false},
                    { field: 'userable.name', title: 'Hotel Name', sortable: true},
                    { field: 'userable.code', title: 'Hotel Code', sortable: true},
                    { field: 'userable.email', title: 'Email', sortable: true},
                    { field: 'userable.phone_number', title: 'Phone Number', sortable: true},
                    {
                        field: 'action',
                        title: 'Actions',
                        align: 'center',
                        clickToSelect: false,
                        render: function(e, value, row){},
                        formatter: function (e, value, row){

                            return '<a class="btn btn-sm show" data-toggle="modal" data-target="#"><i class="fas fa-eye text-info"></i></a>'
                        },
                        events: {
                            'click .show': function (e, value, row){
                                //return window.location.assign('/admin/show/'+row.id);
                                //alert('yes');
                                Fire.$emit('viewSingleHotel', row);

                            },
                            'click .edit': function (e, value, row){
                                return window.location.assign('/admin/show/'+row.id)

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
                                                'User Could Not Be Deleted.',
                                                'warning'
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
        methods: {
            createUser(){
                this.$Progress.start();
                this.form.post('/data/hotel')
                    .then((response) => {
                        $('#hotelUserModal').modal('hide');

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);},
                            icon: 'success',
                            title: 'Hotel Added Successfully'
                        });
                        Fire.$emit('tableUpdate');
                        this.$Progress.finish();

                    })
                    .catch((error) => {
                        this.loading = false;
                        this.error = error.response.message || error.message;
                    });
            },

            index() {
                this.error = this.hotels = null;
                this.loading = true;
                axios
                    .get('/data/hotel')
                    .then(response => {
                        this.loading = false;
                        this.hotels = response.data;
                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },
            viewHotel(row){
                if(row.profile_updated === 1){
                    this.hotel = null;
                    this.hotelUserable = null;
                    this.hotelAddressable = null;
                    this.hotel = row;
                    this.hotelUserable = this.hotel.userable;
                    this.hotelAddressable = this.hotel.address;
                    this.hotelMap = this.hotelUserable.map;
                    $('#viewUserModal').modal('show')
                }
                else{
                    Swal.fire(
                        'Warning',
                        'User Profile Not Updated',
                        'warning'
                    );
                }

            },
            handleIncoming(user){
                this.hotels.push(user);
            },

        },
        created() {
            this.index();


        },
        mounted(){
            Fire.$on('viewSingleHotel', (row) => {
                this.viewHotel(row);
            });
            Echo.channel('newUser').listen('NewUser', (e) => {
                this.handleIncoming(e.user);
            });


        },
    }
</script>

<style scoped>

</style>
