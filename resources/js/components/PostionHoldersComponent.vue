<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.name}}</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group row">
                        <div class="col-2">
                            <label for="ctype">Training Type</label>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <select class="form-control" id="ctype" v-model="trainingtype" @change="loadTrainees">
                                    <option :value="cdata.cid" v-for="cdata in ccourseData">
                                        {{cdata.cdesc}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a :href="genCertUrl" class="btn btn-info text-white" target="_blank">Generate Report</a></div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                trainingtype: '',
                traineetype: '',
                name: "Individual Scheduling..",
                genCertUrl: '',
                updateId: 0,
                courseData: {},
                relData: {},
                records: {},
                ccourseData: {},
                filename: '',
                Trainees: {}
            }
        },
        mounted() {
            this.getcType();
        },
        watch: {
            trainingtype:function () {
                this.genCertUrl= '/position_holders/'+this.trainingtype;
            }
        },
        methods: {
            getcType() {
                axios.get('api/answersht')
                    .then(response => this.ccourseData = response.data)
                    .catch(error => console.log(error));
            }
        }

    }
</script>

<style scoped>

</style>
