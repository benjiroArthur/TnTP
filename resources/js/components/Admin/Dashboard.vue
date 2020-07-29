<template>
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-injured"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Admins</span>
                        <span class="info-box-number"></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-md"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Users</span>
                        <span class="info-box-number"></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-first-aid"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Hotels</span>
                        <span class="info-box-number"></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-health elevation-1"><i class="fas fa-user-cog text-white"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Tourist Sites</span>
                        <span class="info-box-number"></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3></h3>

                        <p>Medical Records</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-medical text-white"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3></h3>

                        <p>Prescriptions</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-capsules text-white"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6 text-white">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3></h3>

                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <!--<h3>{{this.onlineSize}}</h3>-->

                        <p>Users Online</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-clock text-white"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- USERS LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Latest Out Users</h3>

                        <div class="card-tools">
                            <span class="badge badge-danger">8 New Members</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <ul class="users-list clearfix">
                            <!--<li v-for="outPatient in outPatients" v-bind:key="outPatient.id">
                                <img :src="outPatient.image" alt="User Image" width="50">
                                <a class="users-list-name" href="#">{{outPatient.full_name}}</a>
                                <span class="users-list-date">{{outPatient.created_at | fromNow}}</span>
                            </li>-->

                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <router-link to="/admin/manage/traveller" class="nav-link">View All Users</router-link>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!--/.card -->
            </div>


            <div class="col-md-6">
                <!-- USERS LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Latest Hotels</h3>

                        <div class="card-tools">
                            <span class="badge badge-danger">8 New Hotels</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <ul class="users-list clearfix">
                           <!-- <li v-for="doctor in doctors" v-bind:key="doctor.id">
                                <img :src="doctor.image" alt="User Image" width="50">
                                <a class="users-list-name" href="#">{{doctor.full_name}}</a>
                                <span class="users-list-date">{{doctor.created_at | fromNow}}</span>
                            </li>-->

                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <router-link to="/admin/manage/hotel" class="nav-link">View All Users</router-link>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!--/.card -->
            </div>
        </div>
       <!-- <div class="row">
            <div class="col-md-6">
                &lt;!&ndash; USERS LIST &ndash;&gt;
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Latest Pharmacies</h3>

                        <div class="card-tools">
                            <span class="badge badge-danger">8 New Members</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    &lt;!&ndash; /.card-header &ndash;&gt;
                    <div class="card-body p-0">
                        <ul class="users-list clearfix">
                            <li v-for="pharmacy in pharmacies" v-bind:key="pharmacy.id">
                                <img :src="pharmacy.image" alt="User Image" width="50">
                                <a class="users-list-name" href="#">{{pharmacy.full_name}}</a>
                                <span class="users-list-date">{{pharmacy.from_now}}</span>
                            </li>
                        </ul>
                        &lt;!&ndash; /.users-list &ndash;&gt;
                    </div>
                    &lt;!&ndash; /.card-body &ndash;&gt;
                    <div class="card-footer text-center">
                        <router-link to="/admin/manage/pharmacy" class="nav-link">View All Users</router-link>
                    </div>
                    &lt;!&ndash; /.card-footer &ndash;&gt;
                </div>
                &lt;!&ndash;/.card &ndash;&gt;
            </div>


            <div class="col-md-6">
                &lt;!&ndash; USERS LIST &ndash;&gt;
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Latest Administrators</h3>

                        <div class="card-tools">
                            <span class="badge badge-danger">8 New Members</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    &lt;!&ndash; /.card-header &ndash;&gt;
                    <div class="card-body p-0">
                        <ul class="users-list clearfix">
                            <li v-for="admin in admins" v-bind:key="admin.id">
                                <img :src="admin.image" alt="User Image" width="50">
                                <a class="users-list-name" href="#">{{admin.full_name}}</a>
                                <span class="users-list-date">{{admin.from_now}}</span>
                            </li>
                        </ul>
                        &lt;!&ndash; /.users-list &ndash;&gt;
                    </div>
                    &lt;!&ndash; /.card-body &ndash;&gt;
                    <div class="card-footer text-center">
                        <router-link to="/admin/manage/admin" class="nav-link">View All Users</router-link>
                    </div>
                    &lt;!&ndash; /.card-footer &ndash;&gt;
                </div>
                &lt;!&ndash;/.card &ndash;&gt;
            </div>
        </div>-->


    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        data(){
            return{
                admins:[],
            }
        },
    }
</script>

<style scoped>

</style>
