<template>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.cardName}}</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-8 offset-2">
                        <form @submit.prevent="SubLibrary" id="form">
                            <div class="input-group form-group">
                             <div class="row">
                                 <div class="col-2">
                                     <label for="cid">Category:</label>
                                 </div>
                                 <div class="col-10">
                                     <select name="cid" id="cid" :class="{ 'is-invalid': form.errors.has('cid') }" v-model="form.cid" class="form-control w-75 ml-5">
                                         <option :value="libd.cid" v-for="libd in lData">{{libd.category}}</option>
                                     </select>
                                     <has-error :form="form" field="cid"></has-error>
                                 </div>
                             </div>
                            </div>
                            <div class="input-group form-group">
                              <div class="row">
                                  <div class="col-2">
                                      <label for="slibrary">Sub-Category:</label>
                                  </div>
                                  <div class="col-10">
                                      <input :class="{ 'is-invalid': form.errors.has('slibrary') }" autocomplete="off" class="form-control w-75 ml-5" name="slibrary" id="slibrary" placeholder="Library Sub-Category.." type="text" v-model="form.slibrary">
                                      <has-error :form="form" field="slibrary"></has-error>
                                  </div>
                              </div>
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
                                    <th scope="col">Category</th>
                                    <th scope="col">Sub-Category</th>
                                    <th scope="col">Edit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(l,index) in slibData.data">
                                    <th scope="row">{{++index}}</th>
                                    <td scope="col">{{l.category}}</td>
                                    <td scope="col">{{l.slibrary}}</td>
                                    <td scope="col">
                                        <a @click="selectRecord(l.sid)">
                                            <i class="fas fa-lg fa-pen text-info" title="Edit Record"></i>
                                        </a>
                                    </td>
                                </tr>
                                <pagination :data="slibData" @pagination-change-page="getResults" class="pagination justify-content-center"></pagination>
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
                    cid:'',
                    slibrary: ''
                }),
                cardName: "Create Library Sub Category",
                slibData: {},
                lData: {},
                currentId:''

            }
        },
        mounted() {
            this.libData();
            this.getResults();
        },
        methods:
            {
                SubLibrary() {
                    this.form.post('api/slibrary')
                        .then(response => {
                            swal("Congratulations!", "Sub Category Of Library Added Successfully", "success")
                                .then((value) => {
                                    location.reload();
                                });
                        })
                        .catch(error => swal("Notice!", "Library Creation Failed", "error"));
                },
                getResults(page) {
                    if (page == undefined) {
                        page = 1;
                    }

                    this.form.get('api/slibrary?page='+page)
                        .then(response => this.slibData = response.data)
                        .catch(error => console.log(error));

                },
                selectRecord(id)
                {
                    this.form.get('api/slibrary/'+id)
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
                    this.form.put('api/slibrary/'+this.currentId)
                        .then(response=>{
                            swal('Congratulations','Record Updated Successfully..','success')
                                .then((value)=>{
                                    location.reload();
                                });
                        })
                        .catch(error=>swal('Notice!','Record Updation Failed..','error'));
                },
                libData()
                {
                      axios.get('api/category/catData')
                          .then(response=>{
                              this.lData=response.data;
                          })
                          .catch(error=>console.log(error));
                }
            },
        filters: {
            capitalize: function (value) {
                return value.toUpperCase();
            }
        }

    }
</script>
