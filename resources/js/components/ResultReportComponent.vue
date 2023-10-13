<template>
    <div class="container">
        <div class="card text-center">
            <div class="card-header">
                <h4 class="text-info">Training Result Report</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 offset-1">
                        <div class="form-group">
                            <label for="lecture_feedback">Select Training</label>
                            <select class="form-control" id="lecture_feedback" v-model="selectedCourse" @change="getExamData">
                                <option v-for="l in lectureData" :value="l.cid">{{l.cdesc}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label for="exam_list">Exams List</label>
                            <select class="form-control" id="exam_list" v-model="examListId" @change="assignUrl">
                                <option v-for="exam in examData" :value="exam.exam_id">{{exam.examtitle}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="p-2"><a class="btn btn-info text-white" :href="genLecUrl" target="_blank">Generate Result Report</a></div>
                    <div class="p-2"><a class="btn btn-info text-white" :href="genFeedUrl" target="_blank">Generate FeedBack Report</a></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                lectureData:{},
                examData:{},
                selectedCourse:'',
                genLecUrl:'',
                genFeedUrl:'',
                examListId:0
            }
        },
        mounted() {
            this.getLectures();
            // this.getExamData();
        },
        methods: {
            getLectures() {
                     axios.get('api/addcourse/definelib')
                    .then(response => this.lectureData=response.data)
                    .catch(error => console.log(error));
            },
            getExamData(){
                axios.get('api/exam/examdata_'+this.selectedCourse)
                    .then(response => {
                        this.examData=response.data;
                    })
                    .catch(error => console.log(error));
            },
            assignUrl(){
                this.genLecUrl='/res_reports/'+this.selectedCourse+'-'+this.examListId;
                this.genFeedUrl='/feedback_reports/'+this.selectedCourse;
            }
        }
    }
</script>

<style scoped>

</style>
