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
                        <form @submit.prevent="defineLibrary" id="form">
                            <alert-error :form="form" message="There were some problems with your input."></alert-error>
                            <div class="form-inline form-group justify-content-center">
                                <label>Library:</label>
                                <input v-model="form.library" type="text" name="library"
                                       placeholder="Library Description.." autocomplete="off"
                                       class="form-control w-75 ml-auto" :class="{ 'is-invalid': form.errors.has('library') }">
                                <has-error :form="form" field="library"></has-error>
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
                                    <th scope="col">Library</th>
                                    <th scope="col">Edit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(l,index) in libData.data">
                                    <th scope="row">{{++index}}</th>
                                    <td scope="col">{{l.library}}</td>
                                    <td scope="col">
                                        <a @click="selectRecord(l.lid)">
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
                    library: '',
                }),
                cardName: "Create Library",
                libData: {},
                currentId:''

            }
        },
        mounted() {
            Fire.$on('updateRecords',()=>{
                this.getResults();
            });
            this.getResults();
        },
        methods:
            {
                defineLibrary() {
                    this.form.post('api/library')
                        .then(response => {
                            swal("Congratulations!", "Library Added Successfully", "success")
                                .then((value) => {
                                    Fire.$emit('updateRecords');
                                });
                        })
                        .catch(error => console.log(error));
                },
                getResults(page) {
                    if (page == 'undefined') {
                        page = 1;
                    }

                    this.form.get('api/library?page='+page)
                        .then(response => this.libData = response.data)
                        .catch(error => swal("Notice!", "Library Data Retrieval Failed", "error"))

                },
                selectRecord(id)
                {
                    this.form.get('api/library/'+id)
                        .then(response=>{
                            $('#delete').removeAttr("disabled");
                            $('#edit').removeAttr("disabled");
                            $('#submit').attr("disabled","disabled");
                            this.form.fill(response.data);
                            this.currentId=response.data.lid;
                        })
                        .catch(error=>swal("Notice!", "Record data not fetched..", "error"));
                },
                deleteRecord()
                {
                    this.form.delete('api/library/'+this.currentId)
                        .then(response=>{
                            swal('Congratulations','Record Deleted Successfully..','success')
                                .then((value)=>{
                                    Fire.$emit('updateRecords');
                                    this.form.reset();
                                });
                        })
                        .catch(error=>swal('Notice!','Record Deletion Failed..','error'));
                },
                updateRecord()
                {
                    this.form.put('api/library/'+this.currentId)
                        .then(response=>{
                            swal('Congratulations','Record Updated Successfully..','success')
                                .then((value)=>{
                                  Fire.$emit('updateRecords');
                                });
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
