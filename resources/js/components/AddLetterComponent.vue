<template>
    <div class="container">
        <div class="card ">
            <h5 class="card-header">{{this.cardName}}</h5>
            <div class="card-body">
                <form @submit.prevent="addLetter" id="main_form">
                    <div class="row">
                        <div class="col-2">
                            <label for="course_title">Course</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select :class="{ 'is-invalid': form.errors.has('course') }" class="form-control w-75"
                                        disabled id="course_title" v-model="form.course">
                                    <option :value="cs.cid" v-for="cs in courseData">{{cs.cdesc}}</option>
                                </select>
                                <has-error :form="form" field="course"></has-error>
                            </div>
                        </div>
                        <div class="col-2">
                            <label for="ctitle">Title</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('ctitle') }" class="form-control w-75" disabled
                                       id="ctitle" name="ctitle" type="text" v-model="form.ctitle">
                                <has-error :form="form" field="ctitle"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-2">
                            <label for="sdate">Start date</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <Datepicker :class="{ 'is-invalid': form.errors.has('sdate') }" calendar-button-icon="fa fa-calendar-alt" disabled
                                            format="dd-MM-yyyy" id="sdate"
                                            input-class="form-control w-75" placeholder="Course Start Date"
                                            v-model="form.sdate"></Datepicker>
                                <has-error :form="form" field="sdate"></has-error>
                            </div>
                        </div>

                        <div class="col-2">
                            <label>End Date</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <Datepicker :class="{ 'is-invalid': form.errors.has('edate') }" calendar-button-icon="fa fa-calendar-alt"
                                            disabled format="dd-MM-yyyy"
                                            input-class="form-control w-75" placeholder="Course End Date"
                                            v-model="form.edate"></Datepicker>
                                <has-error :form="form" field="edate"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="instructor">Instructor</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select :class="{ 'is-invalid': form.errors.has('instructor') }" class="form-control w-75"
                                        disabled id="instructor" v-model="form.instructor">
                                    <option :value="i.ins_id" v-for="i in instData">{{i.name}}</option>
                                </select>
                                <has-error :form="form" field="instructor"></has-error>
                            </div>
                        </div>

                        <div class="col-2">
                            <label for="lno">Letter Number</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('letterNo') }" class="form-control w-75"
                                       id="lno" name="lno" type="text" v-model="form.letterNo">
                                <has-error :form="form" field="letterNo"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="ltitle">Letter Date</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <Datepicker :class="{ 'is-invalid': form.errors.has('letterDate') }"
                                            calendar-button-icon="fa fa-calendar-alt" format="dd-MM-yyyy"
                                            input-class="form-control w-75" placeholder="Letter Date"
                                            v-model="form.letterDate"></Datepicker>
                                <has-error :form="form" field="letterDate"></has-error>
                            </div>
                        </div>
                        <div class="col-2">
                            <label for="ltitle">Letter Title</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('letterTitle') }" class="form-control w-75"
                                       id="ltitle" name="ltitle" type="text"
                                       v-model="form.letterTitle">
                                <has-error :form="form" field="letterTitle"></has-error>
                            </div>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-center">
                        <button class="btn btn-success btn-sm" type="submit">Submit</button>
                        <div class="custom-control custom-radio ml-2">
                            <input class="custom-control-input" id="customRadio2" name="customRadio" type="radio"
                                   v-model="form.checkParticipent" value="internal">
                            <label class="custom-control-label" for="customRadio2">Internal</label>
                        </div>
                        <div class="custom-control custom-radio ml-2">
                            <input class="custom-control-input" id="customRadio1" name="customRadio" type="radio"
                                   v-model="form.checkParticipent" value="external">
                            <label class="custom-control-label" for="customRadio1">External</label>
                        </div>
                    </div>

                </form>
                <div class="table-responsive mt-2">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Letter Title</th>
                            <th scope="col">Letter No</th>
                            <th scope="col">Letter Date</th>
                            <th scope="col">Course</th>
                            <th scope="col">Instructor</th>
                            <th scope="col">Type</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(l,index) in letterData.data" v-if="l.sch_id==sentId">
                            <td scope="row">{{++index}}</td>
                            <td scope="col">{{l.ltitle}}</td>
                            <td scope="col">{{l.lno}}</td>
                            <td scope="col">{{l.ldate}}</td>
                            <td scope="col">{{l.cdesc}}</td>
                            <td scope="col">{{l.name}}</td>
                            <td :id="'check'+l.letterid" scope="col">{{l.checkparticipent}}</td>
                            <td scope="col">
                                <div class="d-flex flex-row">
                                    <div class="pl-2 pt-1"><a @click="selectRecord(l.letterid)">
                                        <i class="fas fa-lg fa-pen text-info" title="Edit Record"></i>
                                    </a></div>
                                    <div class="pl-2 pt-1"><a @click="deleteRecord(l.letterid)">
                                        <i class="fas fa-lg fa-trash text-danger" title="Delete Record"></i>
                                    </a></div>
                                    <div class="pl-2"><a @click="addMembers(l.letterid)" class="btn btn-sm btn-info text-white" v-model="form1.lid">
                                        Participents
                                    </a></div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-none" id="external_section">
                <div class="card">
                    <div class="card-block">
                        <div class="card-header text-info">
                            External Trainee
                            <button @click="closebtn" aria-label="Close" class="close" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="submitTrainees">
                                <div class="row">
                                    <div class="col">
                                        <table class="table table-bordered">
                                            <tbody>
                                            <tr v-for="(x,index) in extSelect">
                                                <td><span class="badge bg-danger">{{x.letterTitle}}</span></td>
                                                <td><span class="badge bg-danger">{{x.letterNo}}</span></td>
                                                <td>
                                                    <span class="badge bg-danger">{{x.ctitle}}</span>
                                                </td>
                                                <td><span class="badge bg-danger">{{x.checkParticipent}}</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off"
                                                   class="form-control w-75" id="name" name="name"
                                                   type="text" v-model="form1.name">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <label for="address">Address</label>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input :class="{ 'is-invalid': form1.errors.has('address') }" autocomplete="off"
                                                   class="form-control w-75" id="address" name="address"
                                                   type="text" v-model="form1.address">
                                            <has-error :form="form1" field="address"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <label for="phone">Phone</label>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input :class="{ 'is-invalid': form.errors.has('phone') }" autocomplete="off"
                                                   class="form-control w-75" id="phone" name="phone"
                                                   type="text" v-model="form1.phone">
                                            <has-error :form="form1" field="phone"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input :class="{ 'is-invalid': form1.errors.has('email') }" autocomplete="off"
                                                   class="form-control w-75" id="email" name="email"
                                                   type="text" v-model="form1.email">
                                            <has-error :form="form1" field="email"></has-error>
                                        </div>
                                        <input class="d-none" type="text" v-model="tide">
                                        <input class="d-none" type="text" v-model="tblId">
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="p-1">
                                        <button class="btn btn-sm btn-primary" id="add_mem">
                                            Add Member
                                        </button>
                                    </div>
                                    <div class="p-1 d-none" id="update_mem">
                                        <button @click="updateTrainee" class="btn btn-sm btn-success" type="button">
                                            Update Member
                                        </button>
                                    </div>
                                    <div class="p-1">
                                        <button @click="closebtn" class="btn btn-danger btn-sm" type="button">Close
                                        </button>
                                    </div>
                                </div>
                            </form>
                           <div class="table-responsive mt-2">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Type</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(l,index) in traineesData.data" v-if="l.sch_id==autoFill">
                                        <td scope="row">{{++index}}</td>
                                        <td scope="col">{{l.name}}</td>
                                        <td scope="col">{{l.address}}</td>
                                        <td scope="col">{{l.phone}}</td>
                                        <td scope="col">{{l.email}}</td>
                                        <td scope="col">{{l.checkparticipent}}</td>
                                        <td scope="col">
                                            <div class="d-flex flex-row">
                                                <div class="pl-3 pt-1"><a @click="selectExtRecord(l.tid)">
                                                    <i class="fas fa-lg fa-pen text-info" title="Edit Record"></i>
                                                </a></div>
                                                <div class="pl-3 pt-1"><a @click="deleteInRecord(l.tid)">
                                                    <i class="fas fa-lg fa-trash text-danger" title="Delete Record"></i>
                                                </a></div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div class="table-responsive">

                <table class="table table-hover d-none mt-2" id="hris_trainees">
                    <div class="row">
                        <div class="col">
                            <table class="table table-bordered">
                                <tbody>
                                <tr v-for="(x,index) in intSelect">
                                    <td><span class="badge bg-danger">{{x.letterTitle}}</span></td>
                                    <td><span class="badge bg-danger">{{x.letterNo}}</span></td>
                                    <td>
                                        <span class="badge bg-danger">{{x.ctitle}}</span>
                                    </td>
                                    <td><span class="badge bg-danger">{{x.checkParticipent}}</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Type</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
