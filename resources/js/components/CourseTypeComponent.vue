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
                            <form id="coursetype" @submit.prevent="defineCourse">
                                <div class="input-group form-group">
                                    <label for="course_type">Training Type:</label>
                                    <input class="form-control w-75 ml-5" v-model="coursetype" id="course_type" name="course_type" autocomplete="off" placeholder="Training Type.." required type="text">
                                </div>
                                <div class="input-group-append justify-content-center">
                                    <button type="submit" class="btn btn-navbar text-primary">
                                        <i class="fas fa-2x fa-plus-circle"></i>
                                    </button>
                                    <button class="btn btn-navbar text-delete text-danger" @click="delRec" type="button" id="delete" disabled>
                                        <i class="fas fa-2x fa-trash"></i>
                                    </button>
                                    <button  class="btn btn-navbar text-delete text-success" @click="updateRecord" title="Update Record" type="button" id="update" disabled>
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
                                    <th>Training Type</th>
                                    <th></th>
                                </tr>
                                <tr  class="text-center" v-for="(records,index) in coursetypeData.data">
                                    <td>{{++index}}</td>
                                    <td :id="'td'+records.coursetype_id">{{records.coursetype_desc}}</td>
                                    <td>
                                        <a @click="selectRecord(records.coursetype_id)" class="pl-3">
                                            <i class="fas fa-lg fa-pen text-info">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                <pagination :data="coursetypeData" class="pagination justify-content-center" @pagination-change-page="getResults"></pagination>
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
import DeleteCourseModal from './DeleteCourseModal'
    export default {
        components:{
          DeleteCourseModal
        },
        data() {
            return {
                name: "Define Course Type",
                coursetype:"",
                coursetypeData:{},
                currentId:'',
                deleteModalFlag:false
            }
        },
        mounted() {
            Fire.$on('updateRecords',()=>{
                this.getResults();
            });
            this.getResults();
        },
        methods: {

            defineCourse()
            {
               axios.post('api/coursetype',{coursetype: this.coursetype})
                   .then(response=>{
                       swal("Congratulations!", "Data Added Successfully", "success");
                       this.coursetype='';
                       Fire.$emit('updateRecords');
                   })
                   .catch(error=>swal("Notice!", "Record Not Added,Please Try Again", "error"));
            },
            getResults(page)
            {
                if (page=='undefined')
                {
                    page=1;
                }
                axios.get('api/coursetype?page='+page)
                    .then(response=>this.coursetypeData=response.data)
                    .catch(error=>console.log(error));
            },
            selectRecord(id)
            {
                $('#delete').removeAttr("disabled");
                $('#update').removeAttr("disabled");
                this.currentId=id;
               let val=$("#td"+id).text();
               this.coursetype=val;
            },
            deleteRecord()
            {
                axios.delete('api/coursetype/'+this.currentId)
                    .then(response=>{
                        swal("Notice!", "Record Deleted Successfully", "error")
                            .then((value)=>{
                                Fire.$emit('updateRecords');
                                this.coursetype='';
                            });
                    })
                    .catch(error=>swal("Notice!", "Record Exists Somewhere else..Failed,", "error"));
            },
            delRec(){
              this.deleteModalFlag=!this.deleteModalFlag;
            },
            updateRecord()
            {
                axios.put('api/coursetype/'+this.currentId,{coursetype:this.coursetype})
                    .then(response=>{
                        swal("Congratulations!", "Record Added Successfully", "success")
                            .then((value)=>{
                                Fire.$emit('updateRecords');
                            });
                    })
                    .catch(error=>swal("Notice!", "Record Destruction Failed", "error"));
            }

        }
    }
</script>

<style scoped>

</style>
