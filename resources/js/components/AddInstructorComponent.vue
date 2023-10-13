<template>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Instructor</h4>
                <div class="card-tools">
                    <button class="btn btn-sm" @click="addInstructorPanel" id="add_instructor" name="add_instructor">
                        <i class="fas fa-2x fa-user-plus green"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-hover table-thead table-responsive-sm">
                    <tr class="text-center">
                        <th>Sr</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>DOB</th>
                        <th>Phone</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                    <tr class="text-center" v-for="(records,index) in records.data">
                        <!--                                                <td>{{records.id}}</td>-->
                        <td>{{++index}}</td>
                        <td>{{records.name | capitalize}}</td>
                        <td>{{records.title}}</td>
                        <td>{{records.dob}}</td>
                        <td>{{records.phone}}</td>
                        <td>{{records.mobile}}</td>
                        <td>{{records.email}}</td>
                        <td>
                            <div class="d-flex flex-row-reverse">
                                <div class="p-2"><a @click="editRecord(records.ins_id)" data-target="#addInstructorModal" data-toggle="modal">
                                    <i class="fas fa-lg fa-edit text-success">

                                    </i>
                                </a></div>
                                <div class="p-2"> <a @click="deleteRecord(records.ins_id)">
                                    <i class="fas fa-lg fa-trash red">

                                    </i>
                                </a></div>
                            </div>
                        </td>
                    </tr>
                    <pagination :data="records" @pagination-change-page="loadUser" class="pagination justify-content-center"></pagination>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div aria-hidden="true" aria-labelledby="addInstructorModalLabel" class="modal fade" id="addInstructorModal" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addInstructorModalLabel"><span class="text-info">{{this.modalTitle}}</span></h5>
                        <form class="form-inline ml-auto">
                            <div class="input-group input-group-sm">
                                <div class="input-group-append">
                                    <div class="form-check">
                                        <button @click="retData" class="btn btn-sm btn-info text-white" id="hris_btn" name="hris_btn" type="button">HRIS
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createInstructor" id="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off"
                                       class="form-control" name="name" placeholder="Name" type="text"
                                       v-model="form.name">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('title') }" autocomplete="off"
                                       class="form-control" name="title" placeholder="Title" type="text"
                                       v-model="form.title">
                                <has-error :form="form" field="title"></has-error>
                            </div>
                            <div class="form-group">
                                <Datepicker calendar-button-icon="fa fa-calendar-alt" format="dd-MM-yyyy"
                                            input-class="form-control" placeholder="D.O.B"
                                            v-model="form.dob"></Datepicker>
                            </div>
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('phone') }" autocomplete="off"
                                       class="form-control" name="phone"
                                       placeholder="Phone No.." type="text"
                                       v-model="form.phone">
                                <has-error :form="form" field="phone"></has-error>
                            </div>
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('mobile') }" autocomplete="off"
                                       class="form-control" name="mobile"
                                       placeholder="Mobile No.." type="text"
                                       v-model="form.mobile">
                                <has-error :form="form" field="mobile"></has-error>
                            </div>
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('email') }" autocomplete="off"
                                       class="form-control" name="email"
                                       placeholder="Email Address" type="text"
                                       v-model="form.email">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <alert-error :form="form"
                                         message="please fill all the fields..data submission failed"></alert-error>
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


        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="employee_modalTitle" class="modal fade" id="employee_modal" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info py-1 my-0">
                        <h5 class="modal-title" id="employee_modalTitle">Employees List</h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-header bg-default p-1">
                        <div class="container">
                            <tr>
                                <th><input class="form-control form-control-sm" placeholder="HRIS ID" type="text" v-model="hris_search"></th>
                                <th><input class="form-control form-control-sm" placeholder="Name" type="text" v-model="hris_name"></th>
                                <th><input class="form-control form-control-sm" placeholder="Designation" type="text" v-model="hris_designation"></th>
                                <th><input class="form-control form-control-sm" placeholder="BPS" type="text" v-model="hris_bps"></th>
                                <th><input class="form-control form-control-sm" placeholder="Department" type="text" v-model="hris_department"></th>
                                <th></th>
                            </tr>
                        </div>
                    </div>

                    <div class="modal-body py-0">

                        <div class="card-body table-responsive mt-0 py-0" style="height: 300px;width: auto;">

                            <table class="table table-hover" v-if="hris_data.length" id="table_hris">
                                <thead class="bg-none">
                                <tr>
                                    <th>HRIS</th>
                                    <th>NAME</th>
                                    <th>DESIGNATION</th>
                                    <th>BPS</th>
                                    <th>DEPARTMENT</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="hr in HrisData" class="py-0 my-0" @dblclick="EditHris(hr.MyId)">
                                    <td>{{hr.MyId}}</td>
                                    <td>{{hr.Name}}</td>
                                    <td>{{hr.Designation}}</td>
                                    <td>{{hr.Grade}}</td>
                                    <td>{{hr.DeptName}}</td>
                                    <td><a @click="EditHris(hr.MyId)">
                                        <i class="fas fa-lg fa-check-circle text-success">

                                        </i>
                                    </a></td>
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
    import Datepicker from 'vuejs-datepicker';
    // import UpdateUserModal from "./UpdateUserModal";
    export default {
        // components: {
        //     'update-modal': UpdateUserModal
        // },
        components: {
            Datepicker
        },
        data() {
            return {
                form: new Form({
                    name: '',
                    title: '',
                    dob: '',
                    phone: '',
                    mobile: '',
                    email: ''
                }),
                cardName: "Create New Instructor",
                modalTitle: "Add Instructor",
                records: {},
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
                createInstructor() {
                    // Submit the form via a POST request

                    if (this.updateId === '') {
                        this.form.post('api/instructor')
                            .then(response => {
                                swal("Good job!", "Congratulations!!Instructor Created Successfully..", "success")
                                    .then((value) => {
                                        this.form.reset();
                                        location.reload();
                                    });
                            })
                            .catch(error => console.log(error));
                    } else {
                        this.form.put('api/instructor/' + this.updateId)
                            .then(response => {
                                swal("Good job!", "Congratulations!!Instructor Updated Successfully..", "success")
                                    .then((value) => {
                                        this.updateId = '';
                                        this.form.reset();
                                        location.reload();
                                    });
                            })
                            .catch(error => {
                                console.log(error);
                            });

                    }


                },
                loadUser(page) {
                    if (page === 'undefined') {
                        page = 1;
                    }
                    axios.get('api/instructor?page=' + page)
                        .then(response => {
                            this.records = response.data;
                        });

                    axios.get('api/hrisdata')
                        .then(response => this.hris_data = response.data)
                        .catch(error => console.log(error));
                },
                editRecord(id) {
                    axios.get('api/instructor/' + id)
                        .then(response => {
                            this.modalTitle = "Update User:" + response.data.name;
                            this.form.fill(response.data);
                            this.updateId = id;
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
                                    axios.delete('api/instructor/' + id)
                                        .then(response => {
                                            // swal("Notice!", "Your Record Deleted Successfully!", "error")
                                            swal("Notice!", "Your Record Deleted Successfully!", "error")
                                                .then((value) => {
                                                    location.reload();
                                                });
                                        })
                                        .catch(error => {
                                            swal("Sorry!", "Course is scheduled against Instructor so cant Be Deleted!", "error");
                                        });
                                    break;
                                default:
                                    swal("Got away safely!");
                            }
                        });

                },
                EditHris(val) {
                    axios.get('api/emp_record/' + val)
                        .then(response => {
                            $('#employee_modal').modal('hide');
                            this.form.fill(response.data[0]);
                        })
                        .catch(error => console.log(error));
                },
                retData() {
                    $('#employee_modal').modal('show');

                },

                addInstructorPanel()
                {
                    this.form.reset();
                    $('#addInstructorModal').modal('show');
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
#table_hris{
        font-size: x-small;
    }

</style>
