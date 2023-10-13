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
                        <alert-error :form="form" message="There were some problems with your input."></alert-error>
                        <form @submit.prevent="Category" id="form">
                            <div class="input-group form-group">
                                <label for="category">Category:</label>
                                <input :class="{ 'is-invalid': form.errors.has('category') }" autocomplete="off" class="form-control w-75 ml-5" id="category" name="category" placeholder="Category Description.." type="text" v-model="form.category">
                                <has-error :form="form" field="category"></has-error>
                            </div>
                            <div class="input-group-append justify-content-center">
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
                                    <th scope="col">Library Category</th>
                                    <th scope="col">Edit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(l,index) in libData.data">
                                    <th scope="row">{{++index}}</th>
                                    <td scope="col">{{l.category}}</td>
                                    <td scope="col">
                                        <a @click="selectRecord(l.cid)">
                                            <i class="fas fa-lg fa-pen text-info" title="Edit Record"></i>
                                        </a>
                                    </td>
                                </tr>
                                <pagination :data="libData" @pagination-change-page="getResults" class="pagination justify-content-center"></pagination>
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
                    category: '',
                }),
                cardName: "Define Library Category",
                libData: {},
                currentId:''

            }
        },
        mounted() {
            this.getResults();
        },
        methods:
            {
                Category() {
                    this.form.post('api/category')
                        .then(response => {
                            swal("Congratulations!", "Library Category Added Successfully", "success")
                                .then((value) => {
                                    location.reload();
                                });
                        })
                        .catch(error => console.log(error));
                },
                getResults(page) {
                    if (page == 'undefined') {
                        page = 1;
                    }

                    this.form.get('api/category?page='+page)
                        .then(response => this.libData = response.data)
                        .catch(error => swal("Notice!", "Library Data Retrieval Failed", "error"))

                },
                selectRecord(id)
                {
                    this.form.get('api/category/'+id)
                        .then(response=>{
                            $('#delete').removeAttr("disabled");
                            $('#edit').removeAttr("disabled");
                            $('#submit').attr("disabled", 'disabled');
                            this.form.fill(response.data);
                            this.currentId=id;
                        })
                        .catch(error=>swal("Notice!", "Record data not fetched..", "error"));
                },
                deleteRecord()
                {
                    this.form.delete('api/category/'+this.currentId)
                        .then(response=>{
                            swal('Congratulations','Record Deleted Successfully..','success')
                                .then((value)=>{
                                    location.reload();
                                });
                        })
                        .catch(error=>swal('Notice!','Record Deletion Failed..','error'));
                },
                updateRecord()
                {
                    this.form.put('api/category/'+this.currentId)
                        .then(response=>{
                            swal('Congratulations','Record Updated Successfully..','success')
                                .then((value)=>{
                                    location.reload();
                                });
                        })
                        .catch(error=>swal('Notice!','Record Updation Failed..','error'));
                }
            },
        filters: {
            capitalize: function (value) {
                return value.toUpperCase();
            }
        }

    }
</script>
