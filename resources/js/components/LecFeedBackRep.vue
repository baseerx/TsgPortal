<template>
    <div class="container">
        <div class="card text-center">
            <div class="card-header">
                <h4 class="text-info">Lecture Report</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-10 offset-1">
                        <div class="form-group">
                            <label for="lecture_feedback">Select Lecture</label>
                            <select class="form-control" id="lecture_feedback" v-model="selectedLec" @change="assignLecVal">
                                <option v-for="l in lectureData" :value="l.pid">{{l.description}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5 offset-3">
                        <a class="btn btn-info text-white" :href="genLecUrl" target="_blank">Generate Report</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
    export default {
          data(){
            return{
                lectureData:{},
                selectedLec:'',
                genLecUrl:''
            }
          },
        mounted() {
            this.getLectures();
        },
        methods: {
            getLectures() {
                axios.get('api/lecreport')
                    .then(response => this.lectureData=response.data)
                    .catch(error => console.log(error));
            },
            assignLecVal()
            {
                this.genLecUrl='/lec_reports/'+this.selectedLec;

            }
        }
    }
</script>

<style scoped>

</style>
