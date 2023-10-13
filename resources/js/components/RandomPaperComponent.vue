<template>
    <div class="container">
        <div class="card ">
            <h5 class="card-header">{{ this.cardName }}</h5>
            <div class="card-body">
                <form @submit.prevent="addLetter" id="main_form">
                    <div class="row">
                        <div class="col-2">
                            <label for="exam_id">Exam Title</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select :class="{ 'is-invalid': form.errors.has('exam_id') }" class="form-control w-75"
                                        id="exam_id" v-model="form.exam_id">
                                    <option :value="exam.exam_id" v-for="exam in examData">{{ exam.examtitle }}</option>
                                </select>
                                <has-error :form="form" field="exam_id"></has-error>
                            </div>
                        </div>
                        <div class="col-2">
                            <label for="questions">No of Questions</label>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input :class="{ 'is-invalid': form.errors.has('ctitle') }" class="form-control w-75"
                                       id="questions" name="questions" type="text" v-model="form.questions">
                                <has-error :form="form" field="questions"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <button class="btn btn-success btn-sm" type="submit">Submit</button>
                    </div>
                </form>
                <div class="table-responsive mt-2">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Exam Title</th>
                            <th scope="col">No of Questions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(l,index) in randQuestionsData">
                            <td scope="row">{{ ++index }}</td>
                            <td scope="col">{{ l.examtitle }}</td>
                            <td scope="col">{{ l.quesitons }}</td>
                            <td scope="col">
                                <div class="d-flex flex-row">
                                    <div class="pl-2 pt-1"><a @click="selectRecord(l.randid)">
                                        <i class="fas fa-lg fa-pen text-info" title="Edit Record"></i>
                                    </a></div>
                                    <div class="pl-2 pt-1"><a @click="deleteRecord(l.randid)">
                                        <i class="fas fa-lg fa-trash text-danger" title="Delete Record"></i>
                                    </a></div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            name: "Random Paper Component",
            cardName: "Random Paper Component",
            form: new Form({
                exam_id: 0,
                questions: 0
            }),
            examData: {},
            randQuestionsData: {}
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData(){

        },
        selectRecord(id) {

        },
        deleteRecord(id) {

        }
    }
}
</script>

<style scoped>

</style>
