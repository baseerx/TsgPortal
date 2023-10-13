<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h5">{{name}}</div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Functionality for development</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Login and see training in progress,completed and future training if any</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Click on the progress training and see the schedule of the training</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Course handouts/Lecture slides or videos for the completed lectures</td>

                            </tr>

                            <tr>
                                <th scope="row">4</th>
                                <td>Making and Result to be displayed</td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Making and Result to be displayed</td>
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>There should be section on this page called Lecture Slides and handouts,other Materials</td>
                            </tr>
                            <tr>
                                <th scope="row">7</th>
                                <td>Trainees should be able to submit there assigments</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-muted">
                        <router-link to="/home">
                            <i class="fa fa-arrow-left fa-3x text-primary"></i>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: "Trainees Detail"
            }
        },
        mounted() {

        }
    }
</script>
