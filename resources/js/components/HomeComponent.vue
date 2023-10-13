<template>
    <div class="container">

        <h3 class="text-danger" v-if="courseDataLen>0"><span class="badge badge-danger text-white">Existing Courses</span></h3>
        <table class="table table-dark" v-if="courseDataLen>0">
            <thead>
            <tr>
                <th>#</th>
                <th>Training</th>
                <th>Training Title</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(c,index) in courseData.data">
                <td>{{++index}}</td>
                <td>{{ c.cdesc }}</td>
                <td>{{ c.ctitle }}</td>
                <th class="animated flash infinite  text-primary" scope="row">{{
                    c.sdate.split("-").reverse().join("-")}}
                </th>
                <td>{{ c.edate.split("-").reverse().join("-") }}</td>
            </tr>
       </tbody>
        </table>
        <div class="d-none" id="trainees_data">
            <h3 class="text-danger"><span class="badge badge-danger text-white">Enrolled Trainings</span></h3>
            <table class="table table-dark">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Training</th>
                    <th>Training Title</th>
                    <th>Letter</th>
                    <th>Trainee</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(trainee,index) in traineesData">
                    <td>{{++index}}</td>
                    <td>{{ trainee.cdesc }}</td>
                    <td>{{ trainee.ctitle }}</td>
                    <td>{{ trainee.ltitle }}</td>
                    <td>{{ trainee.name }}</td>
                    <th class="animated flash infinite  text-primary" scope="row">{{
                        trainee.sdate.split("-").reverse().join("-")}}
                    </th>
                    <td>{{ trainee.edate.split("-").reverse().join("-") }}</td>
                    <td><button :class="examClass" title="For Paper Start Click Here.." @click="startExam(trainee.cid,trainee.stime)">Start Paper</button></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="d-none" id="ins_data">
            <h3 class="text-danger"><span class="badge badge-danger text-white">Training Schedule</span></h3>
            <table class="table table-dark">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Training</th>
                    <th>Training Title</th>
                    <th>Instructor</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(sch,index) in schData.data">
                    <td>{{++index}}</td>
                    <td>{{ sch.cdesc }}</td>
                    <td>{{ sch.ctitle }}</td>
                    <td>{{ sch.name }}</td>
                    <th class="animated flash infinite  text-primary" scope="row">{{
                        sch.sdate.split("-").reverse().join("-")}}
                    </th>
                    <td>{{ sch.edate.split("-").reverse().join("-") }}</td>
                </tr>
                </tbody>
            </table>

        </div>

        <div class="card table-responsive" v-if="tableLength">
            <div class="card-header h3 text-danger">
                Annoncements
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Description</th>
                    <th scope="col">File Type</th>
                    <th scope="col">Training Type</th>
                    <th scope="col">Download</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(data,index) in files">
                    <th scope="row">{{++index}}</th>
                    <td>{{data.description}}</td>
                    <td>{{data.filetype}}</td>
                    <td>{{data.coursetype_desc}}</td>
                    <td><a :href="'../presentation_files/'+data.file" :title="data.file"><i class="fas fa-2x fa-file-download"></i></a></td>
                </tr>

                </tbody>
            </table>
        </div>
        <div class="card table-responsive" v-if="pDataLength">
            <div class="card-header h3 text-danger">
                Trainee Data
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">File Type</th>
                    <th scope="col">Training Type</th>
                    <th scope="col">Download</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(data,index) in pData">
                    <th scope="row">{{++index}}</th>
                    <td>{{data.name}}</td>
                    <td>{{data.description}}</td>
                    <td>{{data.filetype}}</td>
                    <td>{{data.coursetype_desc}}</td>
                    <td><a :href="'../presentation_files/'+data.file" :title="data.file"><i class="fas fa-2x fa-file-download"></i></a></td>

                </tr>

                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: "NTDC TSG Training Portal",
                schData: {},
                traineesData: {},
                courseData: {},
                files: {},
                tableLength:0,
                pData:{},
                pDataLength:0,
                courseDataLen:0,
                examClass:'btn btn-sm btn-info text-white d-none'
            }

        },
        mounted() {

            this.getSchedules();
            this.userTableTrainee();
            this.getPresentations();
            this.getTraineeData();
            this.getResults();
            Fire.$on('tdata', () => {

                $('#trainees_data').removeClass('d-none');
                $('#trainees_data').addClass('d-block');
            });

            Fire.$on('insdata', () => {
                $('#ins_data').removeClass('d-none');
                $('#ins_data').addClass('d-block');
            });
        },
        methods: {
            getPresentations()
            {
                axios.get('api/display_data/specificTrainee')
                    .then((response) => {
                        this.pData=response.data;
                        this.pDataLength=response.data.length;
                    })
                    .catch((error) => console.log("error occured in files retrieval.."));
            },
            getSchedules() {
                axios.get('api/display_data/instructor')
                    .then(response => {
                        if (response.data.length > 0) {
                            this.schData = response.data;
                            // console.log(this.schData.data.length);
                            Fire.$emit('insdata');
                        }
                    })
                    .catch(error => console.log(error));

                // Fire.$emit('myEvent');
            },
            userTableTrainee() {
                axios.get('api/display_data/content')
                    .then((response) => {
                        this.files=response.data;
                        this.tableLength=response.data.length;
                    })
                    .catch((error) => console.log("error occured in files retrieval.."));
            },
            startExam(cid,stime)
            {
                let course='course-'+cid;
                axios.get('api/exam/'+course)
                    .then((response)=>{
                        let stime=response.data;
                        let d = new Date();
                        let currentTime=d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
                        console.log(currentTime);
                        console.log(stime);
                        if(currentTime>=stime)
                        {
                            this.$router.push('result');
                        }
                        else
                        {
                            swal('Notice!','Kindly wait till the starting time..Starting Time: '+stime,'warning');
                        }
                    })
                    .catch(error=>console.log(error));
            },
            getTraineeData() {
                axios.get('api/display_data/trainee')
                    .then(response => {
                        if (response.data.length > 0) {
                            this.traineesData = response.data;
                            let startD=response.data[0].sdate.split('-').reverse().join('-');
                            let currentD=new Date();
                            currentD=currentD.toISOString().split('T');
                            currentD=currentD[0].split('-').reverse().join('-');
                            if (currentD.toString()===startD.toString())
                            {
                                this.examClass='btn btn-sm btn-info text-white d-block'
                            }
                            else
                            {
                                this.examClass='btn btn-sm btn-info text-white d-none'
                            }
                            Fire.$emit('tdata');
                        }
                    })
                    .catch(error => console.log(error));
            },
            getResults() {
                axios.get('api/display_data')
                    .then(response => {
                        this.courseData = response.data;
                        this.courseDataLen=response.data.length;
                    })
                    .catch(error => console.log(''));
            }
        }
    }
</script>

<style scoped>
    .table-dark {
        color: #fff;
        background-color: #663300;
    }

    .table-dark th,
    .table-dark td,
    .table-dark thead th {
        border-color: #FF860D;
    }
</style>
