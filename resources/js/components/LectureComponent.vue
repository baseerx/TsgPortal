<template>
    <div class="container">

        <div class="card table-responsive">
            <h3 class="text-danger"><span class="badge badge-danger text-white ml-2">Lectures</span></h3>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Description</th>
                    <th scope="col">File Type</th>
                    <th scope="col">Training Type</th>
                    <th scope="col">Download</th>
                    <th scope="col">FeedBack</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(data,index) in lData">
                    <th scope="row">{{++index}}</th>
                    <td>{{data.description}}</td>
                    <td>{{data.filetype}}</td>
                    <td>{{data.coursetype_desc}}</td>
                    <td><a :href="'../presentation_files/'+data.file" :title="data.file" target="_blank"><i
                        class="fas fa-2x fa-file-download"></i></a></td>
                    <td>
                        <button @click="checkLectureFeedBack(data.pid)"><i class="fas fa-2x fa-comments text-info"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: "NTDC TSG Training Portal",
                lData: [],
                lDataLength: 0,
                baseUrl: 'https://tsgportal.ntdc.com.pk/',
                traineeEmail: ''
            }
        },
        mounted() {

            this.getLectures();

        },
        methods: {
            getLectures() {
                this.traineeEmail = this.$route.params.trainemail;
                axios.get(this.baseUrl + 'api/display_data/content-')
                    .then((response) => {
                        this.lData = response.data;
                        this.lDataLength = response.data.length;
                    })
                    .catch((error) => console.log("error occured in files retrieval.."));
            },
            checkLectureFeedBack(id) {
                axios.get(this.baseUrl + 'api/lecfeed/' + id)
                    .then(response => {
                        if (response.data === true) {
                            swal('Warning!', 'You have already submitted Feedback against this lecture..', 'error');
                        } else {
                            let to = '/lecture_feedback/' + id;
                            this.$router.push(to);
                        }
                    }).catch(error => console.log(error));

            }
        }
    }
</script>

<style scoped>

</style>
