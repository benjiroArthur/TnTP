<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">Bookings</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table table-responsive table-striped p-0">
                        <bootstrap-table :data="bookings" :options="myOptions" :columns="myColumns" sticky-header responsive />
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
        name: "Bookings",
        components: {
            'bootstrap-table': BootstrapTable,
        },
        data(){
            return{
                bookings: {},
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
            index() {
                this.error = this.bookings = null;
                this.loading = true;
                axios
                    .get('/data/bookings')
                    .then((response) => {
                        this.loading = false;
                        this.bookings = response.data;
                    }).catch((error) => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },
        },
        mounted() {
            this.index();
        }
    }
</script>

<style scoped>

</style>