<!--InternalListData-->
                    <tbody>
                    <tr v-for="(l,index) in traineesintData">
                        <td scope="col">{{++index}}</td>
                        <td scope="col">{{l.name}}</td>
                        <td scope="col">{{l.address}}</td>
                        <td scope="col">{{l.phone}}</td>
                        <td scope="col">{{l.email}}</td>
                        <td scope="col">{{l.checkparticipent}}</td>
                        <td scope="col">
                            <div class="d-flex flex-row">
                                <div class="pl-3 pt-1"><a @click="deletehrisRecord(l.tid)">
                                    <i class="fas fa-lg fa-trash text-danger" title="Delete Record"></i>
                                </a></div>
                            </div>
                        </td>
                    </tr>
  </tbody>
                    <div class="d-flex justify-content-center">
                        <button @click="showhrisModal" class="btn btn-info btn-sm d-none" id="modalbtn" type="button">
                            ADD HRIS EMPLOYEE
                        </button>
                    </div>
                </table>
            </div>

            <input class="d-none" type="text" v-model="ide">
        </div>
        <div aria-hidden="true" aria-labelledby="employee_modalTitle" class="modal fade" data-backdrop="static"
             data-keyboard="false" id="hr_employee_modal" role="dialog" tabindex="-1">
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
                                <th><input class="form-control form-control-sm" placeholder="HRIS ID" type="text"
                                           v-model="hris_search"></th>
                                <th><input class="form-control form-control-sm" placeholder="Name" type="text"
                                           v-model="hris_name"></th>
                                <th><input class="form-control form-control-sm" placeholder="Designation" type="text"
                                           v-model="hris_designation"></th>
                                <th><input class="form-control form-control-sm" placeholder="BPS" type="text"
                                           v-model="hris_bps"></th>
                                <th><input class="form-control form-control-sm" placeholder="Department" type="text"
                                           v-model="hris_department"></th>
                                <th></th>
                            </tr>
                        </div>
                    </div>

                    <div class="modal-body py-0">

                        <div class="card-body table-responsive mt-0 py-0" style="height: 300px;">

                            <table class="table table-hover" id="table_hris" v-if="hris_data.length">
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
                                <tr @dblclick="EditHris(hr.MyId)" class="py-0 my-0" v-for="hr in HrisData">
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
                    <!--<div class="modal-footer justify-content-center">-->
                    <!--<button @click='AddHrisTrainee' class="btn btn-navbar text-delete text-success" id="addhristrainee" name="addhristrainee" type="button">-->
                    <!--<i class="fas fa-plus-circle fa-3x"></i>-->
                    <!--</button>-->
                    <!--</div>-->
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        components: {
            Datepicker
        },

        data() {
            return {
                form: new Form({
                    course: '',
                    ctitle: '',
                    instructor: '',
                    sdate: '',
                    edate: '',
                    letterTitle: '',
                    letterNo: '',
                    letterDate: '',
                    checkParticipent: ''
                }),
                form1: new Form({
                    name: '',
                    address: '',
                    phone: '',
                    email: '',
                    lid: ''
                }),
                cardName: "Add Letter",
                sentId:'',
                hris_check: '',
                hris_search: '',
                hris_name: '',
                hris_designation: '',
                hris_bps: '',
                hris_department: '',
                hris_data: [],
                letterData: {},
                courseData: {},
                traineesData: {},
                traineesintData: {},
                instData: {},
                ext_trainee: '',
                hris_trainee: '',
                hris_checkbox: '',
                ide: 0,
                tide: 0,
                tblId: 0,
                extSelect: {},
                intSelect: {},
                autoFill: this.$route.params.param,
                baseUrl:'https://tsgportal.ntdc.com.pk/'
            }
        },
        created() {
            Fire.$on('Results', () => {
                this.getResults();
            });

            Fire.$on('removedhrisRecord', () => {
                this.getintTrainees();
            });
            Fire.$on('updateExt', () => {
                this.getTrainees();
                this.getintTrainees();
            });
            this.getResults();
            this.loadUser();
            this.getcourseData();
            this.loadInstructor();
            this.getTrainees();
            this.getintTrainees();
            this.autofillForm();

            // setInterval(()=>this.getResults(),3000);
            // setInterval(()=>this.getintTrainees(),3000);
            // setInterval(()=>this.getTrainees(),3000);

        },
        watch: {
            ext_trainee: function (val) {
                if (val) {
                    $('#extrainee_id,#addtrainee').removeClass('d-none');
                    $('#hris_control').addClass('d-none');
                    $('#extrainee_id,#addtrainee').addClass('d-block');
                } else {
                    $('#extrainee_id,#addtrainee').removeClass('d-block');
                    $('#extrainee_id,#addtrainee').addClass('d-none');
                    $('#hris_control').removeClass('d-none');
                    $('#hris_control').addClass('d-block');
                }
            },
            hris_trainee(val) {
                if (val) {
                    $('#hr_employee_modal').modal('show');
                    $('#ext_control').addClass('d-none');


                } else {
                    $('#hr_employee_modal').modal('hide');
                    $('#ext_control').removeClass('d-none');
                    $('#ext_control').addClass('d-block');
                }
            }

        },
        methods: {
            addLetter() {

                // this.form.emp_check = val;

                swal({
                    title: "Are you sure?",
                    text: "You want to enroll this member?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((Ok) => {

                        if (Ok) {
                            this.form.post(this.baseUrl+'api/letter')
                                .then(response => {
                                    this.hris_trainee = false;
                                    this.form.reset();
                                    Fire.$emit('Results');
                                    swal('Congratulations!', 'Your record added successfully..', 'success');
                                })
                                .catch(error => console.log(error));

                        } else {
                            swal("Record Submission Failed..");
                        }
                    })


            },
            autofillForm() {
                axios.get(this.baseUrl+'api/schedule/' + this.autoFill)
                    .then(response => this.form.fill(response.data))
                    .catch(error => console.log(error));
            },
            loadUser(page) {

                axios.get(this.baseUrl+'api/hrisdata')
                    .then(response => this.hris_data = response.data)
                    .catch(error => console.log(error));
            },
            getResults(page) {
                this.sentId=this.$route.params.param;
                if (page === 'undefined') {
                    page = 1;
                }
                axios.get(this.baseUrl+'api/letter?page=' + page)
                    .then(response => this.letterData = response.data)
                    .catch(error => console.log(error));
            },
            getTrainees(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get(this.baseUrl+'api/trainee_external?page=' + page)
                    .then(response => this.traineesData = response.data)
                    .catch(error => console.log(error));
            },
            getintTrainees() {
                axios.get(this.baseUrl+'api/inttrainees/'+this.sentId)
                    .then(response => this.traineesintData = response.data)
                    .catch(error => console.log(error));
            },
            AddTrainee() {
                this.form.post('api/letter')
                    .then(response => {
                        this.hris_trainee = false;
                        swal('Congratulations!', 'Your record added successfully..', 'success');
                        Fire.$emit('Results');
                    })
                    .catch(error => console.log(error));
            },
            selectRecord(id) {
                this.form.get(this.baseUrl+'api/letter/' + id)
                    .then(response => this.form.fill(response.data[0]))
                    .catch(error => console.log(error));
                $('#extrainee_id,#hris_trainees').removeClass('d-block');
                $('#extrainee_id,#hris_trainees').addClass('d-none');
                $('#main_form').removeClass('d-none');
                $('#main_form').addClass('d-block');
            },
            selectExtRecord(id) {
                this.tide = id;
                this.form1.get(this.baseUrl+'api/trainees/' + id)
                    .then(response => {
                        Fire.$emit('updateExt');
                        this.form1.fill(response.data);
                        $("#add_mem").addClass('d-none');
                        $("#add_mem").removeClass('d-block');
                        $("#update_mem").addClass('d-block');
                    })
                    .catch(error => console.log(error));
            },
            deleteRecord(id) {
                axios.delete(this.baseUrl+'api/letter/' + id)
                    .then(response => {
                        Fire.$emit('Results');
                        Fire.$emit('updateExt');
                        swal('Notice!', 'Record Deleted Successfully..', 'warning');
                    })
                    .catch(error => swal('Notice!', 'It cant be deleted as revelant data exists..', 'warning'));
            },
            deletehrisRecord(id) {
                axios.delete(this.baseUrl+'api/trainees/' + id)
                    .then(response => {
                        Fire.$emit('removedhrisRecord');
                        swal('Notice!', 'Record Deleted Successfully..', 'warning');

                    })
                    .catch(error => console.log(error));
            },
            deleteInRecord(id) {
                let str = '';
                str += id + '-' + 'internal';
                axios.delete(this.baseUrl+'api/trainees/' + str)
                    .then(response => {

                        Fire.$emit('removedhrisRecord');
                        Fire.$emit('updateExt');
                        Fire.$emit('Results');
                        swal('Notice!', 'Record Deleted Successfully..', 'warning');

                        $("#add_mem").removeClass('d-none');
                        $("#add_mem").addClass('d-block');
                    })
                    .catch(error => console.log(error));
            },
            getcourseData() {
                axios.get(this.baseUrl+'api/schedule/getcourse')
                    .then(response => this.courseData = response.data)
                    .catch(error => console.log(error));
            },
            loadInstructor() {
                axios.get(this.baseUrl+'api/instructor/' + 'all')
                    .then(response => this.instData = response.data)
                    .catch(error => console.log(error));
            },
            addMembers(id) {
                let val = $('#check' + id).html();
                this.ide = id;
                this.tblId = id;
                if (val == 'external') {

                    this.form1.reset();

                    $('#external_section,#add_mem').removeClass('d-none');
                    $('#external_section,#add_mem').addClass('d-block');

                    $('#update_mem,#hris_trainees,#main_form').removeClass('d-block');
                    $('#update_mem,#hris_trainees,#main_form').addClass('d-none');

                    this.form.get(this.baseUrl+'api/letter/' + id)
                        .then(response => this.extSelect = response.data)
                        .catch(error => console.log(error));
                } else {

                    $('#hris_trainees,#modalbtn').removeClass('d-none');
                    $('#hris_trainees,#modalbtn').addClass('d-block');

                    $('#external_section').removeClass('d-block');
                    $('#external_section,#main_form').addClass('d-none');

                    this.form.get(this.baseUrl+'api/letter/' + id)
                        .then(response => this.intSelect = response.data)
                        .catch(error => console.log(error));

                }
            },
            submitTrainees() {
                this.form1.tid = this.ide;
                this.form1.post(this.baseUrl+'api/trainees')
                    .then(response => {
                        swal('Congratulations!', 'Your record added successfully..', 'success');
                        Fire.$emit('updateExt');
                        this.form1.reset();
                    })
                    .catch(error => console.log(error));
            },
            closebtn() {
                $('#external_section').removeClass('d-block');
                $('#external_section').addClass('d-none');

            },
            EditHris(val) {
                var str = '';
                str = val + '-' + this.tblId;
                axios.get(this.baseUrl+'api/trainee_store/' + str)
                    .then(response => {
                        Fire.$emit('updateExt');
                        swal('Congratulations', 'Record added successfully..', 'success');
                    })
                    .catch(error => swal('Failed!','Record Already exists in list','warning'));
            },
            updateTrainee() {
                this.form1.put(this.baseUrl+'api/trainees/' + this.tide)
                    .then(response => {
                        swal('Congratulations', 'Record updated successfully..', 'success');
                        this.form1.reset();
                        Fire.$emit('updateExt');
                        $("#add_mem").removeClass('d-none');
                        $("#add_mem").addClass('d-block');
                        $("#update_mem").addClass('d-none');
                        $("#update_mem").removeClass('d-block');

                    })
                    .catch(error => swal('Failed!', 'Some Fields are empty kindly fill it befor submit..', 'warning'));
            },
            showhrisModal() {
                $('#hr_employee_modal').modal('show');
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
    }
</script>

<style scoped>
    .table > tbody > tr > td {
        padding-bottom: 0;
        padding-top: 0;
    }

    .table > thead > tr > td {
        padding-bottom: 0;
        padding-top: 0;
    }

    #table_hris {
        font-size: small;
    }

</style>
