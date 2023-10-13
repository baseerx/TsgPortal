<template>
    <div class="container">
        <div class="card mt-2">
            <h4 class="card-header text-info">{{cardTitle}} <span
                class="float-right text-danger animated flash delay-3s">Paper time:1 Hour</span><button v-if="showTime" type="button" class="btn btn-danger animated pulse infinite">
                Exam End Time: <span class="badge badge-light">{{endTime}}</span>
            </button></h4>
            <div class="card-body overflow-auto">
                <ul :id="m.paperid" class="list-group mt-2" v-for="(m,i) in mcqsData.data">
                    <li class="list-group-item active py-3">{{++i}}: <span class="ml-3 blockquote">{{m.question}}</span>
                        <span class="badge badge-light float-right">attempted:{{AttemptedMcqs}} total:{{McqsCount}}</span>
                        <span :id="'badgeTrue'+m.paperid" class="badge badge-success d-none"><small>Mcqs Marked Successfully..</small></span>
                        <span :id="'badgeFalse'+m.paperid" class="badge badge-danger d-none"><small>Failed!Mark Again..Please Connect Internet</small></span>
                    </li>
                    <li v-if="m.first" :key="m.paperid+'1'" class="list-group-item py-2">A:<span
                        class="ml-4 blockquote">{{m.first}}</span><span
                        :id="m.paperid+'1'" class="float-right"><input :name="m.paperid"
                                                                       :value="m.paperid+'#'+m.answer+'#'+'A'"
                                                                       @click="computeResult(m.paperid+'#'+m.answer+'#'+'A')"
                                                                       type="radio"></span></li>
                    <li v-if="m.second" :key="m.paperid+'2'" class="list-group-item py-2">B:<span
                        class="ml-4 blockquote">{{m.second}}</span><span
                        :id="m.paperid+'2'" class="float-right"><input :name="m.paperid"
                                                                       :value="m.paperid+'#'+m.answer+'#'+'B'"
                                                                       @click="computeResult(m.paperid+'#'+m.answer+'#'+'B')"
                                                                       type="radio"></span></li>
                    <li v-if="m.third" :key="m.paperid+'3'" class="list-group-item py-2">C:<span
                        class="ml-4 blockquote">{{m.third}}</span><span
                        :id="m.paperid+'3'" class="float-right"><input :name="m.paperid"
                                                                       :value="m.paperid+'#'+m.answer+'#'+'C'"
                                                                       @click="computeResult(m.paperid+'#'+m.answer+'#'+'C')"
                                                                       type="radio"
                    ></span></li>
                    <li v-if="m.fourth" :key="m.paperid+'4'" class="list-group-item py-2">D:<span
                        class="ml-4 blockquote">{{m.fourth}}</span><span :id="m.paperid+'4'" class="float-right"><input
                        :name="m.paperid" :value="m.paperid+'#'+m.answer+'#'+'D'"
                        @click="computeResult(m.paperid+'#'+m.answer+'#'+'D')" type="radio"></span></li>
                    <li v-if="m.fifth" :key="m.paperid+'5'" class="list-group-item py-2">E:<span
                        class="ml-4 blockquote">{{m.fifth}}</span><span :id="m.paperid+'5'" class="float-right"><input
                        :name="m.paperid" :value="m.paperid+'#'+m.answer+'#'+'E'"
                        @click="computeResult(m.paperid+'#'+m.answer+'#'+'E')" type="radio"></span></li>
                </ul>
                <div class="d-flex flex-row-reverse mt-2">
                    <button @click="getResult(1)" class="btn btn-success btn-sm" id="submitBtn" type="button">Submit
                        Paper
                    </button>
                </div>
                <pagination :data="mcqsData" @pagination-change-page="getMcqs"
                            class="pagination justify-content-center mt-3"></pagination>
            </div>
        </div>
        <resultModal :result="resultCounter" :showModal="passVal"></resultModal>
    </div>
</template>

