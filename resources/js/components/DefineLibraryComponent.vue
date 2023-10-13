<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.name}}</h4>

            </div>
            <div class="card-body">
                <form @submit="createLibrary">

                    <div class="form-group row">
                        <div class="col-1 text-right"><label>Author</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('author') }" class="form-control" id="author" name="author" type="text"
                                   v-model="form.author">
                            <has-error :form="form" field="author"></has-error>
                        </div>
                        <div class="col-2 text-right">
                            <label>File</label>
                        </div>
                        <div class="col-4">
                            <div class="custom-file">
                                <input @change="handleFileUpload" class="custom-file-input form-control" id="file" name="file"
                                       type="file">
                                <label class="custom-file-label" for="file" v-text="filename"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-1 text-right"><label>Description</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('description') }" class="form-control" id="description" name="description"
                                   type="text" v-model="form.description">
                            <has-error :form="form" field="description"></has-error>
                        </div>
                        <div class="col-2 text-right"><label>Category</label></div>
                        <div class="col-4">
                            <select :class="{ 'is-invalid': form.errors.has('category') }" class="form-control"
                                     v-model="form.category">
                                <option v-for="cat in categoryData" :value="cat.lid">{{cat.library}}</option>
                            </select>
                            <has-error :form="form" field="category"></has-error>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" id="submitBtn" name="submitBtn" type="submit"
                                v-text="btnName"></button>
                        <button @click="updateRecord" class="btn btn-success d-none" id="updateBtn" name="updateBtn"
                                type="button">Update
                        </button>
                    </div>
                    <alert-error :form="form" message="Fill all the fields correctly.."></alert-error>
                </form>
                <div class="row mt-2">
                    <div class="col-12 table-responsive">
                        <table class="table table-hover">
                            <tr class="text-center">
                                <th>Sr.</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>File</th>
                                <th>Download</th>
                                <th></th>
                            </tr>
                            <tr class="text-center" v-for="(records,index) in records.data">
                                <td>{{++index}}</td>
                                <td>{{records.author}}</td>
                                <td>{{records.library}}</td>
                                <td>{{records.description}}</td>
                                <td>{{records.filename}}</td>
                                <td><a :href="'../library/'+records.filename" :title="records.filename"><i
                                    class="fas fa-2x fa-file-download"></i></a></td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center">
                                        <a @click="editLibrary(records.libraryid)">
                                            <i class="fas fa-lg fa-pen text-info">

                                            </i>
                                        </a>
                                        <a @click="deleteRecord(records.libraryid)" class="pl-3">
                                            <i class="fas fa-lg fa-trash text-danger">

                                            </i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <pagination :data="records" @pagination-change-page="getResults"
                                        class="pagination justify-content-center"></pagination>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    author: '',
                    description: '',
                    file: '',
                    category: ''
                }),
                name: "Define Library",
                btnName: 'Submit',
                updateId: 0,
                records: {},
                categoryData: {},
                filename: ''
            }
        },
        mounted() {
            Fire.$on('updateRecords', () => {
                this.getResults();
            });
            this.getCategory();
            this.getResults();
            // this.getSchedulesData();
            // this.getInstructorData();
        },
        watch: {},
        methods: {
            handleFileUpload(e) {

                let file = e.target.files[0];
                this.form.file = e.target.files[0];
                this.filename = file.name;
            },
            createLibrary(e) {
                e.preventDefault();


                let currentObj = this;

                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                }
                let formData = new FormData();
                formData.append('author', this.form.author);
                formData.append('description', this.form.description);
                formData.append('category', this.form.category);
                formData.append('file', this.form.file);

                axios.post('api/definelib', formData, config)
                    .then(response => {
                        this.form.reset();
                        this.filename = '';
                        Fire.$emit('updateRecords');
                        swal('Congratulations', 'Record Stored Successfully..', 'success');
                    })
                    .catch(error => swal('Failed', 'Record Submission Failed..', 'error'));
            },
            getCategory() {
                axios.get('api/definelib/category')
                    .then(response => this.categoryData = response.data)
                    .catch(error => swal("Notice!", "Library Data Retrieval Failed", "error"))
            },
            getRelatedData(id) {
                axios.get('api/definelib/' + id)
                    .then(response => this.relData = response.data)
                    .catch(error => console.log(error));
            },
            onChangeCourse(event) {
                let checkVal = event.target.value;
                this.getRelatedData(checkVal);
                // this.getInstructorData(checkVal);

            },
            getResults() {
                axios.get('api/definelib')
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

                formData.append('author', this.form.author);
                formData.append('description', this.form.description);
                formData.append('file', this.form.file);
                formData.append('category', this.form.category);
                formData.append("_method", "put");

                axios.post('api/definelib/' + this.updateId, formData, config)
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
            deleteRecord(id) {
                axios.delete('api/definelib/' + id)
                    .then(response => {
                        swal('Congratulation!', 'Record Deleted Successfully..', 'warning');
                        Fire.$emit('updateRecords');
                    })
                    .catch(error => console.log(error))
            },
            editLibrary(id) {

                let str = 'lib-' + id;
                axios.get('api/definelib/' + str)
                    .then(response => {
                        this.getRelatedData(response.data.course);
                        this.form.fill(response.data);
                        $('#updateBtn').removeClass('d-none');
                        $('#updateBtn').addClass('d-block');
                        $('#submitBtn').addClass('d-none');
                        this.updateId = id;
                        this.filename = response.data.filename;
                    })
                    .catch(error => console.log(error));

            }

        }

    }
</script>

<style scoped>

</style>
