<template>
    <div class="container">

        <div class="card table-responsive">
            <h3 class="text-danger"><span class="badge badge-danger text-white ml-2">Individual Content</span></h3>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Training Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Download</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(data,index) in lData">
                    <th scope="row">{{++index}}</th>
                    <td>{{data.coursetype_desc}}</td>
                    <td>{{data.description}}</td>
                    <td><a :href="'../indschedual/'+data.file" :title="data.file" target="_blank"><i
                    class="fas fa-2x fa-file-download"></i></a></td>
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

        this.indComponentData();

    },
    methods: {
        indComponentData() {
            axios.get(this.baseUrl + 'api/display_data/indData')
                .then((response) => {
                    this.lData = response.data;
                    console.log(this.lData);
                    this.lDataLength = response.data.length;
                })
                .catch((error) => console.log("error occured in files retrieval.."));
        }
    }
}
</script>

<style scoped>

</style>
