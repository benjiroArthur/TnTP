<template>
    <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-center">Tourist</h3>
                    <div class="card-tools">
                        <!--<div class="input-group input-group-sm">
                            &lt;!&ndash;<button class="btn btn-danger btn-sm mr-2" title="Download template" @click="downloadExcel"><i class="fas fa-download"></i></button>
                            <button class="btn btn-success btn-sm mr-2" title="Add Bulk Users" data-toggle="modal" data-target="#pharmacyUserModalBulk"><i class="fas fa-file-excel"></i></button>&ndash;&gt;
                            <button class="btn btn-primary btn-sm mr-2" title="Add New User" data-toggle="modal" data-target="#pharmacyUserModal"><i class="fas fa-plus"></i></button>
                        </div>-->
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
    </div>
</template>

<script>
    import BootstrapTable from 'bootstrap-table/dist/bootstrap-table-vue.min.js';
    export default {
        name: "Transport",
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
                    vehicle_number: '',
                    vehicle_brand: '',
                    phone_number: '',
                    colour:''
                }),

                users: {},
                user: '',
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
                                return window.location.assign('/admin/show/'+row.id)

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
                    .get('/data/transport')
                    .then((response) => {
                        this.loading = false;
                        this.users = response.data;
                    }).catch((error) => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
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
        }
    }
</script>

<style scoped>

</style>
