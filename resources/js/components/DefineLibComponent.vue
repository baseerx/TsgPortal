<template>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.cardName}}</h4>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form @submit.prevent="LibraryTrans" id="form" class="justify-content-center">
                    <div class="row">
                        <div class="col-4 offset-3">
                            <div class="form-group">
                                <label for="category">Library Class</label>
                                <select name="category" id="category" :class="{ 'is-invalid': form.errors.has('lib_class') }" v-model="form.lib_class" class="form-control">
                                    <option value="" selected>Library Class</option>
                                    <option value="main_library">Main Library</option>
                                    <option value="sub_library">Sub Library</option>
                                </select>
                                <has-error :form="form" field="lib_class"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="category_description">Description:</label>
                                <select name="category_description" id="category_description" :class="{ 'is-invalid': form.errors.has('category_description') }" v-model="form.category_description" class="form-control">
                                    <option value="" selected>Description</option>
                                    <option v-for="d in lData" :value="d.lid">{{d.library}}</option>
                                </select>
                                <has-error :form="form" field="category_description"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="scategory">Sub Category</label>
                                <select name="scategory" id="scategory" :class="{ 'is-invalid': form.errors.has('scategory') }" v-model="form.scategory" class="form-control">
                                    <option value="" selected>Sub Category</option>
                                    <option v-for="d in sData.data" :value="d.sid">{{d.slibrary}}</option>
                                </select>
                                <has-error :form="form" field="scategory"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="user">User Id</label>
                                <input :class="{ 'is-invalid': form.errors.has('user') }" autocomplete="off" class="form-control" name="user" id="user" placeholder="User ID" type="text" v-model="form.user">
                                <has-error :form="form" field="user"></has-error>
                            </div>
                            <div class="input-group-append justify-content-center">
                                <button class="btn btn-navbar text-primary" type="submit">
                                    <i class="fas fa-2x fa-plus-circle"></i>
                                </button>
                                <button class="btn btn-navbar text-danger" @click="deleteRecord" id="delete" disabled type="button">
                                    <i class="fas fa-2x fa-trash"></i>
                                </button>
                                <button class="btn btn-navbar text-success" @click="updateRecord" id="edit" disabled type="button">
                                    <i class="fas fa-2x fa-pen"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!--<div class="container table-responsive">-->
                    <!--<table class="table table-hover">-->
                        <!--<thead>-->
                        <!--<tr>-->
                            <!--<th scope="col">#</th>-->
                            <!--<th scope="col">Category</th>-->
                            <!--<th scope="col">Library</th>-->
                            <!--<th scope="col">Sub Library</th>-->
                            <!--<th scope="col">User Id</th>-->
                            <!--<th scope="col">Edit</th>-->
                        <!--</tr>-->
                        <!--</thead>-->
                        <!--<tbody>-->
                        <!--<tr v-for="(l,index) in slibData.data">-->
                            <!--<th scope="row">{{++index}}</th>-->
                            <!--<td scope="col">{{l.category}}</td>-->
                            <!--<td scope="col">{{l.library}}</td>-->
                            <!--<td scope="col">{{l.slibrary}}</td>-->
                            <!--<td scope="col">{{l.user}}</td>-->
                            <!--<td scope="col">-->
                                <!--<a @click="selectRecord(l.trid)">-->
                                    <!--<i class="fas fa-lg fa-pen text-info" title="Edit Record"></i>-->
                                <!--</a>-->
                            <!--</td>-->
                        <!--</tr>-->
                        <!--<pagination :data="slibData" @pagination-change-page="getResults" class="pagination justify-content-center"></pagination>-->
                        <!--</tbody>-->
                    <!--</table>-->
                <!--</div>-->
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
                    lib_class:'',
                    category_description: '',
                    scategory: '',
                    user:''
                }),
                cardName: "Library Transactions",
                slibData: {},
                lData: {},
                sData: {},
                currentId:''

            }
        },
        mounted() {
            this.getResults();
            this.libData();
            this.sublibData();
        },
        methods:
            {
                LibraryTrans() {
                    this.form.post('api/libtrans')
                        .then(response => {
                            swal("Congratulations!", "Data Added Successfully", "success")
                                .then((value) => {
                                    location.reload();
                                });
                        })
                        .catch(error => swal("Notice!", "Data Creation Failed", "error"));
                },
                getResults(page) {
                    if (page == 'undefined') {
                        page = 1;
                    }

                    this.form.get('api/libtrans?page='+page)
                        .then(response => this.slibData = response.data)
                        .catch(error => swal("Notice!", "Library Data Retrieval Failed", "error"))

                },
                selectRecord(id)
                {
                    this.form.get('api/libtrans/'+id)
                        .then(response=>{
                            $('#delete').removeAttr("disabled");
                            $('#edit').removeAttr("disabled");
                            this.form.fill(response.data);
                            this.currentId=id;
                        })
                        .catch(error=>swal("Notice!", "Record data not fetched..", "error"));
                },
                deleteRecord()
                {
                    this.form.delete('api/libtrans/'+this.currentId)
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
                    this.form.put('api/libtrans/'+this.currentId)
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
                    axios.get('api/library/libtrans')
                        .then(response=>{
                            this.lData=response.data;
                        })
                        .catch(error=>console.log(error));
                },
                sublibData()
                {

                    axios.get('api/slibrary/slibtrans')
                        .then(response=>{
                            this.sData=response;
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
