<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.name}}</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="ctype">Training Type</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control" @change="enrolledTrainees" id="ctype" v-model="trainingtype">
                                    <option :value="cdata.cid" v-for="cdata in ccourseData">
                                        {{cdata.coursetype_desc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <label for="cdate">Certificate Date</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input type="text" required placeholder="dd-mm-yyyy" class="form-control"  id="cdate" v-model="certificateDate">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2 text-right">
                            <label for="ctype">Trainee</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select class="form-control" id="ttype" v-model="traineetype">
                                    <option :value="t.tid" v-for="t in Trainees">
                                        {{t.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a :href="genCertUrl" type="submit" class="btn btn-info text-white" target="_blank">Generate Report</a></div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                trainingtype: '',
                traineetype: '',
                name: "Certificates Section",
                genCertUrl: '',
                updateId: 0,
                courseData: {},
                relData: {},
                records: {},
                ccourseData: {},
                filename: '',
                Trainees: {},
                certificateDate:''
            }
        },
        mounted() {
            this.getcType();
            this.enrolledTrainees();
            this.getCourseData();
        },
        watch: {
            traineetype:function () {
               this.genCertUrl= '/certificates/'+this.traineetype+'*'+this.certificateDate;
            }

        },
        methods: {
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
            getResults() {
                axios.get('api/indsch')
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
                axios.get('api/user/cid-'+this.trainingtype)
                    .then(response => this.Trainees = response.data)
                    .catch(error => console.log(error));
            },
            deleteRecord(id) {
                axios.delete('api/indsch/' + id)
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

            },

        }

    }
</script>

<style scoped>

</style>
