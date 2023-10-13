<template>
    <div class="container">
        <h3 class="text-danger"></h3>
        <div class="card table-responsive" v-if="pDataLength">
            <div class="card-header h3 text-danger">
                <span class="badge badge-danger text-white ml-3">Presentations</span>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Description</th>
                    <th scope="col">File Type</th>
                    <th scope="col">Download</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(data,index) in pData">
                    <th scope="row">{{++index}}</th>
                    <td>{{data.description}}</td>
                    <td>{{data.filetype}}</td>
                    <td><a :href="'../presentation_files/'+data.file" target="_blank" :title="data.file"><i class="fas fa-2x fa-file-download"></i></a></td>
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
                pData: [],
                pDataLength: 0,
                baseUrl: 'https://tsgportal.ntdc.com.pk/',
                traineeEmail: ''
            }
        },
        mounted() {

            this.getPresentations();

        },
        methods: {
            getPresentations() {
                // this.traineeEmail = this.$route.params.trainemail;
                axios.get(this.baseUrl + 'api/display_data/specificTrainee-')
                    .then((response) => {
                        this.pData = response.data;
                        this.pDataLength = response.data.length;
                    })
                    .catch((error) => console.log("error occured in files retrieval.."));
            }
        }
    }
</script>

<style scoped>

</style>
