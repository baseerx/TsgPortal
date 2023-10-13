<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Users</h4>
                <div class="card-tools">
                    <button class="btn btn-sm" data-target="#addUserModal" data-toggle="modal"
                            id="add_user" name="add_user">
                        <i class="fas fa-2x fa-user-plus green"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-hover table-responsive-sm">
                    <tr class="text-center">
                        <!--                                                <th>ID</th>-->
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Modify</th>
                    </tr>
                    <tr class="text-center" v-for="records in records.data">
                        <!--                                                <td>{{records.id}}</td>-->
                        <td>{{records.name | capitalize}}</td>
                        <td>{{records.email}}</td>
                        <td>{{records.user_type}}</td>
                        <td>
                            <a @click="editRecord(records.id)" data-target="#addUserModal" data-toggle="modal">
                                <i class="fas fa-lg fa-edit text-success">

                                </i>
                            </a>
                            |
                            <a @click="deleteRecord(records.id)">
                                <i class="fas fa-lg fa-trash red">

                                </i>
                            </a>
                        </td>
                    </tr>
                    <pagination :data="records" @pagination-change-page="loadUser"
                                class="pagination justify-content-center"></pagination>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div aria-hidden="true" aria-labelledby="addUserModalLabel" class="modal fade" id="addUserModal" role="dialog"
             tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">{{this.modalTitle}}</h5>
                        <form class="form-inline ml-auto">
                            <div class="input-group input-group-sm">
                                <div class="input-group-append">
                                    <div class="form-check">
                                        <button @click="retData" class="btn btn-sm btn-info text-white" id="hris_btn" name="hris_btn" type="button">
                                            HRIS
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createUser" id="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off" class="form-control" name="name" placeholder="Name"
                                       type="text" v-model="form.name">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('email') }" autocomplete="off" class="form-control"
                                       name="email" placeholder="Email Address"
                                       type="text" v-model="form.email">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <select :class="{ 'is-invalid': form.errors.has('t_type') }" class="form-control" id="t_type" name="t_type"
                                        v-model="form.t_type">
                                    <option value="">Select T Type</option>
                                    <option value="trainee">Trainee</option>
                                    <option value="trainer">Trainer</option>
                                </select>
                                <!--                                <input v-model="form.user_type" type="text" name="user_type"-->
                                <!--                                       placeholder="UserType" autocomplete="off"-->
                                <!--                                       class="form-control" :class="{ 'is-invalid': form.errors.has('user_type') }">-->
                                <has-error :form="form" field="t_type"></has-error>
                            </div>
                            <div class="form-group">
                                <select :class="{ 'is-invalid': form.errors.has('t_type') }" class="form-control" id="user_type" name="user_type"
                                        v-model="form.user_type">
                                    <option value="">User Type</option>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                    <option value="super admin">Super Admin</option>
                                </select>
                                <has-error :form="form" field="user_type"></has-error>
                            </div>
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" name="password"
                                       placeholder="Password"
                                       type="password" v-model="form.password">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <span class="alert alert-danger small" v-if="message!=''">{{message}}</span>
                            <button class="btn btn-danger btn-md" data-dismiss="modal" type="button">Close</button>
                            <button class="btn btn-info btn-md" type="submit">Create</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!--<div id="modals">-->
        <!--<update-modal :sendId="updateActive"></update-modal>-->
        <!--</div>-->

        <div aria-hidden="true" aria-labelledby="employee_modalTitle" class="modal fade" id="hr_employee_modal"
             role="dialog"
             tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="employee_modalTitle">Employees List</h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed table-hover" v-if="hris_data.length">
                                <thead class="thead-light position-absolute">
                                <tr class="p-0 m-0">
                                    <th><input class="form-control form-control-sm" placeholder="HRIS ID" type="text" v-model="hris_search"></th>
                                    <th><input class="form-control form-control-sm" placeholder="Name" type="text" v-model="hris_name"></th>
                                    <th><input class="form-control form-control-sm" placeholder="Designation" type="text" v-model="hris_designation"></th>
                                    <th><input class="form-control form-control-sm" placeholder="BPS" type="text" v-model="hris_bps"></th>
                                    <th><input class="form-control form-control-sm" placeholder="Department" type="text" v-model="hris_department"></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="text-sm p-0 m-0">
                                <tr v-for="hr in HrisData" @click="EditHris(hr.MyId)" id="table_hris">
                                    <td>{{hr.MyId}}</td>
                                    <td>{{hr.Name}}</td>
                                    <td>{{hr.Designation}}</td>
                                    <td>{{hr.Grade}}</td>
                                    <td>{{hr.DeptName}}</td>
                                    <td>
                                        <a @click="EditHris(hr.MyId)">
                                            <i class="fas fa-lg fa-check-circle text-success">

                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</template>

