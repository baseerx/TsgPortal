<template>
    <div class="container">
        <div class="card ">
            <h5 class="card-header">Training Schedule</h5>
            <div class="card-body">
                <form @submit.prevent="courseSch">
                    <div class="row">
                        <div class="col-2">
                            <label for="course_title">Training</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select :class="{ 'is-invalid': form.errors.has('course') }" class="form-control w-75" id="course_title" v-model="form.course">
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
                                <input type="text" :class="{ 'is-invalid': form.errors.has('ctitle') }" class="form-control w-75" id="ctitle" name="ctitle" v-model="form.ctitle">
                                <has-error :form="form" field="ctitle"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-2">
                            <label for="instructor">Instructor</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select :class="{ 'is-invalid': form.errors.has('instructor') }" class="form-control w-75" id="instructor" v-model="form.instructor">
                                    <option :value="i.ins_id" v-for="i in instData">{{i.name}}</option>
                                </select>
                                <has-error :form="form" field="instructor"></has-error>
                            </div>
                        </div>
                        <div class="col-2">
                            <label for="sdate">Start date</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <Datepicker :class="{ 'is-invalid': form.errors.has('sdate') }" id="sdate" calendar-button-icon="fa fa-calendar-alt" format="dd-MM-yyyy" input-class="form-control w-75" placeholder="Training Start Date" v-model="form.sdate"></Datepicker>
                                <has-error :form="form" field="sdate"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-2">
                            <label>End Date</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <Datepicker :class="{ 'is-invalid': form.errors.has('edate') }" calendar-button-icon="fa fa-calendar-alt" format="dd-MM-yyyy" input-class="form-control w-75" placeholder="Training End Date" v-model="form.edate"></Datepicker>
                                <has-error :form="form" field="edate"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-navbar text-success" id="sch_submit" name="sch_submit" type="submit">
                            <i class="fas fa-plus-circle fa-3x"></i>
                        </button>
                        <button class="btn btn-navbar text-success d-none" id="sch_update" @click="updateRecord" name="sch_update" type="button">
                            <i class="fas fa-user-edit fa-3x"></i>
                        </button>
                    </div>
                </form>
                <div class="row mt-2">
                    <div class="col-12 table-responsive">
                        <table class="table table-hover">
                            <tr class="text-center">
                                <th>Sr.</th>
                                <th>Training</th>
                                <th>Title</th>
                                <th>Instructor</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th></th>
                            </tr>
                            <tr class="text-center" v-for="(records,index) in schData.data">
                                <td>{{++index}}</td>
                                <td>{{records.cdesc}}</td>
                                <td>{{records.ctitle}}</td>
                                <td>{{records.name}}</td>
                                <td>{{records.sdate}}</td>
                                <td>{{records.edate}}</td>
                                <td>
                                    <div class="d-flex flex-row">
                                        <a @click="selectRecord(records.sch_id)">
                                            <i class="fas fa-lg fa-edit text-info p-2">

                                            </i>
                                        </a>
                                        <a @click="delRec(records.sch_id)">
                                            <i class="fas fa-lg fa-trash text-danger p-2">

                                            </i>
                                        </a>
                                        <router-link :to="'/add_letter/'+records.sch_id" class="btn btn-sm btn-info ml-1 text-white">Add Participant</router-link>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <pagination :data="schData" class="pagination justify-content-center" @pagination-change-page="loadData"></pagination>
                    </div>
                </div>
                <DeleteCourseModal @deleteMe="deleteRecord" :delflag="deleteModalFlag"></DeleteCourseModal>
            </div>
        </div>
    </div>
