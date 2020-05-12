<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">Tourist</h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table table-responsive table-striped p-0">
                        <bootstrap-table :data="users" :options="myOptions" :columns="myColumns" sticky-header responsive />
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="modal" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title text-bold">User Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="login-logo">
                            <img :src="this.userable.image" width="100" height="auto" alt="user" class="userImage img-circle">

                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input v-model="this.userable.last_name" type="text" name="last_name"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input v-model="this.userable.first_name" type="text" name="first_name"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Other Name</label>
                                    <input v-model="this.userable.other_name" type="text" name="other_name"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input v-model="this.userable.email" type="email" name="email"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Ghana Post GPS Address</label>
                                    <input v-model="this.addressable.gp_digital_address" type="text" name="gp_digital_address"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Date Of Registration</label>
                                    <input v-model="this.userable.registered" type="text" name="city"
                                           class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Date Of Birth</label>
                                    <input v-model="this.userable.dob" type="text" name="dob"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Gender</label>
                                    <input v-model="this.userable.gender" type="text" name="gender"
                                           class="form-control"  readonly>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input v-model="this.userable.phone_number" type="text" name="phone_number"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Region</label>
                                    <input v-model="this.addressable.region" type="text" name="region"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <input v-model="this.addressable.city" type="text" name="city"
                                           class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Last Profile Update</label>
                                    <input v-model="this.userable.updated" type="text" name="city"
                                           class="form-control" readonly>
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
        name: "Traveller",
        components: {
            'bootstrap-table': BootstrapTable,
        },
        data(){
            return{
                form: new Form({
                    last_name: '',
                    first_name: '',
                    other_name: '',
                    email: '',
                    role: 'traveller',
                    password: '',
                }),

                props: {
                    userShow: {}
                },
                users: {},
                user: '',
                userable: {},
                addressable: {},
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
                    { field: 'index', title: 'ID',  formatter: function(row, cell, index){

                            return `<p>${index+1}</p>`;
                        }},
                    { field: 'id', title: 'ID', sortable: true,  visible: false},
                    { field: 'userable.full_name', title: 'Name', sortable: true},
                    { field: 'userable.email', title: 'Email', sortable: true},
                    { field: 'userable.dob', title: 'Date Of Birth', sortable: true},
                    { field: 'userable.gender', title: 'Gender', sortable: true},
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
                               // return window.location.assign('/user/show/'+row.id)
                                Fire.$emit('viewSingleTraveller', row);
                            },
                            'click .edit': function (e, value, row){
                                return window.location.assign('/user/show/'+row.id)

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
                                        axios.delete('/data/user/' + row.id).then((response) => {
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
                this.form.post('/data/traveller')
                    .then((response) => {
                        $('#pharmacyUserModal').modal('hide');
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
                            title: 'User Added Successfully'
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
                this.error = this.users = null;
                this.loading = true;
                axios
                    .get('/data/traveller')
                    .then((response) => {
                        this.loading = false;
                        this.users = response.data;
                    }).catch((error) => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },
            viewTraveller(row){
                if(row.profile_updated === 1){
                    this.user = null;
                    this.userable = null;
                    this.addressable = null;
                    this.user = row;
                    this.userable = this.user.userable;
                    this.addressable = this.user.address;
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

        },
        created()
        {
            this.index();
            //alert(this.$status);
            //this.getData();

            Echo.channel('newUser').listen('NewUser', function(e){
                this.index();
                console.log(e);
            });

            Fire.$on('tableUpdate', () => {
                this.index();
            });
            Fire.$on('viewSingleTraveller', (row) => {
                this.viewTraveller(row);
            });
        }
    }
</script>

<style scoped>

</style>
