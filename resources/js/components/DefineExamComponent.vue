<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.name}}</h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="defineExam">
                    <div class="form-group row">
                        <div class="col-1 text-right"><label>Course</label></div>
                        <div class="col-4">
                            <select :class="{ 'is-invalid': form.errors.has('course') }" class="form-control" id="course"
                                    @change="getRelatedData"
                                    name="course" v-model="form.course">
                                <option :value="cdata.cid" v-for="cdata in courseData" v-text="cdata.cdesc"></option>
                            </select>
                            <has-error :form="form" field="course"></has-error>
                        </div>
                        <div class="col-2 text-right"><label>Course Schedules</label></div>
                        <div class="col-4">
                            <select :class="{ 'is-invalid': form.errors.has('schedules') }" class="form-control"
                                    id="schedules" name="schedules"
                                    v-model="form.schedules">
                                <option :value="sdata.sch_id" v-for="sdata in courseSchData">{{sdata.ctitle}}</option>
                            </select>
                            <has-error :form="form" field="schedules"></has-error>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-1 text-right"><label>Instructor</label></div>
                        <div class="col-4">
                            <select :class="{ 'is-invalid': form.errors.has('instructor') }" class="form-control"
                                    id="instructor" name="instructor"
                                    v-model="form.instructor">
                                <option :value="idata.ins_id" v-for="idata in insData">{{idata.name}}</option>
                            </select>
                            <has-error :form="form" field="instructor"></has-error>
                        </div>
                        <div class="col-2 text-right"><label>Date</label></div>
                        <div class="col-4">
                            <div class="form-group">
                                <date-picker class="w-100" formate="YYYY-MM-dd" lang="en" placeholder="Select Date"
                                             type="date" v-model="form.date"></date-picker>
                                <has-error :form="form" field="date"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="aftereditAdjust">
                        <div class="col-1"><label for="center">Center</label></div>
                        <div class="col-4"><input class="form-control" id="center" name="center" type="text"
                                                  v-model="form.center"></div>
                        <div class="col-2 text-right"><label>Start Time</label></div>
                        <div class="col-4">
                            <date-picker class="w-100" format="hh:mm:ss a" lang="en" placeholder="Start Time" type="time" v-model="form.stime"></date-picker>
                            <has-error :form="form" field="time"></has-error>
                            <small class="text-info float-right" v-text="stimeEdit"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-1"><label>EndTime</label></div>
                        <div class="col-4">
                            <date-picker class="w-100" format="hh:mm:ss a" lang="en" placeholder="End Time" type="time"
                                         v-model="form.etime"></date-picker>
                            <has-error :form="form" field="time"></has-error>
                            <small class="text-info" v-text="etimeEdit"></small>
                        </div>
                        <div class="col-2 text-right"><label for="marks_criteria">Marks Criteria</label></div>
                        <div class="col-4"><input class="form-control" id="marks_criteria" name="marks_criteria" type="text"
                                                  v-model="form.marks"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-1"><label for="exam_title">Title</label></div>
                        <div class="col-4"><input class="form-control" id="exam_title" placeholder="Examination title" name="exam_title" type="text"
                                                  v-model="form.examtitle"></div>
                        <div class="col-5 text-right">
                            <input type="checkbox" class="form-check-input" id="examstatus" v-model="form.exam_status">
                            <label class="form-check-label" for="examstatus">Active/In-active</label>
                        </div>
                    </div>
                    <!--                    <div class="d-flex flex-row justify-content-center">-->
                    <!--                        <div class="p-2 bd-highlight"><input type="checkbox" class="form-check-input" id="exam-active"></div>-->
                    <!--                        <div class="p-2 text-bold bd-highlight"><label class="form-check-label" for="exam-active">Exam Active/Or Not</label></div>-->
                    <!--                    </div>-->
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-thead table-responsive-sm">
                            <tr class="text-center">
                                <th>Sr</th>
                                <th>Course</th>
                                <th>Instructor</th>
                                <th>Date</th>
                                <th>Title</th>
                                <th>From</th>
                                <th>To</th>
                                <th></th>
                            </tr>
                            <tr class="text-center" v-for="(records,index) in records.data">
                                <!--                                                <td>{{records.id}}</td>-->
                                <td>{{++index}}</td>
                                <td>{{records.cdesc}}</td>
                                <td>{{records.name}}</td>
                                <td>{{records.date}}</td>
                                <td>{{records.examtitle}}</td>
                                <td>{{records.stime}}</td>
                                <td>{{records.etime}}</td>
                                <td>
                                    <div class="d-flex flex-row-reverse">
                                        <div class="p-2"><a @click="editExam(records.exam_id)">
                                            <i class="fas fa-lg fa-edit text-success">

                                            </i>
                                        </a></div>
                                        <div class="p-2"><a @click="deleteRecord(records.exam_id)">
                                            <i class="fas fa-lg fa-trash red">

                                            </i>
                                        </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <pagination :data="records" @pagination-change-page="getResults"
                                    class="pagination justify-content-center"></pagination>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" id="submitBtn" name="submitBtn" type="submit"
                                v-text="btnName"></button>
                        <button type="button" @click="updateRecord" class="btn btn-success d-none" id="updateBtn" name="updateBtn">Update</button>
                    </div>
                    <alert-error :form="form" message="Fill all the fields correctly.."></alert-error>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker'