<script>
    import resultModal from './ResultModalComponent';
    import moment from 'moment';

    export default {
        components: {
            resultModal
        },
        data() {
            return {
                cardTitle: "Examination Conduction Section..",
                showTime:false,
                endTime:'',
                mcqsData: {},
                checkResult: '',
                passVal: 0,
                AttemptedMcqs: 0,
                McqsCount: 0,
                compareCount: 0,
                resultCounter: 0,
                checkCounter: 0,
                paginateControl: 1
            }
        },
        mounted() {
            this.getMcqs();
            this.getMcqsCount();
            this.endPaperCheck();
            Fire.$on('updateMcqs',()=>{
                this.Attempted();
            });
        },
        methods:
            {
                getMcqs(page) {
                    if (page === undefined) {
                        page = 1;
                    }
                    if (this.paginateControl <= page) {
                        this.paginateControl = page;
                        axios.get('api/result?page=' + page)
                            .then((response) => this.mcqsData = response.data)
                            .catch((error) => console.log(error));
                    } else {
                        swal('Warning', 'You cant go back', 'warning');
                    }

                },
                getMcqsCount() {
                    axios.get('api/result/' + 'totalMcqs')
                        .then((response) => {
                            this.McqsCount = response.data;
                        })
                        .catch((error) => console.log(error));
                },
                computeResult(val) {
                    this.$isLoading(true)
                    let str = '';
                    str = val.toString().split('#');
                    axios.put('api/result/' + str[0], {answer: str[1], selected: str[2]})
                         .then((response) => {
                            this.$isLoading(false);
                            $('#badgeFalse'+str[0]).removeClass("d-block");
                            $('#badgeTrue'+str[0]).removeClass("d-none");
                            $('#badgeTrue'+str[0]).addClass("d-block");
                            $('#badgeFalse'+str[0]).addClass("d-none");
                            Fire.$emit('updateMcqs');
                        }).catch((error) => {
                        $('#badgeFalse'+str[0]).removeClass("d-none");
                        $('#badgeTrue'+str[0]).removeClass("d-block");
                        $('#badgeTrue'+str[0]).addClass("d-none");
                        $('#badgeFalse'+str[0]).addClass("d-block");
                        this.$isLoading(false);
                    });

                },
                Attempted()
                {
                    axios.get('api/result/attempted')
                    .then(response=>this.AttemptedMcqs=response.data)
                    .catch(error=>console.log(error));
                },
                getResult(check) {
                   if (check===1)
                   {
                       swal({
                           title: "Are you sure?",
                           text: "You want to submit Paper after you will not be able to make changes..!",
                           icon: "warning",
                           buttons: true,
                           dangerMode: true,
                       })
                           .then((oK) => {
                               if (oK) {
                                   axios.post('api/submitresult')
                                       .then((response)=>{
                                           swal('Notice!','Your Result Submitted Successfully..','success');
                                           this.$router.push({ path: '/feedback' });
                                       })
                                       .catch((error)=>swal('Error!','Your Result Submitted Failed..Contact Admin','error'));
                               } else {
                                   swal("Kindly fill the paper accordingly..!");
                               }
                           });
                   }
                   else {
                       axios.post('api/submitresult')
                           .then((response)=>{
                               swal('Notice!','Your Paper time is ended now..','success');
                               this.$router.push({ path: '/feedback' });
                           })
                           .catch((error)=>swal('Error!','Your Result Submitted Failed..Contact Admin','error'));
                   }
                },
                endPaperCheck() {
                    axios.get('api/result/user_course')
                        .then(response => {
                            let etime = response.data;
                            let endtime = moment(etime, 'HH:mm:ss').subtract(10, 'minutes').format('HH:mm:ss');
                              endtime=endtime.toString();
                            let current_time;
                            setInterval(() => {
                                current_time = new moment().format("HH:mm:ss");
                                current_time=current_time.toString();
                                if (endtime === current_time) {
                                    this.showTime=true;
                                    this.endTime=etime;
                                }
                                if (etime===current_time)
                                {
                                   this.getResult(2);
                                }
                            }, 1000);

                        })
                        .catch(error => console.log(error));
                }
            }
    }
</script>

<style scoped>
  .zindex{
      z-index: 9999;
      position: relative;
  }
</style>
