<template>
    <div class="container">
        <div class="card">
            <h5 class="card-header">{{ name }} <span class="text-info text-sm">Your ID will be kept hidden..</span></h5>
            <div class="card-body" v-for="(f,index) in feedbacks">
                <div class="card">
                    <div class="card-header bg-primary font-weight-bold">
                        {{ f.question }}
                    </div>
                    <ul class="list-group list-group-flush" :key="index">
                        <li class="list-group-item list-group-item-secondary font-weight-bold text-dark">{{ f.first }}
                            <input
                                type="radio" class="float-right" :name="index" id="strongly_agree"
                                @click="feedBack(f.first+'-'+f.qno)"></li>
                        <li class="list-group-item list-group-item-success font-weight-bold text-dark">
                            {{ f.second }}<input
                            type="radio" class="float-right" :name="index" id="agree"
                            @click="feedBack(f.second+'-'+f.qno)"></li>
                        <li class="list-group-item list-group-item-danger font-weight-bold text-dark">
                            {{ f.third }}<input
                            type="radio" class="float-right" :name="index" id="neutral"
                            @click="feedBack(f.third+'-'+f.qno)"></li>
                        <li class="list-group-item list-group-item-warning font-weight-bold text-dark">
                            {{ f.fourth }}<input
                            type="radio" class="float-right" :name="index" id="disagree"
                            @click="feedBack(f.fourth+'-'+f.qno)"></li>
                        <li class="list-group-item list-group-item-info font-weight-bold text-dark">{{ f.fifth }}<input
                            type="radio" class="float-right" :name="index" id="strongly_disagree"
                            @click="feedBack(f.fifth+'-'+f.qno)"></li>
                    </ul>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button @click="submitFunct" class="btn btn-success btn-sm mb-2">Submit</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: "Give Us Your FeedBack..",
            feedbacks: [{
                question: "Duration of the Technical Refresher Course was just fine?",
                qno: 1,
                first: 'Strongly Agree',
                second: 'Agree',
                third: 'Neutral',
                fourth: 'Disagree',
                fifth: 'Strongly Disagree'
            }, {
                question: "Contents of the Course were just fine?",
                qno: 2,
                first: 'Strongly Agree',
                second: 'Agree',
                third: 'Neutral',
                fourth: 'Disagree',
                fifth: 'Strongly Disagree'
            }, {
                question: "Extra-Curricular activities helped In Team building?",
                qno: 3,
                first: 'Strongly Agree',
                second: 'Agree',
                third: 'Neutral',
                fourth: 'Disagree',
                fifth: 'Strongly Disagree'
            }, {
                question: "Overall Trainers were well prepared?",
                qno: 4,
                first: 'Strongly Agree',
                second: 'Agree',
                third: 'Neutral',
                fourth: 'Disagree',
                fifth: 'Strongly Disagree'
            }, {
                question: "Overall Technical Refresher Course was excellent?",
                qno: 5,
                first: 'Strongly Agree',
                second: 'Agree',
                third: 'Neutral',
                fourth: 'Disagree',
                fifth: 'Strongly Disagree'
            }, {
                question: "NTDC TRC Setup is superior to Other TRC Setups?",
                qno: 6,
                first: 'Strongly Agree',
                second: 'Agree',
                third: 'Neutral',
                fourth: 'Disagree',
                fifth: 'Strongly Disagree'
            }, {
                question: "Quality of the Simulator Training was excellent?",
                qno: 7,
                first: 'Strongly Agree',
                second: 'Agree',
                third: 'Neutral',
                fourth: 'Disagree',
                fifth: 'Strongly Disagree'
            }, {
                question: "Accommodation Facility provided was excellent?",
                qno: 8,
                first: 'Strongly Agree',
                second: 'Agree',
                third: 'Neutral',
                fourth: 'Disagree',
                fifth: 'Strongly Disagree'
            }, {
                question: "Use of Information Technology was very helpful?",
                qno: 9,
                first: 'Strongly Agree',
                second: 'Agree',
                third: 'Neutral',
                fourth: 'Disagree',
                fifth: 'Strongly Disagree'
            }, {
                question: "Assessment Criteria was just fine?",
                qno: 10,
                first: 'Strongly Agree',
                second: 'Agree',
                third: 'Neutral',
                fourth: 'Disagree',
                fifth: 'Strongly Disagree'
            }]
        }
    },
    mounted() {
        this.noBack()
    },
    methods: {
        feedBack(f) {
            // let val=f.split('-');
            axios.post('api/feedback', {'feedback': f})
                .then(response => console.log(response.data))
                .catch(error => console.log(error));
        },
        submitFunct() {
            swal('Thank You!!', 'Your FeedBack Submitted Successfully..', 'success');
            this.$router.push('/home');
        },
        noBack() {
            history.pushState(null, null, location.href);
            history.back();
            history.forward();
            window.onpopstate = function () { history.go(1); }
        }
    }
}
</script>

<style scoped>

</style>
