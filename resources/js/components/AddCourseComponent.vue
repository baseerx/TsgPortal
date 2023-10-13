<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">
                    <h3 class="text-info" v-once v-text="name"></h3>
                </div>
                <div class="card-body">
                    <form @submit="submitData">
                        <div class="row">
                            <div class="col-2 offset-1">
                                <label for="course_desc">Description</label>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input autocomplete="off" autofocus class="form-control" id="course_desc" name="course_desc" placeholder="Training Description.." required type="text" v-model="addcourse">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 offset-1">
                                <label for="ccode">Training Code</label>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input autocomplete="off" class="form-control" id="ccode" name="ccode" placeholder="Training Code.." required type="text" v-model="coursecode">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 offset-1">
                                <label for="adesc">Area Description</label>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <select class="form-control" id="adesc" v-model="areaFor">
                                        <option :value="adata.carea_id" v-for="adata in acourseData">
                                            {{adata.carea_desc}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 offset-1">
                                <label for="ctype">Training Type</label>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <select class="form-control" id="ctype" v-model="courseFor">
                                        <option :value="cdata.coursetype_id" v-for="cdata in ccourseData">
                                            {{cdata.coursetype_desc}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div>
                                <label for="closed">Closed</label>
                                <input type="radio" name="status" value="0" id="closed" v-model="status" :checked="status===0">
                            </div>
                            <div class="pl-5">
                                <label for="open">Open</label>
                                <input type="radio" name="open" id="open" value="1" v-model="status" :checked="status===1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group-append justify-content-center">
                                    <button class="btn btn-navbar text-primary" type="submit">
                                        <i class="fas fa-2x fa-plus-circle"></i>
                                    </button>
                                    <button class="btn btn-navbar text-delete text-danger" @click="deleteRecord" type="button" id="delete" disabled>
                                        <i class="fas fa-2x fa-trash"></i>
                                    </button>
                                    <button  class="btn btn-navbar text-delete text-success" @click="updateRecord" title="Update Record" type="button" id="update" disabled>
                                        <i class="fas fa-2x fa-pen"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="container table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Code</th>
                                <th scope="col">Type</th>
                                <th scope="col">Area</th>
                                <th scope="col">Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(acd,index) in addcourseData.data">
                                <th scope="row">{{++index}}</th>
                                <td>{{acd.cdesc}}</td>
                                <td>{{acd.ccode}}</td>
                                <td>{{acd.carea_desc}}</td>
                                <td>{{acd.coursetype_desc}}</td>
                                <td><a @click="selectRecord(acd.cid)" class="pl-3">
                                    <i class="fas fa-lg fa-pen text-info">

                                    </i>
                                </a></td>
                            </tr>
                            <pagination :data="addcourseData" class="pagination justify-content-center" @pagination-change-page="getResults"></pagination>
                            </tbody>
                        </table>
                    </div>
                    <DeleteCourseModal @deleteMe="deleteRec" :delflag="deleteModalFlag"></DeleteCourseModal>
                </div>
                <div class="card-footer text-muted">
                    Tsg Portal @NTDC
                </div>
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
                name: "Define Trainings",
                addcourse: "",
                coursecode: "",
                areaFor:"",
                courseFor:"",
                acourseData: {},
                ccourseData: {},
                addcourseData: {},
                currentId: '',
                status: '',
                deleteModalFlag:false
            }
        },
        mounted() {
            this.getaDesc();
            this.getcType();
            this.getResults();
        },
        watch:{

        },
        methods: {

            submitData() {
                axios.post('api/addcourse', {courseDesc: this.addcourse,courseCode:this.coursecode,areaFor:this.areaFor,courseFor:this.courseFor,status:this.status})
                    .then(response => swal("Congratulations!", "Data Added Successfully", "success"))
                    .catch(error => swal("Notice!", "Record Not Added,Please Try Again", "error"));
            },
            getResults(page) {
                if (page == 'undefined') {
                    page = 1;
                }
                axios.get('api/addcourse?page=' + page)
                    .then(response => this.addcourseData = response.data)
                    .catch(error => console.log(error));
            },
            selectRecord(id) {
                $('#delete').removeAttr("disabled");
                $('#update').removeAttr("disabled");
                axios.get('api/addcourse/'+id)
                    .then(response=>{
                        // console.log(response.data);
                        this.addcourse=response.data.cdesc;
                        this.coursecode=response.data.ccode;
                        this.areaFor=response.data.carea_id;
                        this.courseFor=response.data.coursetype_id;
                        this.status=response.data.status;
                        this.currentId=id;
                    }).catch(error=>console.log(error));
            },
            deleteRec(){
                axios.delete('api/addcourse/' + this.currentId)
                    .then(response => {
                        swal("Notice!", "Record Deleted Successfully", "error")
                            .then((value) => {
                                this.deleteRecord()
                                location.reload();
                            });
                    })
                    .catch(error =>  swal("Notice!", "Data in hierarchy already exists", "error"));
            },
            deleteRecord() {
                this.deleteModalFlag=!this.deleteModalFlag;
            },
            updateRecord() {
                axios.put('api/addcourse/' + this.currentId, {addcourse: this.addcourse,coursecode:this.coursecode,aid:this.areaFor,cid:this.courseFor,status:this.status})
                    .then(response => {
                        swal("Congratulations!", "Record Updated Successfully", "success")
                            .then((value) => {
                                location.reload();
                            });
                    })
                    .catch(error => swal("Notice!", "Record updation Failed", "error"));
            },
            getaDesc() {
                axios.get('api/coursearea/' + 1)
                    .then(response => this.acourseData = response.data)
                    .catch(error => console.log(error));
            },
            getcType() {
                axios.get('api/coursetype/' + 1)
                    .then(response => this.ccourseData = response.data)
                    .catch(error => console.log(error));
            }

        }
    }
</script>

<style scoped>

</style>
