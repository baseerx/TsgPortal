<template>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.cardName}}</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <alert-error :form="form" message="There were some problems with your input."></alert-error>
                <div class="row">
                    <div class="col-8 offset-2">
                        <form @submit.prevent="CourseInstructor" id="form">
                            <div class="input-group form-group">
                                <label>Instructor</label>
                                <select instructor="ins_id" id="ins_id" :class="{ 'is-invalid': form.errors.has('ins_id') }" v-model="form.ins_id" class="form-control-sm w-75 ml-auto">
                                    <option :value="i.ins_id" v-for="i in iData">{{i.name}}</option>
                                </select>
                                <has-error :form="form" field="instructor"></has-error>
                            </div>
                            <div class="input-group form-group">
                                <label>Training</label>
                                <select name="course_id" id="course_id" :class="{ 'is-invalid': form.errors.has('course_id') }" v-model="form.course_id" class="form-control-sm w-75 ml-auto">
                                    <option :value="ci.cid" v-for="ci in cinsData">{{ci.cdesc}}</option>
                                </select>
                                <has-error :form="form" field="course_id"></has-error>
                            </div>
                            <div class="input-group-append justify-content-center pl-5">
                                <button class="btn btn-navbar text-primary" type="submit" id="submit">
                                    <i class="fas fa-2x fa-plus-circle"></i>
                                </button>
                                <button class="btn btn-navbar text-danger" @click="deleteRecord" id="delete" disabled type="button">
                                    <i class="fas fa-2x fa-trash"></i>
                                </button>
                                <button class="btn btn-navbar text-success" @click="updateRecord" id="edit" disabled type="button">
                                    <i class="fas fa-2x fa-pen"></i>
                                </button>
                            </div>
                        </form>
                        <div class="container table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Instructor</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Edit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(l,index) in ciData.data">
                                    <th scope="row">{{++index}}</th>
                                    <td scope="col">{{l.name}}</td>
                                    <td scope="col">{{l.cdesc}}</td>
                                    <td scope="col">
                                        <a @click="selectRecord(l.ci_id)">
                                            <i class="fas fa-lg fa-pen text-info" title="Edit Record"></i>
                                        </a>
                                    </td>
                                </tr>
                                <pagination :data="ciData" @pagination-change-page="getResults" class="pagination justify-content-center"></pagination>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</template>

<script>
    // import UpdateUserModal from "./UpdateUserModal";
    export default {
        // components: {
        //     'update-modal': UpdateUserModal
        // },
        data() {
            return {
                form: new Form({
                    ins_id:'',
                    course_id: ''
                }),
                cardName: "Course related to instructor..",
                ciData: {},
                cinsData: {},
                iData: {},
                currentId:''

            }
        },
        mounted() {
            this.courseData();
            this.instructorData();
            this.getResults();
        },
        methods:
            {
                CourseInstructor() {
                    this.form.post('api/cinstructor')
                        .then(response => {
                            swal("Congratulations!", "Data Added Successfully", "success")
                                .then((value) => {
                                    location.reload();
                                });
                        })
                        .catch(error => swal("Notice!", "Record Submission Failed", "error"));
                },
                getResults(page) {
                    if (page == 'undefined') {
                        page = 1;
                    }

                    this.form.get('api/cinstructor?page='+page)
                        .then(response => this.ciData = response.data)
                        .catch(error => console.log(error));

                },
                selectRecord(id)
                {
                    this.form.get('api/cinstructor/'+id)
                        .then(response=>{
                            $('#delete').removeAttr("disabled");
                            $('#edit').removeAttr("disabled");
                            $('#submit').attr("disabled","disabled");
                            this.form.fill(response.data);
                            this.currentId=id;
                        })
                        .catch(error=>swal("Notice!", "Record data not fetched..", "error"));
                },
                deleteRecord()
                {
                    this.form.delete('api/slibrary/'+this.currentId)
                        .then(response=>{
                            swal('Congratulations','Record Deleted Successfully..','success')
                                .then((value)=>{
                                    location.reload();
                                });
                        })
                        .catch(error=>swal('Notice!','Record Deletion Failed As Data Exists In Parent Table..','error'));
                },
                updateRecord()
                {
                    this.form.put('api/cinstructor/'+this.currentId)
                        .then(response=>{
                            swal('Congratulations','Record Updated Successfully..','success')
                                .then((value)=>{
                                    location.reload();
                                });
                        })
                        .catch(error=>swal('Notice!','Record Updation Failed..','error'));
                },
                courseData()
                {
                    axios.get('api/cinstructor/cinstructor')
                        .then(response=>{
                            this.cinsData=response.data;
                        })
                        .catch(error=>console.log(error));
                },
                instructorData()
                {
                    axios.get('api/cinstructor/instructor')
                        .then(response=>{
                            this.iData=response.data;
                        })
                        .catch(error=>console.log(error));                }
            },
        filters: {
            capitalize: function (value) {
                return value.toUpperCase();
            }
        }

    }
</script>
