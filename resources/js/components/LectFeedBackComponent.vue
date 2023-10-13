<template>
    <div class="container">

        <div class="card">
            <h5 class="card-header bg-info text-white">{{ courtname }}</h5>


            <div class="card-body">
                <div class="card">
                    <ul class="list-group m-3"  v-for="lec in lData" v-if="lec.pid==pid">
                        <li class="list-group-item">
                           <b>Name Of Participant:</b> {{ userDetails.username }}
                        </li>
                        <li class="list-group-item"><b>Name of Topic & Speaker:</b> {{ lec.description }}</li>
                        <!-- <li class="list-group-item"><b>Topic Name:</b> {{ lec.coursetype_desc }}</li> -->
                    </ul>

                    <table class="table table-bordered">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Question</th>
                            <th scope="col">First</th>
                            <th scope="col">Second</th>
                            <th scope="col">Third</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr  v-for="(f,index) in feedbacks" :key="index">
                            <th scope="row">{{++index}}</th>
                            <th scope="row">{{f.question}}</th>
                            <td> {{ f.first }} <input
                                type="radio" class="float-right" :name="index" id="Excellent"
                                @click="feedBack(f.first+'-'+f.question+'-'+f.category)"></td>
                            <td>{{ f.second }}<input
                                type="radio" class="float-right" :name="index" id="Good"
                                @click="feedBack(f.second+'-'+f.question+'-'+f.category)"></td>
                            <td>{{ f.third }}<input
                                type="radio" class="float-right" :name="index" id="Average"
                                @click="feedBack(f.third+'-'+f.question+'-'+f.category)"></td>
                        </tr>
                        </tbody>
                    </table>


                   <div class="m-4">
                       <p class="text-info">Recommended for Future Course? </p>
                       <div class="form-check">
                           <input class="form-check-input" type="radio" @click="feedBack(sub_feedbacks.first+'-'+sub_feedbacks.question+'-'+sub_feedbacks.category)" name="subquestion" id="subquestion">
                           <label class="form-check-label" for="flexRadioDefault1">
                               Yes
                           </label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input" type="radio" @click="feedBack(sub_feedbacks.second+'-'+sub_feedbacks.question+'-'+sub_feedbacks.category)" name="subquestion" id="subquestion">
                           <label class="form-check-label" for="flexRadioDefault1">
                               No
                           </label>
                       </div>
                   </div>

                    <LecFeedSubComponent :feedsub="feedsub" :pid="pid"></LecFeedSubComponent>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button @click="submitFunct" class="btn btn-success btn-sm mb-2">Submit</button>
            </div>
        </div>
    </div>
</template>
<script>
import LecFeedSubComponent from "./LecFeedSubComponent";

export default {
    components: {
        LecFeedSubComponent
    },
    data() {
        return {
            userDetails: [],
            courtname: "",
            feedsub: 0,
            pid: this.$route.params.pid,
            baseUrl: 'https://tsgportal.ntdc.com.pk/',
            sub_feedbacks: {

                category:'Recommended for Future Course',
                question: "Recommended for Future Course?",
                qno: 6,
                first: 'yes',
                second: 'no',
            },
            feedbacks: [{

                    category:'Learning Environment and Teaching Methods',
                question: "Command over the subject?",
                qno: 1,
                first: 'Excellent',
                second: 'Good',
                third: 'Average',
            },
                {
                        category:'Learning Environment and Teaching Methods',
                    question: "Quality of coverage?",
                    qno: 2,
                    first: 'Excellent',
                    second: 'Good',
                    third: 'Average',

                },
                {
                        category:'Learning Environment and Teaching Methods',
                    question: "Quality of presentation?",
                    qno: 3,
                    first: 'Excellent',
                    second: 'Good',
                    third: 'Average',

                },
                {
                    category:'Learning Environment and Teaching Methods',
                    question: "Relevance to the course?",
                    qno: 4,
                    first: 'Excellent',
                    second: 'Good',
                    third: 'Average',

                },
                {
                    category:'Learning Environment and Teaching Methods',
                    question: "Response to questions?",
                    qno: 5,
                    first: 'Excellent',
                    second: 'Good',
                    third: 'Average',

                }],
            lData:[]

        }
    },
    mounted() {
        this.getCourtName();
        this.getUserName();
        this.getLectures();
    },
    methods: {
        feedBack(f) {
            // let val=f.split('-');


            axios.post(this.baseUrl + 'api/lecfeed', {'feedback': f, 'pid': this.pid})
                .then(response => console.log(response.data))
                .catch(error => console.log(error));
        },
        getLectures() {
            axios.get(this.baseUrl + 'api/display_data/content-')
                .then((response) => {
                    this.lData = response.data;

                })
                .catch((error) => console.log("error occured in files retrieval.."));
        },
        getUserName() {
            axios.get(this.baseUrl + 'api/userdetails')
                .then(response => {
                    this.userDetails = response.data;

                })
                .catch(error => console.log(error))
        },
        getCourtName() {
            axios.get(this.baseUrl + 'api/coursedetail')
                .then(response => this.courtname = response.data)
                .catch(error => console.log(error))
        },
        submitFunct() {
            this.feedsub = Math.random();
        }
    }
}
</script>

<style scoped>

</style>
