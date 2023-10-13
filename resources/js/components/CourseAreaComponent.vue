<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">
                    <h3 class="text-info" v-once v-text="name"></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8 offset-2">
                            <form @submit.prevent="CourseArea" id="coursetype">
                                <div class="input-group form-group">
                                    <label for="course_area">Training Area:</label>
                                    <input autocomplete="off" autofocus class="form-control w-75 ml-5"
                                           id="course_area" name="course_area" placeholder="Training Area.." required
                                           type="text" v-model="coursearea">
                                </div>
                                <div class="input-group-append justify-content-center">
                                    <button class="btn btn-navbar text-primary" type="submit">
                                        <i class="fas fa-2x fa-plus-circle"></i>
                                    </button>
                                    <button @click="delRec" class="btn btn-navbar text-delete text-danger"
                                            disabled id="delete" type="button">
                                        <i class="fas fa-2x fa-trash"></i>
                                    </button>
                                    <button @click="updateRecord" class="btn btn-navbar text-delete text-success"
                                            disabled id="update" title="Update Record" type="button">
                                        <i class="fas fa-2x fa-pen"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-hover">
                                <tr class="text-center">
                                    <th>Sr.</th>
                                    <th>Training Area</th>
                                    <th></th>
                                </tr>
                                <tr class="text-center" v-for="(records,index) in courseareaData.data">
                                    <td>{{++index}}</td>
                                    <td :id="'td'+records.carea_id">{{records.carea_desc}}</td>
                                    <td>
                                        <a @click="selectRecord(records.carea_id)" class="pl-3">
                                            <i class="fas fa-lg fa-pen text-info">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                <pagination :data="courseareaData" @pagination-change-page="getResults"
                                            class="pagination justify-content-center"></pagination>
                            </table>
                        </div>
                    </div>
                    <DeleteCourseModal @deleteMe="deleteRecord" :delflag="deleteModalFlag"></DeleteCourseModal>
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
                name: "Define Course Area",
                coursearea: "",
                courseareaData: {},
                currentId: '',
                deleteModalFlag:false

            }
        },
        mounted() {
            Fire.$on('updateRecords', () => {
                this.getResults();
            });
            this.getResults();
        },
        methods: {

            CourseArea() {
                axios.post('api/coursearea', {coursearea: this.coursearea})
                    .then(response => {
                        swal("Congratulations!", "Data Added Successfully", "success");
                        this.coursearea = '';
                        Fire.$emit('updateRecords');
                    })
                    .catch(error => swal("Notice!", "Record Not Added,Please Try Again", "error"));
            },
            getResults(page) {
                if (page == 'undefined') {
                    page = 1;
                }
                axios.get('api/coursearea?page=' + page)
                    .then(response => this.courseareaData = response.data)
                    .catch(error => console.log(error));
            },
            selectRecord(id) {
                $('#delete').removeAttr("disabled");
                $('#update').removeAttr("disabled");
                this.currentId = id;
                let val = $("#td" + id).text();
                this.coursearea = val;
            },
            delRec(){
              this.deleteModalFlag=!this.deleteModalFlag
            },
            deleteRecord() {
                axios.delete('api/coursearea/' + this.currentId)
                    .then(response => {
                        swal("Notice!", "Record Deleted Successfully", "error");
                        Fire.$emit('updateRecords');
                        this.coursearea = '';
                    })
                    .catch(error => swal("Notice!", "Record Deletion Failed,It Exists Somewhere else..", "error"));
            },
            updateRecord() {
                axios.put('api/coursearea/' + this.currentId, {coursearea: this.coursearea})
                    .then(response => {
                        swal("Congratulations!", "Record Added Successfully", "success")
                            .then((value) => {
                                Fire.$emit('updateRecords');
                                this.coursearea="";
                            });
                    })
                    .catch(error => swal("Notice!", "Record Destruction Failed", "error"));
            }

        }
    }
</script>

<style scoped>

</style>
