<template>
    <div class="container">
         <div class="card table-responsive">
            <div class="card-header h3 text-danger">
               Individual Content
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Description</th>
                    <th scope="col">Training Type</th>
                    <th scope="col">Download</th>
                </tr>
                </thead>
                <tbody>
                <tr :key="index" v-for="(data,index) in indData">
                    <th scope="row">{{++index}}</th>
                    <td>{{data.description}}</td>
                    <td>{{data.coursetype_desc}}</td>
                    <td><a :href="'../indschedual/'+data.file" target="_blank" :title="data.file"><i class="fas fa-2x fa-file-download"></i></a></td>
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
                indData:{},
                inddataLength:0,
            }
        },
        mounted() {
            this.getResults();
 
        },
        methods: {
            getResults() {
                axios.get('api/indsch/ind')
                    .then(response => this.indData = response.data)
                    .catch(error => console.log(error));
            },
        }
    }
</script>

<style scoped>
    .table-dark {
        color: #fff;
        background-color: #663300;
    }

    .table-dark th,
    .table-dark td,
    .table-dark thead th {
        border-color: #FF860D;
    }
</style>
