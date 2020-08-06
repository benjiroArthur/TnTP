<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">Tourist Sites In Ghana</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm">

                                <button class="btn btn-primary btn-sm mr-2 bg-trip" title="Add New Tourist Site" data-toggle="modal" data-target="#sitesModal"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table table-responsive table-striped p-0">
                        <bootstrap-table :data="sites" :options="myOptions" :columns="myColumns" sticky-header responsive  />
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- form modal Add User -->
        <div class="modal fade" id="sitesModal" tabindex="-1" role="dialog" aria-labelledby="sitesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title">Add Tourist Site</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createSite">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Basic Information</h4>
                                    <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.name" type="text" name="name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                    <div class="form-group">
                                        <label>Price Per Individual</label>
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

                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Address Info</h4>
                                            <div class="form-group">
                                                <label>Region</label>
                                                <select v-model="form.region" name="region" v-on:change="getCity"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('region') }" >
                                                    <option disabled value="">Select Region</option>
                                                    <option v-for="region in this.regions">{{region.name}}</option>


                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>City</label>
                                                <select v-model="form.city" name="city"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('city') }" >
                                                    <option disabled value="">Select City</option>
                                                    <option v-for="city in this.cities">{{city.name}}</option>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Ghana Post GPS Address</label>
                                                <input v-model="form.gp_digital_address" type="text" name="gp_digital_address"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('gp_digital_address') }">
                                                <has-error :form="form" field="gp_digital_address"></has-error>
                                            </div>
                                            <h4>Map Details</h4>
                                            <div class="form-group">
                                                <label>Latitude</label>
                                                <input v-model="form.lat" type="text" name="lat"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('lat') }">
                                                <has-error :form="form" field="lat"></has-error>
                                            </div>
                                            <div class="form-group">
                                                <label>Longitude</label>
                                                <input v-model="form.long" type="text" name="long"
                                                       class="form-control" :class="{ 'is-invalid': form.errors.has('long') }">
                                                <has-error :form="form" field="long"></has-error>
                                            </div>

                                        </div>
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
        name: "TouristSite",
        components: {
            'bootstrap-table': BootstrapTable,
        },
        data(){
            return{
                form: new Form({
                    name: '',
                    price: '',
                    description: '',
                    lat: '',
                    long: '',
                    region: '',
                    city: '',
                    gp_digital_address: '',
                }),
                coverImg: new FormData(),
                allImg: new FormData(),
                image_file:'',
                image_files:[],
                sites: {},
                site: '',
                files:[],
                file: '',
                regions:{},
                region:'',
                cities:{},
                city:'',
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
                    { field: 'name', title: 'Name', sortable: true},
                    { field: 'price', title: 'Price (GH¢)', sortable: true},
                    { field: 'address.region', title: 'Region', sortable: true},
                    { field: 'address.city', title: 'City', sortable: true},
                    { field: 'address.gp_digital_address', title: 'GP Digital Address', sortable: true},
                    { field: 'map.lat', title: 'Map Latitude', sortable: true},
                    { field: 'map.long', title: 'Map Longitude', sortable: true},
                    {
                        field: 'action',
                        title: 'Actions',
                        align: 'center',
                        clickToSelect: false,
                        render: function(e, value, row){},
                        formatter: function (e, value, row){

                            return ` <router-link :to="'/tourist-site/details/'+${row.id}" class="btn btn-sm show" title="details">
                                      <i class="fas fa-edit text-info"></i>
                                    </router-link>  <a class="btn btn-sm destroy" href="#" title="delete"><span class="fas fa-trash text-danger"></span></a>`

                        },
                        events: {
                            'click .show': function (e, value, row){

                                //return vm.$router.push('/tourist-site/details/'+row.id)
                                //return router.push({name:'tourist-site-details', params: {id:row.id}})
                                //return window.location.assign('/tourist-site/details/'+row.id)
                                Fire.$emit('site-details', row);

                            },
                            'click .edit': function (e, value, row){
                               // return window.location.assign('/admin/show/'+row.id)

                            },
                            'click .destroy': function (e, value, row){
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
                                        axios.delete('/data/tourist-site/' + row.id).then((response) => {
                                            if(response.data === "success")
                                            {
                                                Fire.$emit('tableUpdate');
                                                Swal.fire(
                                                    'Deleted!',
                                                    'Tourist Site Deleted Successfully',
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
                                        }).catch((error) => {
                                            Swal.fire(
                                                'Failed!',
                                                'Tourist Site Could Not Be Deleted.',
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
        methods: {
            createSite(){
                this.coverImg.append('image', this.file);
                $('#sitesModal').modal('hide');
                this.$Progress.start();
                this.form.post('/data/tourist-site')
                    .then((response)=>{

                        let newSite = response.data;

                        axios.post('/data/site-image/'+newSite.id,
                            this.coverImg,
                            {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            },)
                            .then((response) => {
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
                                    title: 'Tourist Site Added Successfully'
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
                this.error = this.sites = null;
                this.loading = true;
                axios
                    .get('/data/tourist-site')
                    .then((response) => {
                        this.loading = false;
                        this.sites = response.data;
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
            loadImages(events){
                //
                this.files = events.target.files;
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
                let re = this.form.region;
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

        },
        created()
        {
            this.index();
            this.getRegion();




            Fire.$on('tableUpdate', () => {
                this.index();
            });
            Fire.$on('site-details', (row) => {
                this.$router.push({path: `/tourist-site/details/${row.id}`});
            });
        },
        mounted(){
            /*Echo.privateChannel('newUser').listen('NewUser', (e) => {
                this.index();
                console.log(e.data);
            });*/
        },

    }
</script>

<style scoped>

</style>
