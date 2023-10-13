<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{name}}</h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="makePaper">
                    <div class="row">
                        <div class="col-2 text-center">
                            <label for="question">Question</label>
                        </div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('question') }" autocomplete="off"
                                   class="form-control" id="question" name="question"
                                   placeholder="Question Here.."
                                   type="text" v-model="form.question">
                            <has-error :form="form" field="question"></has-error>
                        </div>
                        <div class="col-2 text-center">
                            <label for="foption">First Option</label>
                        </div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('first') }" autocomplete="off"
                                   class="form-control" id="foption" name="foption"
                                   placeholder="A:option"
                                   type="text"
                                   v-model="form.first">
                            <has-error :form="form" field="first"></has-error>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-2 text-center">
                            <label for="soption">Second Option</label>
                        </div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('second') }" autocomplete="off"
                                   class="form-control" id="soption" name="soption"
                                   placeholder="B:option"
                                   type="text"
                                   v-model="form.second">
                            <has-error :form="form" field="second"></has-error>
                        </div>
                        <div class="col-2 text-center">
                            <label for="toption">Third Option</label>
                        </div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('third') }" autocomplete="off"
                                   class="form-control" id="toption" name="toption"
                                   placeholder="C:option" type="text"
                                   v-model="form.third">
                            <has-error :form="form" field="third"></has-error>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-2 text-center">
                            <label for="froption">Fourth Option</label>
                        </div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('fourth') }" autocomplete="off"
                                   class="form-control" id="froption" name="froption"
                                   placeholder="D:option" type="text"
                                   v-model="form.fourth">
                            <has-error :form="form" field="fourth"></has-error>
                        </div>
                        <div class="col-2 text-center">
                            <label for="fioption">Fifth Option</label>
                        </div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('fifth') }" autocomplete="off"
                                   class="form-control" id="fioption" name="fioption"
                                   placeholder="E:option" type="text"
                                   v-model="form.fifth">
                            <has-error :form="form" field="fifth"></has-error>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-2 text-center">
                            <label for="answer">Answer</label>
                        </div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('answer') }"
                                   autocomplete="off" class="form-control text-uppercase" id="answer" maxlength="1"
                                   name="answer" placeholder="A,B,C,D,E" type="text" v-model="form.answer">
                            <has-error :form="form" field="answer"></has-error>
                        </div>
                        <div class="col-2 text-center"><label>Course</label></div>
                        <div class="col-4">
                            <select :class="{ 'is-invalid': form.errors.has('course') }" class="form-control" id="course" name="course" v-model="form.course">
                                <option :value="cdata.cid" v-for="cdata in courseData" v-text="cdata.cdesc"></option>
                            </select>
                            <has-error :form="form" field="course"></has-error>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-2 text-center">
                            <label for="papertype">Paper Type</label>
                        </div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('papertype') }" autocomplete="off"
                                   class="form-control" id="papertype" name="papertype" placeholder="Paper Type.."
                                   type="text" v-model="form.papertype">
                            <has-error :form="form" field="papertype"></has-error>
                        </div>
                        <div class="col-2 text-center"><label>Exam Type</label></div>
                        <div class="col-4">
                            <select :class="{ 'is-invalid': form.errors.has('exam_id') }" @change="onChangeCourse" class="form-control" id="exam_id" name="exam_id" v-model="form.exam_id">
                                <option :value="exam.exam_id" v-for="exam in examData" v-text="exam.examtitle"></option>
                            </select>
                            <has-error :form="form" field="exam_id"></has-error>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <button class="btn btn-info" id="submitBtn" name="submitBtn" type="submit">Submit</button>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 table-responsive">
                            <table class="table table-hover">
                                <tr class="text-center">
                                    <th>Sr.</th>
                                    <th>Question</th>
                                    <th>First Option</th>
                                    <th>Second Option</th>
                                    <th>Third Option</th>
                                    <th>Fourth Option</th>
                                    <th>Answer</th>
                                    <th>Exam Type</th>
                                    <th></th>
                                </tr>
                                <tr class="text-center" v-for="(records,index) in records.data">
                                    <td>{{++index}}</td>
                                    <td>{{records.question}}</td>
                                    <td>{{records.first}}</td>
                                    <td>{{records.second}}</td>
                                    <td>{{records.third}}</td>
                                    <td>{{records.fourth}}</td>
                                    <td>{{records.answer}}</td>
                                    <td>{{records.examtitle}}</td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            <a @click="editQuestion(records.paperid)">
                                                <i class="fas fa-lg fa-pen text-info">

                                                </i>
                                            </a>
                                            <a @click="deleteQuestion(records.paperid)" class="pl-3">
                                                <i class="fas fa-lg fa-trash text-danger">

                                                </i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                            <pagination :data="records" @pagination-change-page="onChangeCourse"
                                        class="pagination justify-content-center"></pagination>
                        </div>
                    </div>

                    <alert-error :form="form" class="mt-2" message="fill all the fields correctly.."></alert-error>
                </form>

            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                form: new Form({
                    question: '',
                    first: '',
                    second: '',
                    third: '',
                    fourth: '',
                    fifth: '',
                    answer: '',
                    papertype: '',
                    course:'',
                    exam_id:0
                }),
                name: "Make Paper For Examination..",
                updateId: 0,
                records: {},
                courseData: {},
                examData: {},
            }
        },
        mounted() {
            Fire.$on('updateRecords', () => {
                this.getResults();
            });
            // this.getResults();
            this.getCourseData();
            this.fetchExamTitle();
        },
        methods:
            {
                makePaper() {
                    if (this.updateId != 0) {
                        this.form.put('api/paper/' + this.updateId)
                            .then(response => {
                                swal('Congratulations!', 'Record Updated Successfully..', 'success');
                                this.form.reset();
                                this.updateId = 0;
                            })
                            .catch(error=>swal('Failed!', 'Record Updation Failed..', 'warning'))

                    } else {
                        this.form.post('api/paper')
                            .then(response => {
                                swal('Congratulations!', 'Data Submitted Successfully..', 'success');
                                this.form.reset();
                            })
                            .catch(error => console.log(error));
                    }
                    this.form.reset();
                },
                getCourseData() {
                    axios.get('api/addcourse/definelib')
                        .then(response => this.courseData = response.data)
                        .catch(error => console.log(error));
                },
                onChangeCourse(page) {
                    if (page==='undefined')
                    {
                        page=1;
                    }
                    let eid='examid-'+this.form.exam_id;
                    axios.get('api/paper/'+eid+'?page='+page)
                        .then(response => this.records=response.data)
                        .catch(error => console.log(error));
                },
                getResults(page) {
                    if(page==='undefined')
                    {
                        page=1;
                    }
                    axios.get('api/paper?page='+page)
                        .then(response => this.records = response.data)
                        .catch(error => console.log(error));
                },
                editQuestion(id) {
                    axios.get('api/paper/' + id)
                        .then(response => {
                            this.form.fill(response.data);
                            this.updateId = response.data.paperid;
                        })
                        .catch(error => console.log(error));
                },
                deleteQuestion(id) {
                    axios.delete('api/paper/' + id)
                        .then(response => {
                            swal('Notice!', 'Record Deleted Successfully..', 'Warning');
                            Fire.$emit('updateRecords');
                        })
                        .catch(error => swal('Notice!', 'Deletion Of Record Failed..', 'Warning'));
                },
                fetchExamTitle(){
                    axios.get('api/exam/_examId')
                        .then(response => this.examData = response.data)
                        .catch(error => console.log(error));
                }
            }
    }
</script>

<style scoped>

</style>
