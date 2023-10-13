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
                            <input :class="{ 'is-invalid': form.errors.has('description') }" class="form-control" id="description" name="description"
                                   type="text" v-model="form.description">
                            <has-error :form="form" field="description"></has-error>
                        </div>
                        <div class="col-2 text-right">
                            <label>File</label>
                        </div>
                        <div class="col-4">
                            <div class="custom-file">
                                <input @change="handleFileUpload" class="custom-file-input form-control" id="file" name="file"
                                       type="file">
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
                                <select class="form-control" id="ctype" v-model="form.trainingtype">
                                    <option :value="cdata.coursetype_id" v-for="cdata in ccourseData">
                                        {{cdata.coursetype_desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2 text-right">
                            <label for="ctype">Trainee</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control" id="ttype" v-model="form.traineetype">
                                    <option :value="t.tid" v-for="t in Trainees">
                                        {{t.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" id="submitBtn" name="submitBtn" type="submit"
                                v-text="btnName"></button>
                        <button @click="updateRecord" class="btn btn-success d-none" id="updateBtn" name="updateBtn"
                                type="button">Update
                        </button>
                    </div>
                    <alert-error :form="form" message="Fill all the fields correctly.."></alert-error>
                </form>
                <div class="row mt-2">
                    <div class="col-12 table-responsive">
                        <table class="table table-hover">
                            <tr class="text-center">
                                <th>Sr.</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Training Type</th>
                                <th>Description</th>
                                <th>File</th>
                                <th></th>
                            </tr>
                            <tr class="text-center" v-for="(records,index) in records.data">
                                <td>{{++index}}</td>
                                <td>{{records.name}}</td>
                                <td>{{records.email}}</td>
                                <td>{{records.coursetype_desc}}</td>
                                <td>{{records.description}}</td>
                                <td><a :href="'../indschedual/'+records.file" :title="records.file"><i
                                    class="fas fa-2x fa-file-download"></i></a></td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center">
                                        <a @click="editPresentation(records.ind_id)">
                                            <i class="fas fa-lg fa-pen text-info">
                                            </i>
                                        </a>
                                        <a @click="delRec(records.ind_id)" class="pl-3">
                                            <i class="fas fa-lg fa-trash text-danger">

                                            </i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <pagination :data="records" @pagination-change-page="getResults"
                                        class="pagination justify-content-center"></pagination>
                        </table>
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
        data() {
            return {
                form: new Form({
                    description: '',
                    file: '',
                    trainingtype: '',
                    traineetype: ''
                }),
                name: "Individual Scheduling..",
                btnName: 'Submit',
                updateId: 0,
                courseData: {},
                relData: {},
                records: {},
                ccourseData: {},
                filename: '',
                Trainees: {},
                deleteModalFlag:false,
                currentId:0

            }
        },
        mounted() {
            Fire.$on('updateRecords', () => {
                this.getResults();
            });
            this.getcType();
            this.enrolledTrainees();
            this.getCourseData();
            this.getResults();
            // this.getSchedulesData();
            // this.getInstructorData();
        },
        watch: {},
        methods: {
            handleFileUpload(e) {

                let file = e.target.files[0];
                this.form.file = e.target.files[0];
                this.filename = file.name;
            },
            uploadPresentation(e) {
                e.preventDefault();


                let currentObj = this;

                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                }
                let formData = new FormData();

                formData.append('description', this.form.description);
                formData.append('file', this.form.file);
                formData.append('trainingtype', this.form.trainingtype);
                formData.append('traineetype', this.form.traineetype);

                axios.post('api/indsch', formData, config)
                    .then(response => {
                        this.form.reset();
                        this.filename = '';
                        Fire.$emit('updateRecords');
                        swal('Congratulations', 'Record Stored Successfully..', 'success');
                    })
                    .catch(error => swal('Failed', 'Record Submission Failed..', 'error'));
            },
            getcType() {
                axios.get('api/coursetype/' + 1)
                    .then(response => this.ccourseData = response.data)
                    .catch(error => console.log(error));
            },
            getCourseData() {
                axios.get('api/addcourse/presentation')
                    .then(response => this.courseData = response.data)
                    .catch(error => console.log(error));
            },
            getRelatedData(id) {
                axios.get('api/presentation/' + id)
                    .then(response => this.relData = response.data)
                    .catch(error => console.log(error));
            },
            onChangeCourse(event) {
                let checkVal = event.target.value;
                this.getRelatedData(checkVal);
                // this.getInstructorData(checkVal);

            },
            getResults(page) {
                if (page=='undefined')
                {
                    page=1;
                }
                axios.get('api/indsch?page=' + page)
                    .then(response => this.records = response.data)
                    .catch(error => console.log(error));
            },
            updateRecord(e) {
                e.preventDefault();
                let currentObj = this;
                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                }

                var formData = new FormData();

                formData.append('traineetype', this.form.traineetype);
                formData.append('description', this.form.description);
                formData.append('file', this.form.file);
                formData.append('trainingtype', this.form.trainingtype);
                formData.append("_method", "put");

                axios.post('api/indsch/' + this.updateId, formData, config)
                    .then(response => {
                        this.form.reset();
                        this.filename = '';
                        $("#submitBtn").removeClass('d-none');
                        $("#updateBtn").removeClass('d-block');
                        $("#updateBtn").addClass('d-none');
                        $("#submitBtn").addClass('d-block');
                        Fire.$emit('updateRecords');
                        swal('Congratulations', 'Record Stored Successfully..', 'success');
                    })
                    .catch(error => swal('Failed', 'Record Submission Failed..', 'error'));
            },
            enrolledTrainees() {
                axios.get('api/user/presentation')
                    .then(response => this.Trainees = response.data)
                    .catch(error => console.log(error));
            },
            delRec(id){
                this.currentId=id;
                this.deleteModalFlag=!this.deleteModalFlag;
            },
            deleteRecord() {
                axios.delete('api/indsch/' + this.currentId)
                    .then(response => {
                        swal('Congratulation!', 'Record Deleted Successfully..', 'warning');
                        Fire.$emit('updateRecords');
                    })
                    .catch(error => console.log(error))
            },
            editPresentation(id) {
                axios.get('api/indsch/' + id)
                    .then(response => {
                        this.form.fill(response.data);
                        $('#updateBtn').removeClass('d-none');
                        $('#updateBtn').addClass('d-block');
                        $('#submitBtn').addClass('d-none');
                        this.updateId = id;
                        this.filename = response.data.file;
                    })
                    .catch(error => console.log(error));

            }

        }

    }
</script>

<style scoped>

</style>
