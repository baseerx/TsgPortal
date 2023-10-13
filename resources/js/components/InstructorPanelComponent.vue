<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h5 text-primary text-center">{{name}}</div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Instructor Panel</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Login for instructor,Basic information for instructor</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Lecture for instructor,specific library for instructor to their registered user</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Any type of document can be uploaded</td>

                            </tr>

                            <tr>
                                <th scope="row">4</th>
                                <td>Instructor can upload any type of document in any time of period of course</td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>SMS and email will be send to registered users regarding updated course contents</td>
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>Attendance for the registered user on daily basis</td>
                            </tr>
                            <tr>
                                <th scope="row">7</th>
                                <td>In case of delay in lecture schedule must be displayed for trainees and alert should be issued</td>
                            </tr>
                            <tr>
                                <th scope="row">8</th>
                                <td>same course can be assigned to different users</td>
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