export default {
    components: {
        DatePicker
    },
    data() {
        return {
            form: new Form({
                course: '',
                schedules: '',
                instructor: '',
                date: '',
                stime: '',
                etime: '',
                center: '',
                marks: '',
                examtitle:'',
                exam_status:false
            }),
            name: "Define Exam",
            btnName: 'Submit',
            updateId: 0,
            records: {},
            courseData: {},
            courseSchData:{},
            insData:[],
            stimeEdit: '',
            etimeEdit: ''
        }
    },
    mounted() {
        Fire.$on('updateRecords', () => {
            this.getResults();
            this.stimeEdit = '';
            this.etimeEdit = '';
        });
        this.getInsData();
        this.getCourseData();
        this.getResults();
    },
    watch: {

    },
    methods: {
        handleFileUpload(e) {

            let file = e.target.files[0];
            this.form.file = e.target.files[0];
            this.filename = file.name;
        },
        defineExam() {

            if (this.updateId!==0)
            {
                this.updateRecord();
            }
            else
            {
                let date = this.form.date;
                if (date!=="")
                {
                    this.form.date = new Date(date.getTime() - (date.getTimezoneOffset() * 60000)).toJSON();
                }
                this.form.stime = this.form.stime.toLocaleString('en-GB');
                this.form.etime = this.form.etime.toLocaleString('en-GB');
                this.form.post('api/exam')
                    .then(response => {
                        this.form.reset();
                        Fire.$emit('updateRecords');
                        swal('Congratulations', 'Record Stored Successfully..', 'success');
                    })
                    .catch(error => swal('Failed', 'Record Submission Failed..', 'error'));
            }
        },
        getCourseData() {
            axios.get('api/addcourse/definelib')
                .then(response => this.courseData = response.data)
                .catch(error => console.log(error));
        },
        getRelatedData(page) {
            let courseId=this.form.course+'_'+'courseId';
            axios.get('api/schedule/'+courseId)
                .then(response=>{
                    this.courseSchData=response.data
                })
                .catch(error=>console.log(error));

            if (page==='undefined')
            {
                page=1;
            }
            axios.get('api/exam/'+courseId+'?page='+page)
                .then(response => this.records = response.data)
                .catch(error => console.log(error));
        },
        getInsData()
        {
            axios.get('api/instructor/all')
                .then(response=>{
                    this.insData=response.data;
                })
                .catch(error=>console.log(error));
        },
        getResults(page) {
            if (page==='undefined')
            {
                page=1;
            }
            axios.get('api/exam?page='+page)
                .then(response => this.records = response.data)
                .catch(error => console.log(error));
        },
        updateRecord() {
            let date = this.form.date;
            if(date.toString().includes("GMT"))
            {
                this.form.date = new Date(date.getTime() - (date.getTimezoneOffset() * 60000)).toJSON();
                let splitDate=this.form.date.toString().split('T');
                this.form.date=splitDate[0];
            }
            if (this.form.stime.toString().includes("GMT"))
            {
                this.form.stime = this.form.stime.toLocaleString('en-GB');
                let stime=this.form.stime.toString().split(',');
                this.form.stime=stime[1];
                if (this.form.stime.toString().includes('AM') || this.form.stime.toString().includes('PM'))
                {
                    let str=this.form.stime.toString().split(' ');

                    this.form.stime=str[1];
                }
            }
            if (this.form.etime.toString().includes("GMT"))
            {
                this.form.etime = this.form.etime.toLocaleString('en-GB');
                let etime=this.form.etime.toString().split(',');
                this.form.etime=etime[1];
                if (this.form.etime.toString().includes('AM') || this.form.etime.toString().includes('PM'))
                {
                    let str=this.form.etime.toString().split(' ');

                    this.form.etime=str[1];
                }
            }
            this.form.put('api/exam/' + this.updateId)
                .then(response => {
                    this.form.reset();
                    Fire.$emit('updateRecords');
                    swal('Congratulations', 'Record Stored Successfully..', 'success');
                })
                .catch(error => swal('Failed', 'Record Submission Failed..', 'error'));

            this.updateId=0;
        },
        deleteRecord(id) {
            axios.delete('api/exam/' + id)
                .then(response => {
                    swal('Congratulation!', 'Record Deleted Successfully..', 'warning');
                    Fire.$emit('updateRecords');
                })
                .catch(error => console.log(error))
        },
        editExam(id) {
            axios.get('api/exam/' + id)
                .then(response => {
                    this.stimeEdit = response.data.stime;
                    this.etimeEdit = response.data.etime;
                    this.updateId = response.data.exam_id;
                    // $("#aftereditAdjust").addClass('mb-0');
                    this.btnName='Update';
                    this.form.fill(response.data);
                })
                .catch(error => console.log(error));

        }

    }

}
</script>

<style scoped>

</style>
