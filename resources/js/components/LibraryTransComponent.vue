<template>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.cardName}}</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                    <form @submit.prevent="LibraryTrans" id="form">
                        <alert-error :form="form"
                                     message="please fill all the fields..data submission failed"></alert-error>
                        <div class="form-group row py-0 my-0">
                            <label class="col-2 col-form-label" for="library">Library</label>
                            <div class="col-4">
                                <select :class="{ 'is-invalid': form.errors.has('library') }" class="form-control w-75"
                                        id="library" name="library" v-model="form.library">
                                    <option :value="lib.lid" v-for="lib in lData">{{lib.library}}</option>
                                </select>
                                <has-error :form="form" field="library"></has-error>
                            </div>
                            <label class="col-2 col-form-label" for="category">Category</label>
                            <div class="col-4">
                                <select :class="{ 'is-invalid': form.errors.has('category') }" class="form-control w-75"
                                        id="category" name="category" v-model="form.category">
                                    <option :value="cat.cid" v-for="cat in cData">{{cat.category}}</option>
                                </select>
                                <has-error :form="form" field="category"></has-error>
                            </div>
                        </div>

                        <div class="form-group row my-0 py-0 justify-content-center">
                            <label class="col-2 col-form-label" for="scategory">Sub Catg</label>
                            <div class="col-4">
                                <select :class="{ 'is-invalid': form.errors.has('scategory') }"
                                        class="form-control w-75"
                                        id="scategory" name="scategory" v-model="form.scategory">
                                    <option :value="sub.sid" v-for="sub in sData">{{sub.slibrary}}</option>
                                </select>
                                <has-error :form="form" field="scategory"></has-error>
                            </div>

                            <label class="col-2 col-form-label" for="description">Title</label>
                            <div class="col-4">
                                <input :class="{ 'is-invalid': form.errors.has('description') }"
                                       class="form-control w-75"
                                       id="description" name="description" placeholder="Description"
                                       v-model="form.description">
                                <has-error :form="form" field="description"></has-error>
                            </div>
                        </div>

                        <div class="form-group row py-0 my-0">
                            <label class="col-2 col-form-label">D.O.P</label>
                            <div class="col-4">
                                <Datepicker calendar-button-icon="fa fa-calendar-alt" format="dd-MM-yyyy"
                                            input-class="form-control w-75" placeholder="D.O.P"
                                            v-model="form.dop"></Datepicker>
                            </div>
                            <label class="col-2 col-form-label">D.O.E</label>
                            <div class="col-4">
                                <Datepicker calendar-button-icon="fa fa-calendar-alt" format="dd-MM-yyyy"
                                            input-class="form-control w-75" placeholder="D.O.E"
                                            v-model="form.doe"></Datepicker>
                            </div>
                        </div>
                        <div class="form-group row my-0 py-0 justify-content-center">
                            <label class="col-2 col-form-label" for="price">Price</label>
                            <div class="col-4">
                                <input :class="{ 'is-invalid': form.errors.has('price') }" class="form-control w-75"
                                       id="price" name="price" placeholder="Price" v-model="form.price">
                                <has-error :form="form" field="price"></has-error>
                            </div>
                            <label class="col-2 col-form-label" for="book_code">Book Code</label>
                            <div class="col-4">
                                <input :class="{ 'is-invalid': form.errors.has('book_code') }" class="form-control w-75"
                                       id="book_code" name="book_code" placeholder="Book Code"
                                       v-model="form.book_code">
                                <has-error :form="form" field="book_code"></has-error>
                            </div>
                        </div>
                        <div class="form-group row my-0 py-0 justify-content-center">
                            <label class="col-2 col-form-label" for="author_name">Author Name</label>
                            <div class="col-4">
                                <input :class="{ 'is-invalid': form.errors.has('author_name') }"
                                       class="form-control w-75"
                                       id="author_name" name="author_name" placeholder="Author Name"
                                       v-model="form.author_name">
                                <has-error :form="form" field="author_name"></has-error>
                            </div>
                            <label class="col-2 col-form-label" for="publisher">Publisher</label>
                            <div class="col-4">
                                <input :class="{ 'is-invalid': form.errors.has('publisher') }" class="form-control w-75"
                                       id="publisher" name="publisher" placeholder="Publisher"
                                       v-model="form.publisher">
                                <has-error :form="form" field="publisher"></has-error>
                            </div>
                        </div>
                        <div class="form-group row my-0 py-0 justify-content-center">
                            <label class="col-2 col-form-label" for="author_name">Distributor</label>
                            <div class="col-4">
                                <input :class="{ 'is-invalid': form.errors.has('distributor') }"
                                       class="form-control w-75"
                                       id="distributor" name="distributor" placeholder="Distributor"
                                       v-model="form.distributor">
                                <has-error :form="form" field="distributor"></has-error>
                            </div>
                            <label class="col-2 col-form-label" for="file">File</label>
                            <div class="col-4">
                                <div class="custom-file w-75">
                                    <input @change="handleFileUpload" class="custom-file-input form-control" id="file"
                                           name="file" type="file">
                                    <label class="custom-file-label" for="file" v-text="filename"></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row my-0 py-0 justify-content-center">
                            <label class="col-2 col-form-label" for="filedesc">File Description</label>
                            <div class="col-4">
                                <input :class="{ 'is-invalid': form.errors.has('filedesc') }" class="form-control w-75"
                                       id="filedesc" name="filedesc" placeholder="File Description"
                                       v-model="form.filedesc">
                                <has-error :form="form" field="filedesc"></has-error>
                            </div>
                        </div>
                        <div class="form-group form-check-inline d-flex flex-row justify-content-around">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" id="book" name="customRadio" type="radio"
                                       v-model="form.filetype" value="book">
                                <label class="custom-control-label" for="book">Book</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" id="video" name="customRadio" type="radio"
                                       v-model="form.filetype" value="video">
                                <label class="custom-control-label" for="video">Video</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" id="audio" name="customRadio" type="radio"
                                       v-model="form.filetype" value="audio">
                                <label class="custom-control-label" for="audio">Audio</label>
                            </div>
                        </div>
                        <!--Button Section Starts Here-->
                        <div class="input-group-append justify-content-center">
                            <button class="btn btn-navbar text-primary" id="submit" type="submit">
                                <i class="fas fa-2x fa-plus-circle"></i>
                            </button>
                            <button @click="deleteRecord" class="btn btn-navbar text-danger" disabled id="delete"
                                    type="button">
                                <i class="fas fa-2x fa-trash"></i>
                            </button>
                            <button @click="updateRecord" class="btn btn-navbar text-success" disabled id="edit"
                                    type="button">
                                <i class="fas fa-2x fa-pen"></i>
                            </button>
                        </div>
                    </form>



            </div>
            <!-- /.card-body -->
        </div>
        <div class="container table-responsive mt-2">
            <table class="table table-hover">
                <thead>
                    <th scope="col">Sr</th>
                    <th scope="col">Library</th>
                    <th scope="col">Category</th>
                    <th scope="col">SCat</th>
                    <th scope="col">Title</th>
                    <th scope="col">Book Code</th>
                    <th scope="col">Author Name</th>
                    <th scope="col">Edit</th>
                </thead>
                <tbody>
                <tr v-for="(l,index) in transData.data">
                    <td scope="col">{{++index}}</td>
                    <td scope="col">{{l.library}}</td>
                    <td scope="col">{{l.category}}</td>
                    <td scope="col">{{l.slibrary}}</td>
                    <td scope="col">{{l.description}}</td>
                    <td scope="col">{{l.book_code}}</td>
                    <td scope="col">{{l.author_name}}</td>
                    <td scope="col">
                        <a @click="selectRecord(l.trid)">
                            <i class="fas fa-lg fa-pen text-info" title="Edit Record"></i>
                        </a>
                    </td>

                </tr>

                </tbody>
            </table>
            <pagination :data="transData" @pagination-change-page="getResults"
                        class="pagination justify-content-center"></pagination>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    // import UpdateUserModal from "./UpdateUserModal";
    export default {
        // components: {
        //     'update-modal': UpdateUserModal
        // },
        components: {
            Datepicker
        },
        data() {
            return {
                form: new Form({
                    library: '',
                    category: '',
                    scategory: '',
                    description: '',
                    dop: '',
                    doe: '',
                    price: '',
                    book_code: '',
                    author_name: '',
                    publisher: '',
                    distributor: '',
                    filetype: '',
                    filedesc: '',
                    file: ''
                }),
                progressBar: 'd-none',
                filename: '',
                cardName: "Library Transactions",
                transData: {},
                lData: {},
                sData: {},
                currentId: '',
                cData: {}

            }
        },
        mounted() {
            Fire.$on('updateRecords', () => {
                this.getResults();
            });
            this.getResults();
            this.libData();
            this.catData();
            this.sublibData();
        },
        methods:
            {
                LibraryTrans() {

                    let currentObj = this;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    }
                    let formData = new FormData();
                    let dop = this.form.dop;
                    let doe = this.form.doe;
                    if (dop !== "" || doe !== "") {
                        this.form.dop = new Date(dop.getTime() - (dop.getTimezoneOffset() * 60000)).toJSON();
                        this.form.doe = new Date(doe.getTime() - (doe.getTimezoneOffset() * 60000)).toJSON();
                    }

                    formData.append('library', this.form.library);
                    formData.append('category', this.form.category);
                    formData.append('scategory', this.form.scategory);
                    formData.append('description', this.form.description);
                    formData.append('dop', this.form.dop);
                    formData.append('doe', this.form.doe);
                    formData.append('price', this.form.price);
                    formData.append('book_code', this.form.book_code);
                    formData.append('author_name', this.form.author_name);
                    formData.append('publisher', this.form.publisher);
                    formData.append('distributor', this.form.distributor);
                    formData.append('file', this.form.file);
                    formData.append('filetype', this.form.filetype);
                    formData.append('filedesc', this.form.filedesc);
                     this.progressBar='d-block';
                    axios.post('api/libtrans', formData, config)
                        .then(response => {
                            swal("Congratulations!", "Data Added Successfully", "success")
                                .then((value) => {
                                    this.progressBar='d-none';
                                    Fire.$emit('updateRecords');
                                    this.filename = "";
                                    this.form.reset();
                                });
                        })
                        .catch(error => swal("Notice!", "Data Creation Failed", "error"));
                },
                handleFileUpload(e) {

                    let file = e.target.files[0];
                    this.form.file = e.target.files[0];
                    this.filename = file.name;
                },
                getResults(page) {
                    if (page == 'undefined') {
                        page = 1;
                    }
                    this.form.get('api/libtrans?page=' + page)
                        .then(response => this.transData = response.data)
                        .catch(error => console.log(error));

                },
                catData() {
                    axios.get('api/category/catData')
                        .then(response => {
                            this.cData = response.data;
                        })
                        .catch(error => console.log(error));
                },
                selectRecord(id) {

                    this.form.get('api/libtrans/' + id)
                        .then(response => {
                            $('#delete').removeAttr("disabled");
                            $('#edit').removeAttr("disabled");
                            $('#submit').attr("disabled", "disabled");
                            this.form.fill(response.data);
                            this.filename = response.data.file;
                            this.form.filetype = response.data.type;
                            this.currentId = id;
                        })
                        .catch(error => swal("Notice!", "Record data not fetched..", "error"));
                },
                deleteRecord() {
                    this.form.delete('api/libtrans/' + this.currentId)
                        .then(response => {
                            swal('Congratulations', 'Record Deleted Successfully..', 'success')
                                .then((value) => {
                                    Fire.$emit('updateRecords');
                                    this.form.reset();
                                    this.filename = "";
                                });
                        })
                        .catch(error => swal('Notice!', 'Record Deletion Failed As Data Exists In Parent Table..', 'error'));
                },
                updateRecord() {
                    let currentObj = this;
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    }
                    let formData = new FormData();
                    let dop = this.form.dop;
                    let doe = this.form.doe;
                    if (dop.toString().includes("GMT")) {
                        this.form.dop = new Date(dop.getTime() - (dop.getTimezoneOffset() * 60000)).toJSON();
                        let splitDate = this.form.dop.toString().split('T');
                        this.form.dop = splitDate[0];
                    }
                    if (doe.toString().includes("GMT")) {
                        this.form.doe = new Date(doe.getTime() - (doe.getTimezoneOffset() * 60000)).toJSON();
                        let splitDate = this.form.doe.toString().split('T');
                        this.form.doe = splitDate[0];
                    }

                    formData.append('library', this.form.library);
                    formData.append('category', this.form.category);
                    formData.append('scategory', this.form.scategory);
                    formData.append('description', this.form.description);
                    formData.append('dop', this.form.dop);
                    formData.append('doe', this.form.doe);
                    formData.append('price', this.form.price);
                    formData.append('book_code', this.form.book_code);
                    formData.append('author_name', this.form.author_name);
                    formData.append('publisher', this.form.publisher);
                    formData.append('distributor', this.form.distributor);
                    formData.append('file', this.form.file);
                    formData.append('filetype', this.form.filetype);
                    formData.append('filedesc', this.form.filedesc);
                    formData.append("_method", "put");

                    axios.post('api/libtrans/' + this.currentId, formData, config)
                        .then(response => {
                            swal('Congratulations', 'Record Updated Successfully..', 'success')
                                .then((value) => {
                                    Fire.$emit('updateRecords');
                                    this.form.reset();
                                    this.filename = "";
                                });
                        })
                        .catch(error => swal('Notice!', 'Record Updation Failed..', 'error'));
                },
                libData() {
                    axios.get('api/library/libtrans')
                        .then(response => {
                            this.lData = response.data;
                        })
                        .catch(error => console.log(error));
                },
                sublibData() {

                    axios.get('api/slibrary/slibtrans')
                        .then(response => {
                            this.sData = response.data;
                        })
                        .catch(error => console.log(error));
                }
            },
        filters: {
            capitalize: function (value) {
                return value.toUpperCase();
            }
        }

    }
</script>
