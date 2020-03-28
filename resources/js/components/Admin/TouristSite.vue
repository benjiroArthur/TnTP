<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">Tourist Sites In Ghana</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm">

                                <button class="btn btn-primary btn-sm mr-2" title="Add New User" data-toggle="modal" data-target="#sitesModal"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table table-responsive table-striped p-0">
                        <bootstrap-table :data="sites" :options="myOptions" :columns="myColumns" sticky-header responsive />
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- form modal Add User -->
        <div class="modal" id="sitesModal" tabindex="-1" role="dialog" aria-labelledby="sitesModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title">Add Tourist Site</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createUser">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
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
                                        <label>Cover Image</label>
                                        <input v-model="form.image" type="text" name="image"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('image') }">
                                        <has-error :form="form" field="image"></has-error>
                                    </div>
                                </div>
                                <div class="col-6">
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
    export default {
        name: "TouristSite"
    }
</script>

<style scoped>

</style>
