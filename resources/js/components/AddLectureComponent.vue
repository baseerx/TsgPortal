<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.name}}</h4>

            </div>
            <div class="card-body">
                <form @submit="uploadPresentation">
                    <div class="form-group row">
                        <div class="col-2"><label>Description</label></div>
                        <div class="col-4">
                            <input type="text" name="description" id="description" v-model="form.description" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                            <has-error :form="form" field="description"></has-error>
                        </div>
                        <div class="col-2 text-right">
                            <label>File</label>
                        </div>
                        <div class="col-4">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input form-control" id="file" name="file"  @change="handleFileUpload">
                                <label class="custom-file-label" for="file" v-text="filename"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="course">Training</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control" @change="fetchCourseType" id="course" v-model="form.course">
                                    <option :value="cdata.cid" v-for="cdata in tcourseData">
                                        {{cdata.cdesc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <label for="ctype">Training Type</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control" id="ctype" v-model="form.trainingtype">
                                    <option :value="cdata.coursetype_id" v-for="cdata in ccourseData">
                                        {{cdata.coursetype_desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-check-inline d-flex flex-row justify-content-around">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="lecture" id="lecture" v-model="form.filetype" name="customRadio">
                            <label for="lecture" class="custom-control-label">Lecture</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="video" id="video" v-model="form.filetype" name="customRadio">
                            <label for="video" class="custom-control-label">Video</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="audio" id="audio" v-model="form.filetype" name="customRadio">
                            <label for="audio" class="custom-control-label">Audio</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" id="submitBtn" name="submitBtn" v-text="btnName"></button>
                        <button type="button" class="btn btn-success d-none" @click="updateRecord" id="updateBtn" name="updateBtn">Update</button>
                    </div>
                    <alert-error :form="form" message="Fill all the fields correctly.."></alert-error>
                </form>
                <div class="row mt-2">
                    <div class="col-12 table-responsive">
                        <table class="table table-hover">
                            <tr class="text-center">
                                <th>Sr.</th>
                                <th>Description</th>
                                <th>Training Type</th>
                                <th>File Type</th>
                                <th>File</th>
                                <th></th>
                            </tr>
                            <tr  class="text-center" v-for="(records,index) in records.data">
                                <td>{{++index}}</td>
                                <td>{{records.description}}</td>
                                <td>{{records.coursetype_desc}}</td>
                                <td>{{records.filetype}}</td>
                                <td><a :href="'../presentation_files/'+records.file" :title="records.file"><i class="fas fa-2x fa-file-download"></i></a></td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center">
                                        <a @click="editPresentation(records.pid)">
                                            <i class="fas fa-lg fa-pen text-info">
                                            </i>
                                        </a>
                                        <a class="pl-3" @click="delRec(records.pid)">
                                            <i class="fas fa-lg fa-trash text-danger">

                                            </i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <pagination :data="records" class="pagination justify-content-center" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <DeleteCourseModal @deleteMe="deleteRecord" :delflag="deleteModalFlag"></DeleteCourseModal>
            </div>
        </div>

    </div>
</template>

<script>
import DeleteCourseModal from "./DeleteCourseModal";
    export default {
        components:{
            DeleteCourseModal
        },
        data ()
        {
            return {
                form:new Form({
                    description:'',
                    filetype:'',
                    file:'',
                    trainingtype:'',
                    course:''
                }),
                name: "Lectures",
                btnName:'Submit',
                updateId:0,
                courseData:{},
                relData:{},
                records:{},
                ccourseData:{},
                filename:'',
                Trainees:{},
                tcourseData:{},
                currentId:0,
                deleteModalFlag:false
            }
        },
        mounted()
        {
            Fire.$on('updateRecords',()=>{
                this.getResults();
            });
            this.enrolledTrainees();
            this.getCourseData();
            this.getResults();
            this.getTCourseData();
            // this.getSchedulesData();
            // this.getInstructorData();
        },
        methods:{
            handleFileUpload(e) {

                let file = e.target.files[0];
                this.form.file=e.target.files[0];
                this.filename=file.name;
            },
            uploadPresentation(e)
            {
                e.preventDefault();


                let currentObj = this;

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                let formData = new FormData();

                formData.append('description', this.form.description);
                formData.append('filetype', this.form.filetype);
                formData.append('file', this.form.file);
                formData.append('trainingtype', this.form.trainingtype);
                formData.append('course', this.form.course);
                axios.post('api/addlecture',formData, config)
                    .then(response=>{
                        this.form.reset();
                        this.filename='';
                        Fire.$emit('updateRecords');
                        swal('Congratulations','Record Stored Successfully..','success');
                    })
                    .catch(error=>swal('Failed','Record Submission Failed..','error'));
            },
            fetchCourseType()
            {
                let courseId= this.form.course+'_course';
                axios.get('api/coursetype/' + courseId)
                    .then(response => this.ccourseData = response.data)
                    .catch(error => console.log(error));
            },
            getCourseData()
            {
                axios.get('api/addcourse/presentation')
                    .then(response=>this.courseData=response.data)
                    .catch(error=>console.log(error));
            },
            getRelatedData(id)
            {
                axios.get('api/presentation/'+id)
                    .then(response=>this.relData=response.data)
                    .catch(error=>console.log(error));
            },
            onChangeCourse(event)
            {
                let checkVal=event.target.value;
                this.getRelatedData(checkVal);
                // this.getInstructorData(checkVal);

            },
            getResults(page)
            {
                if (page == 'undefined') {
                    page = 1;
                }
                axios.get('api/addlecture?page='+page)
                    .then(response=>this.records=response.data)
                    .catch(error=>console.log(error));
            },
            updateRecord(e)
            {
                e.preventDefault();
                let currentObj = this;
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                var formData = new FormData();

                formData.append('description', this.form.description);
                formData.append('filetype', this.form.filetype);
                formData.append('file', this.form.file);
                formData.append('trainingtype', this.form.trainingtype);
                formData.append('course', this.form.course);
                formData.append("_method", "put");

                axios.post('api/addlecture/'+this.updateId,formData, config)
                    .then(response=>{
                        this.form.reset();
                        this.filename='';
                        $("#submitBtn").removeClass('d-none');
                        $("#updateBtn").removeClass('d-block');
                        $("#updateBtn").addClass('d-none');
                        $("#submitBtn").addClass('d-block');
                        Fire.$emit('updateRecords');
                        swal('Congratulations','Record Stored Successfully..','success');
                    })
                    .catch(error=>swal('Failed','Record Submission Failed..','error'));
            },
            getTCourseData()
            {
                axios.get('api/addcourse/definelib')
                    .then(response=>this.tcourseData=response.data)
                    .catch(error=>console.log(error));
            },
            enrolledTrainees()
            {
                axios.get('api/user/presentation')
                    .then(response=>this.Trainees=response.data)
                    .catch(error=>console.log(error));
            },
            delRec(id){
                this.currentId=id;
                this.deleteModalFlag=!this.deleteModalFlag;
            },
            deleteRecord() {
                axios.delete('api/presentation/'+this.currentId)
                    .then(response=>{
                        swal('Congratulation!','Record Deleted Successfully..','warning');
                        Fire.$emit('updateRecords');
                    })
                    .catch(error=>console.log(error))
            },
            editPresentation(id)
            {
                axios.get('api/presentation/'+id)
                    .then(response=>{
                        this.form.fill(response.data);
                        $('#updateBtn').removeClass('d-none');
                        $('#updateBtn').addClass('d-block');
                        $('#submitBtn').addClass('d-none');
                        this.updateId=id;
                        this.filename=response.data.file;
                    })
                    .catch(error=>console.log(error));

            }

        }

    }
</script>

<style scoped>

</style>