</template>
<script>
    import Datepicker from 'vuejs-datepicker';
    import DeleteCourseModal from "./DeleteCourseModal";

    export default {
        components: {
            Datepicker,
            DeleteCourseModal
        },
        data() {
            return {
                form: new Form({
                    course: '',
                    ctitle:'',
                    instructor: '',
                    sdate:'',
                    edate: '',
                }),

                letterData:{},
                courseData:{},
                schData:{},
                updateId:Number,
                trainee_name:'',
                trainee_address:'',
                trainee_email:'',
                totalTrainees:{},
                instData:{},
                schVal:'',
                currentId:0,
                deleteModalFlag:false
            }
        },
        mounted() {
            Fire.$on('updateResults',()=>{
                this.getSchData();
            });
            this.getSchData();
            this.getcourseData();
            this.loadData();
            this.loadInstructor();
        },
        watch: {

        },
        methods: {
            loadLetterComp(id)
            {
                // this.$router.push({ path: '/home/5' });
            },
            courseSch()
            {
                this.form.post('api/schedule')
                    .then(response=>{
                        swal("Good job!", "Congratulations!!Training Scheduled Successfully..", "success");
                        Fire.$emit('updateResults');
                        this.form.reset();
                    })
                    .catch(error=>swal("Failed!", "Training Scheduling Failed..", "warning"))
            },
            getSchData()
            {
                axios.get('api/schedule')
                    .then(response=>this.schData=response.data)
                    .catch(error=>console.log(error));
            },
            getcourseData()
            {
                axios.get('api/schedule/getcourse')
                    .then(response=>this.courseData=response.data)
                    .catch(error=>console.log(error));
            },
            loadData(page)
            {
                if (page==='undefined')
                {
                    page=1;
                }
                axios.get('api/schedule?page='+page)
                    .then(response=>this.schData=response.data)
                    .catch(error=>console.log(error));
            },
            selectRecord(id)
            {
                axios.get('api/schedule/'+id)
                    .then(response=>{
                        this.form.fill(response.data);
                        this.updateId=response.data.sch_id;
                        $('#sch_submit').addClass('d-none');
                        $('#sch_update').addClass('d-none');
                        $('#sch_update').addClass('d-block');
                    })
                    .catch(error=>console.log(error));
            },
            delRec(id)
            {
              this.currentId=id;
              this.deleteModalFlag=!this.deleteModalFlag;

            },
            deleteRecord()
            {
                this.form.delete('api/schedule/'+this.currentId)
                    .then(response=>{
                        swal("Good job!", "Record Deleted Successfully..", "warning");
                        Fire.$emit('updateResults');
                    })
                    .catch(error=>swal('Notice',"Relevant data already exists therefore can't be deleted"));
            },
            updateRecord()
            {
                this.form.put('api/schedule/'+this.updateId)
                    .then(response=>{
                        swal("Good job!", "Congratulations!!Record Updated Successfully..", "success");
                        Fire.$emit('updateResults');
                    })
                    .catch(error=>console.log(error));
            },
            addTrainees(id)
            {
                $('#trainees_list_modal').modal('show');
                let str='totalT-'+id;

                axios.get('api/schedule/'+str)
                    .then(response=>this.totalTrainees=response.data)
                    .catch(error=>console.log(error));
            },
            loadInstructor(){
                axios.get('api/instructor/'+'all')
                    .then(response=>this.instData=response.data)
                    .catch(error=>console.log(error));
            },
            toLetter(id)
            {

                this.schVal=id;
            }
        },
        computed: {
            TraineesData: function () {
                if (this.trainee_name) {
                    return this.totalTrainees.filter((hr) => {
                        return hr.name.toString().toUpperCase().includes(this.trainee_name.toUpperCase());
                    });
                } else if (this.trainee_address) {
                    return this.totalTrainees.filter((hr) => {
                        return hr.address.toString().toUpperCase().includes(this.trainee_address.toUpperCase());
                    });
                } else if (this.trainee_email) {
                    return this.totalTrainees.filter((hr) => {
                        return hr.email.toString().startsWith(this.trainee_email);
                    });
                } else {
                    return this.totalTrainees;
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