<script>
    // import UpdateUserModal from "./UpdateUserModal";
    export default {
        // components: {
        //     'update-modal': UpdateUserModal
        // },
        data() {
            return {
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    user_type: '',
                    t_type: ''
                }),
                cardName: "Create New User",
                modalTitle: "Add User",
                records: {},
                message: '',
                updateActive: {},
                updateId: '',

                hris_check: '',
                hris_search: '',
                hris_name: '',
                hris_designation: '',
                hris_bps: '',
                hris_department: '',
                hris_data: []

            }
        },
        mounted() {

            this.loadUser();
        },
        methods:
            {
                addUser() {
                    alert("You are about to add new user");
                },
                createUser() {
                    // Submit the form via a POST request
                    if (this.updateId === '') {
                        this.form.post('api/user')
                            .then(response => {
                                swal("Good job!", "Congratulations!!User Created Successfully..", "success")
                                    .then((value) => {
                                        this.form.reset();
                                        location.reload();
                                    });
                            })
                            .catch(error => {
                                this.message = "Some fields are empty..kindly them first!!";
                            });
                    } else {
                        this.form.put('api/user/' + this.updateId)
                            .then(response => {
                                swal("Good job!", "Congratulations!!User Updated Successfully..", "success")
                                    .then((value) => {
                                        this.form.reset();
                                        location.reload();
                                    });
                            })
                            .catch(error => {
                                this.message = "Some Fields are empty kindly fill them first..";
                            });
                        this.updateId = '';
                    }


                },
                loadUser(page) {
                    if (page === 'undefined') {
                        page = 1;
                    }
                    axios.get('api/user?page=' + page)
                        .then(response => {
                            this.records = response.data;
                        });

                    axios.get('api/hrisdata')
                        .then(response => this.hris_data=response.data)
                        .catch(error => console.log(error));
                },
                editRecord(id) {
                    axios.get('api/user/' + id)
                        .then(response => {
                            this.modalTitle = "Update User:" + response.data.name;
                            this.form.name = response.data.name;
                            this.form.email = response.data.email;
                            this.form.user_type = response.data.user_type;
                            this.form.t_type = response.data.t_type;
                            this.updateId = response.data.id;

                        })
                        .catch(error => console.log(error));
                    // this.form.fill(this.updateActive.data);

                    // this.updateActive=id;
                    // alert(this.updateActive);
                },
                deleteRecord(id) {
                    swal("You want to delete this record?", {
                        buttons: {
                            cancel: "CANCEL",
                            OK: true,
                        },
                    })
                        .then((value) => {
                            switch (value) {

                                case "OK":
                                    axios.delete('api/user/' + id)
                                        .then(response => {
                                            // swal("Notice!", "Your Record Deleted Successfully!", "error")
                                            swal("Notice!", "Your Record Deleted Successfully!", "error")
                                                .then((value) => {
                                                    location.reload();
                                                });
                                        })
                                        .catch(error => {
                                            swal("Sorry!", "Admin Cant Be Deleted!", "error");
                                        });
                                    break;
                                default:
                                    swal("Got away safely!");
                            }
                        });

                },
                retData() {
                    $('#hr_employee_modal').modal('show');

                },
                EditHris(val) {
                    axios.get('api/emp_record/' + val)
                        .then(response => {
                            $('#hr_employee_modal').modal('hide');
                            this.form.fill(response.data[0]);
                        })
                        .catch(error => console.log(error));
                }
            },
        computed: {
            HrisData: function () {
                if (this.hris_bps) {
                    return this.hris_data.filter((hr) => {
                        return hr.Grade.toString().startsWith(this.hris_bps);
                    });
                } else if (this.hris_designation) {
                    return this.hris_data.filter((hr) => {
                        return hr.Designation.toString().toUpperCase().includes(this.hris_designation.toUpperCase());
                    });
                } else if (this.hris_search) {
                    return this.hris_data.filter((hr) => {
                        return hr.MyId.toString().startsWith(this.hris_search);
                    });
                } else if (this.hris_name) {
                    return this.hris_data.filter((hr) => {
                        return hr.Name.toString().includes(this.hris_name.toUpperCase());
                    });
                } else if (this.hris_department) {
                    return this.hris_data.filter((hr) => {
                        return hr.DeptName.toString().toUpperCase().includes(this.hris_department.toUpperCase());
                    });
                } else {
                    return this.hris_data;
                }
            }
        },
        filters: {
            capitalize: function (value) {
                return value.toUpperCase();
            }
        }

    }
</script>

<style scoped>
    .table>tbody>tr>td
    {
        padding-bottom: 0;
        padding-top: 0;
    }
    .table>thead>tr>td
    {
        padding-bottom: 0;
        padding-top: 0;
    }
</style>
