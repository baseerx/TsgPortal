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
                            <label for="ctype">Training Type</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control" id="ctype" @change="getCourseDetail()" v-model="form.trainingtype">
                                    <option :value="cdata.coursetype_id" v-for="cdata in ccourseData">
                                        {{cdata.coursetype_desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2 text-right">
                            <label for="Training">Training</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control" id="training" v-model="form.training">
                                    <option :value="cddata.cid" v-for="cddata in ccourseDet">
                                        {{cddata.cdesc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-check-inline d-flex flex-row justify-content-around">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" value="presentation" id="presentation" v-model="form.filetype" name="customRadio">
                            <label for="presentation" class="custom-control-label">Presentation</label>
                        </div>
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
                                <th>Training Type</th>
                                <th>Training</th>
                                <th>Description</th>
                                <th>File Type</th>
                                <th>File</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr  class="text-center" v-for="(records,index) in records.data">
                                <td>{{++index}}</td>
                                <td>{{records.coursetype_desc}}</td>
                                <td>{{records.cdesc}}</td>
                                <td>{{records.description}}</td>
                                <td>{{records.filetype}}</td>
                                <td><a :href="'../logdata/'+records.file" :title="records.file"><i class="fas fa-2x fa-file-download"></i></a></td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center">
                                        <a @click="editRecord(records.recid)">
                                            <i class="fas fa-lg fa-pen text-info">
                                            </i>
                                        </a>
                                        <a class="pl-3" @click="deleteRecord(records.recid)">
                                            <i class="fas fa-lg fa-trash text-danger">

                                            </i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <pagination :data="records" class="pagination justify-content-left" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data ()
        {
            return {
                form:new Form({
                    description:'',
                    filetype:'',
                    file:'',
                    trainingtype:'',
                    training:''
                }),
                name: "Presentations",
                btnName:'Submit',
                updateId:0,
                courseData:{},
                ccourseDet:{},
                relData:{},
                records:{},
                ccourseData:{},
                filename:'',
                Trainees:{}
            }
        },
        mounted()
        {
            Fire.$on('updateRecords',()=>{
                this.getResults();
            });
            this.getcType();
            this.getCourseDetail();
            this.enrolledTrainees();
            this.getCourseData();
            this.getResults();
            // this.getSchedulesData();
            // this.getInstructorData();
        },
        methods:{
            getCourseDetail()
            {
                  let str='definelib*'+this.form.trainingtype;
                  axios.get('api/addcourse/'+str)
                  .then(response=>this.ccourseDet=response.data)
                  .catch(error=>console.log(error));
            },
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
                formData.append('training', this.form.training);

                axios.post('api/logdata',formData, config)
                    .then(response=>{
                        this.form.reset();
                        this.filename='';
                        Fire.$emit('updateRecords');
                        swal('Congratulations','Record Stored Successfully..','success');
                    })
                    .catch(error=>swal('Failed','Record Submission Failed..','error'));
            },
            getcType() {
                axios.get('api/coursetype/' + 1)
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
                if(page==='undefined')
                {
                    page=1;
                }
                axios.get('api/logdata?page='+page)
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
                formData.append('training', this.form.training);
                formData.append("_method", "put");

                axios.post('api/logdata/'+this.updateId,formData, config)
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
            enrolledTrainees()
            {
                axios.get('api/user/presentation')
                    .then(response=>this.Trainees=response.data)
                    .catch(error=>console.log(error));
            },
            deleteRecord(id) {
                axios.delete('api/logdata/'+id)
                    .then(response=>{
                        swal('Congratulation!','Record Deleted Successfully..','warning');
                        Fire.$emit('updateRecords');
                    })
                    .catch(error=>console.log(error))
            },
            editRecord(id)
            {
                axios.get('api/logdata/'+id)
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
